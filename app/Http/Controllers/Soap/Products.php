<?php

namespace App\Http\Controllers\Soap;

//session_start();
//require_once "SoapConexion.class.php";
use App\Http\Controllers\Soap\SoapConexion;
use App\Models\Articulo;
use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Support\Facades\Hash;
use stdClass;

class Products extends SoapConexion
{

	public function GetProducts()
	{
		try {
			$fechaAnterior = date('Y/m/d H:i:s', strtotime('-1 day'));			
			$this->getSoapConexion();

			$GetProductsRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Filters>' .
				'<Filter Name="ChangedFrom" Value="'.$fechaAnterior.'"/>' .
				'</Filters>' .
				'</Request>';

			$GetProductsResponse = $this->objClientSoap->GetProductsV3(array('request' => $GetProductsRequest));
			//dd($GetProductsResponse->GetProductsV3Result);
			$xml = simplexml_load_string($GetProductsResponse->GetProductsV3Result);
			return $xml;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}
	public function updateUnidades()
	{
		$client = new Login();
		$client->getLogin('16C9326D-D680-493E-A327-69821CC8451C', '..sdfSD3afA3fsafaf_');
		$products = $this->GetProductsV3("2023/04/07 00:00:00");
		//dd($products->Families->Family[2]['FamilyId']);
		$count = 0;
		foreach ($products->Families->Family as $family) {
			$familyId = strval($family['FamilyId']);
			//dd($familyId);
			$articulos = Articulo::where('familyId', '=', $familyId)->get();
			if ($articulos) {
				foreach ($articulos as $articulo) {
					$articulo->unidad = strval($family->MeasureUnit['Symbol']);
					$articulo->save();
				}
			}
		};
	}



	public function addNew()
	{
		$client = new Login();
		$client->getLogin('16C9326D-D680-493E-A327-69821CC8451C', '..sdfSD3afA3fsafaf_');
		$clientes = $this->GetCustomer();
		$count = 0;
		foreach ($clientes->Customers->Customer as $cliente) {
			$CustomerId = strVal($cliente['CustomerId']);
			$client = Cliente::where('CustomerId', '=', $CustomerId)->first();
			if (!$client) {
				$client = new Cliente;
				$client->CustomerId = $CustomerId;
				$client->CustomerCode = $cliente['CustomerCode'];
				$client->Enabled = $cliente['Enabled'];
				$client->empresa = $cliente['CustomerDescription'];
				$client->razonSocial = $cliente['BusinessName'];
				$client->DefaultListPriceId = $cliente['DefaultListPriceId'];
				$client->TaxConditionName = $cliente['TaxConditionName'];
				$client->direccion = $cliente['Address.Street'];
				$client->provincia = $cliente['Address.State'];
				$client->localidad = $cliente['Address.City'];
				$client->cp = $cliente['Address.PostalCode'];
				$client->telefono = $cliente['CustomerTelephone'];
				$client->cuit = $cliente->Company['CUIT'];
				$username = str_replace(' ', '', $cliente->Company['CUIT']);
				$username = str_replace('-', '', $cliente->Company['CUIT']);
				$client->username = $username . $count . "new";
				$client->password = Hash::make("euma123");
				$client->save();
			}
			$count++;
		}
		return "Ok";
	}

	public function GetCategoria()
	{
		try {
			$this->getSoapConexion();
			$GetProductsRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Filters>' .
				'<Filter Name="ChangedFrom" Value="2023/01/01 00:00:00"/>' .
				'</Filters>' .
				'</Request>';

			$GetProductsResponse = $this->objClientSoap->GetProductCategories(array('request' => $GetProductsRequest));
			$xml = simplexml_load_string($GetProductsResponse->GetProductCategoriesResult);
			return $xml;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}

	public function applyPromotion($articulo)
	{
		try {
			$client = new Login();
			$idLogin = $client->getLogin('16C9326D-D680-493E-A327-69821CC8451C', '..sdfSD3afA3fsafaf_');
			$this->getSoapConexion();

			$apply = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Invoice>' .
				'<Customer CustomerId="34A17C00-2678-49F7-87B4-82F1BD881E27"/>' .
				'<Items>' .
				'<Item ' .
				'ProductId="' . $articulo->productId . '" ' .
				'Quantity="' . $articulo->cantidad . '" ' .
				'Price="' . $articulo->precio . '" MoneyId="2"/> ' .
				'</Items>' .
				'</Invoice>' .
				'</Request>';

			$response = $this->objClientSoap->ApplyPromotions(array('request' => $apply));
			$applyPromotionsResult = $response->ApplyPromotionsResult;
			$xml = simplexml_load_string($applyPromotionsResult);
			
			return $xml->Items->Item;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}
	public function addPedido($carrito,$cliente,$envio)
	{
		try {
			$client = new Login();
			$idLogin = $client->getLogin('16C9326D-D680-493E-A327-69821CC8451C', '..sdfSD3afA3fsafaf_');
			$this->getSoapConexion();
			$orderId = uniqid();
			if (function_exists('com_create_guid')) {
				$uuid = com_create_guid();
			} else {
				mt_srand((double)microtime() * 10000);
				$charid = strtoupper(md5(uniqid(rand(), true)));
				$hyphen = chr(45);
				$uuid = chr(123)
					. substr($charid, 0, 8) . $hyphen
					. substr($charid, 8, 4) . $hyphen
					. substr($charid, 12, 4) . $hyphen
					. substr($charid, 16, 4) . $hyphen
					. substr($charid, 20, 12)
					. chr(125);				
			}
		
			$order = '<Request>'.
			'<Authentication '.
			'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" '.
			'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>'.
			'<Order OrderId="'.$uuid.'" CustomerDescription="'.$cliente->empresa.'" DeliveryAddress="'.$envio.'">'.
				'<Customer CustomerId="'.$cliente->CustomerId.'"/>'.
				'<OrderItems>';
				foreach($carrito as $item){				
					$order .='<OrderItem><Product ProductId="'.$item->productId.'" Quantity="'.$item->cantidad.'" Price="'.$item->precio.'" DiscountValue="'.$item->DiscountValue.'" DefaultTaxIncluded="True"/>'.
					'</OrderItem>';					
				}
					$order .='</OrderItems>'.
							'</Order>'.
						'</Request>';

			//dd($order);
			// $order = '<Request>' .
			// 	'<Authentication ' .
			// 	'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
			// 	'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
			// 	'<Customer CustomerId="fcd8b337-6ffe-4554-8965-2b352bff7efd"/>' .
			// 	'<OrderItems>' .
			// 	'<OrderItem>' .
			// 	'<Product ProductId="dcc7bbdb-bda8-4d8d-ac15-195b2faa2721" Quantity="1.00" Price="1.50" DiscountValue="6.00000" DefaultTaxIncluded="True"/>' .
			// 	'</OrderItem>' .
			// 	'<OrderItem>' .
			// 	'<Product ProductId="a31747c9-9e4e-44b4-a036-e854d538a22b" Quantity="1.50" Price="2.30" DiscountValue="6.00000" DefaultTaxIncluded="True"/>' .
			// 	'</OrderItem>' .
			// 	'</OrderItems>' .
			// 	'</Order>' .
			// 	'</Request>';

			$response = $this->objClientSoap->AddOrder(array('request' => $order));			
			//dd($response);
			$xml = simplexml_load_string($response->AddOrderResult);
			$obj = new stdClass;
			$obj->orderId = (string) $xml->Order['OrderId'];
			$obj->orderNumber = (string) $xml->Order['OrderNumber'];
			return $obj;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}
	public function GetCustomer()
	{
		try {

			$this->getSoapConexion();

			$GetCustomersRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Filters>' .
				'</Filters>' .
				'</Request>';

			$GetCustomersResponse = $this->objClientSoap->GetCustomers(array('request' => $GetCustomersRequest));
			
			$GetCustomersResponse->GetCustomersResult = str_replace('@', '',$GetCustomersResponse->GetCustomersResult);			
			
			$xml = simplexml_load_string($GetCustomersResponse);
			dd($xml);
			//$xml = $GetCustomersResponse->GetCustomersResult;

			return $xml;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}
	public function updateClientes()
	{
		$client = new Login();
		$client->getLogin('16C9326D-D680-493E-A327-69821CC8451C', '..sdfSD3afA3fsafaf_');
		$clientes = $this->GetCustomer();
		$count = 0;
		
		
		foreach ($clientes->Customers->Customer as $cliente) {
			dd($cliente);
			$CustomerId = strVal($cliente['CustomerId']);
			$client = Cliente::where('CustomerId', '=', $CustomerId)->first();
			if (!$client) {
				$client = new Cliente;
				$ultimoId = Cliente::latest()->value('id');
				if($cliente->Company){
					$client->cuit = (string)$cliente->Company['CUIT'];
					$username = str_replace(' ', '', $cliente->Company['CUIT']);
					$username = str_replace('-', '', $cliente->Company['CUIT']);
				}
				if($cliente->Person){
					$client->dni = (string)$cliente->Person['DocumentNumber'];					
					$client->nombre = $cliente->Person['FirstName'];
					$client->apellido = $cliente->Person['FirstName'];
					$username = str_replace(' ', '', $cliente->Person['DocumentNumber']);
					$username = str_replace('-', '', $cliente->Person['DocumentNumber']);
				}
				$client->username = $username . $ultimoId+1;
				$client->password = Hash::make("euma123");
			}
			if($cliente->Company){
				$client->tipo = "compania";
			}
			if($cliente->Person){
				$client->tipo = "persona";
			}
			$client->CustomerId = $CustomerId;
			$client->CustomerCode = $cliente['CustomerCode'];
			$client->CustomerDescription = $cliente['CustomerDescription'];
			$client->Enabled = $cliente['Enabled'];
			$client->empresa = $cliente['CustomerDescription'];
			$client->razonSocial = $cliente['BusinessName'];
			$client->DefaultListPriceId = $cliente['DefaultListPriceId'];
			$client->TaxConditionName = $cliente['TaxConditionName'];
			$client->direccion = $cliente['Address.Street'];
			$client->provincia = $cliente['Address.State'];
			$client->localidad = $cliente['Address.City'];
			$client->cp = $cliente['Address.PostalCode'];
			$client->telefono = $cliente['CustomerTelephone'];

			$client->save();
			$count++;			
		}
		return "Ok";
	}
	public function addCustomer($cliente)
	{
		try {

			$this->getSoapConexion();

			$GetCustomersRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Customer TaxCondition="'. $cliente->TaxConditionName .'" BusinessName="'. $cliente->empresa .'">';
				if($cliente->tipo == 'persona'){
					$GetCustomersRequest .= '<Person FirstName="'. $cliente->nombre .'" LastName="'. $cliente->apellido .'" DocumentType="CUIT" DocumentNumber="'. $cliente->cuit .'">
					</Person>';
				}else{
					$GetCustomersRequest .= '<Company Name="'. $cliente->nombreEmpresa .'" CUIT="'. $cliente->cuit .'">
					</Company>';
				}
				$GetCustomersRequest .= '<CustomerAddress Street="'. $cliente->direccion .'" StreetNumber="'. $cliente->numero .'" City="'. $cliente->localidad .'" State="'. $cliente->provincia .'" PostalCode="'. $cliente->cp .'" Body="" Floor="" Department="" Office=""/>'.
				'<DeliveryAddress Street="'. $cliente->direccionEntrega .'" StreetNumber="'. $cliente->numeroEntrega .'" City="'. $cliente->localidadEntrega .'" State="'. $cliente->provinciaEntrega .'" PostalCode="'. $cliente->cpEntrega .'" Body="" Floor="" Department="" Office=""/>'.
				'<ContactInfo Telephone="'. $cliente->telefono .'" EMail="'. $cliente->email .'"/>'.
				'<Comments>
				<![CDATA[Transporte: '.  $cliente->transporte .']]>
				</Comments>'.
				'</Customer>'.
				'</Request>';
				
			$GetCustomersResponse = $this->objClientSoap->AddCustomer(array('request' => $GetCustomersRequest));


			$xml = simplexml_load_string($GetCustomersResponse->GetCustomersResult);

			return $xml;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}
	public function GetPromotionProducts()
	{
		try {

			$this->getSoapConexion();

			$GetPromotionProductsRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Filters>' .
				'</Filters>' .
				'</Request>';

			$GetPromotionProductsResponse = $this->objClientSoap->GetPromotionProducts(array('request' => $GetPromotionProductsRequest));

			$xml = simplexml_load_string($GetPromotionProductsResponse->GetPromotionProductsResult);
			return $xml;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}
	public function GetPromotionsTest($productId)
    {
		
        try {
            $client = new Login();
            $idLogin = $client->getLogin('16C9326D-D680-493E-A327-69821CC8451C', '..sdfSD3afA3fsafaf_');
            $Products = new Products;
            $promociones = $Products->GetPromotions();			
            foreach ($promociones->Promotions[0] as $promo) {
				$id = (string)$promo['PromotionId'];
                $productos = $this->GetPromotionId($id)->Promotion->Products;
				
			
                foreach ($productos[0] as $producto) {
					
					$auxId = (string)$producto['ProductId'];					
                    if ($productId == $auxId) {
						//dd($promo['Name']);
                        return (string)$promo['Name'];                        
                    }
                }
            }
            
        } catch (\PDOException $e) {
            return "error";
        }
    }
	public function GetPromotions()
	{

		$this->getSoapConexion();

		$GetPromotionsRequest = '<Request>' .
			'<Authentication ' .
			'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
			'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
			'<Filters>' .
			'<Filter Name="ChangedFrom" Value="2023/04/07 00:00:00"/>' .
			'</Filters>' .
			'</Request>';

		$GetPromotionsResponse = $this->objClientSoap->GetPromotions(array('request' => $GetPromotionsRequest));
		$xml = simplexml_load_string($GetPromotionsResponse->GetPromotionsResult);

		return $xml;
	}

	public function GetPromotionId($id)
	{
		try{
			$this->getSoapConexion();
	
			$GetPromotionsRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Promotion PromotionId="' . $id . '"/>' .
				'</Request>';
	
				try{
					$GetPromotionsResponse = $this->objClientSoap->GetPromotion(array('request' => $GetPromotionsRequest));
					$xml = simplexml_load_string($GetPromotionsResponse->GetPromotionResult);
			
					return $xml;
				}catch(\PDOException $e){
					return false;
				}
	
		} catch (\PDOException $e) {
			return false;
		}
	}

	public function GetProductsV3($dateLastUpdate)
	{
		try {

			$this->getSoapConexion();
			$dateLastUpdate = str_replace("-", "/", $dateLastUpdate);
			//echo $ApplicationId = $_SESSION["AuthenticationId"];
			$GetProductsRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Filters>' .
				'<Filter Name="ChangedFrom" Value="' . $dateLastUpdate . '"/>' .
				'</Filters>' .
				'</Request>';

			//var_dump($GetProductsRequest);

			$GetProductsResponse = $this->objClientSoap->GetProductsV3(array('request' => $GetProductsRequest));
			//echo $dateLastUpdate."<br>";
			$xml = simplexml_load_string($GetProductsResponse->GetProductsV3Result);
			return $xml;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}

	public function getProductSmallImage($ProductId)
	{
		try {

			$this->getSoapConexion();

			//echo $ApplicationId = $_SESSION["AuthenticationId"];

			$GetProductsSmallImageRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Product ProductId="' . $ProductId . '" />' .
				'</Request>';

			$GetProductsSmallImageResponse = $this->objClientSoap->GetProductSmallImage(array('request' => $GetProductsSmallImageRequest));
			//$smallImage = simplexml_load_string($GetProductsSmallImageResponse->GetProductSmallImageResult);
			//$smallImage = base64_decode($GetProductsSmallImageResponse->GetProductSmallImageResult);
			//$smallImage = array($GetProductsSmallImageResponse->GetProductSmallImageResult);
			$smallImage = $GetProductsSmallImageResponse->GetProductSmallImageResult;
			//var_dump($GetProductsSmallImageResponse);
			return $smallImage;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();
		}
	}

	public function GetProductBigImage($ProductId)
	{
		try {

			$this->getSoapConexion();

			//echo $ApplicationId = $_SESSION["AuthenticationId"];

			$GetProductsBigImageRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Product ProductId="' . $ProductId . '" />' .
				'</Request>';

			//var_dump($GetProductsBigImageRequest);

			$GetProductsBigImageResponse = $this->objClientSoap->GetProductBigImage(array('request' => $GetProductsBigImageRequest));
			//$smallImage = simplexml_load_string($GetProductsSmallImageResponse->GetProductSmallImageResult);
			//$smallImage = base64_decode($GetProductsSmallImageResponse->GetProductSmallImageResult);
			//$smallImage = array($GetProductsSmallImageResponse->GetProductSmallImageResult);
			//$BigImage = $GetProductsBigImageResponse->GetProductBigImageResult;
			$BigImage = $GetProductsBigImageResponse->GetProductBigImageResult;
			//var_dump($GetProductsBigImageResponse);
			return $BigImage;
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();
		}
	}

	public function GetDiscountsV3($dateLastUpdate)
	{
		try {

			$this->getSoapConexion();
			$dateLastUpdate = str_replace("-", "/", $dateLastUpdate);
			echo $ApplicationId = $_SESSION["AuthenticationId"];
			/*
				$GetDiscountsRequest = '<Request>'.
				'<Authentication '.
				'ApplicationId="6EFE9A13-6410-475F-815E-691CBB520026" '.
				'AuthenticationId="'.$_SESSION["AuthenticationId"].'"/>'.
				'<Filters>'.
				'<Invoice>'.
				'<Customer CustomerId="93085F67-F588-473B-8D32-305EE43F6EF0"/>'.
				'<Items>
				<Item ProductId="883DAFD9-FCD4-4F93-B223-37BE5E33C64C" Quantity="5" 
				OriginalPrice="100" OriginalPriceMoneyId="1" Price="100" MoneyId="1" 
				Discount="0" DiscountType="Fixed"/>
				</Items>'.
				'</Invoice>'.
				'</Filters>'.
				'</Request>';*/

			$GetDiscountsRequest = '<Request>' .
				'<Authentication ' .
				'ApplicationId="16C9326D-D680-493E-A327-69821CC8451C" ' .
				'AuthenticationId="' . $_SESSION["AuthenticationId"] . '"/>' .
				'<Invoice>' .
				'<Customer CustomerId="93085F67-F588-473B-8D32-305EE43F6EF0"/>' .
				'<Items>
				<Item ProductId="9851D927-3FEB-45FA-A000-4B7593B8E58B" Quantity="5" 
				OriginalPrice="100" OriginalPriceMoneyId="1" Price="100" MoneyId="1" 
				Discount="0" DiscountType="Fixed"/>
				</Items>' .
				'</Invoice>' .
				'</Request>';
			var_dump($GetDiscountsRequest);
			echo "<br><br>";
			$GetDiscountsResponse = $this->objClientSoap->ApplyPromotions(array('request' => $GetDiscountsRequest));
			var_dump($GetDiscountsResponse);
			$xml = simplexml_load_string($GetDiscountsResponse->ApplyPromotionsResult);
			return $xml;
			// AppId BizCom = 16C9326D-D680-493E-A327-69821CC8451C
			// AppId = 6EFE9A13-6410-475F-815E-691CBB520026
		} catch (\PDOException $e) {
			//echo "Conexion Error: " . $e->getMessage();

		}
	}
}
