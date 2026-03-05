@extends('layouts.plantilla')

@section('metadatos')

@endsection





@section('content')

    <style>

        .textochico {

            max-width: 60%;

            max-height: 50%;

            overflow: hidden;

            position: relative;

            z-index: 2;

            color: #000;

        }



        .textochico h5,

        h4,

        h3,

        h2,

        h1 {

            font-size: 32px;

        }



        .textochico p {

            font-size: 1.1vw;

        }



        .tituloSlider {

            font-weight: 500;

            font-size: 32px;

            color: #000;

        }



        .titulo {

            color: #000;

        }



        .producto:hover {

            text-decoration: none;

        }



        .btn-ficha {

            color: #fff;

            background-color: #124D6B;

            border-color: #124D6B;

        }





        .btn-ficha:hover {

            color: #124D6B;

            background-color: white;

            border-color: #124D6B;



        }



        .prodwrap {

            width: 100%;

            height: 300px;



        }



        .prodwrap:hover .imgoverlay {

            display: block;

            top: 13px;

            bottom: 15px;

            left: 10px;

            right: 20px;

            height: 202px;

            width: 354px;

            opacity: 0.5;

            transition: .5s ease;

            background-origin: content-box;

            padding: 85px;

            background-color: #009FE3;

        }



        .imgoverlay {

            cursor: pointer;

            position: relative;

            display: none;

            color: white;



            text-align: center

        }



        .imgoverlay:hover {

            position: relative;

            color: white;



        }



        .icono_hover {

            height: 53px;

            width: 54px;

        }



        .producto:hover {

            text-decoration: none;



        }



        .carousel-indicators li {

            width: 10px;

            height: 10px;

            border-radius: 20px;

            border-top: none;

            border-bottom: none;

        }



        .home_slider .contenedor_texto {

            position: absolute;

            padding: 8% 0;

            top: 11%;

            display: block !important;

            position: relative;

            z-index: 9;

        }



        .textoSlider h1 {

            position: relative;

            left: -138%;

            padding-left: 5px;

        }



        .contenedor_texto h2 {

            font-size: 27px;

            font-weight: bold;

            text-align: start;

            text-transform: uppercase;

        }



        .carousel-indicators {

            background-color: unset !important;

            left: -88%;

            padding-left: 10vh;

        }



        .carousel-indicators.active {

            background-color: #fff !important;

        }



        #carouselExampleIndicators .carousel-indicators button.active {

            border-top: unset !important;

            border-bottom: unset !important;

            width: 10px !important;

            height: 10px !important;

            border-radius: 15px !important;

            background-color: #FFFFFF !important;



        }



        #carouselExampleIndicators .carousel-indicators button {

            border-top: unset !important;

            border-bottom: unset !important;

            width: 10px !important;

            height: 10px !important;

            border-radius: 15px !important;

            background-color: #fff !important;



        }



        .banner_titulo_slider h1 {

            margin: unset;

            line-height: 0.6;

        }



        :focus-visible {

            outline: none;

        }



        .slick-dots li button:before {

            font-size: 17px;

        }



        .slick-dots {

            bottom: -50px;

        }



        .slick-dots li.slick-active button:before {

            color: #717171;

        }



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



        /* .box_hover:hover img{

                                      -webkit-transform: scale(1.05);

                                        transform: scale(1.05);

                                        transition: all 0.5s ease 0.2s;

                                    } */

        .box_hover {

            position: relative !important;

        }



        .box_hover:hover:before {

            content: "+";

            display: flex;

            justify-content: center;

            align-items: center;

            font-size: 45px;

            background: #D8D8D8;

            width: 30%;

            height: 30%;

            border-radius: 100%;

            opacity: 0.7;

            z-index: 99;

            color: #fff;

            position: absolute;

        }



        .box_hoverImg img {

            position: relative;

            z-index: 100;

        }



        .box_hoverImg div {

            position: relative;

            z-index: 101;

        }



        .box_hoverImg:hover img {

            -webkit-transform: scale(1.03);

            transform: scale(1.03);

            transition: all 0.3s ease 0.2s;

            position: relative;

            z-index: 100;

        }



        .box_hoverImg img:before {

            content: " ";

            display: flex;

            justify-content: center;

            align-items: center;

            font-size: 45px;

            background: #D8D8D8;

            width: 100%;

            height: 100%;

            opacity: 0.7;

            z-index: 99;

            background: #D8D5C4;

            color: #fff;

            position: absolute;

        }



        /*

                                    .box_hover2:hover:before{

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

                                    } */

        .box_banner p {

            padding-bottom: 3vh;

        }



        .boxHeader {

            position: absolute;

            z-index: 2;

        }



        .bg-container::after {

            background: linear-gradient(90deg, rgba(0, 0, 0, 0.68) 0%, rgba(0, 0, 0, 0) 100%);

            width: 100%;

            height: 100%;

            z-index: 1;

            position: absolute;

        }



        .equipoContainer {

            overflow: hidden;

            /* Oculta el contenido que se desborde */

            position: relative;

            /* Necesario para centrar la imagen */

        }



        .equipoContainer::before {

            content: "";

            position: absolute;

            top: 0;

            left: 0;

            width: 100%;

            height: 100%;

            background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.4) 100%);

            opacity: 0;

            transition: opacity 0.5s ease;

            z-index: 2;

        }



        .equipoContainer:hover::before {

            opacity: 1;

        }



        .equipoContainer span {

            color: #000;

            font-size: 20px;

            padding: 0 58px;

            text-align: center;

        }



        .equipoContainer img {

            /* position: absolute; */

            /* Para centrar la imagen */

            /* top: 50%; */

            /* Centra verticalmente */

            /* left: 50%; */

            /* Centra horizontalmente */

            /* transform: translate(-50%, -50%) scale(2); */

            /* Centra y escala la imagen */

            /* transition: transform 0.5s ease; */

            /* Agrega una transición suave */

        }



        /* .equipoContainer:hover img {

                    transform: translate(-50%, -50%) scale(2.3);

                } */



        @media (max-width: 600px) {

            .home_slider .contenedor_texto {

                padding: 0 0vh !important;

                padding-top: 0vh !important;

            }



            .home_slider .contenedor_texto h1,

            h2 {

                font-size: 14px !important;

            }



            .home_slider .contenedor_texto P {

                font-size: 11px !important;

            }



            .banner_padding {

                padding: 5vh 2vh !important;

            }



            .banner_titulo_slider h1 {

                line-height: 1.4 !important;

            }



            .img_logo_hecho {

                left: 62% !important;

            }

        }





        .home_slider.carousel-item.active div::before {

            background: rgba(0, 0, 0, 0.7);

        }

        video::-webkit-media-controls {

            display: none !important;

        }



        video::-webkit-media-controls-enclosure {

            display: none !important;

        }



        video::-webkit-media-controls-panel {

            display: none !important;

        }



        video::-webkit-media-controls-play-button {

            display: none !important;

        }



        video::-webkit-media-controls-start-playback-button {

            display: none !important;

        }

    </style>

    {{-- SLDIER --}}

    @if ($modal)

      </div><button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">

        Launch demo modal

      </button>

      

      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-header">

              <h5 class="modal-title" id="exampleModalLabel"></h5>

              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>   

            <a href="{{$modal->mapa}}">

                

                <img src="{{ asset(Storage::url($modal->direccion)) }}" class="img-fluid">

            </a>         

          </div>

        </div>

      </div>

    @endif

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">



        <div class="carousel-inner ">

            <div class="w-100 h-100" style="position: absolute;background:rgba(0, 0, 0, 0.35);z-index:5"></div>

            @forelse ($sliders as $key => $item)            

                @if ($loop->first)

                    <div class="home_slider carousel-item active" style="position:relative;">

                        @if(substr($item->imagen, -3) == 'mp4')

                        <div class="videoWrapper d-none d-md-flex justify-content-center" style="position:relative;">

                            <video style="width: -webkit-fill-available;" src="{{ asset(Storage::url($inicio->video)) }}" autoplay loop muted controls="false"></video>

                            <div class="contenedor_texto box_container" style="display: block!important;position: absolute!important;">

                                <div class="pe-5 d-none d-md-block" data-aos="fade-down" data-aos-easing="linear"

                                    data-aos-duration="1000" style="position: relative;bottom: -34%;width: 60%;">

                                    <div class="tituloSlider" style="color:#fff">{{ $item->titulo }}</div>

                                    <div class="textochico" style="color:#fff">{!! $item->descripcion !!}</div>



                                </div>

                            </div>

                        </div>

                        <div class="videoWrapper d-block d-md-none" style="position:relative;">

                            <video style="width: -webkit-fill-available;" src="{{ asset(Storage::url($inicio->video)) }}" style="width: -webkit-fill-available;" autoplay loop muted controls="false"></video>

                        </div>

                        @else

                            <div class=" w-100 d-none d-md-flex justify-content-center"

                                style="background: url({{ asset(Storage::url($item->imagen)) }});background-size: cover;background-repeat: no-repeat;background-position: right;position:relative;height:80vh;">

                                <div class="contenedor_texto box_container" style="display: block!important">

                                    <div class="pe-5 d-none d-md-block" data-aos="fade-down" data-aos-easing="linear"

                                        data-aos-duration="1000" style="position: relative;bottom: -34%;width: 60%;">

                                        <div class="tituloSlider" style="color:#fff">{{ $item->titulo }}</div>

                                        <div class="textochico" style="color:#fff">{!! $item->descripcion !!}</div>



                                    </div>

                                </div>

                            </div>

                            <img class="d-md-none" src="{{ asset(Storage::url($item->imagen)) }}" width="100%" height="auto">

                        @endif                        

                    </div>

                @else                

                    <div class="home_slider carousel-item" style="position:relative;">

                        @if(substr($item->imagen, -3) == 'mp4')

                        <div style="height: auto">

                            <div class="videoWrapper d-none d-md-flex justify-content-center" style="position:relative;">

                                <video style="width: -webkit-fill-available;" src="{{ asset(Storage::url($item->imagen)) }}" autoplay loop muted controls="false"></video>

                                <div class="contenedor_texto box_container" style="display: block!important;position: absolute!important;">

                                    <div class="pe-5 d-none d-md-block" data-aos="fade-down" data-aos-easing="linear"

                                        data-aos-duration="1000" style="position: relative;bottom: -34%;width: 60%;">

                                        <div class="tituloSlider" style="color:#fff">{{ $item->titulo }}</div>

                                        <div class="textochico" style="color:#fff">{!! $item->descripcion !!}</div>

    

                                    </div>

                                </div>

                            </div>

                            <div class="videoWrapper d-block d-md-none" style="position:relative;">

                                <video style="width: -webkit-fill-available;" src="{{ asset(Storage::url($item->imagen)) }}" style="width: -webkit-fill-available;" autoplay loop muted controls="false"></video>

                            </div>

                        </div>

                        @else

                        <div class=" w-100 d-none d-md-flex justify-content-center"

                            style="background: url({{ asset(Storage::url($item->imagen)) }});background-size: cover;background-repeat: no-repeat;background-position: right;position:relative;height:80vh;">

                            <div class="contenedor_texto box_container" style="display: block!important">

                                <div class="pe-5 d-none d-md-flex justify-content-center align-items-center" data-aos="fade-down" data-aos-easing="linear"

                                    data-aos-duration="1500" style="position: relative;bottom: -34%;width: 60%;">

                                    <div class="tituloSlider"  style="color:#fff">{{ $item->titulo }}</div>

                                    <div class="textochico" style="color:#fff" >{!! $item->descripcion !!}</div>

                                    @isset($item->link)

                                        <div class="my-5">

                                            <a href="{{ $item->link }}" class="py-2 px-4"

                                                style="background:rgb(0, 166, 81);color:#fff;text-decoration: none;border-radius:0px;">{{ $item->boton }}</a>

                                        </div>

                                    @endisset

                                </div>

                            </div>

                        </div>

                        <img class="d-md-none" src="{{ asset(Storage::url($item->imagen)) }}" width="100%" height="auto">

                        @endif

                    </div>       

            @endif

                <div class="flex flex-column justify-content-center align-items-start">

                    <div class="box_container">

                        <ol class="carousel-indicators m-0 ps-5" style="justify-content:left;bottom:15px;left:15px;position: absolute;z-index:6;">

                            @for ($i = 0; $i < count($sliders); $i++)

                                <button type="button" data-bs-target="#carouselExampleIndicators"

                                    data-bs-slide-to="{{ $i }}"

                                    style="width: 27px!important;height: 5px!important;"

                                    class="{{ $i == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide 1"></button>

                            @endfor

                        </ol>

                    </div>

                </div>

            @empty

            @endforelse



        </div>



    </div>

    @if(count($logos)>0)

    <div class="d-flex flex-column justify-content-center align-items-center my-4">

        <div class="box_container d-flex justify-content-start align-items-center p-2 flex-wrap" style="background: #F5F5F5;">

            @forelse ($logos as $logo)

                <img src="{{ asset(Storage::url($logo->imagen)) }}" class="img-fluid m-2" style="max-width: 200px">

            @empty

                

            @endforelse

        </div>

    </div>

    @endif

    <div class="d-flex flex-column justify-content-center align-items-center">

        {{-- PRODUCTOS DESTACADOS --}}

        @if (count($articulos) > 0)

            <div

                class="d-flex flex-row justify-content-start align-items-center align-items-md-start flex-wrap mx-1 mx-md-5 box_container">

                <div class="col-12 text-center pt-5 mb-3" style="font-size:26px;font-weight:500;">Productos destacados</div>

                @forelse ($articulos as $producto)                

                <div class="d-flex flex-column productoContainer" onclick="window.location='{{ route('page.producto', $producto) }}'">

                    <img src="{{ asset(Storage::url($producto->imagen)) }}" class="img-fluid">

                    <b>{{ $producto->name }}</b>



                    @if ($producto->ObtenerCategoria())

                        {{$producto->ObtenerCategoria()->name}}

                    @endif

                    

                </div>

                @empty

                    <div class="col-12 px-2">

                        <span>No se encontraron productos.</span>

                    </div>

                @endforelse

            </div>

        @endif

    </div>



    



    <div class="d-flex justify-content-between flex-wrap mt-5 mb-5" style="background: #F4F4F4;">

        <div data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800"

        class="col-12 col-md-5 d-flex flex-column justify-content-center align-items-center px-1">

        <div style="width: 60%;" class="tituloSlider">{{ $inicio->titulo }}</div>

        <div style="width: 60%;" class="textochico">{!! $inicio->descripcion !!}</div>

    </div>

    <div class="col-12 col-md-7">

        <img class="d-flex justify-contentet-start col-8 py-5" data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800"

            src="{{ asset(Storage::url($inicio->imagen)) }}">

    </div>

    </div>



    <div class="d-flex flex-column justify-content-center align-items-center">

        {{-- PRODUCTOS DESTACADOS --}}

        @if (count($categorias) > 0)

            <div

                class="d-flex flex-row justify-content-start align-items-center align-items-md-start flex-wrap mx-1 mx-md-5 box_container">

                <div class="col-12 text-center pt-5 mb-3" style="font-size:26px;font-weight:500;">Categorías destacadas</div>                

                @forelse ($categorias as $item)

                <div id="boxProducto"

                    class="col-12 col-md-6 d-fex flex-column justify-content-center align-items-center align-items-md-start mb-5"

                    style="position: relative;text-transform:uppercase;border-radius: 0px;" data-aos="zoom-in">

                    <div class="d-flex flex-column justify-content-start align-items-center"

                        style="cursor:pointer;border-radius:0px;">

                        <div class="equipoContainer d-flex flex-row justify-content-center align-items-end"

                            style="background:#fff;border:1px solid #f4f4f4"

                            onclick="window.location='{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}'">

                            <div class="d-flex justify-content-start align-items-end col-6 pb-4">

                                <span class="px-5 text-center"><b>{{ $item->name }}</b></span>

                            </div>

                            <div class="d-flex justify-content-center align-items-center col-6">

                                @if ($item->imagen)

                                    <img src="{{ asset(Storage::url($item->imagen)) }}" class="img-fluid px-4">

                                @else

                                    <img src="{{ asset('img/logo2.jpg') }}" class="px-4">

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

                @empty

                    <div class="col-12 px-2">

                        <span>No se encontraron productos.</span>

                    </div>

                @endforelse

            </div>

        @endif

    </div>



    <div class="d-flex justify-content-between flex-wrap mt-5 mb-5" style="background: #F4F4F4;">

        <div class="col-12 col-md-7">

            <img class="d-flex justify-contentet-start" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800"

                src="{{ asset(Storage::url($inicio->imagenDos)) }}">

        </div>

        <div data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800"

        class="col-12 col-md-5 d-flex flex-column justify-content-center align-items-center px-1">

        <div style="width: 60%;" class="tituloSlider">{{ $inicio->tituloDos }}</div>

        <div style="width: 60%;" class="textochico">{!! $inicio->descripcionDos !!}</div>

    </div>

    </div>

    <!-- Modal -->

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="errorModalLabel">Error</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                @if ($errors->has('msj'))

                    {{ $errors->first('msj') }}

                @endif

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            </div>

        </div>

    </div>

</div>

    <script>

        const button = document.querySelector('.btn-primary');

        window.onload = function() {

            console.log(button)

            button.click();    

        };

        </script>    

@endsection

