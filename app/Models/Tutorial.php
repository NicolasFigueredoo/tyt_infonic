<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Tutorial extends Model {
    use SoftDeletes;

	protected $table = 'tutoriales';
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
    public function codigo(){
        $url = $this->link;
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $queryParams);
        $codigo = $queryParams['v'];
    
        return $codigo;
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