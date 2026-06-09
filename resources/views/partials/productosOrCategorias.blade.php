<script async src="https://www.googletagmanager.com/gtag/js?id=G-1M8QB6GGJR"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
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
                    style='background-image: url("{{ asset('images/logo.png') }}"); background-position: center; background-repeat:no-repeat;'>
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

{{--
    LOS MODALES se renderizan UNA SOLA VEZ acá, fuera de cualquier
    contenedor que se duplique (desktop/mobile).
    Solo se incluyen si el usuario está logueado y hay productos.
--}}
@if (isset(Auth::guard('cliente')->user()->id) && $tieneProductos == 1)

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
                                <div id="carousel-{{ $producto->id }}" class="carousel slide" data-bs-ride="carousel"
                                    onclick="window.location='{{ route('page.producto', ['articulo' => $producto->slug ?? $producto->id]) }}'"
                                    style="cursor: pointer">

                                    <div class="carousel-indicators">
                                        @if ($producto->imagen)
                                            <button type="button" data-bs-target="#carousel-{{ $producto->id }}"
                                                data-bs-slide-to="0" class="active" aria-current="true"
                                                aria-label="Slide 1"></button>
                                        @endif
                                        @forelse ($producto->obtenerGaleria() as $index => $galeria)
                                            <button type="button" data-bs-target="#carousel-{{ $producto->id }}"
                                                data-bs-slide-to="{{ $loop->iteration }}"
                                                aria-label="Slide {{ $loop->iteration }}"></button>
                                        @empty
                                        @endforelse
                                        @if ($producto->video)
                                            <button type="button" data-bs-target="#carousel-{{ $producto->id }}"
                                                data-bs-slide-to="{{ count($producto->obtenerGaleria()) + 1 }}"
                                                aria-label="Slide Video 1"></button>
                                        @endif
                                        @if ($producto->videoTwo)
                                            <button type="button" data-bs-target="#carousel-{{ $producto->id }}"
                                                data-bs-slide-to="{{ count($producto->obtenerGaleria()) + 2 }}"
                                                aria-label="Slide Video 2"></button>
                                        @endif
                                    </div>

                                    <div class="carousel-inner">
                                        @if ($producto->imagen)
                                            <div class="carousel-item active">
                                                <span class="box-count-img">1/{{ count($producto->obtenerGaleria()) + 1 }}</span>
                                                <img src="{{ asset(Storage::url($producto->imagen)) }}"
                                                    class="d-block w-100" alt="...">
                                            </div>
                                        @endif

                                        @forelse ($producto->obtenerGaleria() as $index => $galeria)
                                            @if ($galeria != '')
                                                <div class="carousel-item">
                                                    <span class="box-count-img">{{ $loop->iteration + 1 }}/{{ count($producto->obtenerGaleria()) + 1 }}</span>
                                                    <img src="{{ asset(Storage::url($galeria)) }}"
                                                        class="d-block w-100" alt="...">
                                                </div>
                                            @endif
                                        @empty
                                        @endforelse

                                        @if ($producto->video)
                                            <div class="carousel-item" style="height: 400px !important">
                                                @php
                                                    parse_str(parse_url($producto->video, PHP_URL_QUERY), $videoParams);
                                                    $videoId = $videoParams['v'] ?? null;
                                                @endphp
                                                @if ($videoId)
                                                    <div class="video-container" style="height: 400px !important">
                                                        <iframe style="height: 400px !important"
                                                            src="https://www.youtube.com/embed/{{ $videoId }}"
                                                            class="d-block w-100" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                        @if ($producto->videoTwo)
                                            <div class="carousel-item" style="height: 400px !important">
                                                @php
                                                    parse_str(parse_url($producto->videoTwo, PHP_URL_QUERY), $videoTwoParams);
                                                    $videoTwoId = $videoTwoParams['v'] ?? null;
                                                @endphp
                                                @if ($videoTwoId)
                                                    <div class="video-container" style="height: 400px !important">
                                                        <iframe style="height: 400px !important"
                                                            src="https://www.youtube.com/embed/{{ $videoTwoId }}"
                                                            class="d-block w-100" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carousel-{{ $producto->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carousel-{{ $producto->id }}" data-bs-slide="next">
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
                                            @if (session('locale') === 'es') Precio:
                                            @else Price: @endif
                                        </b> ${!! nl2br(e($producto->precioVigente)) !!}
                                    </span>
                                @endif

                                <span class="text-muted">
                                    <b>
                                        @if (session('locale') === 'es') Codigo:
                                        @else Code: @endif
                                    </b> {!! nl2br(e($producto->code)) !!}
                                </span>

                                @isset($producto->marca)
                                    <span class="text-muted mt-2">
                                        <b>
                                            @if (session('locale') === 'es') Marca:
                                            @else Brand: @endif
                                        </b>{{ $producto->Marca }}
                                    </span>
                                @endisset

                                <span class="text-muted mt-2">
                                    <b>
                                        @if (session('locale') === 'es') Código abreviado:
                                        @else Shortcode: @endif
                                    </b>{!! nl2br(e($producto->codigoAnterior)) !!}
                                </span>

                                @if (isset(Auth::guard('cliente')->user()->id))
                                    <span class="text-muted mt-2">
                                        <b>
                                            @if (session('locale') === 'es') Bulto Minorista:
                                            @else Retail Package: @endif
                                        </b>{!! nl2br(e($producto->bultoMinorista)) !!}
                                    </span>
                                    <span class="text-muted mt-2">
                                        <b>
                                            @if (session('locale') === 'es') Bulto Mayorista:
                                            @else Wholesale Package: @endif
                                        </b>{!! nl2br(e($producto->bultoMayorista)) !!}
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
                                                @if (session('locale') === 'es') SUMAR AL CARRITO
                                                @else ADD TO CART @endif
                                            </button>
                                        </div>
                                    @else
                                        <h3 style="color: #F15E40">
                                            @if (session('locale') === 'es') SIN STOCK
                                            @else OUT OF STOCK @endif
                                        </h3>
                                    @endif
                                @else
                                    <span>
                                        <a href="{{ $inicio->quieroCliente }}" target="_blank">
                                            <button class="btn mt-3" type="button"
                                                style="color:#fff;background:#F15E40;border-radius:30px; height: 100%; width: 170px;">
                                                @if (session('locale') === 'es') Quiero ser cliente
                                                @else I want to be a client @endif
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

<script src="{{ asset('js/scriptP.js?v=9') }}"></script>

<script>
    function verModal(id) {
        let modal = '.modalProducto' + id;
        let backdrop = '.modal-backdrop';
        $(modal).addClass('show').css({ display: 'flex' });
        if (!$(backdrop).length) {
            $('body').append('<div class="modal-backdrop show"></div>');
        } else {
            $(backdrop).addClass('show').css({ display: 'block' });
        }
        $('body').css('overflow', 'hidden');
    }

    function cerrarModal(id) {
        let modal = '.modalProducto' + id;
        let backdrop = '.modal-backdrop';
        $(modal).removeClass('show').css({ display: 'none' });
        if (!$('.modalProducto.show').length) {
            $(backdrop).remove();
        }
        $('body').css('overflow', 'auto');
    }

    function decrementQuantity(step, id) {
        var $quantity = $(".quantity" + id);
        var currentValue = parseInt($quantity.val()) || 0;
        if (currentValue > 0) {
            $quantity.val(currentValue - step);
        }
    }

    function incrementQuantity(step, id) {
        var $quantity = $(".quantity" + id);
        var currentValue = parseInt($quantity.val()) || 0;
        $quantity.val(currentValue + step);
    }

    function contarProductosEnCarrito() {
        const obj_fila = localStorage.getItem('obj_fila');
        let cantidadTotal = 0;
        if (obj_fila) {
            try {
                const productos = JSON.parse(obj_fila);
                if (Array.isArray(productos) && productos.length > 0) {
                    cantidadTotal = productos.length;
                }
            } catch (error) {
                console.error('Error al parsear JSON:', error);
                cantidadTotal = 0;
            }
        }
        $('#cantidad-carrito').text('(' + cantidadTotal + ')');
    }

    contarProductosEnCarrito();

    function pedido(id, imagen, codigo, nombre, precio, descuento, stock) {
        if (stock <= 0) {
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
            url: '{{ route("eventos.store") }}',
            type: 'POST',
            data: evento,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function(response) { console.log("Evento guardado", response); },
            error: function(xhr, status, error) { console.error("Error al guardar el evento", error); }
        });

        var producto = { item_id: id, item_name: nombre, price: precio, quantity: cantidad };
        myCartModule.addToCart(producto);

        let precioFinal = precio;
        const subtotal = precioFinal * cantidad;
        const fila = {
            cantidad: cantidad,
            imagen: imagen,
            codigo: codigo,
            nombre: nombre,
            precio: precioFinal,
            subtotal: subtotal,
            pid: `fila_${id}`
        };

        let obj_fila = localStorage.getItem('obj_fila');
        if (obj_fila != null) {
            obj_fila = JSON.parse(obj_fila);
            const index = obj_fila.findIndex(obj => obj.codigo === fila.codigo);
            if (index !== -1) {
                obj_fila[index].cantidad = parseInt(obj_fila[index].cantidad) + parseInt(fila.cantidad);
            } else {
                obj_fila.push(fila);
            }
        } else {
            obj_fila = [fila];
        }

        localStorage.setItem('obj_fila', JSON.stringify(obj_fila));
        alertify.set('notifier', 'position', 'bottom-right');
        alertify.notify(`Se agregó el producto al carrito`, 'success', 3);
        contarProductosEnCarrito();
    }
</script>