<script async src="https://www.googletagmanager.com/gtag/js?id=G-1M8QB6GGJR"></script>

<script>

    window.dataLayer = window.dataLayer || [];



    function gtag() {

        dataLayer.push(arguments);

    }

    gtag('js', new Date());



    gtag('config', 'G-1M8QB6GGJR');

</script>





@if ($tieneProductos == 1)

    @foreach ($productos as $producto)

        <div class="col-6 col-sm-6 col-md-6 col-lg-4 d-flex flex-column productoContainer"

        onclick="window.location='{{ route('page.producto', ['articulo' => $producto->slug ?? $producto->id]) }}'">

            @isset($producto->imagen)

                <div class='producto-portada'

                    style='background-image: url("{{ asset(Storage::url($producto->imagen)) }}"); background-size: contain; background-position: center; background-repeat:no-repeat;'>

                </div>

            @else

                <div class='producto-portada'

                    style='background-image: url("{{ asset('images/logo.png') }}"); background-position: center; background-repeat:no-repeat;'>

                </div>

            @endisset



            <div class="w-100">

                <p class="textoCat product-name">{{ $producto->name }}</p>

            </div>

            @if (isset(Auth::guard('cliente')->user()->id))

                <div class="w-100 d-flex justify-content-between mt-3 contenedorMobileCart">

                    <p class="textoCat product-name">${{ $producto->precioVigente }}</p>

                    <!-- Aquí se bloquea la propagación del clic para que solo abra el modal -->

                    <button class="btn agregarCarrito" data-bs-toggle="modal"

                        data-bs-target="#productModal-{{ $producto->id }}"

                        onclick="event.stopPropagation(), verModal({{ $producto->id }})">

                        Agregar al carrito

                    </button>

                </div>

            @endif



        </div>

    @endforeach

@else

    @foreach ($categoriasSub as $categoria)

        <div class="col-6 col-sm-6 col-md-6 col-lg-4 d-flex flex-column categoriaContainer"

            onclick="window.location='{{ route('page.productos', ['id' => $categoria->id, 'productosVisible' => 1]) }}'">

            @isset($categoria->imagen)

                <div class='producto-portada'

                    style='background-image: url("{{ asset(Storage::url($categoria->imagen)) }}"); background-size: contain; background-position: center; background-repeat:no-repeat;'>

                </div>

            @else

                <div class='producto-portada'

                    style='background-image: url("{{ asset('images/logo.png') }}");  background-position: center; background-repeat:no-repeat;'>

                </div>

            @endisset



            <p class="textoCat" style="justify-content: center;align-items: center;display: flex; font-weight: bold">

                @if (session('locale') === 'es')

                    {{ $categoria->name }}

                @else

                    {{ $categoria->nameEnglish }}

                @endif

            </p>

        </div>

    @endforeach

@endif



@if (isset(Auth::guard('cliente')->user()->id))



    @if ($tieneProductos == 1)

        @foreach ($productos as $producto)

            <div class="modal modalProducto{{ $producto->id }}" id="productModal-{{ $producto->id }}"

                data-toggle="modal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">

                <div class="modal-dialog modal-lg">

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title" id="productModalLabel">Información del producto</h5>

                            <button type="button" onclick="cerrarModal({{ $producto->id }})" class="btn-close"

                                data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>

                        <div class="modal-body d-flex">



                            <div class="row">

                                <div class="col-lg-6">

                                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel"

                                        onclick="window.location='{{ route('page.producto', ['articulo' => $producto->slug ?? $producto->id]) }}'"

                                        style="cursor: pointer">

                                        <div class="carousel-indicators">

                                            {{-- Indicadores para las imágenes --}}

                                            @if ($producto->imagen)

                                                <button type="button" data-bs-target="#carouselExampleIndicators"

                                                    data-bs-slide-to="0" class="active" aria-current="true"

                                                    aria-label="Slide 1"></button>

                                            @endif

                                            @forelse ($producto->obtenerGaleria() as $index => $galeria)

                                                <button type="button" data-bs-target="#carouselExampleIndicators"

                                                    data-bs-slide-to="{{ $loop->iteration }}"

                                                    aria-label="Slide {{ $loop->iteration }}"></button>

                                            @empty

                                            @endforelse

                                            {{-- Indicadores para los videos --}}

                                            @if ($producto->video)

                                                <button type="button" data-bs-target="#carouselExampleIndicators"

                                                    data-bs-slide-to="{{ count($producto->obtenerGaleria()) + 1 }}"

                                                    aria-label="Slide Video 1"></button>

                                            @endif

                                            @if ($producto->videoTwo)

                                                <button type="button" data-bs-target="#carouselExampleIndicators"

                                                    data-bs-slide-to="{{ count($producto->obtenerGaleria()) + 2 }}"

                                                    aria-label="Slide Video 2"></button>

                                            @endif

                                        </div>



                                        <div class="carousel-inner">

                                            {{-- Imagen principal --}}

                                            @if ($producto->imagen)

                                                <div class="carousel-item active">

                                                    <span

                                                        class="box-count-img">1/{{ count($producto->obtenerGaleria()) + 1 }}</span>

                                                    <img src="{{ asset(Storage::url($producto->imagen)) }}"

                                                        class="d-block w-100" alt="...">

                                                </div>

                                            @endif



                                            {{-- Galería de imágenes --}}

                                            @forelse ($producto->obtenerGaleria() as $index => $galeria)

                                                @if ($galeria != '')

                                                    <div class="carousel-item">

                                                        <span

                                                            class="box-count-img">{{ $loop->iteration + 1 }}/{{ count($producto->obtenerGaleria()) + 1 }}</span>

                                                        <img src="{{ asset(Storage::url($galeria)) }}"

                                                            class="d-block w-100" alt="...">

                                                    </div>

                                                @endif

                                            @empty

                                            @endforelse



                                            {{-- Video 1 --}}

                                            @if ($producto->video)

                                                <div class="carousel-item" style="height: 400px !important">

                                                    @php

                                                        // Extraer el ID del video de YouTube directamente en la vista

                                                        parse_str(

                                                            parse_url($producto->video, PHP_URL_QUERY),

                                                            $videoParams,

                                                        );

                                                        $videoId = $videoParams['v'] ?? null;

                                                    @endphp

                                                    @if ($videoId)

                                                        <div class="video-container" style="height: 400px !important">

                                                            <iframe style="height: 400px !important"

                                                                src="https://www.youtube.com/embed/{{ $videoId }}"

                                                                class="d-block w-100" frameborder="0"

                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"

                                                                allowfullscreen>

                                                            </iframe>

                                                        </div>

                                                    @endif

                                                </div>

                                            @endif



                                            {{-- Video 2 --}}

                                            @if ($producto->videoTwo)

                                                <div class="carousel-item" style="height: 400px !important">

                                                    @php

                                                        // Extraer el ID del segundo video de YouTube

                                                        parse_str(

                                                            parse_url($producto->videoTwo, PHP_URL_QUERY),

                                                            $videoTwoParams,

                                                        );

                                                        $videoTwoId = $videoTwoParams['v'] ?? null;

                                                    @endphp

                                                    @if ($videoTwoId)

                                                        <div class="video-container" style="height: 400px !important">

                                                            <iframe style="height: 400px !important"

                                                                src="https://www.youtube.com/embed/{{ $videoTwoId }}"

                                                                class="d-block w-100" frameborder="0"

                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"

                                                                allowfullscreen>

                                                            </iframe>

                                                        </div>

                                                    @endif

                                                </div>

                                            @endif

                                        </div>



                                        {{-- Controles del carrusel --}}

                                        <button class="carousel-control-prev" type="button"

                                            data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">

                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>

                                            <span class="visually-hidden">Previous</span>

                                        </button>

                                        <button class="carousel-control-next" type="button"

                                            data-bs-target="#carouselExampleIndicators" data-bs-slide="next">

                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>

                                            <span class="visually-hidden">Next</span>

                                        </button>

                                    </div>



                                </div>

                                <div class="col-lg-6 col-md-6 d-flex flex-column propiedadList">

                                    <div class="pb-4 d-flex justify-content-between align-items-center"

                                        style="font-size:24px;color:#000;font-weight:600;text-transform: uppercase;">



                                        @if (session('locale') === 'es')

                                            {{ $producto->name }}

                                        @else

                                            {{ $producto->nameEnglish }}

                                        @endif

                                    </div>



                                    @if (isset(Auth::guard('cliente')->user()->id))

                                        <span class="precioV">

                                            <b>

                                                @if (session('locale') === 'es')

                                                    Precio:

                                                @else

                                                    Price:

                                                @endif

                                            </b> ${!! nl2br(e($producto->precioVigente)) !!}

                                        </span>

                                    @endif





                                    <span class="text-muted">

                                        <b>

                                            @if (session('locale') === 'es')

                                                Codigo:

                                            @else

                                                Code:

                                            @endif

                                        </b> {!! nl2br(e($producto->code)) !!}

                                    </span>

                                    @isset($producto->marca)

                                        <span class="text-muted mt-2">



                                            <b>



                                                @if (session('locale') === 'es')

                                                    Marca:

                                                @else

                                                    Brand:

                                                @endif









                                            </b>{{ $producto->Marca }}

                                        </span>

                                    @endisset







                                    <span class="text-muted mt-2">

                                        <b>



                                            @if (session('locale') === 'es')

                                                Código abreviado:

                                            @else

                                                Shortcode:

                                            @endif









                                        </b>{!! nl2br(e($producto->codigoAnterior)) !!}

                                    </span>





                                    @if (isset(Auth::guard('cliente')->user()->id))

                                        <span class="text-muted mt-2">

                                            <b>



                                                @if (session('locale') === 'es')

                                                    Bulto Minorista:

                                                @else

                                                    Retail Package:

                                                @endif









                                            </b>{!! nl2br(e($producto->bultoMinorista)) !!}

                                        </span>



                                        <span class="text-muted mt-2">



                                            <b>

                                                @if (session('locale') === 'es')

                                                    Bulto Mayorista:

                                                @else

                                                    Wholesale Package:

                                                @endif

                                            </b>

                                            {!! nl2br(e($producto->bultoMayorista)) !!}

                                        </span>

                                    @endif











                                    @if (isset(Auth::guard('cliente')->user()->id))

                                        <span class="mt-3">

                                            <div class="quantity-input">

                                                <button class="minus"

                                                    onclick="decrementQuantity({{ $producto->bultoMinorista }}, {{ $producto->id }})">-</button>

                                                <input class="quantity{{ $producto->id }}" type="number"

                                                    value="0" step="{{ $producto->bultoMinorista }}"

                                                    id="quantity{{ $producto->id }}">



                                                <button class="plus"

                                                    onclick="incrementQuantity({{ $producto->bultoMinorista }}, {{ $producto->id }})">+</button>

                                            </div>



                                        </span>

                                    @endif







                                    @if (isset(Auth::guard('cliente')->user()->id))

                                        @if ($producto->getAttribute('stock-disponible'))

                                            <div class="d-flex align-items-center justify-content-start"

                                                style="gap: 10px; margin-top: 20px;">



                                                <button class="sumarCarrito btn py-1 px-4"

                                                    data-nombre="{{ $producto->name }}"

                                                    data-precio="{{ $producto->precioVigente }}"

                                                    style="background:#F15E40;color:#fff;border-radius:30px;"

                                                    onclick="pedido({{ $producto->id }}, '{{ asset(Storage::url($producto->imagen)) }}', '{{ $producto->code }}', '{{ addslashes($producto->name) }}', {{ $producto->precioVigente ?? 0 }}, {{ Auth::guard('cliente')->user()->descuento ?? 0 }}, {{ $producto['stock-disponible'] ?? 0 }})">

                                                    @if (session('locale') === 'es')

                                                        SUMAR AL CARRITO

                                                    @else

                                                        ADD TO CART

                                                    @endif

                                                </button>





                                            </div>

                                        @else

                                            <h3 style="color: #F15E40">

                                                @if (session('locale') === 'es')

                                                    SIN STOCK

                                                @else

                                                    OUT OF STOCK

                                                @endif

                                            </h3>

                                        @endif

                                    @else

                                        <span>

                                            <a href="{{ $inicio->quieroCliente }}" target="_blank">

                                                <button class="btn mt-3" type="button"

                                                    style="color:#fff;background:#F15E40;border-radius:30px; height: 100%; width: 170px;">

                                                    @if (session('locale') === 'es')

                                                        Quiero ser cliente

                                                    @else

                                                        I want to be a client

                                                    @endif

                                                </button>

                                            </a>

                                        </span>

                                    @endif



                                </div>



                            </div>

                        </div>

                        <div class="modal-footer">

                            <button type="button" onclick="cerrarModal({{ $producto->id }})"

                                class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach



    @endif

