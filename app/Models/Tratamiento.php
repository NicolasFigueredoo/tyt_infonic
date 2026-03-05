<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Tratamiento extends Model {
    use SoftDeletes;

	protected $table = 'tratamientos';
    protected $appends = [];

    protected $fillable = [];
	protected $casts = [
	];

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
    }

    
}