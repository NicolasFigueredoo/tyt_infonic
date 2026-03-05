<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    private $baseUrl = 'https://tytsa.com.ar';
    
    /**
     * Sitemap Index - archivo principal que referencia todos los sitemaps
     */
    public function index()
    {
        $sitemaps = [
            [
                'loc' => $this->baseUrl . '/sitemap-pages.xml',
                'lastmod' => now()->toDateString(),
            ],
            [
                'loc' => $this->baseUrl . '/sitemap-categories.xml',
                'lastmod' => $this->getLastCategoryUpdate(),
            ],
        ];
        
        // Agregar sitemaps de productos (divididos en chunks de 1000)
        $totalProducts = $this->getVisibleProductsCount();
        $chunks = ceil($totalProducts / 1000);
        
        for ($i = 1; $i <= $chunks; $i++) {
            $sitemaps[] = [
                'loc' => $this->baseUrl . "/sitemap-products-{$i}.xml",
                'lastmod' => $this->getLastProductUpdate(),
            ];
        }
        
        $xml = $this->buildSitemapIndex($sitemaps);
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Sitemap de páginas estáticas
     */
    public function pages()
    {
        $pages = [
            [
                'loc' => $this->baseUrl,
                'lastmod' => now()->toDateString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => $this->baseUrl . '/catalogo',
                'lastmod' => now()->toDateString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => $this->baseUrl . '/quienes_somos',
                'lastmod' => now()->subMonth()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
            [
                'loc' => $this->baseUrl . '/contacto',
                'lastmod' => now()->subMonth()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ],
            [
                'loc' => $this->baseUrl . '/registro',
                'lastmod' => now()->subMonth()->toDateString(),
                'changefreq' => 'monthly',
                'priority' => '0.5',
            ],
        ];
        
        $xml = $this->buildUrlSet($pages);
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Sitemap de categorías
     */
    public function categories()
    {
        $urls = [];
        
        // Obtener categorías principales (visible y no eliminadas)
        $mainCategories = DB::table('tipo_articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->where('principal', 'true')
            ->get();
        
        foreach ($mainCategories as $main) {
            // URL de categoría principal: /catalogo/{id}/0
            $urls[] = [
                'loc' => $this->baseUrl . '/catalogo/' . $main->id . '/0',
                'lastmod' => $main->updated_at ? date('Y-m-d', strtotime($main->updated_at)) : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.8',
            ];
            
            // Obtener subcategorías
            $subCategories = DB::table('tipo_articulos')
                ->whereNull('deleted_at')
                ->where('oculto', 'false')
                ->where('sub_categoria_id', $main->id)
                ->get();
            
            foreach ($subCategories as $sub) {
                // URL de subcategoría: /catalogo/{sub_id}/1
                $urls[] = [
                    'loc' => $this->baseUrl . '/catalogo/' . $sub->id . '/1',
                    'lastmod' => $sub->updated_at ? date('Y-m-d', strtotime($sub->updated_at)) : now()->toDateString(),
                    'changefreq' => 'weekly',
                    'priority' => '0.7',
                ];
            }
        }
        
        $xml = $this->buildUrlSet($urls);
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Sitemap de productos (paginado)
     */
    public function products($page = 1)
    {
        $perPage = 1000;
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
        
        if ($products->isEmpty() && $page > 1) {
            abort(404);
        }
        
        $urls = [];
        
        foreach ($products as $product) {
            $url = [
                'loc' => $this->baseUrl . '/articulo/' . $product->slug,
                'lastmod' => $product->updated_at ? date('Y-m-d', strtotime($product->updated_at)) : now()->toDateString(),
                'changefreq' => 'weekly',
                'priority' => '0.6',
            ];
            
            // Agregar imagen si existe
            if (!empty($product->imagen)) {
                $url['image'] = $this->buildImageUrl($product->imagen);
                $url['image_title'] = $this->cleanProductName($product->name);
            }
            
            $urls[] = $url;
        }
        
        $xml = $this->buildUrlSet($urls, true);
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
    
    /**
     * Construir XML del Sitemap Index
     */
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
    
    /**
     * Construir XML del URL Set
     */
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
            
            // Agregar imagen si existe
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
    
    /**
     * Construir URL de imagen
     */
    private function buildImageUrl($imagePath)
    {
        if (empty($imagePath)) {
            return null;
        }
        
        // Si ya es URL completa
        if (Str::startsWith($imagePath, 'http')) {
            return $imagePath;
        }
        
        // Si empieza con public/, quitarlo y usar storage
        if (Str::startsWith($imagePath, 'public/')) {
            $imagePath = Str::replaceFirst('public/', '', $imagePath);
            return $this->baseUrl . '/storage/' . $imagePath;
        }
        
        // Si empieza con inicio/ u otro path
        return $this->baseUrl . '/storage/' . $imagePath;
    }
    
    /**
     * Limpiar nombre de producto para título de imagen
     */
    private function cleanProductName($name)
    {
        return ucwords(strtolower(trim($name)));
    }
    
    /**
     * Obtener cantidad de productos visibles
     */
    private function getVisibleProductsCount()
    {
        return DB::table('articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->count();
    }
    
    /**
     * Obtener última actualización de productos
     */
    private function getLastProductUpdate()
    {
        $lastUpdate = DB::table('articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->max('updated_at');
        
        return $lastUpdate ? date('Y-m-d', strtotime($lastUpdate)) : now()->toDateString();
    }
    
    /**
     * Obtener última actualización de categorías
     */
    private function getLastCategoryUpdate()
    {
        $lastUpdate = DB::table('tipo_articulos')
            ->whereNull('deleted_at')
            ->where('oculto', 'false')
            ->max('updated_at');
        
        return $lastUpdate ? date('Y-m-d', strtotime($lastUpdate)) : now()->toDateString();
    }
}
