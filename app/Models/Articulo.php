<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Storage;

use GuzzleHttp\Client;

use GuzzleHttp\RequestOptions;

class Articulo extends Model {

    use SoftDeletes;



	protected $table = 'articulos';

    protected $appends = ['path','pathFicha','pathGaleria','pathColores','obtenerGaleria','obtenerColores'];



  protected $fillable = [
        'code',
        'codigoAnterior',
        'orden',
        'name',
        'slug',
        'nameEnglish',
        'tipoProducto',
        'colores',
        'short',
        'precio',
        'precioVigente',
        'cantidad',
        'unidad',
        'Marca',
        'imagen',
        'galeria',
        'oculto',
        'description',
        'descriptionPrivada',
        'video',
        'videoTwo',
        'minimo',
        'stock-min',
        'stock-max',
        'bultoMinorista',
        'bultoMayorista',
        'stock-disponible',
        'tipo_articulo_id',
        'sub_categoria',
        'destacado',
    ];

	protected $casts = [

	];



    public static function boot() {

        parent::boot();

        self::creating(function ($model) {

            // $model->uuid = __uuid();

        });

    }

    public function subCategoria() {

        return $this->belongsTo(SubCategoria::class, 'code', 'tipoProducto')->first();

    }

    public function ObtenerCategoria() {

        return $this->belongsTo(TipoArticulo::class, 'tipoProducto', 'code')->first();

    }



    public function stock() {

        return $this->hasMany(ArticuloStock::class, 'articulo_id');

    }

    public function logs() {

        return $this->hasMany(ArticuloLog::class, 'articulo_id');

    }



    public function getStockCantidadTotalAttribute() {

        return $this->stock->sum('cantidad');

    }

    public function getStockPesoTotalAttribute() {

        return $this->stock->sum('peso');

    }



    public function categorias()

    {

        return $this->belongsToMany(TipoArticulo::class, 'categoria_producto');

    }





    public function getPathGaleriaAttribute(){

        $data= null;

        if($this->galeria){            

            $data =[];

            $galeria = $this->galeria;

            $img = explode(',',$galeria);

            foreach($img as $item){

                array_push($data, asset(Storage::url($item)));

            }

        }

        return $data;

    }

    public function getObtenerGaleriaAttribute(){

        

        $galeria = $this->hasMany(ArticulosImagen::class, 'productId','id')->get();

        if(count($galeria)>0){

            foreach($galeria as $img){

                $img->imagen = asset(Storage::url($img->imagen));

            }

        }

        return $galeria;

    }

    public function obtenerGaleria(){

        $galeria = $this->galeria;

        if($galeria){

            $galeria = explode(',',$galeria);

        }else{

            $galeria = [];            

        }

        

        return $galeria;

    }

    public function getObtenerColoresAttribute(){

        return $this->hasMany(ArticulosColores::class, 'productId','id')->get();

    }

    public function getPathColoresAttribute(){

        $data= null;

        if($this->colores){            

            $data =[];

            $colores = $this->colores;

            $img = explode(',',$colores);

            foreach($img as $item){

                array_push($data, asset(Storage::url($item)));

            }

        }

        return $data;

    }



    public function getPathAttribute()

    {

        $data= null;

        if($this->imagen){

            $data = asset(Storage::url($this->imagen));

        }

        return $data;

    }

    public function getPathFichaAttribute()

    {

        $data= null;

        if($this->archivo){

            $data = asset(Storage::url($this->archivo));

        }

        return $data;

    }

    public function DatoApi(){

        $client = new Client([

            'verify' => false, // Ignora la verificación del certificado SSL

        ]);

        $headers = [

            'accept' => 'application/json',

            'X-API-KEY' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8='

        ];

        $response = $client->request('GET', 'https://tytsaapi.ddns.net:8443/productos/'.$this->tipoProducto.'/'.$this->code, [

            RequestOptions::HEADERS => $headers,

            RequestOptions::TIMEOUT => 5,

        ]);        

        $datos = json_decode($response->getBody(), true);

        return $datos;

    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
   

    

}