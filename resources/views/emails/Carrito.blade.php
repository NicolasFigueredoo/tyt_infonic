<div>Realizado el @php $date = date('d/m/o') @endphp {{$date}}</div>
<div style="margin:auto;">
<p>Nuevo pedido</p><br>
<p>Se ha registrado una nueva venta. A continuaci��n se detallan los datos del comprador y los productos adquiridos:</p><br>

<p>Pedido #{{$pedido_carrito->id}}</p>
</div>
<table class="table">
    <th>Pedido</th>
    <tr><td>Razon social</td><td>{{$usuario->razonSocial}}</td></tr>
    <tr><td>Cuenta</td><td>{{$usuario->cuenta}}</td></tr>
    <tr><td>Nombre</td><td>{{$usuario->nombre}} {{$usuario->apellido}}</td></tr>
    <tr><td>Email</td><td>{{$usuario->email}}</td></tr>
    <tr><td>Empresa</td><td>{{$usuario->empresa}}</td></tr>    
    <tr><td>Observacion</td><td>{{$pedido_carrito->observacion}}</td></tr>
</table>
<table class="table" >
    <th>Detalle de compra</th>
    <tr>
        <td>Item #</td>
        <td>Descripcion</td>
        <td>Cantidad</td>
        <td>Precio</td>
    </tr>    

    @forelse ($pedido_carrito->pedido as $item)
    <tr>
        <td>{{$item['codigo']}}</td>
        <td>{{$item['nombre']}}</td>
        <td>{{$item['cantidad']}}</td>
        <td> $ {{$item['precio']}}</td>
     
    </tr>
    @empty
    @endforelse    
<tr><td colspan="4">TOTAL: ${{ number_format($pedido_carrito->total_pedido, 2, ',', '.') }}</td></tr>
</table>
