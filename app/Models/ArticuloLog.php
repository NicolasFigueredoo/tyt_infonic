<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ArticuloLog extends Model {
    use SoftDeletes;

	protected $table = 'articulo_logs';
    protected $appends = ['created_at_human', 'created_at_formatted'];

    protected $fillable = [
        'articulo_id',
        'user_id',
        'message'
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

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getCreatedAtHumanAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtFormattedAttribute() {
        return $this->created_at->format('d/m/Y h:i A');
    }
}