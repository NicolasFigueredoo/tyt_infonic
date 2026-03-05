@extends('layouts.newplantilla')
@section('content')
    <style>
        .accordion-button.collapsed {
            background: transparent;
        }

        .box_hover {
            position: relative;
        }

        /* .box_hover:hover img{
      -webkit-transform: scale(1.05);
        transform: scale(1.05);
        transition: all 0.5s ease 0.2s;
        position: relative;
        z-index: 100;
        } */
        .box_hover:hover:before {
            content: "+";
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            background: #D8D8D8;
            width: 94px;
            height: 94px;
            border-radius: 100%;
            opacity: 0.7;
            z-index: 99;
            color: #fff;
            position: absolute;
        }

        .box_description>* {
            color: #717171 !important;
            font-size: 18px !important;
        }
        .carousel-control-next-icon, .carousel-control-prev-icon{
            filter: invert()
        }
        .box-count-img{
            position: absolute;            
            border: 1px solid #f15e40;
            border-radius: 100%;
            padding: 7px 10px;
            font-size: 19px;
            color: #f15e40;
            background: #fff;
            z-index: 1;
        }
    </style>
    <div class="d-flex justify-content-center align-items-center">
        <div class="box_container pt-5 d-flex justify-content-between align-items-center">
            <span style="cursor: pointer !important" onclick="window.location='{{ route('page.productosCategorias') }}'"><b>< PRODUCTOS</b></span>            
                        
            <a class="btn" style="background: #F15E40;border-radius:35px;color:#fff;" href="{{route('page.carrito')}}">
                <span>Confirmar</span>
            </a>
        </div>
    </div>
    <div class="d-flex justify-content-center py-5">
        <div class="table-responsive box_container">            
            <table class="w-100">
                <thead style="background: #E1E5E9;color:#000;">
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"></td>
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>C&Oacute;DIGO</div></td>
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>DESCRIPCI&Oacute;N</div></td>                        
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>CANTIDAD</div></td>
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>BULTO MAYORISTA</div></td>
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>BULTO MINORISTA</div></td>
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>PRECIO LISTA x U.</div></td>  
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>DESCUENTO CLIENTE</div></td>                        
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>SUBTOTAL</div></td>
                    <td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div></div></td>
                </thead>
                <tbody style="background: white;border: 1px solid #f2f2f2;">                        
                    @forelse ($productos as $producto)
                    @if($producto->oculto == 'false')
                    <tr id="fila_{{$producto->id}}" data-producto="{{$producto->id}}">
                        <div class="modal" id="{{$producto->code}}Modal" tabindex="-1" aria-labelledby="{{$producto->code}}ModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="{{$producto->code}}ModalLabel"></h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row flex-wrap">
                                        <div class="col-12">
                                            <div id="carouselExampleIndicators{{$producto->id}}" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-indicators">
                                                @if ($producto->imagen)                                                     
                                                    <button type="button" data-bs-target="#carouselExampleIndicators{{$producto->id}}" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                @endif                            
                                                @forelse ($producto->obtenerGaleria() as $galeria)                            
                                                    <button type="button" data-bs-target="#carouselExampleIndicators{{$producto->id}}" data-bs-slide-to="{{$loop->iteration}}" aria-label="Slide {{$loop->iteration}}"></button>
                                                @empty
                                                @endforelse                                 
                                                </div>                            
                                                <div class="carousel-inner">                                
                                                    @if ($producto->imagen)
                                                    <div class="carousel-item active">
                                                        <span class="box-count-img">1/{{count($producto->obtenerGaleria()) + 1 }}</span>
                                                    <img src="{{ asset(Storage::url($producto->imagen)) }}" class="d-block w-100" alt="...">
                                                    </div>
                                                @endif                            
                                                @forelse ($producto->obtenerGaleria() as $galeria)
                                                @if ($galeria != '')
                                                <div class="carousel-item">
                                                        <span class="box-count-img">{{ $loop->iteration+1}}/{{count($producto->obtenerGaleria()) + 1 }}</span>
                                                    <img src="{{ asset(Storage::url($galeria)) }}" class="d-block w-100" alt="...">
                                                    </div>                                    
                                                    @endif
                                                @empty
                                                @endforelse                                   
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators{{$producto->id}}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators{{$producto->id}}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex flex-column propiedadList">
                                            <div class="pb-4 d-flex justify-content-between align-items-center"
                                                style="font-size:24px;color:#000;font-weight:600;text-transform: uppercase;">
                                                {{ $producto->name }}
                                            </div>

                                            @isset($producto->description)
                                            {!! nl2br(e($producto->description)) !!}
                                            @endisset
                                            @isset($producto->descriptionPrivada)
                                            {!! nl2br(e($producto->descriptionPrivada)) !!}
                                            @endisset
                                            <div class="d-flex flex-row flex-wrap">
                                                @if($producto->obtenerColores)
                                                <div class="col-12 mt-4"><b>Colores</b></div>
                                                @endif
                                                @forelse ($producto->obtenerColores as $color)                        
                                                <div class="image-container">
                                                    <div class="boxColor" style="background: linear-gradient(135deg, {{$color->color1}} 50%, {{$color->color2}} 50%)"></div>
                                                </div>
                                                @empty
                                                    
                                                @endforelse
                                            </div>
                                        </div>                    
                                    </div>
                                </div>                                
                              </div>
                            </div>
                          =</div>
                        <td class="pt-2 pb-2 " id="imagen" data-imagen="{{asset(Storage::url($producto->imagen))}}" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;color:#707070;">
                            <img src="{{asset(Storage::url($producto->imagen))}}" width="60px;" height="auto">
                        </td>
                        <td class="pt-2 pb-2 " id="codigo" data-codigo="{{$producto->code}}" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;color:#707070;">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#{{$producto->code}}Modal">
                                {{$producto->code}}
                            </button>
                        </td>
                        <td class="pt-2 pb-2 " id="nombre" data-nombre="{{$producto->name}}" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;color:#707070;">
                            {{$producto->name}} 
                        </td>
                        
                        <td class="pt-2 pb-2" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;color:#707070;">
                            <input class="input_number cantidad{{$producto->id}} form-control" data-descuento="{{Auth::guard('cliente')->user()->descuento}}" data-fila="{{$producto->id}}" type="number" value="{{$cantidad}}" step="{{$producto->bultoMinorista}}" min="0" name="cantidad" id="cantidad" style="width: 5vw;border-radius: 0px;border-top: none;border-right: none;border-left: none;background: transparent;">
                        </td>       
                        
                        <td>
                        {{$producto->bultoMinorista}}
                        </td>
                        <td>
                            {{$producto->bultoMayorista}}
                            </td>
                        <td class="pt-2 pb-2 precio{{$producto->id}}" data-precio="{{round($producto->precioVigente,2)}}" id="precio" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;color:#707070;">
                            ${{ number_format($producto->precioVigente, 2) }}        

                        </td>

                        <?php
                        $descuentoCliente = Auth::guard('cliente')->user()->descuento;
                        $precioVigente = $producto->precioVigente;
                        $precioConDescuento = $producto->precioVigente;
                        
                        if ($descuentoCliente) {
                            
                            $descuento = ($precioVigente * $descuentoCliente) / 100;
                            $precioConDescuento = $precioVigente - $descuento;
                        }

                        if($cantidad  > 0){
                            $precioConDescuento = $precioConDescuento * $cantidad;
                        }
                        ?>

<td>
    @if(Auth::guard('cliente')->user()->descuento > 0)
    (%{{Auth::guard('cliente')->user()->descuento}})
    @endif
</td>
                        
                        <td class="pt-2 pb-2 subtotal{{$producto->id}}" 
                            data-subtotal="{{ round($precioConDescuento, 2) }}" 
                            id="subtotal" 
                            style="vertical-align: middle; border: unset; padding-left: 1vh; font-size: 14px; font-weight: bold; color: #707070;">
                            
                            ${{ number_format($precioConDescuento, 2) }}    
                            
                           
                        </td>

                       
                        
                        
                        <td class="pt-2 pb-2" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;">
                            <button class"sumarCarrito" data-nombre="{{$producto->name}}" data-precio="{{$producto->precioVigente}}" id="btnComprar" onclick="pedido('{{$producto->id}}', '{{$producto['stock-disponible'] ?? 0}}')" style="color: #797979;background:#fff;border:1px solid #797979;font-weight: bold;padding: 8px 2vw;font-size: 14px;border-radius:30px;" type="button">Agregar</button>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" class="py-5">
                            No se encontraron resultados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('js')
<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

<!-- 
    RTL version
-->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>
<script>   


function pedido(id, stock) {
    if (stock <= 0) {
                swal("El producto no tiene stock", "", "error");
                return;
            }

            
        var evento = {
            @if(Auth::guard('cliente')->check())
            cliente_id: {{ Auth::guard('cliente')->user()->id }},
        @endif
        producto_id: id,
        cantidad: $(`#fila_${id} #cantidad`).val(),
        tipo_evento: 'add_to_cart',  // Puedes ajustar este valor según tu nomenclatura
        fecha: new Date().toISOString()
    };
    console.log(evento);

    $.ajax({
        url: '{{ route("eventos.store") }}', // Ruta definida en Laravel
        type: 'POST',
        data: evento,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function(response) {
            console.log("Evento guardado", response);
        },
        error: function(xhr, status, error) {
            console.error("Error al guardar el evento", error);
        }
    });


            
var producto = {
  item_id: $(`#fila_${id} #codigo`).data('codigo'),
  item_name: $(`#fila_${id} #nombre`).data('nombre'),
  price: $(`#fila_${id} #precio`).data('precio'),
  quantity: $(`#fila_${id} #cantidad`).val(),
};


myCartModule.addToCart(producto);

    const fila = {         
        cantidad: $(`#fila_${id} #cantidad`).val(),
        imagen: $(`#fila_${id} #imagen`).data('imagen'),
        codigo: $(`#fila_${id} #codigo`).data('codigo'),
        nombre: $(`#fila_${id} #nombre`).data('nombre'),        
        precio: $(`#fila_${id} #precio`).data('precio'),         
        subtotal: $(`#fila_${id} #subtotal`).data('subtotal'),
        pid: `fila_${id}` // Guarda el id de la fila
    };

    let obj_fila = localStorage.getItem('obj_fila');

    if (obj_fila != null) {
        obj_fila = JSON.parse(obj_fila); // Parsea el JSON almacenado
        const index = obj_fila.findIndex(obj => obj.codigo === fila.codigo);

        if (index !== -1) { // Si el producto ya existe, actualiza la cantidad
            obj_fila[index].cantidad = parseInt(obj_fila[index].cantidad) + parseInt(fila.cantidad);
        } else { // Si el producto no existe, lo añade
            obj_fila.push(fila);
        }
    } else {
        // Si no hay productos, inicializa el array con el nuevo producto
        obj_fila = [fila];
    }

    localStorage.setItem('obj_fila', JSON.stringify(obj_fila)); // Almacena el array actualizado
    alertify.set('notifier', 'position', 'bottom-right');
    alertify.notify(`Se agregó el producto al carrito`, 'success', 3);     
}

    
    ///FUNCION ESCUCHAR SELECTED
    $(document).on('keyup mouseup', '#presentacion', function() {
        let presentacion = $(this).find(":selected").text();
        
        let precio = $(this).find(":selected").data('precio');   
        
        let id  = $(this).find(":selected").data('id');
        
        let cantidad = $(`.cantidad${id}`).val();
        
        let total = parseFloat(precio)*parseInt(cantidad)
        
        $(`.precio${id}`).data('precio',total.toFixed(2))
        
        $(`.precio${id}`).html('$ '+total.toFixed(2))

        let subtotal = cantidad*total

        $(`.subtotal${id}`).data('subtotal',subtotal.toFixed(2))
        
        $(`.subtotal${id}`).html('$ '+subtotal.toFixed(2))

        
    });

    ///FUNCION ESCUCHAR CANTIDAD
    $(document).on('keyup mouseup', '.input_number', function() {
        
        let id = $(this).data('fila')    
        let cantidad = $(this).val();
        let descuento = $(this).data('descuento')            
        let precio = $(`.precio${id}`).data('precio')
        let precioDescuento = precio
        if (descuento > 0) {
            precioCondescuento = (precio * descuento) / 100;
            precioDescuento = precio - precioCondescuento;
            }


            let total = parseFloat(precioDescuento) * cantidad;

// Formatear el número como moneda en pesos argentinos (ARS) en JavaScript
let totalFormateado = total.toLocaleString('es-AR', { style: 'currency', currency: 'ARS' });

// Actualizar el HTML y el atributo 'data-subtotal'
$(`#fila_${id} #subtotal`).html(totalFormateado);
$(`#fila_${id} #subtotal`).data('subtotal', total.toFixed(2));

          
    });

</script>
@endsection
