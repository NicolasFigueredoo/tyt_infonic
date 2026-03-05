<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Genera todos los archivos de sitemap estáticos';

    private $baseUrl = 'https://tytsa.com.ar';
    private $outputPath;

    public function __construct()
    {
        parent::__construct();
        $this->outputPath = public_path();
    }

    public function handle()
    {
        $this->info('🚀 Iniciando generación de sitemaps...');
        
        // 1. Generar sitemap de páginas
        $this->generatePagesSitemap();
        
        // 2. Generar sitemap de categorías
        $this->generateCategoriesSitemap();
        
        // 3. Generar sitemaps de productos
        $productSitemaps = $this->generateProductSitemaps();
        
        // 4. Generar sitemap index
        $this->generateSitemapIndex($productSitemaps);
        
        $this->info('✅ Sitemaps generados exitosamente!');
        $this->info('📁 Archivos creados en: ' . $this->outputPath);
        
        return Command::SUCCESS;
    }

    private function generatePagesSitemap()
    {
        $this->info('  → Generando sitemap-pages.xml...');
        
        $pages = [
            ['loc' => $this->baseUrl, 'lastmod' => now()->toDateString(), 'changefreq' => 'daily', 'priority' => '1.0'],
            ['loc' => $this->baseUrl . '/catalogo', 'lastmod' => now()->toDateString(), 'changefreq' => 'daily', 'priority' => '0.9'],
            ['loc' => $this->baseUrl . '/quienes_somos', 'lastmod' => now()->subMonth()->toDateString(), 'changefreq' => 'monthly', 'priority' => '0.5'],
            ['loc' => $this->baseUrl . '/contacto', 'lastmod' => now()->subMonth()->toDateString(), 'changefreq' => 'monthly', 'priority' => '0.6'],
        ];
        
        $xml = $this->buildUrlSet($pages);
        File::put($this->outputPath . '/sitemap-pages.xml', $xml);
        
        $this->info('    ✓ ' . count($pages) . ' páginas');
    }

    private function generateCategoriesSitemap()
    {
        $this->info('  → Generando sitemap-categories.xml...');
        
        $urls = [];
        
        // Categorías principales
        $mainCategories = DB::table('tipo_articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->where('principal', 'true')
            ->get();
        
        foreach ($mainCategories as $main) {
            $urls[] = [
                'loc' => $this->baseUrl . '/catalogo/' . $main->id . '/0',
                'lastmod' => $main->updated_at ? date('Y-m-d', strtotime($main->updated_at)) : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
            
            // Subcategorías
            $subCategories = DB::table('tipo_articulos')
                ->whereNull('deleted_at')
                ->where('oculto', 'false')
                ->where('sub_categoria_id', $main->id)
                ->get();
            
            foreach ($subCategories as $sub) {
                $urls[] = [
                    'loc' => $this->baseUrl . '/catalogo/' . $sub->id . '/1',
                    'lastmod' => $sub->updated_at ? date('Y-m-d', strtotime($sub->updated_at)) : now()->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        }
        
        $xml = $this->buildUrlSet($urls);
        File::put($this->outputPath . '/sitemap-categories.xml', $xml);
        
        $this->info('    ✓ ' . count($urls) . ' categorías');
    }

    private function generateProductSitemaps()
    {
        $this->info('  → Generando sitemaps de productos...');
        
        $perPage = 1000;
        $totalProducts = DB::table('articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->count();
        
        $chunks = ceil($totalProducts / $perPage);
        $sitemapFiles = [];
        
        for ($page = 1; $page <= $chunks; $page++) {
            $offset = ($page - 1) * $perPage;
            
            $products = DB::table('articulos')
                ->whereNull('deleted_at')
                ->where('oculto', 'false')
                ->whereNotNull('slug')
                ->where('slug', '!=', '')
                ->orderBy('id')
                ->offset($offset)
                ->limit($perPage)
                ->get();
            
            $urls = [];
            
            foreach ($products as $product) {
                $url = [
                    'loc' => $this->baseUrl . '/articulo/' . $product->slug,
                    'lastmod' => $product->updated_at ? date('Y-m-d', strtotime($product->updated_at)) : now()->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.6',
                ];
                
                if (!empty($product->imagen)) {
                    $url['image'] = $this->buildImageUrl($product->imagen);
                    $url['image_title'] = ucwords(strtolower(trim($product->name)));
                }
                
                $urls[] = $url;
            }
            
            $filename = "sitemap-products-{$page}.xml";
            $xml = $this->buildUrlSet($urls, true);
            File::put($this->outputPath . '/' . $filename, $xml);
            
            $sitemapFiles[] = $filename;
            $this->info("    ✓ {$filename} (" . count($urls) . " productos)");
        }
        
        $this->info("    Total: {$totalProducts} productos en {$chunks} archivo(s)");
        
        return $sitemapFiles;
    }

    private function generateSitemapIndex($productSitemaps)
    {
        $this->info('  → Generando sitemap.xml (index)...');
        
        $sitemaps = [
            ['loc' => $this->baseUrl . '/sitemap-pages.xml', 'lastmod' => now()->toDateString()],
            ['loc' => $this->baseUrl . '/sitemap-categories.xml', 'lastmod' => $this->getLastCategoryUpdate()],
        ];
        
        $lastProductUpdate = $this->getLastProductUpdate();
        foreach ($productSitemaps as $filename) {
            $sitemaps[] = [
                'loc' => $this->baseUrl . '/' . $filename,
                'lastmod' => $lastProductUpdate,
            ];
        }
        
        $xml = $this->buildSitemapIndex($sitemaps);
        File::put($this->outputPath . '/sitemap.xml', $xml);
        
        $this->info('    ✓ Index con ' . count($sitemaps) . ' sitemaps');
    }

    private function buildSitemapIndex($sitemaps)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        
        foreach ($sitemaps as $sitemap) {
            $xml .= '  <sitemap>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($sitemap['loc']) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $sitemap['lastmod'] . '</lastmod>' . PHP_EOL;
            $xml .= '  </sitemap>' . PHP_EOL;
        }
        
        $xml .= '</sitemapindex>';
        
        return $xml;
    }

    private function buildUrlSet($urls, $includeImages = false)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        
        if ($includeImages) {
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . PHP_EOL;
        } else {
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
        }
        
        foreach ($urls as $url) {
            $xml .= '  <url>' . PHP_EOL;
            $xml .= '    <loc>' . htmlspecialchars($url['loc']) . '</loc>' . PHP_EOL;
            $xml .= '    <lastmod>' . $url['lastmod'] . '</lastmod>' . PHP_EOL;
            $xml .= '    <changefreq>' . $url['changefreq'] . '</changefreq>' . PHP_EOL;
            $xml .= '    <priority>' . $url['priority'] . '</priority>' . PHP_EOL;
            
            if ($includeImages && !empty($url['image'])) {
                $xml .= '    <image:image>' . PHP_EOL;
                $xml .= '      <image:loc>' . htmlspecialchars($url['image']) . '</image:loc>' . PHP_EOL;
                if (!empty($url['image_title'])) {
                    $xml .= '      <image:title>' . htmlspecialchars($url['image_title']) . '</image:title>' . PHP_EOL;
                }
                $xml .= '    </image:image>' . PHP_EOL;
            }
            
            $xml .= '  </url>' . PHP_EOL;
        }
        
        $xml .= '</urlset>';
        
        return $xml;
    }

    private function buildImageUrl($imagePath)
    {
        if (empty($imagePath)) return null;
        if (Str::startsWith($imagePath, 'http')) return $imagePath;
        
        if (Str::startsWith($imagePath, 'public/')) {
            $imagePath = Str::replaceFirst('public/', '', $imagePath);
        }
        
        return $this->baseUrl . '/storage/' . $imagePath;
    }

    private function getLastProductUpdate()
    {
        $lastUpdate = DB::table('articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->max('updated_at');
        
        return $lastUpdate ? date('Y-m-d', strtotime($lastUpdate)) : now()->toDateString();
    }

    private function getLastCategoryUpdate()
    {
        $lastUpdate = DB::table('tipo_articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->max('updated_at');
        
        return $lastUpdate ? date('Y-m-d', strtotime($lastUpdate)) : now()->toDateString();
    }
}
