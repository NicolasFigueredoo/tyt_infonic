<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Empresa extends Model {
    use SoftDeletes;

	protected $table = 'empresas';
    protected $appends = ['path','pathLogo','pathLogoDos','pathLogoTres','pathNavbar'];
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
    public function getPathLogoAttribute()
    {
        $data= null;
        if($this->logo){
            $data = asset(Storage::url($this->logo));
        }
        return $data;
    }
    public function getPathLogoDosAttribute()
    {
        $data= null;
        if($this->logo_dos){
            $data = asset(Storage::url($this->logo_dos));
        }
        return $data;
    }
    public function getPathLogoTresAttribute()
    {
        $data= null;
        if($this->logo_tres){
            $data = asset(Storage::url($this->logo_tres));
        }
        return $data;
    }

    public function getPathNavbarAttribute()
    {
        $data= null;
        if($this->fondoNavbar){
            $data = asset(Storage::url($this->fondoNavbar));
        }
        return $data;
    }
}