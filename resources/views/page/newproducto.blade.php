@extends('layouts.newplantilla')
<?php
use App\Models\TipoArticulo;

?>
@section('metadatos')
    <meta name="description" content="{{ $metadatos->descripcion }}" />
    <meta name="keywords" content="{{ $metadatos->keyword }}" />
@endsection
@section('content')
    <style>
        .sumarCarrito {
            padding: 16px 32px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 40px;
            background: #F15E40;
            color: #FFF;
            font-family: Inter;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
            /* 150% */
            border: none;
        }

        .contenedorSubcat .container {
            display: none;
        }


        .boldSubcategoria {
            font-weight: bold !important
        }

        .accordion-body a {
            padding-left: 0px !important
        }


        .slick-dots li.slick-active button:before {
            color: #717171;
        }

        .filtrarPor {
            color: #131313;
            font-family: Inter;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: 130%;
            /* 23.4px */
        }

        .slick-dots {
            display: flex !important;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin-top: 16px;
        }

        .slick-dots li {
            margin: 0 5px;
        }

        .slick-dots li button {
            border: 2px solid #F15E40;
            background-color: black;
            border-radius: 50%;
            width: 12px;
            height: 12px;
            padding: 0;
        }

        .slick-dots li.slick-active button {
            background-color: #F15E40;
        }

        .text-muted {
            color: #AEABAB;
        }

        .text-muted>b {
            color: #303030;
        }

        .quantity-input {
            position: relative;
            display: inline-block;
        }

        .quantity-input input[type="number"] {
            padding: 10px;
            width: 170px;
            text-align: center;
            border: 1px solid #CCCCCC;
            border-radius: 30px;
            font-size: 16px;
        }

        .precioV {
            font-size: 18px
        }

        .quantity-input button {
            position: absolute;
            top: -5px;
            padding: 10px;
            width: 30px;
            height: 80%;
            border: none;
            background-color: transparent;
            cursor: pointer;
        }

        .quantity-input .minus {
            left: 10px;
            font-size: 1.4rem;
            color: #797575;
        }

        .quantity-input .plus {
            right: 10px;
            font-size: 1.4rem;
            color: #797575;
        }


        .fotorama__nav--thumbs {
            display: flex !important;
        }

        .accordion-button.collapsed {
            background: transparent;
        }

        .table,
        tbody,
        tr,
        td {
            border: none;
            font-size: 15px !important;
        }

        .table>:not(caption)>*>* {
            padding-left: 0px;
        }

        .propiedadList ul {
            list-style-image: url("{{ asset('img/market.png') }}")
        }

        .listMarket ul {
            list-style-image: url("{{ asset('img/market2.png') }}")
        }

        .accordion-button {
            background: none !important;
            box-shadow: none !important;
            border-radius: 0px !important;
            padding-left: 0px !important
        }

        .accordion-collapse div {
            padding-left: 0px !important;


        }

        .accordion-collapse div a {
            color: var(--Grey-01, #686666);
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 130%;
            /* 18.2px */
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            /* 16:9 */
            height: 0;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .box {
            width: 100%;
            padding: 1em;
            text-align: center;
        }

        .quantity {
            position: relative;
            display: inline-block;
            color: #7f7f7f;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .quantity input[type="number"] {
            transition: border 0.3s ease-in-out, color 0.3s ease-in-out;
            -webkit-appearance: textfield;
            -moz-appearance: textfield;
            appearance: textfield;
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 24px;
            font-weight: 700;
            box-shadow: none;
            outline: none;
            width: 85px;
            height: 40px;
            text-align: center;
            float: right;
            border: 1px solid #dcdcdc;
            background-color: #fff;
            color: #342f2f;
        }

        .quantity input[type="number"]:focus {
            border-color: #57b8f6 !important;
        }

        .quantity input[type="number"]:hover {
            border-color: #a5a5a5;
        }

        .quantity-button {
            width: 39px;
            height: 34px;
            display: inline-block;
            float: right;
            position: relative;
            cursor: pointer;
        }

        .quantity-button::before,
        .quantity-button::after {
            position: absolute;
            top: calc(50% - 1px);
            left: calc(50% - 7px);
            content: '';
            width: 14px;
            height: 2px;
            background-color: currentColor;
            display: block;
        }

        .quantity-remove::after {
            display: none;
        }

        .quantity-add::after {
            transform: rotate(90deg);
        }

        .image-container {
            position: relative;
            display: inline-block;
        }

        .boxColor {
            width: 56px;
            height: 56px;
            margin: 10px 15px;
        }


        .mobileProductos {
            display: none;

        }


        @media (max-width: 1000px) {

            .sidebar {
                max-height: 300px;
                overflow: scroll;
                margin-bottom: 20px;
            }

            .contenedorSubcat .box_container {
                display: none !important;
            }

            .contenedorSubcat .container {
                display: flex !important;
            }

            .contenedorSubcat {
                display: flex;
                flex-direction: column !important;
                justify-content: start !important;
                align-items: start !important;


            }


            .propiedadList {
                padding-left: 30px
            }

            .mobileProductos {
                display: flex;

            }

            .pcProductos {
                display: none !important
            }

        }



        @media (max-width: 600px) {
            .aplicaciones table tr {
                display: flex;
                flex-flow: column;
            }
        }

        .carousel-control-next-icon,
        .carousel-control-prev-icon {
            filter: invert()
        }

        .box-count-img {
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

    <div class="col-12 py-2 d-flex justify-content-center pt-5 pcProductos" style="font-size:16px;color:#8A8A8A;">
        <div class="box_container">

            <a style="text-decoration: none;color:#8A8A8A;" href="{{ route('page.inicio') }}">Inicio</a>
            /
            <a style="text-decoration: none;color:#8A8A8A;" href="{{ route('page.productosCategorias') }}">Productos</a>
            /
            @if ($categoria)
                {{ $categoria->name }}
            @endif
            /
            <a style="text-decoration: none;color:#8A8A8A;text-transform: uppercase;" href="#">
                {{ $producto->name }}
            </a>
        </div>

    </div>

    <div class="container col-12 py-2 mobileProductos" style="font-size:16px;color:#8A8A8A;">
        <a style="text-decoration: none !important; color: #8A8A8A" href="{{ route('page.inicio') }}"> Inicio </a>
        /
        <a style="text-decoration: none;color:#8A8A8A;" href="{{ route('page.productosCategorias') }}">Productos</a>
        @if ($categoria)
            /
            {{ $categoria->name }}
        @endif
    </div>
    <div class="container col-12 py-2 mobileProductos" style="font-size:16px;color:#8A8A8A;">
        <a style="text-decoration: none;color:#8A8A8A;text-transform: uppercase;" href="#">
            {{ $producto->name }}
        </a>

    </div>


    <div class="d-flex justify-content-center flex-wrap">
        <div
            class="box_container container contenedorSubcat  d-flex flex-row flex-wrap justify-content-between align-items-start py-4">
            <div class="col-12 col-md-3 pe-0 pe-md-4 ">

                <div class="sidebar py-3">
                    <div class="accordion" id="accordionExample">
                        <div class="casillaF">
                            <p class="filtrarPor">
                                @if (session('locale') === 'es')
                                    Filtrar por
                                @else
                                    Filter by
                                @endif
                            </p>

                        </div>
                        @forelse ($categorias as $item)
                            <?php
                            $encontro = tipoArticulo::where('sub_categoria_id', $item->id)->first();
                            
                            ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $item->id }}">
                                    <button
                                        class="accordion-button {{ isset($categoria) && (int) $categoria->id === (int) $item->id ? 'boldSubcategoria' : '' }}"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $item->id }}" aria-expanded="true"
                                        aria-controls="collapse{{ $item->id }}"
                                        onclick="handleButtonClick({{ $item->id }}, {{ $encontro !== null ? 'true' : 'false' }}, '{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 1]) }}')">


                                        {{ $item->name }}

                                    </button>
                                </h2>

                            </div>
                        @empty
                            <p>No hay categorías disponibles.</p>
                        @endforelse


                    </div>
                </div>
            </div>

            <div class="col-12 col-md-9 d-flex flex-column">
                <div class="row flex-wrap">
                    <div class="col-12 col-md-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                {{-- Indicadores para las imágenes --}}
                                @if ($producto->imagen)
                                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                        class="active" aria-current="true" aria-label="Slide 1"></button>
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
                                        <span class="box-count-img">1/{{ count($producto->obtenerGaleria()) + 1 }}</span>
                                        <img src="{{ asset(Storage::url($producto->imagen)) }}" class="d-block w-100"
                                            alt="...">
                                    </div>
                                @endif

                                {{-- Galería de imágenes --}}
                                @forelse ($producto->obtenerGaleria() as $index => $galeria)
                                    @if ($galeria != '')
                                        <div class="carousel-item">
                                            <span
                                                class="box-count-img">{{ $loop->iteration + 1 }}/{{ count($producto->obtenerGaleria()) + 1 }}</span>
                                            <img src="{{ asset(Storage::url($galeria)) }}" class="d-block w-100"
                                                alt="...">
                                        </div>
                                    @endif
                                @empty
                                @endforelse

                                {{-- Video 1 --}}
                                @if ($producto->video)
                                    <div class="carousel-item" style="height: 400px !important">
                                        @php
                                            // Extraer el ID del video de YouTube directamente en la vista
                                            parse_str(parse_url($producto->video, PHP_URL_QUERY), $videoParams);
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
                                            parse_str(parse_url($producto->videoTwo, PHP_URL_QUERY), $videoTwoParams);
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

                    <div class="col-12 col-md-6 d-flex flex-column propiedadList">
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


                        <span class="text-muted mt-3">
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




                                </b>{{ $producto->marca }}
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


                        @isset($producto->description)
                            @if (session('locale') === 'es')
                                <span class="mt-2">
                                    {!! nl2br(e($producto->description)) !!}
                                </span>
                            @else
                                <span class="mt-2">
                                    {!! nl2br(e($producto->descriptionEnglish)) !!}
                                </span>
                            @endif
                        @endisset
                        <div class="d-flex flex-row flex-wrap">
                            @if ($producto->obtenerColores)
                                <div class="col-12 mt-4"><b>
                                        Color</b></div>
                            @endif
                            @forelse ($producto->obtenerColores as $color)
                                <div class="image-container">
                                    <div class="boxColor"
                                        style="background: linear-gradient(135deg, {{ $color->color1 }} 50%, {{ $color->color2 }} 50%)">
                                    </div>
                                </div>
                            @empty
                            @endforelse

                        </div>

                        @if (isset(Auth::guard('cliente')->user()->id))
                            <span>
                                <div class="quantity-input">
                                    <input type="number" value="0" step="{{ $producto->bultoMinorista }}"
                                        id="quantity" onchange="guardarCantidadEnSesion()">
                                    <button class="minus"
                                        onclick="decrementQuantity({{ $producto->bultoMinorista }})">-</button>
                                    <button class="plus"
                                        onclick="incrementQuantity({{ $producto->bultoMinorista }})">+</button>
                                </div>

                            </span>
                        @endif



                        @if (isset(Auth::guard('cliente')->user()->id))
                            @if ($producto->getAttribute('stock-disponible'))
                                <div class="d-flex align-items-center justify-content-start"
                                    style="gap: 10px; margin-top: 20px;">

                                    <button class="sumarCarrito btn py-1 px-4"
                                        style="background:#F15E40;color:#fff;border-radius:30px;"
                                        onclick="pedido({{ $producto->id }}, '{{ asset(Storage::url($producto->imagen)) }}', '{{ $producto->code }}', '{{ addslashes($producto->name) }}', {{ $producto->precioVigente ?? 0 }}, {{ Auth::guard('cliente')->user()->descuento ?? 0 }}, {{ $producto['stock-disponible'] ?? 0 }})">
                                        @if (session('locale') === 'es')
                                            SUMAR AL CARRITO
                                        @else
                                            ADD TO CART
                                        @endif
                                    </button>
                                    <a class="btn py-1 px-4" style="color:#fff;background:#F15E40;border-radius:30px;"
                                        href="{{ route('page.productosPedidoSearch', $producto->id) }}">
                                        @if (session('locale') === 'es')
                                            COMPRAR
                                        @else
                                            BUY
                                        @endif
                                    </a>

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


        </div>

    </div>




