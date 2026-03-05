@extends('layouts.plantilla')

@section('metadatos')

<meta name="description" content="{{$metadatos->descripcion}}"/>
<meta name="keywords" content="{{$metadatos->keyword}}"/>
@endsection

@section('content')
<div class="row justify-content-center align-items-center m-0" style="background:#006FA9;height:174px;">
  <p class="box_container pt-5" style="color:#fff;font-weight:600;font-size:40px;line-height:46.88px">EMPRESAS QUE CONFIAN EN NOSOTROS</p>
</div>
<div class="d-flex justify-content-center my-5">
  <div class="box_container d-flex justify-content-start align-items-start flex-wrap">
    @forelse ($clientes as $item)
      <div class="col-6 col-md-3 p-0 p-md-2" data-aos="zoom-in">
        <img src="{{asset(Storage::url($item->imagen))}}" class="d-block w-100" alt="...">      
      </div>      
    @empty
      
    @endforelse
  </div>
</div>
@endsection