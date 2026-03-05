<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Hash;
use App\Models\TipoArticulo;


class Cliente extends Model implements Authenticatable
{
    use SoftDeletes;

    protected $table = 'clientes';


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
    public static function updateApi(){
        $page = 1;
        $client = new Client([
            'verify' => false, // Ignora la verificación del certificado SSL
        ]);
        $headers = [
            'accept' => 'application/json',
            'X-API-KEY' => 'AQEBEQtz8rVkLVvBKgmYuUmALBpS5GaLG28OUFpd3O08GlfjWrjH3wWt5Hk0GEra5MsMseWHtdise8FGiu3P7iNjEocjzW2T+IJ7c9TH0rbf17trDAc8qK4mAgvv3AMcu5CjuDwzR+9qS1uF5ZZwUNN/FFgD8HRRgkik86XZfttYSPK68RpnFSBrT2XDUTeXvcOdjTjzH7AwJDHj+o9WwskXIQT7Ubgj+oAaTjd4Obq+uyObg75n033Ct5ZO53JTHsvCDfbcMU1BtRtw4CvFynEPiEQ7rufWnDThqJQKqfLvSgBjr2c3L3QV8EKvuNsnNO9vQGrZbuY58sMTXGmMio1iTUxwrnOPpsCO9L4Jr1Onwgu+bIStiJcS2w/3hbzVWR2yo1YWvW0LjJquBNx1I46aUCiw82jHAffI788rrNNuYA8='
        ];
        $response = $client->request('GET', 'https://190.195.163.194:8443/clientes?maxCount=100&page='.$page, [
            RequestOptions::HEADERS => $headers,
        ]);        
        $clientes = json_decode($response->getBody(), true);
        
        // $pageCount = intval(ceil($clientes['count'] / 100));
        
        // while ($page < $pageCount) {
        //    $response = $client->request('GET', 'https://190.195.163.194:8443/clientes?maxCount=100&page='.$page, [
        //        RequestOptions::HEADERS => $headers,
        //    ]);
        //    $clientes = json_decode($response->getBody(), true);
            
            foreach($clientes['values'] as $user){
                $userAux = Cliente::where('username','=',$user['cuenta'])->first();
                if(!$userAux){
                    $userAux = new Cliente();
                    $userAux->password = Hash::make($user['cuenta']);
                    $userAux->username = $user['cuenta'];
                }
                $userAux->estado = 1;
                $userAux->save();
            }
        //    $page++;
        //}
        //return $page;
    }

    // app/Models/Cliente.php

    public function categoriasPermitidas()
    {
        return $this->belongsToMany(
            TipoArticulo::class,  // Modelo relacionado
            'cliente_categoria',  // Tabla pivote
            'id_cliente',         // FK en la tabla pivote hacia Cliente
            'id_categoria',       // FK en la tabla pivote que contiene el valor de la clave de TipoArticulo
        );
    }
    
    

}
