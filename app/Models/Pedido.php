<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Pedido extends Model {
    use SoftDeletes;

	protected $table = 'pedidos';    
    protected $appends = ['empresa','carrito'];
    protected $fillable = [];
	protected $casts = [
	];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
    }  
    public function getCliente() {
        return $this->belongsTo(Cliente::class, 'usuario_id','id')->first();
    } 
    public function getCarritoAttribute(){
        $carrito = $this->pedido;
        return json_decode($carrito);
    }
    public function getEmpresaAttribute()
    {
        $cliente = $this->getCliente();
        // $empresa = $cliente->empresa ?? $cliente->username .' '. $cliente->username;

        $empresa = $cliente->razonSocial 
        ?? $cliente->username 
        ?? $cliente->customerDescripcion 
        ?? '';

        return $empresa;
    }
}