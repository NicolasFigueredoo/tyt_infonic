@extends('layouts.plantilla')



@section('metadatos')

    <meta name="description" content="{{ $metadatos->descripcion }}" />

    <meta name="keywords" content="{{ $metadatos->keyword }}" />

@endsection

@section('content')

    <style>

        .fondodelcoso {

            background-color: #F2F2F2;

            height: 25px;

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

            border: unset;

        }

    </style>



    <div class="col-12 ps-4 py-2" style="font-size:14px;color:#000000;">

        <a style="text-decoration: none;" href="{{ route('page.inicio') }}"><i class="fas fa-home text-white"></i></a>



        <a style="text-decoration: none;color:#000;" href="{{ route('page.productosCategorias') }}">Catalogo</a> /



    </div>    

    <div class="d-flex flex-column-reverse flex-md-row flex-wrap px-4 py-4">



        <div class="col-12 col-md-3 pe-0 pe-md-4">

            <form method="POST" style="position: relative" class="d-flex justify-content-end align-items-center mb-4"  action="{{route('page.productosSearch')}}">

                @csrf

                <!-- <input class="form-control w-100" list="articulosC" placeholder="Buscar" style="height: 40px;border-radius: 10px;">

                <datalist id="articulosC">

                    @forelse ($articulosList as $art)

                        <option value="{{$art->name}}">{{$art->name}}</option>

                        <option value="{{$art->code}}">{{$art->code}}</option>

                    @empty

                        

                    @endforelse

                </datalist> -->

                <button id="search"

                    class="h-100 d-flex justify-content-center align-items-center"

                    style="cursor: pointer;border-radius: 0px 10px 10px 0px;background: #ddd;position: absolute"

                    class="px-2">

                    <img class="mx-3" src="{{ asset('images/search.svg') }}" width="24px" height="24px">

                </button>

            </form>



            <div class="sidebar py-3">

                <div class="accordion px-3" id="accordionExample">

                    <div class="py-4 px-3" style="font-size:16px;color:#848484;">CATEGOR&Iacute;A</div>

                    @forelse ($categorias as $item)

                        <div class="accordion-item" style="text-transform:uppercase;">

                            <a href="{{ route('page.productos', ['id' => $item->id, 'productosVisible' => 0]) }}" class="btn"

                                style="margin:unset;font-size:13px;text-align: start;font-weight:600">{{ $item->name }}</a>

                        </div>

                    @empty

                    @endforelse

                </div>



            </div>

        </div>

        

        <div class="col-12 col-md-9 d-flex flex-row justify-content-start align-items-start flex-wrap table-responsive">            

            @if ($productos)

            @forelse ($productos as $producto)            

                    <div class="d-flex flex-column productoContainer" onclick="window.location='{{ route('page.producto', $producto) }}'">                        

                        <img src="{{ asset(Storage::url($producto->imagen)) }}" class="img-fluid">

                        <b>{{ $producto->name }}</b>                    

                        {{ @$producto->ObtenerCategoria()->name}}                        

                    </div>

                @empty

                @endforelse

            @endif

        </div>

    </div>

@endsection

