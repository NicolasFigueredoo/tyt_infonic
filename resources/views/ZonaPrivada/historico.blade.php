@extends('layouts.newplantilla')
@section('content')

<div class="d-flex justify-content-center align-items-center my-5" style="padding-top: 80px; padding-bottom: 150px">
    <table class="table box_container">
        <thead style="background: #818181;color:#fff;">
          <tr>
            <th>FECHA</th>
            <th>N° DE PEDIDO</th>
            <th>ESTADO</th>
            <th>OBSERVACIONES</th>
            <th>TOTAL</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @forelse ($pedido as $item)            
            <tr>
              <td>{{ $item->fecha }}</td>
              <td>{{ $item->id }}</td>
              <td>{{ $item->estado }}</td>
              <td>{{ $item->observacion }}</td>
              <td>{{ $item->total }}</td>
              <td>
                <button type="button" style="border: 1px solid #F15E40;color:#F15E40;">Recomprar</button>
                <!-- Button trigger modal -->
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#detalle{{$loop->index}}">
                    Ver detalle
                </button>
                
                <!-- Modal -->
                <div class="modal fade" id="detalle{{$loop->index}}" tabindex="-1" aria-labelledby="detalle{{$loop->index}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                    <div class="modal-content">                        
                        <div class="modal-body">
                            <table class="table">
                                <thead style="background: #818181;color:#fff;">
                                  <tr>
                                    <th>CODIGO</th>
                                    <th>NOMBRE</th>
                                    <th>CANTIDAD</th>
                                    <th>PRECIO</th>
                                    <th>SUBTOTAL</th>                                    
                                  </tr>
                                </thead>
                                <tbody>
                                    @forelse ($item->pedido as $producto)
                                        <tr>
                                            <td>{{$producto->codigo}}</td>
                                            <td>{{$producto->nombre}}</td>
                                            <td>{{$producto->cantidad}}</td>
                                            <td>{{$producto->precio}}</td>
                                            <td>{{$producto->subtotal}}</td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>                        
                        </div>
                    </div>
                    </div>
                </div>                
              </td>
            </tr>
                
            @empty
                
            @endforelse
        </tbody>
      </table>
</div>
@endsection