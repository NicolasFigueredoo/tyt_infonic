@extends('layouts.plantilla')

@section('content')
    <?php
    
    $email = Auth::guard('cliente')->user()->email;
    
    $id = Auth::guard('cliente')->user()->id;
    
    $username = Auth::guard('cliente')->user()->username;
    
    ?>

    <style>
        .filtro_banner:before {

            content: "";

            display: flex;

            justify-content: center;

            align-items: center;

            font-size: 45px;

            background: #1F3041;

            width: 100%;

            height: 100%;

            opacity: 0.6;

            top: 0;

            position: absolute;

        }



        td {

            border-top: 1px solid #ddd !important;

            border-bottom: 1px solid #ddd !important;

        }
    </style>



    <div class="d-flex justify-content-center " style="padding-top: 80px; margin-bottom: 150px">

        <form method="POST" action="{{ route('enviarpedido') }}" id="form" enctype="multipart/form-data"
            class="box_container">

            @csrf

            <button
                style="color:#000;border:1px solid #F15E40;font-size:13px;font-weight: bold;width: 163px;border-radius:35px;width:216px;"
                onclick="window.location='{{ route('page.productosCategorias') }}'" class="btn me-4" type="button">

                < SEGUIR COMPRANDO</button>


                    <button
                        style="color:#fff;border:1px solid #dc3545;font-size:13px;font-weight:bold;border-radius:35px;width:216px;background-color:#dc3545;"
                        onclick="vaciarCarrito()" class="btn me-4" type="button">
                        🗑 VACIAR CARRITO
                    </button>



                    <div
                        class="d-flex flex-column justify-content-center align-items-center col-12 producto_container mt-4">

                        <div class="col-12 table-responsive border"
                            style="border-top-left-radius: 20px;border-top-right-radius: 20px;">

                            <div class="text-center w-100 p-5 d-none carritoVacio">

                                <span><b>*Su carrito se encuentra vacio</b></span>

                            </div>

                        </div>

                    </div>

                    <div class="col-12 d-flex justify-content-between my-5">

                        <div class="col-md-6 me-md-1 d-flex flex-column">

                            <div class="col-12 border d-flex flex-column mb-3">

                                <div style="background: #F5F5F5;color:#000;" class="p-2">Información importante</div>

                                <div class="d-flex flex-column p-2">

                                    {!! nl2br(e($carrito->direccion)) !!}

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6 ms-md-1 d-flex flex-column">

                            <div class="col-12 border d-flex flex-column">

                                <div style="background: #F5F5F5;color:#000;" class="p-2">Tu pedido</div>

                                <hr>

                                <div class="d-flex flex-column justify-content-start px-3">

                                    <div class="d-flex justify-content-between">

                                        <span>Total</span>

                                        <span data-total="" id="total"></span>

                                    </div>

                                    <hr>



                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="col-12 d-flex justify-content-between my-5">

                        <div class="col-md-6 me-md-1 d-flex flex-column">

                            <div class="col-12 d-flex flex-column">

                                <div style="color:#000;" class="p-2"><b>Escribinos un mensaje</b></div>

                                <textarea style="min-height: 100px;" name="obeservacion" class="form-control"
                                    placeholder="Dias especiales de entrega, cambios de domicilio, expresos, requerimientos especiales en la mercaderia, exenciones."></textarea>

                            </div>

                        </div>

                        <div class="col-md-6 ms-md-1 d-flex flex-column">

                            <div class="col-12 d-flex flex-column">

                                <div style="color:#000;" class="p-2"><b>Adjunta un archivo</b></div>

                                <div
                                    class="d-flex flex-row justify-content-between align-content-center"style="font-size:16px;color:#000586;font-weight: bold;">

                                    <input type="file" class="form-control" id="file_carrito" name="archivo">

                                </div>

                            </div>

                        </div>

                    </div>

                    <div class="d-flex justify-content-end align-items-center">

                        <button
                            style="color:#000;border:1px solid #F15E40;font-size:13px;font-weight: bold;width: 163px;border-radius:35px;width:216px;"
                            onclick="window.location='{{ route('page.productosCategorias') }}'" class="btn me-4 d-none"
                            type="button">

                            < SEGUIR COMPRANDO</button>

                                <div id="botonSpiner">

                                    <button type="button" onclick="enviar()" class="btn my-3"
                                        style="width: 168px;border-radius:35px!important;background-color: #F15E40;color:white;width:216px;font-weight: bold;">PROCESAR

                                        COMPRA</button>



                                </div>

                                <div id="spinner" style="display: none;">

                                    <i class="fa fa-spinner fa-spin"></i> Procesando...

                                </div>

                                <!-- Agrega este div en tu HTML justo donde está el botón -->



                    </div>

        </form>

    </div>



    <script>
        var descuentoCliente = {{ Auth::guard('cliente')->user()->descuento ?? 0 }};
    </script>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>



    <script>
        function removeItemFromArr(arr, item) {

            var i = arr.indexOf(item);

            arr.splice(i, 1);

        }



        function eliminar(id) {

            // Obtener la fila correspondiente en el DOM

            const fila = document.getElementById(id);

            if (!fila) {

                console.error(`No se encontró el elemento con id: ${id}`);

                return;

            }



            // Obtener el atributo "pid" del elemento usando jQuery

            const $fila = $('#' + id);

            const iddelete = $fila.data('pid');

            const idProducto = parseInt(iddelete.replace("fila_", ""), 10);

            // Recuperar el array de objetos almacenado en localStorage

            let obj_fila = localStorage.getItem('obj_fila');

            if (!obj_fila) {

                console.error("No se encontraron datos en localStorage para 'obj_fila'");

                return;

            }



            try {

                obj_fila = JSON.parse(obj_fila);

            } catch (error) {

                console.error("Error al parsear 'obj_fila' desde localStorage:", error);

                return;

            }



            // Asegurarse de que obj_fila sea un arreglo

            if (!Array.isArray(obj_fila)) {

                obj_fila = $.makeArray(obj_fila);

            }



            // Filtrar los elementos que NO coinciden con iddelete y, para los que coinciden, 

            // enviar el evento a dataLayer

            const updatedArray = obj_fila.filter(element => {

                if (element.pid == iddelete) {







                    var evento = {

                        @if (Auth::guard('cliente')->check())

                            cliente_id: {{ Auth::guard('cliente')->user()->id }},
                        @endif
                        producto_id: idProducto,

                        cantidad: element.cantidad,

                        tipo_evento: 'remove_from_cart', // Puedes ajustar este valor según tu nomenclatura

                        fecha: new Date().toISOString()

                    };



                    $.ajax({

                        url: '{{ route('eventos.store') }}', // Ruta definida en Laravel

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









                    console.log(`Eliminando producto con pid: ${element.pid}`);

                    dataLayer.push({

                        event: 'remove_from_cart',

                        debug_mode: true,

                        ecommerce: {

                            currency: 'ARS',

                            value: element.precio,

                            items: [{

                                item_id: element.codigo,

                                item_name: element.nombre,

                                price: element.precio,

                                quantity: element.cantidad

                            }]

                        }

                    });

                    return false; // Excluir este elemento del array

                }

                return true; // Mantener este elemento

            });



            // Actualizar localStorage y remover la fila del DOM

            localStorage.setItem('obj_fila', JSON.stringify(updatedArray));

            fila.remove();



            // Actualizar el total si existe la función f_total

            if (typeof f_total === 'function') {

                f_total();

            }

        }



        function tabla() {

            tabla = $('.table-responsive');

            var template = '';

            obj_fila = localStorage.getItem('obj_fila');



            // Asignar el descuento del cliente desde Blade al JavaScript

            var descuentoCliente = {{ Auth::guard('cliente')->user()->descuento ?? 0 }};



            if (obj_fila === null) {

                $('.carritoVacio').removeClass('d-none');

            }



            subtotal = 0;

            if (obj_fila != null) {

                obj_fila = jQuery.parseJSON(obj_fila);

                obj_fila = $.makeArray(obj_fila);

                total = 0;



                template += '<table class="table w-100 m-0">';

                template += '<thead style="color:#000;">';

                template +=

                    '<tr style="font-size:20px;text-transform: uppercase;border-bottom:3px;background:#818181;color:#fff;">';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"></td>';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>Producto</div></td>';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>Codigo</div></td>';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>Cantidad</div></td>';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>Precio Unitario</div></td>';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>Descuento cliente</div></td>';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"><div>Precio Total</div></td>';

                template +=

                    '<td class="pt-2 pb-2" style="border:unset;padding-left:1vh;font-size: 14px;font-weight:bold;height: 100%"></td>';

                template += '</tr>';

                template += '</thead>';

                template += '<tbody>';



                for (i = 0; i < obj_fila.length; i++) {

                    console.log(obj_fila[i], 'nico')

                    let precio = parseFloat(obj_fila[i]['precio']);

                    let cantidad = parseFloat(obj_fila[i]['cantidad']);

                    let subtotal = precio * cantidad;

                    const descuentoPorcentual = descuentoCliente / 100;





                    // Aplicar el descuento del cliente al precio unitario

                    const descuentoAplicado = precio * descuentoPorcentual;

                    const precioConDescuento = precio - descuentoAplicado;







                    let subtotalConDescuento = precioConDescuento * cantidad;



                    // Formatear los precios en pesos argentinos

                    let precioFormateado = precioConDescuento.toLocaleString('es-AR', {

                        style: 'currency',

                        currency: 'ARS'

                    });



                    let precioUnitario = precio.toLocaleString('es-AR', {

                        style: 'currency',

                        currency: 'ARS'

                    });





                    let subtotalFormateado = subtotalConDescuento.toLocaleString('es-AR', {

                        style: 'currency',

                        currency: 'ARS'

                    });



                    template +=

                        `<tr class="tablaFila" id="fila_${i}" data-pid="${obj_fila[i]['pid']}" style="border-bottom:1px solid #ccc;">`;

                    template +=

                        `<td class="pt-2 pb-2 filaImagen" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;"><img src="${obj_fila[i]['imagen']}" width="56px" height="56px"></td>`;

                    template +=

                        `<td class="pt-2 pb-2 filaNombre" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;">${obj_fila[i]['nombre']}</td>`;

                    template +=

                        `<td class="pt-2 pb-2 filaCodigo" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;">${obj_fila[i]['codigo']}</td>`;

                    template +=

                        `<td class="pt-2 pb-2 filaCantidad" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;">${obj_fila[i]['cantidad']}</td>`;

                    template +=

                        `<td class="pt-2 pb-2 filaPrecio" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;">${precioUnitario}</td>`;



                    template +=

                        `<td class="pt-2 pb-2 filaPrecio" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;">(${descuentoCliente}%) ${precioFormateado}</td>`;

                    template +=

                        `<td id="subtotal" class="pt-2 pb-2" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;" data-subtotal="${subtotalConDescuento.toFixed(2)}">${subtotalFormateado}</td>`;

                    template +=

                        `<td class="pt-2 pb-2" style="vertical-align: middle;border:unset;padding-left:1vh;font-size: 16px;font-weight:bold;text-transform:uppercase;color:#707070;"><buttom type="buttom" onclick="eliminar('fila_${i}')" class="btn"><i class="far fa-trash-alt"></i></buttom></td>`;

                    template += '</tr>';



                    total += subtotalConDescuento;

                }



                total = total.toLocaleString('es-AR', {

                    style: 'currency',

                    currency: 'ARS'

                });

                $('#total').html(total);

                $('#chektotal').val(total);

                template += '</tbody>';

                template += '</table>';

                tabla.append(template);



                f_total();

            }

        }







        $('.form-check-input').change(function() {

            if (this.checked) {

                if (this.value == "A convenir") {

                    $('#entregaconvenir').removeClass('d-none')

                } else {

                    $('#entregaconvenir').addClass('d-none')

                }

            }

        });

        document.onload = tabla();



        function f_total() {

            let subtal = document.querySelectorAll('#subtotal');

            let total = 0;

            subtal.forEach(element => {

                let valor = element.dataset.subtotal

                total += valor

            })



            let divTotal = document.getElementById('total')

            divTotal.html = "$ " + total

        }



        const enviarPedidoUrl = "{{ route('enviarpedido') }}";



        ///ENVIO AJAX

        function enviar() {















            // Desactivar el botón para evitar clics múltiples

            let div = document.querySelector('#botonSpiner'); // Botón de procesar compra

            let spinner = document.querySelector('#spinner'); // Spinner de carga

            div.innerHTML = ''; // Limpiar el texto del botón

            spinner.style.display = 'block'; // Mostrar el spinner



            let filaTabla = document.querySelectorAll(".tablaFila");

            let producto = new Array();



            filaTabla.forEach(element => {

                const fila = {

                    codigo: element.querySelector('.filaCodigo').textContent,

                    cantidad: element.querySelector('.filaCantidad').textContent,

                    nombre: element.querySelector('.filaNombre').textContent,

                    precio: element.querySelector('.filaPrecio').textContent,

                    subtotal: element.querySelector('#subtotal').textContent,

                };

                producto.push(fila);

            });



            producto = JSON.stringify(producto);



            let data = new FormData();

            data.append('producto', producto);

            data.append('_token', document.querySelector('[name="_token"]').value);

            data.append('archivo', $('input[type=file]')[0].files[0]);

            data.append('obeservacion', document.querySelector('[name="obeservacion"]').value);





            $.ajax({

                url: enviarPedidoUrl,

                data: data,

                type: "post",

                processData: false,

                contentType: false,

                success: function(response) {



                    var orderData = {

                        transaction_id: response.pedido.id, // ID del pedido

                        total: response.pedido.total_pedido, // Total de la compra

                        currency: 'ARS', // Moneda

                        items: response.pedido.pedido // Arreglo de productos

                    };



                    myCartModule.completePurchase(orderData);













                    swal(response.mensaje, "", "success");



                    setTimeout(function() {

                        window.location.href = "{{ route('page.productosCategorias') }}";

                    }, 2000);

                    enviarMails(response);









                },

                error: function(response) {

                    console.log('Error:', response);

                    let errorMsg = response.responseJSON ? response.responseJSON.error : "Error desconocido";

                    swal(errorMsg, "", "error");

                }



            });



        }


        function vaciarCarrito() {
            if (!confirm('¿Estás seguro que querés vaciar el carrito?')) return;

            localStorage.removeItem('obj_fila');

            // Limpiar tabla del DOM
            document.querySelectorAll('.tablaFila').forEach(f => f.remove());

            // Mostrar mensaje carrito vacío
            document.querySelector('.carritoVacio').classList.remove('d-none');

            // Resetear total
            document.getElementById('total').innerHTML = '';
        }

        function enviarMails(dato) {

            const enviarMails = "{{ route('enviarMails') }}";

            let token = document.querySelector('[name="_token"]').value; // Obtener el token CSRF

            let datos = new FormData();

            datos.append('response', JSON.stringify(dato));



            $.ajax({

                url: enviarMails,

                data: datos,

                type: "post",

                processData: false,

                contentType: false,

                headers: {

                    'X-CSRF-TOKEN': token // Incluir el token en los headers

                },

                success: function(response) {

                    console.log(response)



                },

                error: function(response) {

                    console.log('Error:', response);

                    let errorMsg = response.responseJSON ? response.responseJSON.error : "Error desconocido";

                    swal(errorMsg, "", "error");

                }



            });



        }
    </script>
@endsection
