<?php

namespace App\Http\Controllers\Soap;

ini_set("soap.wsdl_cache_enabled", "0");

	class SoapConexion {

		public  $objClientSoap;
		
		protected function getSoapConexion() {			
			try {
				ini_set('default_socket_timeout', 1800000);

				// SOAP 1.2 client
				$params = array ('encoding' => 'UTF-8', 'soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => 1, "connection_timeout" => 1800000);
				try{
					if(is_null($this->objClientSoap)){
						$this->objClientSoap = new \SoapClient('http://server.bizcom.com.ar/BizComIntegrationWS_2023_06_02/BizComAPIv1.asmx?WSDL',$params);
					}
					return $this->objClientSoap;
				}catch (\PDOException $ex){
					return false;
				}
				
			}
			catch (\PDOException $ex){
				echo "Conexion Error: " . $ex->getMessage();
			}
		}

	}
