<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use App\Models\Articulo;
use App\Models\TipoArticulo;

class SincronizarCategoriasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 300;

    public function handle()
    {
        Cache::put('sincronizacion_estado', 'procesando', 600);

        try {
            $client = new Client();
            $apiUrlBase = 'https://tytsaapi.ddns.net:8443/productos?maxCount=100&page=';
            $totalPages = 8;

            for ($page = 0; $page <= $totalPages; $page++) {
                $respuesta = $client->request('GET', $apiUrlBase . $page, [
                    'headers' => [
                        'X-Api-Key' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8='
                    ],
                    'verify' => false
                ]);

                $productos = json_decode($respuesta->getBody(), true);

                foreach ($productos['values'] as $value) {
                    $articulo = Articulo::where('code', $value['codigoProducto'])->first();

                    if ($articulo) {
                        if ($value['unidadNegocio']) {
                            $unidadNegocio = mb_strtolower($value['unidadNegocio'], 'UTF-8');
                            $unidadNegocio = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $unidadNegocio);
                            $categoria = TipoArticulo::whereRaw('LOWER(name) = ?', [$unidadNegocio])->first();

                            if (!$categoria) {
                                $categoria = new TipoArticulo();
                            }
                            $categoria->name = strtoupper($value['unidadNegocio']);
                            $categoria->principal = 'true';
                            $categoria->save();
                        }

                        if ($value['familiaWeb']) {
                            $familiaWeb = mb_strtolower($value['familiaWeb'], 'UTF-8');
                            $familiaWeb = str_replace(['á','é','í','ó','ú','ñ'], ['a','e','i','o','u','n'], $familiaWeb);
                            $subCategoria = TipoArticulo::whereRaw('LOWER(name) = ?', [$familiaWeb])->first();

                            if (!$subCategoria) {
                                $subCategoria = new TipoArticulo();
                            }
                            $subCategoria->name = strtoupper($value['familiaWeb']);
                            $subCategoria->sub_categoria_id = $categoria->id ?? null;
                            $subCategoria->save();
                        }
                    }
                }
            }

            Cache::put('sincronizacion_estado', 'completado', 600);

        } catch (\Exception $e) {
            Cache::put('sincronizacion_estado', 'error: ' . $e->getMessage(), 600);
        }
    }
}