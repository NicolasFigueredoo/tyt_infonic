<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Contacto extends Model {
    use SoftDeletes;

	protected $table = 'contactos';
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

    public function direccionMap(){
        $data = $this->direccion;
        $data = str_replace(" ","%20",$data);
        return $data;
    }
    public function getPathAttribute()
    {
        $data= null;
        if($this->direccion){
            $data = asset(Storage::url($this->direccion));
        }
        return $data;
    }
}