<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Inicio extends Model {
    use SoftDeletes;

	protected $table = 'inicios';
    protected $appends = ['path','pathDos', 'pathTres'];
    protected $fillable = [];
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
    public function getPathDosAttribute()
    {
        $data= null;
        if($this->imagenDos){
            $data = asset(Storage::url($this->imagenDos));
        }
        return $data;
    }   
    public function getPathTresAttribute()
    {
        $data= null;
        if($this->imagenFooter){
            $data = asset(Storage::url($this->imagenFooter));
        }
        return $data;
    }  
}