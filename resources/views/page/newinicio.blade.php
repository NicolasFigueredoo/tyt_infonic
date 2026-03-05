@extends('layouts.newplantilla')
@section('metadatos')
@endsection


@section('content')
    <style>

        .visitarPopup{
            height: 52px;
            width: 180px;
            padding: 16px 18px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            color: var(--Primary-color, #fff);
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            background: #F15E40;
            /* 142.857% */
            border-radius: 40px;
            border: 1.5px solid var(--Primary-color, #F15E40);
        }
        .cuadradoNaranjaMobile {
            padding: 5px !important;
            width: 100% !important;
            margin: 10px !important;
            height: 120px !important;
        }

        .textoNaranja:hover {
            font-weight: bold !important;
        }

        .slick-dots li button {
            white-space: nowrap;
            text-color: black !important;
            text-decoration: none !important;
            text-indent: -9999px;
            overflow: hidden
        }


        .verProductosBotonTwoVisit{
            z-index: 1065 !important;
            height: 52px;
            width: 180px;
            padding: 16px 18px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            color: var(--Primary-color, #ffff);
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            /* 142.857% */
            border-radius: 40px;
            background: #F15E40; 
            border: 1.5px solid var(--Primary-color, #F15E40);
        }

        .verProductosBotonTwo {
            height: 52px;
            width: 180px;
            padding: 16px 18px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            color: var(--Primary-color, #F15E40);
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            /* 142.857% */
            border-radius: 40px;
            border: 1.5px solid var(--Primary-color, #F15E40);
        }

        .verProductosBotonTwo:hover {
            background: #F15E40;
            color: #fff
        }

        .verProductosBoton {
            height: 52px;
            width: 180px;
            padding: 16px 18px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            color: var(--Primary-color, #fff);
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            /* 142.857% */
            border-radius: 40px;
            border: 1.5px solid var(--Primary-color, #F15E40);
            background: #F15E40;


        }

        .verProductosBoton:hover {
            background: #fff;
            color: #F15E40
        }

        .textochico {
            max-width: 60%;
            max-height: 50%;
            overflow: hidden;
            position: relative;
            z-index: 2;
            color: #000;
        }

        .loguearse {
            width: 180px;

            height: 52px;
            padding: 16px 18px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 40px;
            border: 1.5px solid #F14B40 !important;
            background: #F14B40 !important;
            color: var(--Neutro00, #FFF) !important;
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            /* 142.857% */
        }

        .loguearse:hover {
            border: 1.5px solid #F14B40 !important;
            background: #fff !important;
            color: var(--Neutro00, #F14B40) !important;
        }

        .registrarse {
            height: 52px;
            width: 180px;
            padding: 16px 18px;
            justify-content: center;
            align-items: center;
            gap: 10px;
            border-radius: 40px;
            border: 1.5px solid #F14B40;
            color: #F14B40;
            font-family: Inter;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
            /* 142.857% */
        }

        .registrarse:hover {
            background: #F14B40 !important;
            color: #fff !important;

        }




        .textoNaranja {
            color: var(--Neutro00, #FFF);
            text-align: center;

            font-family: Inter;
            font-size: 20px;
            font-style: normal;
            font-weight: 600;
            line-height: 130%;
            /* 26px */
            padding-top: 21px;
            text-decoration: none;

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




        .slick-dots li.slick-active button:before {
            color: #717171;
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
            /* Agrega una transici贸n suave */
        }

        /* .equipoContainer:hover img {
                            transform: translate(-50%, -50%) scale(2.3);
                        } */

        @media (max-width: 500px) {
            .productoContainer img {
                height: 55% !important;
            }

            .nameCategoriaM {
                font-size: 30px !important
            }


        }

        @media (max-width: 300px) {
            .productoContainer img {
                height: 40% !important;
            }


        }

        @media (max-width: 1000px) {

            /* Forzar que el modal con la clase "show" se muestre */
.modal.show {
    display: block !important; /* Aseguramos que se muestra */
    opacity: 1 !important;     /* Para que no esté transparente */
    visibility: visible !important;
}


/* Asegúrate de que el modal tenga un z-index mayor al backdrop */
.modal {
    z-index: 1050 !important;
}

.modal-backdrop {
    z-index: 1040 !important; /* El backdrop debe tener un z-index más bajo */
}

.modal-dialog {
        max-width: 95%; /* Ajusta aún más en pantallas muy pequeñas */
    }

    .modal-lg {
        max-width: 50% !important; /* Ajusta el tamaño del modal para pantallas pequeñas */
    }
            .textoNaranja {
                font-size: 18px !important;
            }

            .barraN {
                height: auto !important;
                width: 100% !important;
                padding-bottom: 20px !important;
                padding-top: 20px !important;

            }

            .barraN div div {
                padding-bottom: 20px !important;
                padding-top: 46px !important;



            }





            .infoP {
                display: flex;
                flex-direction: column-reverse;
                height: auto !important;
            }

            .inicioinfotitle {
                width: 100% !important;
            }

            .inicioinfodescri {
                width: 100% !important;
            }

            .inicioinfobotton {
                width: 100% !important;
                padding-bottom: 50px
            }

            .contenedorT {
                padding-left: var(--bs-gutter-x, .75rem) !important;
            }





        }

        @media (max-width: 600px) {

            .barraN {
                padding: 0px !important
            }

            .experiencia {
                width: 93% !important;
            }


            .inicioinfodescri {
                padding-top: 0px !important;
                padding-bottom: 0px !important;

            }

            .inicioinfobotton button {
                margin-top: 20px !important;
            }


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

        @media (max-width: 336px) {


            .responsive_productos {
                height: 450px !important;
            }

            .slick-list {
                height: 400px !important;
            }

            .barraN {
                padding: 0px !important
            }

        }

        @media (max-width: 1340px){
            .loguearse{
                margin-top: 10px !important;
            }
        }


        @media (max-width: 1400px){
            .loguearse{
                margin-left: 0px !important;
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
    <style>
        .col-md-4-adjusted {
            width: calc(33.3333% - 16px);
            /* Ajusta el ancho restando 5px */
        }

        .inicioinfotitle {
            font-size: 32px !important;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .col-md-4-adjusted {
                width: 95%;
            }

            .inicioinfotitle {
                font-size: 32px !important;
                font-weight: 600;
                margin-top: 20px;
            }
        }

        .slick-arrow {
            display: none;
        }


        .productoContainer:hover img {
            transform: scale(0.9);
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5));
            transition: transform 0.3s ease;
        }
    </style>
    {{-- SLDIER --}}
    @if ($modal)
        </div><button type="button" class="btn btn-primary d-none" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-keyboard="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background: transparent !important; border: 0px">
                    <div class="modal-header d-flex justify-content-between" style="border-bottom: 0px">
                        <button class="btn py-1 px-4 verProductosBotonTwoVisit" type="button"
                            onclick="window.location='{{ $modal->mapa }}'"
                            style="position: relative; z-index: 10;">
                            @if(session('locale') === 'es')
                                Visitar
                            @else
                                Visit
                            @endif   
                        </button>

                        <button class="btn py-1 px-4  btn-close" type="button"  data-bs-dismiss="modal" aria-label="Close"
                        style="position: relative; z-index: 10;">
                        <svg fill="#ffffff" height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 460.775 460.775" xml:space="preserve" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55 c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55 c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505 c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55 l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719 c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z"></path> </g></svg>

                    </button>
                      
                    </div>
                    <div class="modal-body" style="cursor: pointer; position: relative; z-index: 1; background: transparent !important; border: 0px">
                        <div style="width: 500px; height: 600px; background-image: url('{{ asset(Storage::url($modal->direccion)) }}'); background-size: cover; background-position: center;" id="modalImage">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        </div>
    @endif
    <!-- Categorias -->
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-row justify-content-center align-items-center align-items-md-start flex-wrap box_container py-5"
            style="gap: 10px">
            @forelse ($categoriasprin as $item)
                <div id="boxProducto"
                    class="col-12 col-md-4 col-md-4-adjusted d-flex flex-column justify-content-end align-items-start align-items-md-start g-2 p-4 "
                    style="position: relative; text-transform: uppercase;
                    border-radius: 0px; background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ $item->imagen ? asset(Storage::url($item->imagen)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: cover;
                    height: 360px; border-radius: 10px"
                    data-aos="zoom-in">
                    <div>
                        <spam style="color:#fff; font-weight: 600; font-size:16px; margin-bottom:0px"></spam>
                    </div>

                    <div style="height: 24px; width:100%">
                        <div
                            style="width:100%; height: 100%; background: url({{ $item->imagenMarca ? asset(Storage::url($item->imagenMarca)) : asset('img/logo2.jpg') }}) no-repeat; background-size: contain;">

                        </div>

                    </div>
                    <div>
                        <p class="nameCategoriaM" style="color:#fff; font-weight: 600; font-size:46px; margin-bottom:0px">
                            {{ $item->name }}</p>
                    </div>

                    <div styl>
                        <a style="color:#fff; text-decoration:none"
                            href="{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}">
                            @if(session('locale') === 'es')
                            Ver Categoría
                            @else
                            View Category
                            @endif
                            
                            
                            
                            <img src="{{ asset(Storage::url('tipo-articulo/arrow_forward.png')) }}"></a>
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
    <!-- Productos Destacados -->
    <div class="d-flex flex-column justify-content-center align-items-center" style="background: #000">
        <div class="col-12 text-center pt-5 mb-3 my-5" style="font-size:32px;font-weight:500; color:#fff">
            @if(session('locale') === 'es')
            Productos destacados
            @else
            Featured Products
            @endif
     
        
        
        </div>
        <div class="responsive_productos col-11 mb-5" data-aos="fade-in" data-aos-duration="800">
            @forelse ($articulos as $producto)
                <div class="d-flex flex-column productoContainer mx-1 justify-content-center align-items-center"
                    onclick="window.location='{{ route('page.producto', $producto) }}'"
                    style="background:#fff; border-radius:8px;text-align:center;">
                    <img src="{{ asset(Storage::url($producto->imagen)) }}" class="img-fluid" style="height:70%">
                    <b
                        style="font-family: Inter;font-size: 16px;font-weight: 700;line-height: 20.8px;text-align: center;">
                        

                        {{ $producto->name }}
                
                    
                    
                    </b>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <!-- Fin Productos destacados -->
    <!-- Barra naranja -->
    <div style="background: #F15E40; height: 216px;" class="barraN pcProductos">
        <div class="row h-100 d-flex justify-content-center align-items-center">
            @foreach ($secciones as $seccion)
                <div class="col d-flex flex-column align-items-center"
                    style="padding:0px; justify-content:center; border-right: 1px solid white; height: 100%;">
                    <a class="d-flex flex-column align-items-center"
                        style="padding:0px; justify-content:center; text-decoration: none !important"
                        href="{{ $seccion->ruta }}" target="_blank">
                        <img src="{{ asset(Storage::url($seccion->imagen)) }}">
                        <span class="textoNaranja" style="color:#fff !important;">
                            
                            @if(session('locale') === 'es')
                            {{ $seccion->titulo }}
                            @else
                            {{ $seccion->tituloEnglish }}
                            @endif
                        
                        
                        </span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <div style="background: #F15E40; height: 216px;" class="barraN mobileProductos">
        <div class="row h-100 d-flex justify-content-start align-items-center">
            @foreach ($secciones as $seccion)
                <div class="col-6 col-md-2 d-flex flex-column align-items-center"
                    style="justify-content:center; border: 1px solid white; height: 100%;">
                    <a class="d-flex flex-column align-items-center cuadradoNaranjaMobile"
                        style="padding:0px; justify-content:center; text-decoration: none !important"
                        href="{{ $seccion->ruta }}" target="_blank">
                        <img src="{{ asset(Storage::url($seccion->imagen)) }}">
                        <span class="textoNaranja" style="color:#fff !important;">    @if(session('locale') === 'es')
                            {{ $seccion->titulo }}
                            @else
                            {{ $seccion->tituloEnglish }}
                            @endif</span>
                    </a>
                </div>
            @endforeach
        </div>
    </div>




    <!-- Fin Barra naranja -->


    <div class="infoP pcContant">
        <div class="row d-flex justify-content-start align-items-center">
            <div class="col-md-6 d-flex align-items-center justify-content-start"
                style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($inicio->imagen)) }}); background-size: cover; height:500px;">

            </div>
            <div class="col-md-6 d-flex flex-column align-items-start justify-content-center text-center contenedorT"
                style="padding-left: 122px">
                <div class="col-md-8 d-flex flex-column align-items-start justify-content-center text-start">
                    <h2 class="inicioinfotitle">    @if(session('locale') === 'es')
                        {{ $inicio->titulo }}
                        @else
                        {{ $inicio->tituloEnglish }}
                        @endif</h2>
                    <p class="inicioinfodescri" style="padding-top: 32px; padding-bottom:32px">    @if(session('locale') === 'es')
                        {{ $inicio->descripcion }}
                        @else
                        {!! $inicio->descripcionEnglish !!}
                        @endif
                    </p>
                    <div class="inicioinfobotton">
                        <a style="text-decoration: none !important; color: #F15E40" href="{{$inicio->botonPrincipalLink}}"
                            target="_blank">
                            <button class="btn  py-1 px-4 registrarse" type="button">

                                @if(session('locale') === 'es')
                                {{$inicio->botonPrincipal}}
                                @else
                                {{$inicio->botonPrincipalEnglish}}

                                @endif                            </button>
                        </a>

                        <a style="text-decoration: none !important;" href="{{$inicio->botonSecundarioLink}}"
                            target="_blank">
                        <button style="margin-left: 20px" class="btn zp_container py-1 px-4 loguearse" type="button">
                            @if(session('locale') === 'es')
                            {{$inicio->botonSecundario}}
                            @else
                            {{$inicio->botonSecundarioEnglish}}
                            @endif  
                        </button>
                    </a>

                    </div>
                </div>
            </div>
        </div>
        <div class="row  d-flex justify-content-center align-items-center infoP" style="height:500px;">
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-start text-start contenedorT">
                <div class="col-md-8 d-flex flex-column align-items-center justify-content-start text-start mb-3 mb-md-0">
                    <h2 class="inicioinfotitle" style="width: 329px;">

                        @if(session('locale') === 'es')
                        {{ $inicio->tituloDos }}
                        @else
                        {{ $inicio->tituloDosEnglish }}
                        @endif



                    </h2>
                    <p class="inicioinfodescri" style="width: 329px; padding-top: 32px; padding-bottom:32px">
                        @if(session('locale') === 'es')
                        {{ $inicio->descripcionDos }}
                        @else
                        {!! $inicio->descripcionDosEnglish !!}
                        @endif
                    
                    
                    
                    </p>
                    <div class="inicioinfobotton" style="width: 329px;">
                        <button class="btn zp_container py-1 px-4 verProductosBotonTwo" type="button"
                            onclick="window.location='{{$inicio->botonPrincipalDosLink}}'">

                            @if(session('locale') === 'es')
                            {{$inicio->botonPrincipalDos}}
                            @else
                            {{$inicio->botonPrincipalDosEnglish}}
                            @endif
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="col-md-6 d-flex align-items-center justify-content-center"style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($inicio->imagenDos)) }}); background-size: cover; height:500px;">

            </div>
        </div>

    </div>

    <div class="infoP mobileContant">
        <div>
            <div class="col-md-6 d-flex align-items-center justify-content-start"
                style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($inicio->imagen)) }}); background-size: cover; height:500px;">

            </div>
            <div class="col-md-6 d-flex flex-column align-items-start justify-content-center text-center contenedorT"
                style="padding-left: 122px">
                <div class="col-md-8 d-flex flex-column align-items-start justify-content-center text-start">
                    <h2 class="inicioinfotitle">@if(session('locale') === 'es')
                        {{ $inicio->titulo }}
                        @else
                        {{ $inicio->tituloEnglish }}
                        @endif</h2>
                    <p class="inicioinfodescri" style="padding-top: 32px; padding-bottom:32px">@if(session('locale') === 'es')
                        {{ $inicio->descripcion }}
                        @else
                        {{ $inicio->descripcionEnglish }}
                        @endif
                    </p>
                    <div class="inicioinfobotton">
                        <a style="text-decoration: none !important; color: #F15E40" href="{{ $inicio->quieroCliente }}"
                            target="_blank">
                            <button class="btn  py-1 px-4 registrarse" type="button">

                                
                                @if(session('locale') === 'es')
                                Registrarme
                                @else
                                Sign up
                                @endif        
                            </button>
                        </a>
                        <button class="btn zp_container py-1 px-4 loguearse" type="button">

                            
                            @if(session('locale') === 'es')
                            Acceso Cliente

                            @else
                            Customer Access                            @endif        
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="infoP" style="height:500px;">
            <div class="col-md-6 d-flex flex-column align-items-center justify-content-start text-start contenedorT">
                <div class="col-md-8 d-flex flex-column align-items-center justify-content-start text-start mb-3 mb-md-0">
                    <h2 class="inicioinfotitle" style="width: 329px;">      @if(session('locale') === 'es')
                        {{ $inicio->tituloDos }}
                        @else
                        {{ $inicio->tituloDosEnglish }}
                        @endif</h2>
                    <p class="inicioinfodescri" style="width: 329px; padding-top: 32px; padding-bottom:32px">
                        @if(session('locale') === 'es')
                        {{ $inicio->descripcionDos }}
                        @else
                        {{ $inicio->descripcionDosEnglish }}
                        @endif</p>
                    <div class="inicioinfobotton" style="width: 329px;">
                        <button class="btn zp_container py-1 px-4 verProductosBotonTwo" type="button"
                            onclick="window.location='{{ route('page.productosCategorias') }}'">

                            @if(session('locale') === 'es')
                            Ver Productos

                            @else
                            See Products                           @endif   
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="col-md-6 d-flex align-items-center justify-content-center"style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($inicio->imagenDos)) }}); background-size: cover; height:500px;">

            </div>
        </div>

    </div>





    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
        aria-hidden="true">
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
                            slidesToShow: 1,
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
                            slidesToShow: 1,
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
                    },

                    // You can unslick at a given breakpoint now by adding:
                    // settings: "unslick"
                    // instead of a settings object
                ]
            });
        });
    </script>
@endsection
