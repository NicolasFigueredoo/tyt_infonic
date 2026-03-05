@extends('layouts.newplantilla')
<?php
  use App\Models\TipoArticulo;
  use App\Models\Articulo;

?>
@section('metadatos')
    <meta name="description" content="{{ $metadatos->descripcion }}" />
    <meta name="keywords" content="{{ $metadatos->keyword }}" />
@endsection
@section('content')
    <style>


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

        .precioV{
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

        .boldSubcategoria{
            font-weight: bold !important
        }
        .contenedorSubcat{
            display: flex;
             justify-content: start;
             align-items: center;


        }

        .producto-portada{height: 240px;}
        .imgLogoP {

            width: 80%;
            height: 100%;
        }

        .accordion-button {
            background: none !important;
            box-shadow: none !important;
            border-radius: 0px !important;
            padding-left: 0px !important
        }

        .accordion-button-two {
            border: none;
            background: none !important;
            box-shadow: none !important;
            border-radius: 0px !important;
            padding-left: 0px !important;
            font-size: 1rem;
            font-family: 'Inter';
            cursor: context-menu !important;
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

        .fondodelcoso {
            background-color: #F2F2F2;
            height: 25px;
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

        .casillaF {
            height: 50px;
            border-bottom: 1px solid #E0E0E0
        }

        .box_hover:hover:before {
            content: "+";
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            background: #D8D8D8;
            width: 100%;
            height: 100%;
            opacity: 0.4;
            z-index: 99;
            color: #fff;
            position: absolute;
        }

        th {
            vertical-align: middle;
            font-weight: 400;
        }

        .accordion-item {
            padding-top: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #E0E0E0;
                margin-right: 20px !important;
        }

        .accordion-item a {
            color: var(--Neutro-100, #161414);

            /* p */
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 20px;
            /* 142.857% */
            padding-left: 0px !important
        }

        .col-md-4-adjusted {
            width: calc(33.3333% - 10px);
            /* Ajusta el ancho restando 5px */
        }

        .mobileProductos {
            display: none !important
        }

        .product-name {
    font-weight: bold;
    text-align: center;
    word-wrap: break-word; /* Asegura que las palabras largas se ajusten */
    white-space: normal; /* Permite múltiples líneas */
    margin: 10px 0 0; /* Ajusta el margen superior */
}

.agregarCarrito{
    color: #fff;
    background: #F15E40;
    border-radius: 35px;
    font-weight: 400;
}

.agregarCarrito:hover{
    color: white !important;
}




        @media (max-width: 500px) {

            .productoContainer{
                align-items: center !important;
                height: auto !important;
            }

            .productoContainer img{
                width: 60% !important;
            }
            .productoContainer b{
                text-align: center !important;
                font-size: 14px !important
            }

            .categoriaContainer{
                align-items: center !important;
                height: auto !important;
            }

            .categoriaContainer img{
                width: 60% !important;
            }
            .categoriaContainer b{
                text-align: center !important;
                font-size: 14px !important
            }
            
            .tituloClass {
                font-size: 14px !important
            }

            .contenedorCats {
                height: 320px !important;
            }

            .tituloClassCat {
                font-size: 14px
            }

            #boxProducto {
                padding-left: 10px !important;
                padding-top: 10px !important;
                padding-right: 10px !important;
                padding-bottom: 10px !important;
                height: 150px !important;
            }

            .tituloClassCat img {
                display: none !important
            }

        }

        @media (max-width: 300px) {

            .contenedorCats {
                height: 220px !important;
            }

            .tituloClassCat {
                font-size: 10px !important
            }



            #boxProducto {
                padding-left: 5px !important;
                padding-top: 5px !important;
                padding-right: 5px !important;
                padding-bottom: 5px !important;
                height: 100px !important;
            }

            .tituloClass {
                font-size: 14px !important
            }
        }

        @media (max-width: 260px) {
            .tituloClass {
                font-size: 10px !important
            }
        }

      
        .contenedorSubcat .container {
            display: none;
        }
        

        @media (max-width: 1350px) {
            
            .textoCat{
                font-size: 14px !important;
            }
                    
        }
        
         @media (max-width: 1250px) {
            
            .textoCat{
                font-size: 12px !important;
            }
                    
        }

      /* Modal base */
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

/* Modal dialog */
.custom-modal-dialog {
    background: white;
    width: 80%;
    max-width: 800px;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
}

/* Header */
.custom-modal-header {
    padding: 15px;
    background: #f5f5f5;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: bold;
}

/* Close button */
.custom-close-btn {
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
}

/* Body */
.custom-modal-body {
    padding: 20px;
}

/* Footer */
.custom-modal-footer {
    padding: 10px;
    text-align: right;
    background: #f5f5f5;
}

/* Carrusel */
.custom-carousel {
    position: relative;
    width: 100%;
    height: auto;
}

.custom-carousel-inner {
    display: flex;
    overflow: hidden;
}

.custom-carousel-inner .carousel-item {
    flex: 1;
    display: none;
}

.custom-carousel-inner .carousel-item.active {
    display: block;
}

/* Opcional: Agrega transiciones */
.custom-modal-dialog {
    transform: translateY(-20px);
    transition: transform 0.3s ease, opacity 0.3s ease;
    opacity: 0;
}

.custom-modal.show .custom-modal-dialog {
    transform: translateY(0);
    opacity: 1;
}

        
        
        
        @media (max-width: 1000px) {
         
            .modal.show {
    display: flex !important; /* Cambiar a flex para centrar el contenido */
}

            .contenedorMobileCart{
                flex-direction: column !important
            }
            .agregarCarrito{
                margin-top: 20px
            }
               .textoCat{
                font-size: 10px !important;
            }
            
            .producto-portada {
                width: 100% !important;
            }

            .contenedorSubcat .box_container {
            display: none !important;
        }
        .contenedorSubcat .container {
            display: flex !important;
      
        }
        .sidebar {
            max-height: 300px !important;
            overflow: scroll !important;
        }

            .contenedorSubcat{
            display: flex;
            flex-direction: column !important;
             justify-content: start !important;
             align-items: start !important;


        }


            .img-fluid-two {
                height: auto;
                width: 100%;
            }

            .pcProductos {
                display: none !important
            }

            .mobileProductos {
                display: flex !important
            }
        }


        .categoriaContainer @media (max-width: 768px) {
            .col-md-4-adjusted {
                width: 95%;
            }
        }

        .slick-arrow {
            display: none;
        }
    </style>


    <div class="pcProductos">

        <!-- Categorias -->
        <div class="d-flex justify-content-center">
            <div class="d-flex flex-row justify-content-start align-items-center align-items-md-start flex-wrap box_container py-5"
                style="gap: 10px">
                @forelse ($categoriasprin as $item)
                    <div id="boxProducto"
                        class="col-12 col-md-4 col-md-4-adjusted d-flex flex-column justify-content-end align-items-center align-items-md-start g-2 p-4"
                        style="position: relative; text-transform: uppercase;
                        @if ($categoriaPrincipalVer->id !== $item->id) background: linear-gradient(0deg, rgba(128, 128, 128, 0.8), rgba(128, 128, 128, 0.8)), url({{ $item->imagen ? asset(Storage::url($item->imagen)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: cover;
                        @else
                        background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ $item->imagen ? asset(Storage::url($item->imagen)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: cover; @endif
                        height: 180px; border-radius: 10px;"
                        data-aos="zoom-in">
                        <div>
                            <spam style="color:#fff; font-weight: 600; font-size:16px; margin-bottom:0px"></spam>
                        </div>

                        <div style="height: 24px; width:50%">
                            <div
                                style="width:100%; height: 100%; background: url({{ $item->imagenMarca ? asset(Storage::url($item->imagenMarca)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: contain;">

                            </div>

                        </div>
                        <div>
                            <p style="color:#fff; font-weight: 600; font-size:46px; margin-bottom:0px">     @if(session('locale') === 'es')

                                {{ $item->name }}
                                @else
                                {{ $item->nameEnglish }}
                
                                @endif
                            </p>
                        </div>
                        <div styl>
                            <a style="color:#fff; text-decoration:none"
                                href="{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}">
                                
                                @if(session('locale') === 'es')
                                Ver Categoría 
                                @else
                                View Category
                                @endif <img src="{{ asset(Storage::url('tipo-articulo/arrow_forward.png')) }}"></a>
                        </div>
                    </div>
                @empty
                    <div class="col-12 px-2">
                        <span>No se encontraron productos.</span>
                    </div>
                @endforelse
            </div>

        </div>
        <!-- Fin Categorias -->

        <div class="d-flex justify-content-center">
            <div class="d-flex flex-row justify-content-start align-items-center align-items-md-start  box_container">
                <div class="col-lg-12">

                    <a style="text-decoration: none !important; color: #8A8A8A" href="{{ route('page.inicio') }}">Inicio
                    </a>
                    /
                    <a style="text-decoration: none;color:#8A8A8A;"
                        href="{{ route('page.productosCategorias') }}">Productos</a>
                    @if ($categoria)
                        / 
                        
                        @if(session('locale') === 'es')

                                {{ $categoria->name }}
                                @else
                                {{ $categoria->nameEnglish }}
                
                                @endif
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="mobileProductos">
        <div class="container" style="margin-top: 3rem">

            <div class="row contenedorCats" style="width: 100%; height: 400px;">

                @forelse ($categoriasprin as $item)
                    <div style="height: 100px; width:50%" class="col-lg-4 d-flex flex-column">

                        <div id="boxProducto"
                            class="col-12 col-md-4 col-md-4-adjusted d-flex flex-column justify-content-end align-items-start align-items-md-start g-2 p-4"
                            style="position: relative; text-transform: uppercase;
    border-radius: 0px; 
    height: 180px; border-radius: 10px; width:100%;
    @if ($categoriaPrincipalVer->id !== $item->id) background: linear-gradient(0deg, rgba(128, 128, 128, 0.8), rgba(128, 128, 128, 0.8)), url({{ $item->imagen ? asset(Storage::url($item->imagen)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: cover;
                        @else
                        background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ $item->imagen ? asset(Storage::url($item->imagen)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: cover; @endif                            data-aos="zoom-in">

                            <div>
                                <spam style="color:#fff; font-weight: 600; font-size:16px; margin-bottom:0px"></spam>
                            </div>

                            <div style="height: 24px; width:100%">
                                <div
                                    style="width:100%; height: 100%; background: url({{ $item->imagenMarca ? asset(Storage::url($item->imagenMarca)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: contain;">

                                </div>

                            </div>
                            <div>
                                <p class="tituloClass"
                                    style="color:#fff; font-weight: 600; font-size:26px; margin-bottom:0px">

                                    @if(session('locale') === 'es')

                                    {{ $categoria->name }}
                                    @else
                                    {{ $categoria->nameEnglish }}
                    
                                    @endif
                            </div>
                            <div>
                                <a class="tituloClassCat" style="color:#fff; text-decoration:none"
                                    href="{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}">Ver
                                    Categoría <img src="{{ asset(Storage::url('tipo-articulo/arrow_forward.png')) }}"></a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

            </div>
        </div>
    </div>
    <div class="mobileProductos">

        <div class="container col-12 py-2" style="font-size:16px;color:#8A8A8A;">
            <a style="text-decoration: none !important; color: #8A8A8A" href="{{ route('page.inicio') }}"> Inicio </a>
            /
            <a style="text-decoration: none;color:#8A8A8A;" href="{{ route('page.productosCategorias') }}">Productos</a>
            @if ($categoria)
                / 
                
                @if(session('locale') === 'es')

                {{ $categoria->name }}
                @else
                {{ $categoria->nameEnglish }}

                @endif
            @endif
        </div>
    </div>




    <div class="d-flex justify-content-center mt-5" style="margin-bottom: 200px">
        <div class="align-items-md-start box_container container contenedorSubcat">
            <div class="col-12 col-lg-3">

                <div class="sidebar py-3">
                    <div class="accordion" id="accordionExample">
                        <div class="casillaF">
                            <p class="filtrarPor">

                                @if(session('locale') === 'es')
                                Filtrar por                                @else
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
                                <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $item->id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $item->id }}" 
                                    
                                   
                                    onclick="handleButtonClick({{ $item->id }}, {{ $encontro !== null ? 'true' : 'false' }}, '{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 1])}}')">
                                    @if(session('locale') === 'es')
                                    {{ $item->name }} 
                                    @else
                                    {{ $item->nameEnglish }} 

                                    @endif
                                    
                                </button>
                            </h2>

                            @if ($encontro !== null)
                                
                            <div id="collapse{{ $item->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $item->id }}" data-bs-parent="#accordionExample">
                                <div id="subcategorias-{{ $item->id }}" class="accordion-body d-flex flex-column align-items-start">
                                    <!-- Aquí se cargarán las subcategorías -->
                                </div>
                            </div>
                            @endif

                        </div>
                    @empty
                        <p>No hay categorías disponibles.</p>
                    @endforelse
                    
                      
                    </div>
                </div>

            </div>

            <div class="col-12 col-lg-9">

                <div class="row pcProductos productosCpC">
               



                    @include('partials.productosOrCategorias', ['productos' => $productos, 'categoriasSub' => $categoriasSub, 'tieneProductos' => $tieneProductos])


                </div>
                <div class="row mobileProductos productosCpC">
                    @if ($categoriasSub)
                        @forelse ($categoriasSub as $producto)
                            <div class="col-6 d-flex flex-column categoriaContainer"
                                onclick="window.location='{{ route('page.productos', ['id' => $producto->id, 'productosVisible' => 1]) }}'">
                
                                @isset($producto->imagen)
                                <div class='producto-portada' style='background-image: url("{{asset(Storage::url($producto->imagen))}}"); background-size: contain;  background-position: center; background-repeat:no-repeat;'>
                                
                                </div>
                                @else
                                <div class='producto-portada' style='background-image: url("{{ asset('images/logo.png')}}");  background-position: center; background-repeat:no-repeat;'>
                                
                                </div>
        
                                @endisset
                
                                <b style="justify-content: center;align-items: center;display: flex;">
                                    {{ $producto->name }}</b>
                            </div>
                        @empty
                        @endforelse
                    @endif
                    
                                        @include('partials.productosOrCategorias', ['productos' => $productos, 'categoriasSub' => $categoriasSub, 'tieneProductos' => $tieneProductos])

                
               
                </div>
                
            </div>

        </div>

    

    </div>

    

    



@endsection


@section('js')


<script>
     const subcategoriasUrl = "{{ route('subcategorias') }}";
     const tieneProductosUrl = "{{ route('tieneProductos') }}";

let fetching = false;


  function ajaxCategorias(itemId,routeUrl,tieneProductos){


            $('.accordion-button').removeClass('boldSubcategoria');
    
    // Agrega la clase solo al botón específico
    $(`#heading${itemId} .accordion-button`).addClass('boldSubcategoria');

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
    
        if (encontro) {
            fetchSubcategorias(itemId);
        }
    
            ajaxCategorias(itemId,routeUrl,tieneProductos)


   }


function tieneProductos(categoriaId) {
    return new Promise(function(resolve, reject) {
        $.ajax({
            url: tieneProductosUrl,
            type: 'POST',
            data: {
                categoriaId: categoriaId,
                _token: '{{ csrf_token() }}' 
            },
            success: function(data) {
                if (data) {
                    resolve(1); // Resuelve la promesa con 1 si tiene productos
                } else {
                    resolve(0); // Resuelve la promesa con 0 si no tiene productos
                }
            },
            error: function(error) {
                reject(error); // Manejo de errores si falla la solicitud AJAX
            }
        });
    });
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
                _token: '{{ csrf_token() }}' // Incluye el token CSRF
            },
            success: function (data) {
                container.html(data);
                container.slideDown();

                $('#heading' + categoriaId + ' .accordion-button').addClass('active-subcategory');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar las subcategor���as:', textStatus, errorThrown);
                console.error('Respuesta del servidor:', jqXHR.responseText);
                alert('Error al cargar las subcategor���as.');
            },
            complete: function () {
                fetching = false;
            }
        });
    } else {
        container.slideToggle();
    }

    
    
}</script>
@endsection

@if($categoria->principal == 'false') <!-- Asegúrate de que esta variable contenga el ID de la categoría seleccionada -->
    @push('scripts')
    <script>
        $(document).ready(function() {

     



          
            const categoriaId = {{ $categoria->id }};
            const categoriaPadre = {{ $categoria->sub_categoria_id }};

            tieneProductos(categoriaId).then(function(resultado) {
                if(resultado == 1){
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
      }else{
          const container = $('#subcategorias-' + categoriaId);
          const acordeonCollapse = $('#collapse' + categoriaId);
          const bsCollapse = new bootstrap.Collapse(acordeonCollapse[0], {
              toggle: true
          });

          bsCollapse.show();
          fetchSubcategorias(categoriaId, categoriaPadre);
          $('#heading' + categoriaPadre + ' .accordion-button').css('font-weight', 'bold');

      }
                }
}).catch(function(error) {
    console.error('Error:', error); // Manejo de errores si la petición falla
});
          
        

        });
    </script>
    @endpush
@endif





