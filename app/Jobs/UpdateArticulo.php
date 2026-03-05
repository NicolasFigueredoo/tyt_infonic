<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use App\Models\Articulo;
use App\Models\CategoriasArticulo;
use Intervention\Image\ImageManagerStatic as Image;
use App\Http\Controllers\Soap\Login;
use App\Http\Controllers\Soap\Products;

ini_set("soap.wsdl_cache_enabled", "0");

class UpdateArticulo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public  $objClientSoap;
    public $soapVersion = "SOAP_1_2";  
    public $ExpiresOn;
    public $AuthenticationId;  
    public $idnot;
    public $fecha;
    public $fechaFutura;
    public $nuevafecha;
    public $objClienteSOAP;
    public $ApplicationId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

        $user = '16C9326D-D680-493E-A327-69821CC8451C';
        $pass = '..sdfSD3afA3fsafaf_';

        $LoguinRequest = '<Request>'.
        '<Authentication '.
        'ApplicationId="'.$user.'" '. 
        'ApplicationPassword="'.$pass.'"/>'.
        '</Request>';
        $params = array(
        'encoding' => 'UTF-8',
        'soap_version' => SOAP_1_2,
        'trace' => true,
        'exceptions' => true,
        'connection_timeout' => 1800000,
        );
        $wsdlUrl = 'http://server.bizcom.com.ar/BizComIntegrationWS_2023_06_02/BizComAPIv1.asmx?WSDL';
        $objClientSoap = new \SoapClient($wsdlUrl, $params);
        $response = $objClientSoap->Login(array('request' => $LoguinRequest));
        $xml = simplexml_load_string($response->LoginResult);        
        $this->AuthenticationId = (string) $xml->Authentication["AuthenticationId"];
        $this->ExpiresOn = (string) $xml->Authentication["ExpiresOn"];
        $ExpiresOn = $this->ExpiresOn;
        date_default_timezone_set("America/Argentina/Buenos_Aires");
		$this->fecha = strtotime(date('Y-m-j H:i:s'));
        $this->fechaFutura = strtotime("+$ExpiresOn minute",$this->fecha);        
        $this->nuevafecha = strtotime("-2 minute" , $this->fechaFutura);
        $this->ApplicationId = $user;

        $fechaAnterior = date('Y/m/d H:i:s', strtotime('-1 day'));
        $GetProductsRequest = '<Request>' .
        '<Authentication ' .
        'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
        'AuthenticationId="' . $this->AuthenticationId . '"/>' .
        '<Filters>' .
        '<Filter Name="ChangedFrom" Value="2023/01/17 08:58:17"/>' .
        '</Filters>' .
        '</Request>';
        $GetProductsResponse = $objClientSoap->GetProductsV3(array('request' => $GetProductsRequest));		
        $cats = simplexml_load_string($GetProductsResponse->GetProductsV3Result);
        
       $cats = $cats->Products->Product;            
        $objects = array();
        $data = collect();
        foreach ($cats as $item) {            
                $attributes = $item->attributes();
                $productId = (string) $attributes['ProductId'];
                $object = Articulo::where('productId', '=', $productId)->first();
                if (is_null($object)) {
                    $object = new Articulo;
                }
                $object->familyId = (string) $attributes['FamilyId'];
                $categorias = $item->Categories->Category;

                if ($categorias != null && count($categorias) > 0) {
                    foreach ($categorias as $categoria) {
                        //BUSCAR EN TABLA PIBOTE SI EXITE RELACION SI NO CREALA
                        $catAux = $categoria->attributes();
                        $catAux = (string) $catAux->CategoryId;
                        $pibot = CategoriasArticulo::where('productId', '=', $productId)->where('categoryId', '=', $catAux)->first();
                        if (is_null($pibot)) {
                            $pibot = new CategoriasArticulo();
                            $pibot->productId = $productId;
                            $pibot->categoryId = $catAux;
                            $pibot->save();
                        }
                    }
                }
                $object->name = (string) $attributes['FullName'];
                $object->code = (string) $attributes['AppCode'];
                
                if($object->imagen || $object->imagen != "" ){
                    $img = $objClientSoap->GetProductBigImage($attributes['ProductId']);
                    $nombreArchivo = 'articulo/' . (string) $attributes['ProductId'] . '.gif';
                    // Crear un recurso de imagen a partir de los datos de mapa de bits
                    $img = json_encode($img);
                    
                    if ($img != "" && $img != '{}') {
                        //$img = imagecreatefromstring($img);
                        // Crear una instancia de la clase Intervention Image
                        $image = Image::make($img);
                        Storage::disk('public')->put($nombreArchivo, $image->stream('gif', 90));
                        $object->imagen = $nombreArchivo;
                    }
                }
                $object->precio = (float) $attributes['Price'];
                $object->productId = (string) $attributes['ProductId'];
                $object->save();
                $data->push($object);
        
    } 

    }
    /**
     * Execute the job.
     *
     * @return void
     */ 

    public function handle()
    { 

        return "ok";
    }
}
