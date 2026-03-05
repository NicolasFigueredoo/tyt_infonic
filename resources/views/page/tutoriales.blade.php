@extends('layouts.plantilla')

@section('content')
<style>
    iframe{
        min-height: 200px;
    }
    .fondodelcoso{
        background-color: #F2F2F2;
        height: 25px;
    }
    .box_hover:hover:before{
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
    .noveadadDescripcion p{
        width: 100%;
        word-break: break-all;
        height: auto;
    }
    .noveadadDescripcion img{
        display: none!important;
    }
    .box_descripcion>*{
        font-size: 18px!important;
        color:#131313!important;
        font-weight: 300!important;
    }
</style>
<div class="row justify-content-center align-items-center" style="background:#F5F5F5;height:174px;">
    <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#000;text-align: start;">TUTORIALES</p>
</div>
<div class="col-12 mt-4 d-flex flex-row flex-wrap justify-content-center">
    <div class="col-12 d-flex flex-row flex-wrap mb-4 box_container">
        <div class="row row-cols-1 row-cols-md-3 g-4 w-100">
            @forelse ($tutoriales as $item)            
                <div class="col mb-4">
                    <div class="card" style="border:none;">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $item->codigo() }}" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">No hay tutoriales disponibles</div>
            @endforelse
        </div>
    </div>
    @if($tutoriales->links() !== null)
        <div class="w-100 d-flex justify-content-center">
            {!! $tutoriales->links() !!}
        </div>
    @endif
</div>
@endsection
  