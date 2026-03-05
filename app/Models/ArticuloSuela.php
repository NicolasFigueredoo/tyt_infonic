<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticuloSuela extends Model {
    use SoftDeletes;

	protected $table = 'articulo_suelas';
    protected $appends = ['path','pathFicha','pathGaleria','pathColores','obtenerGaleria'];

    protected $fillable = [];
	protected $casts = [
	];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
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
        $galeria = $this->galeria;
        $galeria = str_replace('/','-',$galeria);
        
        $galeria = explode(',',$galeria);
        
        return $galeria;
    }
    public function obtenerGaleria(){
        $galeria = $this->galeria;
        $galeria = explode(',',$galeria);
        
        return $galeria;
    }
    public function obtenerColores(){
        $galeria = $this->colores;
        $galeria = explode(',',$galeria);
        
        return $galeria;
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
    
}