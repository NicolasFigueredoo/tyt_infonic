<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ArticuloStock extends Model {
    use SoftDeletes;

	protected $table = 'articulo_stock';
    protected $appends = [];

    protected $fillable = [
        'articulo_id',
        'almacen_id',
        'ubicacion',
        'cantidad',
        'peso',
        'observaciones'
    ];
	protected $casts = [];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
    }

    public function articulo() {
        return $this->belongsTo(Articulo::class, 'articulo_id');
    }

    public function almacen() {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }
}