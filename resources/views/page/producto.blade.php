@extends('layouts.plantilla')
@section('metadatos')
    <meta name="description" content="{{ $metadatos->descripcion }}" />
    <meta name="keywords" content="{{ $metadatos->keyword }}" />
@endsection
@section('content')
    <style>
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

        .accordion-button:not(.collapsed) {
            color: #006FA9;
            font-weight: 700;
            background: none;
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
        .boxColor{
            width: 56px;
            height: 56px;
            margin: 10px 15px;
        }
        @media (max-width: 600px) {
            .aplicaciones table tr {
                display: flex;
                flex-flow: column;
            }
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

    <div class="col-12 py-2 d-flex justify-content-center" style="font-size:14px;color:#000000;">
        <div class="box_container">

            <a style="text-decoration: none;color:#000;" href="{{ route('page.inicio') }}">Inicio</a>
            /
            <a style="text-decoration: none;color:#000;text-transform: uppercase;" href="#">{{ $producto->name }}</a>
        </div>

    </div>


    <div class="container col-12 py-2" style="font-size:16px;color:#8A8A8A;">
        <a style="text-decoration: none !important; color: #8A8A8A" href="{{ route('page.inicio') }}"> Inicio </a>
        /
        <a style="text-decoration: none;color:#8A8A8A;" href="{{ route('page.productosCategorias') }}">Productos</a> 
        @if ($categoria)
            / {{ $categoria->name }} /
        @endif
        <a style="text-decoration: none;color:#000;text-transform: uppercase;" href="#">{{ $producto->name }}</a>

    </div> 



    <div class="d-flex justify-content-center flex-wrap">
        <div class="box_container d-flex flex-row flex-wrap justify-content-between align-items-start py-4">
            <div class="col-12 col-md-3 pe-0 pe-md-4">
                <div class="sidebar py-3">
                    <div class="accordion" id="accordionExample">
                        <div class="casillaF">
                            <p class="filtrarPor">Filtrar por</p>

                        </div>
                        @forelse ($categorias as $item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{ $item->id }}">
                                <button class="accordion-button {{ (int)$categoria->id == (int)$item->id ? 'boldSubcategoria' : '' }}" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $item->id }}" aria-expanded="true"
                                    aria-controls="collapse{{ $item->id }}" onclick="fetchSubcategorias({{ $item->id }})">
                                    {{ $item->name }}
                                </button>
                            </h2>
                            <div id="collapse{{ $item->id }}" class="accordion-collapse collapse"
                                aria-labelledby="heading{{ $item->id }}" data-bs-parent="#accordionExample">
                                <div id="subcategorias-{{ $item->id }}" class="accordion-body d-flex flex-column align-items-start">
                                    <!-- Aquí se cargarán las subcategorías -->
                                </div>
                            </div>
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
                            @if ($producto->imagen)                                                     
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            @endif                            
                            @forelse ($producto->obtenerGaleria() as $galeria)                            
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$loop->iteration}}" aria-label="Slide {{$loop->iteration}}"></button>                                
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
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <span class="visually-hidden">Next</span>
                            </button>
                          </div>
                    </div>

                    <div class="col-12 col-md-6 d-flex flex-column propiedadList">
                        <div class="pb-4 d-flex justify-content-between align-items-center"
                            style="font-size:24px;color:#000;font-weight:600;text-transform: uppercase;">
                            {{ $producto->name }}

                        </div>
                        <b>Codigo: </b>{!! nl2br(e($producto->code)) !!}
                        <br>
                        @isset($producto->marca)
                        <b>Marca: </b>{{$producto->marca}}
                        @endisset
                        <b>Codigo Anterior: </b>{!! nl2br(e($producto->codigoAnterior)) !!}
                        <br>
                        @isset($producto->description)
                        {!! nl2br(e($producto->description)) !!}
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
                        @if (isset(Auth::guard('cliente')->user()->id))
                        <a class="btn zp_container py-1 px-4"
                            style="color:#fff;background:#F15E40;border-radius:35px;"
                            href="{{ route('page.productosPedidoSearch', $producto->ObtenerCategoria()->id) }}">
                            Comprar
                        </a>
                        @endif
                        
                    </div>                    
                </div>
            </div>
        </div>

    </div>
    

    @endsection
