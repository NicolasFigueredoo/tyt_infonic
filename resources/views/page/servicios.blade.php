@extends('layouts.plantilla')

@section('metadatos')

<meta name="description" content="{{$metadatos->descripcion}}"/>
<meta name="keywords" content="{{$metadatos->keyword}}"/>
@endsection

@section('content')
<div class="row justify-content-center align-items-center" style="background:#F5F5F5;height:174px;">
  <p class="box_container pt-5" style="color:#00A651;font-weight:600;font-size:40px;line-height:46.88px">SERVICIOS</p>
</div>
<div class="row m-0 justify-content-center">.
  @forelse ($servicios as $item)
    @if (($loop->iteration  % 2) == 0)
      <div class="box_container d-flex justify-content-between flex-wrap mb-5">
        <div data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800" class="col-12 col-md-6 d-flex flex-column justify-content-center pe-0 pe-md-5">
          <p style="color:#00A651;font-size:26px;">{{$item->nombre}}</p><br>
          {!!$item->descripcion!!}
        </div>
        <img data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800" src="{{asset(Storage::url($item->imagen))}}" class="col-12 col-md-6">
      </div>  
    @else
      <div class="box_container d-flex justify-content-between flex-wrap mt-5 mb-5">
        <img data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800" src="{{asset(Storage::url($item->imagen))}}" class="col-12 col-md-6">
        <div data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800" class="col-12 col-md-6 d-flex flex-column justify-content-center ps-0 ps-md-5">
          <p style="color:#00A651;font-size:26px;">{{$item->nombre}}</p><br>
          {!!$item->descripcion !!}
        </div>
      </div>      
    @endif
  @empty
    
  @endforelse

  
</div>


@endsection