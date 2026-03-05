<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SubCategoria extends Model {
    use SoftDeletes;

	protected $table = 'sub_categoria';    
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
        return $this->hasMany(Articulo::class,'tipo_articulo_id','id')->get();        
    }
}