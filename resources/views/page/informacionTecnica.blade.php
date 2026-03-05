@extends('layouts.plantilla')



@section('content')
<style>
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
    <div class="d-flex justify-content-center align-items-center" style="background:#F5F5F5;height:174px;">
        <p class="box_container pt-5" style="font-weight:600;font-size:32px;line-height:46.88px;color:#0E7D4A;text-align: center;">Informaci&oacute;n t&eacute;cnica</p>
    </div>
<div class="col-12 mt-4 d-flex flex-row flex-wrap justify-content-center">
    <div class="col-12 d-flex flex-row flex-wrap mb-4 box_container" >
<div class="row row-cols-1 row-cols-md-3 g-4 w-100">
    @forelse ($informacionTecnica as $item)
      <div class="col">
        <div class="card" style="border:none;">
         <div data-aos="zoom-in" class="boxNovedad d-flex flex-column justify-content-start align-items-center mb-4" onclick="window.location='{{route('page.informacion',$item->id)}}'" style="cursor: pointer;">
          <img src="{{asset(Storage::url($item->imagen))}}" style="border:1px solid #ddd;">
          <div class="p-4 d-flex flex-column justify-content-between align-items-start" style="border:1px solid #ddd;height: -webkit-fill-available;height:147px;">
              @isset($item->tipo)
                  <div style="font-size:16px;color:#0E7D4A;"><b>{{$item->tipo->name}}</b></div>
              @endisset
              <p style="font-size: 22px;"><b>{{$item->name}}</b></p>
              <div class="box_descripcion" style="height:50px;overflow: hidden;"><b>{{$item->short}}</b></div>              
          </div>
      </div>
        </div>
      </div>
    @empty

    @endforelse
    </div>
</div>
@if($informacionTecnica->links() !== null)
<div class="w-100 d-flex justify-content-center">
    {!! $informacionTecnica->links() !!}
</div>
@endif
</div>
@endsection