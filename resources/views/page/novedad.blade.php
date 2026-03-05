@extends('layouts.plantilla')

@section('content')
<style>
    .fondodelcoso{
        background-color: #F2F2F2;
        height: 25px;
    }
</style>
<div class="col-12 py-2 d-flex justify-content-center" style="font-size:14px;color:#000000;">
    <div class="box_container">
    <a style="text-decoration: none;color:#000;" href="{{route('page.inicio')}}">Inicio</a>
    /
    <a style="text-decoration: none;color:#000;" href="{{route('page.novedades')}}">Novedades</a>
    </div>

</div>
<div class="d-flex justify-content-center py-5">
    <div class="d-flex flex-row flex-wrap justify-content-between box_container">
        <div class="col-12 d-flex flex-column flex-wrap justify-content-center align-items-center pe-0 pe-md-4">                        
            <div class="w-100 d-flex justify-content-center mb-4" style="position: relative;">
                <div class="w-100 d-flex justify-content-center" style="background-image:url({{asset(Storage::url($novedad->imagen))}});filter: blur(10px);">
                    <img class="pe-0 pe-md-3 "  src="{{asset(Storage::url($novedad->imagen))}}" alt="" width="50%" height="auto">                
                </div>
                <img class="pe-0 pe-md-3 " src="{{asset(Storage::url($novedad->imagen))}}" alt="" width="50%" height="auto" style="position: absolute;">
            </div>
            <div class="d-flex justify-content-start w-100">{{$novedad->created_at->format('d/m/Y')}}</div>
            <div class="mb-3 w-100 text-start" style="font-size:40px;"><b>{{$novedad->name}}</b></div>
            <div  data-aos="fade-up" data-aos-easing="linear"  data-aos-duration="800">
            {!! $novedad->texto!!}
            </div>
        </div>        
    </div>
</div>
    
@endsection
