<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class Familia extends Model {
    use SoftDeletes;

	protected $table = 'familia';
    protected $appends = ['path', 'secondary_path'];
    protected $fillable = ['orden'];
	protected $casts = [
	];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
    }
    public function getPathAttribute()
    {
        $data= null;
        if($this->imagen){
            $data = asset(Storage::url($this->imagen));
        }
        return $data;
    }

    public function getSecondaryPathAttribute()
    {
        $data = null;
        if ($this->imagenMarca) {
            $data = asset(Storage::url($this->imagenMarca));
        }
        return $data;
    }

    public function obtenerProducto(){
        return $this->belongsTo(Articulo::class, 'code', 'tipoProducto')->where('oculto', false)->get();
        // $subCategorias = $this->hasMany(SubCategoria::class,'tipo_articulo_id','id')->get();
        // $arrProductos = [];
        // if(count($subCategorias) > 0){
        //     foreach($subCategorias as $subCategoria){
        //         $productos = $subCategoria->obtenerProducto();
        //         if(count($productos) > 0){
        //             foreach($productos as $producto){
        //                 array_push($arrProductos,$producto);
        //             }
        //         }
        //     }
        // }
        // return $arrProductos;
    }
    public function updateApi(){
        $page = 1;
        $client = new Client([
            'verify' => false, // Ignora la verificación del certificado SSL
        ]);
        $headers = [
            'accept' => 'application/json',
            'X-API-KEY' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8='
        ];
        $response = $client->request('GET', 'https://190.195.163.194:8443/productos?maxCount=100&page='.$page, [
            RequestOptions::HEADERS => $headers,
        ]);
        $categorias = json_decode($response->getBody(), true);
        $pageCount = intval(ceil($categorias['count'] / 100));
        $nuevosDatos = [];
        
        while ($page <= $pageCount) {
            $response = $client->request('GET', 'https://190.195.163.194:8443/productos?maxCount=100&page='.$page, [
                RequestOptions::HEADERS => $headers,
            ]);
            $categorias = json_decode($response->getBody(), true);
            $nuevosDatos = array_merge($nuevosDatos, array_reduce($categorias['values'], function($result, $item) {
                $tipoProducto = trim($item['tipoProducto']); // Eliminar los espacios en blanco al inicio y al final del tipo de producto
                if (!isset($result[$tipoProducto])) {
                    $result[$tipoProducto] = [
                        'tipoProducto' => $tipoProducto,
                        'tipoDescripcion' => $item['tipoDescripcion']
                    ];
                }
                return $result;
            }, []));
            
            $page++;
        }
        foreach($nuevosDatos as $cat){
            $tipo = TipoArticulo::where('code','=',$cat['tipoProducto'])->first();
            if(!$tipo){
                $tipo = new TipoArticulo();
            }
            $tipo->code = $cat['tipoProducto'];
            $tipo->name = $cat['tipoDescripcion'];
            $tipo->save();
        }
    }

    public function subcategorias()
    {
        return $this->hasMany(TipoArticulo::class, 'sub_categoria_id');
    }
}