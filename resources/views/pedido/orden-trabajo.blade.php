@extends('pedido.pdf-layout')

@section('content')
<h1 class="mb-15">Order de Trabajo, Pedido: {{ $pedido->codigo }}</h1>
<table>
    <tr>
        <th class="text-left nowrap">FECHA DE CARGA:</th>
        <td class="pl-4 pr-8">{{ $pedido->fecha_carga_formated }}</td>
        <th class="text-left nowrap">FECHA DEL PEDIDO:</th>
        <td class="pl-4 pr-8">{{ $pedido->fecha_pedido_formated }}</td>
    </tr>
    <tr>
        <th class="text-left nowrap">FECHA DE ENTREGA:</th>
        <td class="pl-4 pr-8">{{ $pedido->fecha_entrega_formated }}</td>
        <th class="text-left nowrap">CLIENTE:</th>
        <td class="pl-4 pr-8">{{ $pedido->cliente->business_name }}</td>
    </tr>
</table>
<!-- Diagrama en html -->
@foreach($rollos as $rollo)
    <h2 class="mt-25">Rollo</h2>
    <table>
        <tr>
            <th class="text-left nowrap">Material:</th>
            <td class="pl-4 pr-8">{{ $rollo['rollo']->articulo->name }}</td>
            <th class="text-left nowrap">Código:</th>
            <td class="pl-4 pr-8">{{ $rollo['rollo']->code }}</td>
            <th class="text-left nowrap">Ancho:</th>
            <td class="pl-4 pr-8">{{ $rollo['rollo']->tamano_y }}</td>
            <th class="text-left nowrap">Largo:</th>
            <td class="pl-4 pr-8">{{ $rollo['rollo']->tamano_x }}</td>
        </tr>
    </table>
    <div style="position: relative; width: 100%; height: 100px; border: 1px solid #c9c9c9;box-sizing: border-box;">
    @foreach ($rollo['rollo']->entredas as $entrada)
        <div style="
            position: absolute;
            left: {{ $entrada->origen_x_porcentaje; }}%;
            top: {{ $entrada->origen_y_porcentaje; }}%;
            width: {{ $entrada->tamano_x_porcentaje; }}%;
            height: {{ $entrada->tamano_y_porcentaje; }}%;
            border: 1px solid #c9c9c9;
            box-sizing: border-box;
        "></div>
    @endforeach
    @php($salidas = [])
    @foreach ($rollo['salidas'] as $salida)
        @php($salidas[] = $salida['salida'])
        <div style="
            position: absolute;
            left: {{ $salida['salida']->origen_x_porcentaje; }}%;
            top: {{ $salida['salida']->origen_y_porcentaje; }}%;
            width: {{ $salida['salida']->tamano_x_porcentaje; }}%;
            height: {{ $salida['salida']->tamano_y_porcentaje; }}%;
            border: 1px solid #565656;
            box-sizing: border-box;
            background: rgb(233,233,233);
            font-weight: normal;
            color: #565656;
        ">
            <span style="
                left: 50%;
                transform: translate(-50%, -50%);
                position: absolute;
                top: 50%;
                font-size: 10px;
                font-weight: bold;
            ">{{ count($salidas) }}</span>
        </div>
    @endforeach
    </div>
    <h3 class="mt-15">Cortes a realizar</h3>
    <table class="table-striped">
        <thead>
            <tr>
                <th class="py-3 px-5 text-right">Nro.</th>
                <th class="py-3 px-5 text-right">Código</th>
                <th class="py-3 px-5 text-right">Ancho</th>
                <th class="py-3 px-5 text-right">Largo</th>
                <th class="py-3 px-5 text-right">Origen izquierda</th>
                <th class="py-3 px-5 text-right">Origen superior</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidas as $key => $salida)
                <tr>
                    <td class="py-3 px-5 text-right">{{ $key + 1 }}</td>
                    <td class="py-3 px-5 text-right">{{ $salida->code }}</td>
                    <td class="py-3 px-5 text-right">{{ number_format($salida->tamano_y, 0, ',', '.') }} mm</td>
                    <td class="py-3 px-5 text-right">{{ number_format($salida->tamano_x, 0, ',', '.') }} mm</td>
                    <td class="py-3 px-5 text-right">{{ number_format($salida->origen_x, 0, ',', '.') }} mm</td>
                    <td class="py-3 px-5 text-right">{{ number_format($salida->origen_y, 0, ',', '.') }} mm</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
@endsection