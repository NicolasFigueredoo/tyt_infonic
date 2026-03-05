<style>
    .letraenlace {
        color: #000;
    }
</style>
@isset($contactos[0]->celular)
    <div class="logo_wsp d-flex flex-column justify-content-center align-items-center"
        style="width:75px;height:75px;background:#0DC143;border-radius: 40px;position: fixed;top: 84%;right: 20px;;z-index:3;">
        <a style="width: 50%;height: 50%;" target="_blank"
            href="https://wa.me/{{ str_replace(['+', ' ', '(', ')', '-'], '', $contactos[0]->celular) }}">
            <img width="100%" src="{{ asset('img/logo_wsp.svg') }}">
        </a>
    </div>
@endisset
<div style="background:#F5F5F5;min-height:280px;box-shadow: 0px 3px 23px rgb(0 0 0 / 10%);position:relative;overflow-x: hidden;"
    class="d-flex justify-content-center align-items-start">
    <div class="container-fluid p-3 d-flex justify-content-center">
        <div class="row justify-content-between box_container flex-wrap">
            <div class="col-3 d-flex flex-column justify-content-between align-items-center my-3" style="position: relative;">
                <img src="{{ asset(Storage::url($logosfooter->image)) }}" width="auto" height="137px">
                <div style="position: relative;">
                    <div class="d-none flex-column justify-content-start w-100">
                        <span class="pt-4" style="color:#F15E40;">Redes sociales</span>
                        <div class="d-flex flex-row align-items-start">
                            @foreach ($redes as $r)
                                @isset($r->facebook)
                                    <div style="height: 48px;" class="d-flex align-items-center">
                                        <a href="{{ $r->facebook }}" target="_blank" style="color:transparent;">
                                            <i class="px-3 icono fab fa-facebook-f text-white"></i>
                                        </a>
                                    </div>
                                @endisset
                                @isset($r->instagram)
                                    <div style="height: 48px;" class="d-flex align-items-center">
                                        <a href="{{ $r->instagram }}" target="_blank" style="color:transparent!important;">
    
                                            <i class="px-3 icono fab fa-instagram text-white"></i>
    
                                        </a>
                                    </div>
                                @endisset
                                @isset($r->youtube)
                                    <div style="height: 48px;" class="d-flex align-items-center">
                                        <a href="{{ $r->youtube }}" target="_blank">
    
                                            <i class="px-3 icono fab fa-youtube text-white"></i>
    
                                        </a>
                                    </div>
                                @endisset
                                @isset($r->twitter)
                                    <div style="height: 48px;" class="d-flex align-items-center">
                                        <a href="{{ $r->twitter }}" target="_blank">
    
                                            <i class="px-3 icono fab fa-twitter text-white"></i>
                                        </a>
                                    </div>
                                @endisset
                                @isset($r->youtube)
                                    <div style="height: 48px;" class="d-flex align-items-center">
                                        <a href="{{ $r->youtube }}" target="_blank">
    
                                            <i class="px-3 icono fab fa-youtube-f text-white"></i>
                                        </a>
                                    </div>
                                @endisset
                            @endforeach
    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4" style="position: relative">
                <span class="letra  " style="font-size:16px;color:#F15E40;font-weight:700;">Secciones</span>
                <div class="d-flex justify-content-start flex-wrap">
                    <div class="col me-4">
                        <a href="{{ route('page.inicio') }}" class="letraenlace">Inicio</a><br>
                        <a href="{{ route('page.productosCategorias') }}" class="letraenlace">Cat&aacute;logo</a><br>                        
                        <a href="{{ route('page.contacto') }}" class="letraenlace">Contacto</a><br>
                    </div>
                    <div class="col">
                        <a href="{{ route('page.empresa') }}" class="letraenlace">Nosotros</a><br>                        
                        <a href="{{ route('page.tutoriales') }}" class="letraenlace">Tutoriales</a><br>
                    </div>
                </div>
            </div>


            <div class="col-md-4 pt-3 mt-2" style="position: relative;">
                <div class="letra " style="font-size:16px;color:#F15E40;font-weight:700;">Datos Contacto</div>
                <div class="row pt-2">
                    <div class="col-md-12 ">                        
                        @foreach ($contactos as $c)
                            <div class="d-flex mt-3">
                                <i class="fas fa-map-marker-alt fa-lg me-3" style="color: #F15E40"></i>
                                <a href="https://www.google.com/maps?q={{$contactos[0]->direccionMap()}}" target="_blank"
                                    class="letraenlace ml-3">{{ $c->direccion }}</a>
                            </div>
                            <div class="d-flex mt-3">
                                @isset($c->email)
                                    <i class="fas fa-envelope fa-lg me-3" style="color:#F15E40"></i>
                                    <a href="mailto:{{ $c->email }}" class="letraenlace ml-3">{{ $c->email }}</a>
                                @endisset
                            </div>
                            <div class="d-flex mt-3">
                                <i class="fas fa-phone-alt fa-lg me-3" style="color: #F15E40"></i>
                                <a href="tel:{{ $c->telefono }}" class="letraenlace ml-3">{{ $c->telefono }}</a>
                            </div>
                            @isset($c->celular)
                                <div class="d-flex mt-3">
                                    <i class="fab fa-whatsapp fa-lg me-3" style="color: #F15E40"></i>
                                    <a href="tel:{{ $c->celular }}" class="letraenlace ml-3">{{ $c->celular }}</a>
                                </div>
                            @endisset
                        @endforeach

                    </div>
                </div>
            </div>

        </div>


    </div>
</div>

<div class="d-flex flex-row justify-content-between align-items-center flex-wrap px-1 px-md-5 py-1"
    style="background:#D1D1D1;color:#000;font-size:14px;height: 60px;">
    <p class="p-0 m-0">Todos los derechos reservados por EUMA S.A.U.</p>
    <a target="_blank" href="https://osole.com.ar/" style="text-decoration: none;color:#000;">By OSOLE</a>
</div>
@section('js')
    <script>        

        $('.iconBuscar').click(function() {
            $('#search').toggle('ocultar_')
        });
    </script>
@endsection