@endsection

@section('js')
    <script type="text/javascript">
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

            $('#cantidad-carrito').text('(' + cantidadTotal + ')'); // Muestra la cantidad en el DOM
        }

        contarProductosEnCarrito();

        function pedido(id, imagen, codigo, nombre, precio, descuento, stock) {

            if (stock <= 0) {
                swal("El producto no tiene stock", "", "error");
                return;
            }



            const cantidad = parseInt($(`#quantity`).val(), 10);

            let precioFinal = precio;


            var evento = {
                @if(Auth::guard('cliente')->check())
            cliente_id: {{ Auth::guard('cliente')->user()->id }},
        @endif        producto_id: id,
        cantidad: cantidad,
        tipo_evento: 'add_to_cart',  // Puedes ajustar este valor según tu nomenclatura
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
            contarProductosEnCarrito();

        }


        function guardarCantidadEnSesion() {
            const input = document.getElementById("quantity");
            let quantity = parseInt(input.value, 10);
            const bultoMinorista =
                {{ $producto->bultoMinorista }}; // Asegúrate de que esta variable esté disponible en tu Blade

            // Validación: asegurarse de que `quantity` sea múltiplo de `bultoMinorista`
            if (quantity % bultoMinorista !== 0) {
                // Ajusta la cantidad al múltiplo más cercano de `bultoMinorista`
                quantity = Math.round(quantity / bultoMinorista) * bultoMinorista;
                input.value = quantity; // Actualiza el valor del input
            }

            // Enviar la cantidad al servidor
            fetch("{{ route('guardar.cantidad') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        cantidad: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log("Cantidad guardada en la sesión.");
                    } else {
                        console.error("Error al guardar la cantidad:", data.message);
                    }
                })
                .catch(error => console.error("Error:", error));
        }

        function decrementQuantity(step) {
            var quantity = document.getElementById("quantity");
            var currentValue = parseInt(quantity.value) || 0;
            if (currentValue > 0) {
                quantity.value = currentValue - step;
                guardarCantidadEnSesion();
            }
        }

        function incrementQuantity(step) {
            var quantity = document.getElementById("quantity");
            var currentValue = parseInt(quantity.value) || 0;
            quantity.value = currentValue + step;
            guardarCantidadEnSesion();
        }


        // const button = document.querySelector('.btn-primary');
        // window.onload = function() {
        //     console.log(button)
        //     button.click();
        // };
        $(document).ready(function() {
            $('.responsive_productos').slick({
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
                dots: true,
                infinite: true,
                speed: 300,
                slidesToShow: 4,
                slidesToScroll: 1,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1,
                            dots: true,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            arrows: false,
                            infinite: true,
                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1,
                            dots: true,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            arrows: false,
                            infinite: true,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            dots: true,
                            autoplay: true,
                            autoplaySpeed: 2000,
                            arrows: false,
                            infinite: true,
                        }
                    }
                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        });
    </script>
