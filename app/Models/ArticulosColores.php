<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticulosColores extends Model {
    use SoftDeletes;
	protected $table = 'articulos_colores';
    protected $fillable = [];
	protected $casts = [
	];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
    }

    public function obtenerProducto(){        
        return $this->belongsTo ('App\Models\Articulo','id','productId')->first();
    }
}