@extends('layouts.newplantilla')



@section('metadatos')

    <meta name="description" content="{{ $metadatos->descripcion }}" />

    <meta name="keywords" content="{{ $metadatos->keyword }}" />

@endsection

@section('content')

    <style>



       

        .imgLogoP{



            width: 80%;

            height: 100%;

        }



        .accordion-button{

            background: none !important;

            box-shadow: none !important;

            border-radius: 0px !important;

            padding-left: 0px !important

        }

        .accordion-button-two{

            border: none;

            background: none !important;

            box-shadow: none !important;

            border-radius: 0px !important;

            padding-left: 0px !important;

            font-size: 1rem;

            font-family: 'Inter';

            cursor: context-menu !important;

        }

        .accordion-collapse div{

            padding-left: 0px !important;

            



        }

        

        .accordion-collapse div a {

            color: var(--Grey-01, #686666);

font-family: Inter;

font-size: 14px;

font-style: normal;

font-weight: 400;

line-height: 130%; /* 18.2px */

        }

        .fondodelcoso {

            background-color: #F2F2F2;

            height: 25px;

        }

        .filtrarPor{

            color: #131313;

font-family: Inter;

font-size: 18px;

font-style: normal;

font-weight: 600;

line-height: 130%; /* 23.4px */

}

.casillaF{

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

            border-bottom: 1px solid #E0E0E0

        }

        .accordion-item a{

            color: var(--Neutro-100, #161414);



/* p */

font-family: Inter;

font-size: 14px;

font-style: normal;

font-weight: 500;

line-height: 20px; /* 142.857% */

padding-left: 0px !important

        }



        .col-md-4-adjusted {

            width: calc(33.3333% - 16px); /* Ajusta el ancho restando 5px */            

        }



        @media (max-width: 1000px) {

            .img-fluid-two{

                height: auto;

                width: 100%;

            }

        }

        @media (max-width: 768px) {

            .col-md-4-adjusted {

                width: 95%;

            }             

        }

        .slick-arrow{

            display:none;

        }

    </style>



    <!-- Categorias -->

    <div class="d-flex justify-content-center">

        <div class="d-flex flex-row justify-content-start align-items-center align-items-md-start flex-wrap box_container py-5">

            @forelse ($categoriasprin as $item)

            <div id="boxProducto"

                    class="col-12 col-md-4 col-md-4-adjusted d-flex flex-column justify-content-end align-items-center align-items-md-start m-2 g-2 p-4 "

                    style="position: relative; text-transform: uppercase;

                    border-radius: 0px; background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ $item->imagen ? asset(Storage::url($item->imagen)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: cover;

                    height: 180px; border-radius: 10px"

                    data-aos="zoom-in">

                <div>

                    <spam  style="color:#fff; font-weight: 600; font-size:16px; margin-bottom:0px"></spam>

                </div>

       

                <div style="height: 24px; width:50%">

                    <div style="width:100%; height: 100%; background: url({{ $item->imagenMarca ? asset(Storage::url($item->imagenMarca)) : asset('img/logo2.jpg') }}) no-repeat center center; background-size: contain;">



                    </div>



                </div>

                <div>

                    <p style="color:#fff; font-weight: 600; font-size:46px; margin-bottom:0px">{{ $item->name }}</p>

                </div>

                <div styl>

                    <a style="color:#fff; text-decoration:none" href="{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}">Ver Categoría <img src="{{ asset(Storage::url('tipo-articulo/arrow_forward.png')) }}"></a>

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







    

        <div class="container col-12 py-2" style="font-size:16px;color:#8A8A8A;">

            <a style="text-decoration: none !important; color: #8A8A8A" href="{{ route('page.inicio') }}"> Inicio </a>

            /

            <a style="text-decoration: none;color:#8A8A8A;" href="{{ route('page.productosCategorias') }}">Productos</a> 

            / Resultados de busqueda por "{{ $search }}"

        </div>   



    

  <div class="container d-flex flex-md-row flex-wrap px-4 py-4" style="margin-bottom: 200px;">
    <div class="col-12 col-lg-9">
        <div class="row">
            @forelse ($productos as $producto)            
                @if ($producto)
                    <div class="col-lg-4 d-flex flex-column productoContainer" onclick="window.location='{{ route('page.producto', $producto) }}'">   
                        @isset($producto->imagen)
                            <img src="{{ asset(Storage::url($producto->imagen)) }}" class="img-fluid-two">
                        @else
                            <img src="{{ asset('images/logo.png') }}" class="img-fluid-two imgLogoP">
                        @endisset
                        <b style="justify-content: center;align-items: center;display: flex;">{{ $producto->name }}</b>                    
                    </div>
                @endif
            @empty
                <div class="col-12">
                    <p class="text-center">No se encontraron productos para la búsqueda "{{ $search }}"</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection





