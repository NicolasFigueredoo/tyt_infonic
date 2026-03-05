<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Hash;
class ClienteRegistro extends Model implements Authenticatable
{
    use SoftDeletes;

    protected $table = 'clientesregistro';

    protected $fillable = ['cuenta', 'estado', 'password','nombre','email'];
    protected $casts = [];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            // $model->uuid = __uuid();
        });
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getKey();
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
   
}
