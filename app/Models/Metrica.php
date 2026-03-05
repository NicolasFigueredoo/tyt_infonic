<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Metrica extends Model {
    use SoftDeletes;

	protected $table = 'metricas';

	protected $fillable = [
        'cliente_id',
        'producto_id',
        'cantidad',
        'tipo_evento',
        'fecha',
        'referrer'
    ];	protected $casts = [
	];

    


}