@extends('layouts.plantilla')
@section('metadatos')

<meta name="description" content="{{$metadatos->descripcion}}"/>
<meta name="keywords" content="{{$metadatos->keyword}}"/>
@endsection


@section('content')
<style>
.accordion-button.collapsed {
    background: transparent;
}
.box_hover{    
    position: relative;
}
/* .box_hover:hover img{
  -webkit-transform: scale(1.05);
    transform: scale(1.05);
    transition: all 0.5s ease 0.2s;
    position: relative;
    z-index: 100;
} */
.accordion-button:not(.collapsed){
  color:#00A651;
  background: #fff;
}

.box_hover:hover:before{
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
.box_description > *{
    color:#717171!important;font-size:18px!important;
}
</style>

<div class="col-12 ps-4 py-2 d-flex justify-content-center" style="font-size:14px;color:#000000;">
    <div class="box_container">
        <a style="text-decoration: none;color:#000;" href="{{route('page.inicio')}}">Inicio</a>
        /
        <a style="text-decoration: none;color:#000;" href="{{route('page.productosCategorias')}}">Productos</a>
        /
        <a style="text-decoration: none;color:#000;text-transform: uppercase;" href="#">{{$categoria->nombre}}</a>
    </div>
</div>
<div class="d-flex justify-content-center">
<div class="d-flex flex-row flex-wrap px-4 py-4 box_container">
<div class="d-flex flex-row flex-wrap justify-content-start align-items-start col-12" style="height: fit-content;">    
      @forelse ($categoria->obtenerProducto() as $item)
      <div class="col-12 col-md-3 d-fex flex-column justify-content-center align-items-center align-items-md-start mb-5" style="position: relative;text-transform:uppercase;"  data-aos="zoom-in" >
        <div class="d-flex flex-column justify-content-start align-items-center" style="width:240px !important;cursor:pointer;border-radius:0px;">
          <div class="productoContainer d-flex justify-content-center align-items-center equiposContainer box_hover" style="border:1px solid #ccc;border-radius:0px;max-width: -webkit-fill-available;" onclick="window.location='{{route('page.producto',$item)}}'">
            @if ($item->imagen)
            <img src="{{asset(Storage::url($item->imagen))}}" style="height: inherit;max-width: -webkit-fill-available;border-radius: 0px;">
            @else
            <img src="{{asset('img/logo2.jpg')}}" style="max-width: -webkit-fill-available;">
            @endif
          </div>
          <div class="d-flex flex-row flex-wrap align-items-start w-100">
            <div class="col-12 py-2" style="text-align:start;font-size:20px;font-weight:400;color:#000;margin:unset;word-break: break-word;overflow: hidden;">{{$item->nombre}}</div>
          </div>              
        </div>
      </div>         
      @empty
        <div class="col-12 px-2">
          <span>No se encontraron productos.</span>
        </div>          
      @endforelse
</div>
{{-- @if($producto->links() !== null)
<div class="w-100 d-flex justify-content-center">
    {!! $producto->links() !!}
</div>
@endif --}}
</div>
</div>
@endsection