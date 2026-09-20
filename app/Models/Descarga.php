<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class Descarga extends Model {
    use SoftDeletes;

	protected $table = 'descargas';
    protected $appends = ['path'];

    protected $fillable = [];
	protected $casts = [
	];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
    }    

    // Secciones: 'lista' se muestra en Lista de precios, 'catalogo' en Catálogos.
    // El tipo lo define la sección del admin donde se carga el registro.
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function getPathAttribute()
    {
        $data= null;
        if($this->imagen){
            $data = asset(Storage::url($this->imagen));
        }
        return $data;
    }


}