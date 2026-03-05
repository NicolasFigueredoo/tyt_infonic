<?php
namespace App\Http\Controllers\Soap;

session_start();
use App\Http\Controllers\Soap\SoapConexion;
//require_once "./SoapConexion.php";
//require_once "./app/Http/Controllers/Soap/SoapConexion.php";

class Login extends SoapConexion {

		public $idnot;
		public $fecha;
		public $fechaFutura;
		public $nuevafecha;
		public $ExpiresOn;
		public $AuthenticationId;
		public $objClienteSOAP;

		public function getLogin($user,$pass) {		
				
				$params = array ('encoding' => 'UTF-8', 'soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => 1, "connection_timeout" => 1800000);
				if(is_null($this->objClientSoap)){
					$this->objClientSoap = new \SoapClient('http://server.bizcom.com.ar/BizComIntegrationWS_2023_06_02/BizComAPIv1.asmx?WSDL',$params);					
				}
				try{
				$LoguinRequest = '<Request>'.
				'<Authentication '.
				'ApplicationId="'.$user.'" '. 
				'ApplicationPassword="'.$pass.'"/>'.
				'</Request>';
				try{
					$LoguinResponse = $this->objClientSoap->Login(array('request' => $LoguinRequest));
					$xml = simplexml_load_string($LoguinResponse->LoginResult);					
					$this->AuthenticationId = (string) $xml->Authentication["AuthenticationId"];
					$this->ExpiresOn = (string) $xml->Authentication["ExpiresOn"]; // Tiempo en que expira
					//var_dump($LoguinResponse);
					//echo "<br><br>";
					
					$ExpiresOn = $this->ExpiresOn;
					//TIEMPO ACTUAL
					date_default_timezone_set("America/Argentina/Buenos_Aires");
					$this->fecha = strtotime(date('Y-m-j H:i:s'));
					// TIEMPO MAS MINUTOS DE EXPIRACION
					$this->fechaFutura = strtotime("+$ExpiresOn minute",$this->fecha) ;
					//TIEMPO CON DESCUENTO RESTANDO 2 MINUTOS
					$this->nuevafecha = strtotime("-2 minute" , $this->fechaFutura) ;
					
									/*
									echo $this->ExpiresOn."<-EXPIRA BIZCOM";
									echo "<br>";
									echo $this->fecha."<-ACTUAL";
									echo "<br>";
									echo $this->fechaFutura."<-EXPIRA";
									echo "<br>";
									echo $this->nuevafecha."<-LOGIN 2 Minutos antes";
									*/
					
									// Guardo en variables de Session
									$_SESSION["nuevafecha"] = $this->nuevafecha; // Fecha a expirar
									$_SESSION["AuthenticationId"] = $this->AuthenticationId;
									$_SESSION["ExpiresOn"] = $this->ExpiresOn;
									$_SESSION["ApplicationId"] = $user;
					
									return $this->AuthenticationId;
				}catch (\PDOException $e){
					return false;
				}
				
			}
				catch (\PDOException $e){
					//echo "Conexion Error: " . $e->getMessage();

			}
		
	}

		public function timeExpire() {

			date_default_timezone_set("America/Argentina/Buenos_Aires");
			$this->fecha = date('Y-m-j H:i:s');
			$this->fecha = strtotime($this->fecha);

			$user = '2f5c3bdb-abe5-456c-81c0-10c9446eed31';
			$pass = 'HJ28ah92aj{2_aa';

			/*
			echo $_SESSION["nuevafecha"];
			echo "=";
			echo $this->fecha;
			*/
			if ($_SESSION["nuevafecha"]<=$this->fecha) {
				$this->getLogin($user,$pass);
				//echo "<script>alert('Session Actualizada con exito')</script>";
			}

		}

	}
