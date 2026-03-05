@extends('layouts.plantilla')



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
            background: #0E7D4A;
            width: 95%;
            height: 82%;
            opacity: 0.4;
            z-index: 99;
            color: #fff;
            position: absolute;
            border-radius: 10px;
        }

        .noveadadDescripcion p {
            width: 100%;
            word-break: break-all;
            height: auto;
        }

        .noveadadDescripcion img {
            display: none !important;
        }

        .box_descripcion>* {
            font-size: 18px !important;
            color: #131313 !important;
            font-weight: 300 !important;
        }
    </style>
    <div class="d-flex justify-content-center align-items-center" style="background:#F5F5F5;height:174px;">
        <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#0E7D4A;text-align: center;">Como comprar</p>
    </div>
    <div class="col-12 mt-4 d-flex flex-row flex-wrap justify-content-center py-5">
        <div class="col-12 d-flex flex-row flex-wrap mb-4 box_container ">
            @forelse ($comoComprar as $item)
                <div class="d-flex flex-column col-md-3 px-4">                    
                    <div style="font-size:32px;font-weight:600;color:#0E7D4A;border-bottom:1px solid #ddd;">{{$item->orden}}</div>
                    <div class="py-3"><b>{{$item->name}}</b></div>
                    <div>{{$item->description}}</div>
                </div>
            @empty
                
            @endforelse
        </div>
    </div>
@endsection