@endsection


@push('scripts')
    <script>
        const subcategoriasUrl = "{{ route('subcategorias') }}";
        let fetching = false;

        function ajaxCategorias(itemId, routeUrl, tieneProductos) {
            $('.btn').removeClass('boldSubcategoria');
            $(`button[onclick*="${itemId}"]`).addClass('boldSubcategoria');


            if (tieneProductos == 25) {
                window.location = routeUrl

            }

            $.ajax({
                url: routeUrl,
                type: 'GET',
                data: {
                    id: itemId,
                    productosVisible: tieneProductos
                },
                success: function(response) {
                    $('.productosCpC').html(response);

                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });

        }

        function handleButtonClick(itemId, encontro, routeUrl, tieneProductos) {
            $('.accordion-button').removeClass('boldSubcategoria');
            $(`#heading${itemId} .accordion-button`).addClass('boldSubcategoria');



            window.location = routeUrl;



            // ajaxCategorias(itemId, routeUrl, tieneProductos)






        }

        function fetchSubcategorias(categoriaId, categoriaSelect) {

            if (fetching) return;

            const container = $('#subcategorias-' + categoriaId);


            if (container.length > 0) {
                $('.accordion-item .accordion-button').removeClass('active-subcategory');

                fetching = true;

                $.ajax({
                    url: subcategoriasUrl,
                    type: 'POST',
                    data: {
                        categoriaId: categoriaId,
                        categoriaSelect: categoriaSelect,
                        productoRoute: 1,
                        _token: '{{ csrf_token() }}' // Incluye el token CSRF
                    },
                    success: function(data) {
                        console.log(data)
                        container.html(data);
                        container.slideDown();

                        $('#heading' + categoriaId + ' .accordion-button').addClass('active-subcategory');

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error al cargar las subcategor���as:', textStatus, errorThrown);
                        console.error('Respuesta del servidor:', jqXHR.responseText);
                        alert('Error al cargar las subcategor���as.');
                    },
                    complete: function() {
                        fetching = false;
                    }
                });
            } else {
                container.slideToggle();
            }



        }
    </script>
@endpush


@if (isset($categoria))
    @if ($categoria->principal == 'false')
        <!-- Asegúrate de que esta variable contenga el ID de la categoría seleccionada -->
        @push('scripts')
            <script>
                $(document).ready(function() {
                    // Abre el acordeón de la categoría seleccionada
                    const categoriaId = {{ $categoria->id }};
                    const categoriaPadre = {{ $categoria->sub_categoria_id }};

                    const container = $('#subcategorias-' + categoriaPadre);

                    if (container.length > 0) {
                        // Abre el acordeón correspondiente
                        const acordeonCollapse = $('#collapse' + categoriaPadre);
                        const bsCollapse = new bootstrap.Collapse(acordeonCollapse[0], {
                            toggle: true
                        });
                        bsCollapse.show(); // Muestra el acordeón

                        // Realiza una llamada AJAX para cargar las subcategorías
                        fetchSubcategorias(categoriaPadre, categoriaId);

                        // Marca la categoría seleccionada en negrita
                        $('#heading' + categoriaId + ' .accordion-button').css('font-weight', 'bold');
                    }
                });
            </script>
        @endpush
    @endif
@endif