@endif



<script src="{{ asset('js/scriptP.js?v=9') }}"></script>



<script>

    function verModal(id) {

        let modal = '.modalProducto' + id;

        let backdrop = '.modal-backdrop';









        // Mostrar el modal

        $(modal).addClass('show').css({

            display: 'flex'

        });



        // Crear y mostrar el backdrop si no existe

        if (!$(backdrop).length) {

            $('body').append('<div class="modal-backdrop show"></div>');

        } else {

            $(backdrop).addClass('show').css({

                display: 'block'

            });

        }



        // Evitar que la página haga scroll mientras el modal está abierto

        $('body').css('overflow', 'hidden');

    }



    function cerrarModal(id) {

        let modal = '.modalProducto' + id;

        let backdrop = '.modal-backdrop';



        // Ocultar el modal

        $(modal).removeClass('show').css({

            display: 'none'

        });



        // Remover el backdrop si no hay más modales abiertos

        if (!$('.modalProducto.show').length) {

            $(backdrop).remove();

        }



        // Permitir scroll en la página

        $('body').css('overflow', 'auto');

    }



    function decrementQuantity(step, id) {

        var $quantity = $(".quantity" + id); // Seleccionamos el elemento con jQuery

        var currentValue = parseInt($quantity.val()) || 0;

        if (currentValue > 0) {

            $quantity.val(currentValue - step);

            // guardarCantidadEnSesion();

        }

    }



    function incrementQuantity(step, id) {

        var $quantity = $(".quantity" + id); // Usamos jQuery para seleccionar el elemento

        console.log($quantity, 'n');



        var currentValue = parseInt($quantity.val()) || 0;

        console.log(currentValue, 'v');



        $quantity.val(currentValue + step);

        console.log($quantity.val());



        // guardarCantidadEnSesion();

    }



    function contarProductosEnCarrito() {

        const obj_fila = localStorage.getItem('obj_fila');

        let cantidadTotal = 0;



        if (obj_fila) {

            try {

                const productos = JSON.parse(obj_fila); // Intenta convertir a objeto



                // Verifica si es un array y tiene elementos

                if (Array.isArray(productos) && productos.length > 0) {

                    cantidadTotal = productos.length; // Contamos la cantidad de productos

                }

            } catch (error) {

                console.error('Error al parsear JSON:', error);

                cantidadTotal = 0; // En caso de error, retornamos 0

            }

        }



        console.log(cantidadTotal, 'Cantidad total de productos en el carrito'); // Para depurar

        $('#cantidad-carrito').text('(' + cantidadTotal + ')'); // Muestra la cantidad en el DOM

    }



    contarProductosEnCarrito();



    function pedido(id, imagen, codigo, nombre, precio, descuento, stock) {

        if (stock <= 0) {

            console.log(stock, 'hola')

            swal("El producto no tiene stock", "", "error");

            return;

        }

        const cantidad = parseInt($(`#quantity` + id).val(), 10);









        var evento = {

        @if(Auth::guard('cliente')->check())

            cliente_id: {{ Auth::guard('cliente')->user()->id }},

        @endif

        producto_id: id,

        cantidad: cantidad,

        tipo_evento: 'add_to_cart',

        fecha: new Date().toISOString()

    };



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

            item_id: id,

            item_name: nombre,

            price: precio,

            quantity: cantidad,

        };

        myCartModule.addToCart(producto);



        let precioFinal = precio;







        const subtotal = precioFinal * cantidad;







        const fila = {

            cantidad: cantidad,

            imagen: imagen,

            codigo: codigo,

            nombre: nombre,

            precio: precioFinal, // Usamos el precio después del descuento

            subtotal: subtotal, // Usamos el subtotal calculado

            pid: `fila_${id}` // Guarda el id de la fila

        };



        console.log(fila)



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



        console.log(obj_fila)



        localStorage.setItem('obj_fila', JSON.stringify(obj_fila)); // Almacena el array actualizado

        alertify.set('notifier', 'position', 'bottom-right');

        alertify.notify(`Se agregó el producto al carrito`, 'success', 3);

        contarProductosEnCarrito();



    }

</script>

