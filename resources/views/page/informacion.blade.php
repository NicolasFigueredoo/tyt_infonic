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
    <a style="text-decoration: none;color:#000;" href="{{route('page.informacionTecnica')}}">Informaci&oacute;n t&eacute;cnica</a>
    </div>

</div>
<div class="d-flex justify-content-center py-5">
    <div class="d-flex flex-row flex-wrap justify-content-between box_container">
        <div class="col-12 d-flex flex-column flex-wrap justify-content-center align-items-center pe-0 pe-md-4">                        
            <div class="w-100 d-flex justify-content-center mb-4" style="position: relative;">                
                <img class="pe-0 pe-md-3 " src="{{asset(Storage::url($informacion->imagen))}}" alt="" width="100%" height="auto">
            </div>
            <div class="d-flex justify-content-start w-100">{{$informacion->created_at->format('d/m/Y')}}</div>
            <div class="mb-3 w-100 text-start" style="font-size:40px;"><b>{{$informacion->name}}</b></div>
            <div  data-aos="fade-up" data-aos-easing="linear"  data-aos-duration="800">
            {!! nl2br($informacion->description) !!}
            </div>
        </div>        
    </div>
</div>
    
@endsection
