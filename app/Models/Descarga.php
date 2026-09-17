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

    // Una descarga se considera "catálogo" si su título (ES o EN) contiene la palabra catálogo/catalog.
    // Se compara sin acentos ni mayúsculas para no depender de cómo se cargó en el admin.
    public function esCatalogo(): bool
    {
        $texto = Str::lower(Str::ascii($this->titulo . ' ' . $this->tituloEnglish));
        return Str::contains($texto, 'catalog');
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