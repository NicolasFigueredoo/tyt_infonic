@section('style')
<style>


.mobileProductos{
display: none !important
}
.contenedorIconos{
        height: 64px !important;
    }
@media (max-width: 400px) {
    .contenedorIconos{
        height: 40px !important;
    }
}
@media (max-width: 1000px) {
    .fotterM{
            width: 100% !important
        }
        .fotterM div{
            width: 100% !important

        }
        .pcProductos{
            display: none !important
        }
        .mobileProductos{
            display: flex !important
        }

}
</style>
@endsection


<div class="container-fluid d-flex justify-content-center flex-column align-items-center footerDiv" style="background: linear-gradient(0deg, #161414 1.96%, rgba(22, 20, 20, 0) 95.28%), url({{ asset(Storage::url($inicio->imagenFooter)) }}); height:678px; background-size: cover; background-position: center;">
    <div class="row d-flex justify-content-center botonesIg" style="margin-bottom:100px">
        <div class="d-flex justify-content-center flex-wrap gap-4" style="color:#Fff;">
            @foreach ($redes as $r)
                <div class="d-flex align-items-center justify-content-center contenedorIconos" >
                    <a href="{{ $r->link }}" target="_blank" style="color:transparent;">
                        <img src="{{ asset(Storage::url($r->imagen)) }}" alt="Red social" class="img-fluid" style="max-height: 64px;">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="d-flex flex-row justify-content-center align-items-center fotterM" >
        <div class="d-flex flex-row justify-content-center align-items-start flex-wrap box_container">
            <div class="col-12 col-md-2 d-flex align-items-start">
                <img src="{{ asset(Storage::url($logosfooter->image )) }}" class="img-fluid " style="margin: 0; padding: 0;">
            </div>
            <div class="col-12 col-md-1 contMobile">
                <span style="color:#F15E40; font-weight:600; font-size:16px;line-height: 16.94px;"> 

                    @if(session('locale') === 'es')
                    Categorías
                    @else
                    categories                           @endif   
                    
                </span>
                <div class="d-flex d-flex align-items-start" style="padding-top: 27px;">
                    <div class="col-6 pcProductos">
                        <!--<a href="{{ route('page.inicio') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Home</a><br>-->
                        <a href="{{ route('page.productos', ['id' => 36, 'productosVisible' => 0]) }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">
                            
                            @if(session('locale') === 'es')
                            Hogar
                            @else
                            Home                           @endif 
                        
                        </a><br>
                        <a href="{{ route('page.productos', ['id' => 37, 'productosVisible' => 0]) }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Detail</a><br>
                        <a href="{{ route('page.productos', ['id' => 38, 'productosVisible' => 0]) }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Automotor</a><br>
                    </div>

                    <div class="col-12 d-flex gap-3 mobileProductos">
                        <!--<a href="{{ route('page.inicio') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Home</a><br>-->
                        <a href="{{ route('page.productos', ['id' => 36, 'productosVisible' => 0]) }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">
                            @if(session('locale') === 'es')
                            Hogar
                            @else
                            Home                           @endif     
                        </a><br>
                        <a href="{{ route('page.productos', ['id' => 37, 'productosVisible' => 0]) }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Detail</a><br>
                        <a href="{{ route('page.productos', ['id' => 38, 'productosVisible' => 0]) }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Automotor</a><br>
                    </div>
          
                </div>
            </div>

            <div class="col-12 col-md-3 contMobile">
                <span style="color:#F15E40; font-weight:600; font-size:16px;line-height: 16.94px;">
                    @if(session('locale') === 'es')
                    Secciones
                    @else
                    Sections 
                    @endif 
                    </span>
                <div class="d-flex d-flex align-items-start" style="padding-top: 27px;">
                    <div class="col-6 pcProductos">
                        {{-- <!--<a href="{{ route('page.inicio') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Home</a><br>--> --}}
                        <a href="{{ route('page.empresa') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">
                            @if(session('locale') === 'es')
                            Quienes somos
                            @else
                            Who we are 
                            @endif
                           </a><br>
                        <a href="{{ route('page.productosCategorias') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">
                            @if(session('locale') === 'es')
                            Productos
                            @else
                            Products
                            @endif</a><br>
                        <a href="{{ route('page.contacto') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">
                            @if(session('locale') === 'es')
                            Contacto
                            @else
                            Contact
                            @endif</a><br>
                    </div>

                    <div class="col-12 d-flex gap-2 mobileProductos">
                        {{-- <!--<a href="{{ route('page.inicio') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">Home</a><br>--> --}}
                        <a href="{{ route('page.empresa') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">       @if(session('locale') === 'es')
                            Quienes somos
                            @else
                            Who we are 
                            @endif</a><br>
                        <a href="{{ route('page.productosCategorias') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;"> @if(session('locale') === 'es')
                            Productos
                            @else
                            Products
                            @endif</a><br>
                        <a href="{{ route('page.contacto') }}" style="color:#fff; text-decoration:none; font-size:16px;line-height: 35px;">  @if(session('locale') === 'es')
                            Contacto
                            @else
                            Contact
                            @endif</a><br>
                    </div>
          
                </div>
            </div>
            @foreach ($contactos as $contacto)
            <div class="col-12 col-md-3 contMobile">
                <span style="color:#F15E40; font-weight:600; font-size:14px">
                    @if(session('locale') === 'es')
                    {{ $contacto->name }}
                    @else
                    {{ $contacto->nameEnglish }}
                    @endif
                   </span>
                <div class="row justify-content-start" style="padding-top: 27px">
                    <div class="col-xl-1 col-lg-1 col-md-2 col-sm-1 col-2 my-2 iconosF">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="18" viewBox="0 0 15 18" fill="none">
                            <path d="M7.07144 0C5.19666 0.00221173 3.3993 0.747945 2.07362 2.07362C0.747953 3.39929 0.00221925 5.19665 7.52328e-06 7.07143C-0.00223791 8.6035 0.498209 10.094 1.42458 11.3143C1.42458 11.3143 1.61744 11.5682 1.64894 11.6049L7.07144 18L12.4965 11.6016C12.5248 11.5676 12.7183 11.3143 12.7183 11.3143L12.7189 11.3124C13.6448 10.0926 14.1451 8.6028 14.1429 7.07143C14.1407 5.19665 13.3949 3.39929 12.0693 2.07362C10.7436 0.747945 8.94622 0.00221173 7.07144 0ZM7.07144 9.64286C6.56286 9.64286 6.0657 9.49205 5.64283 9.20949C5.21996 8.92694 4.89037 8.52534 4.69575 8.05547C4.50112 7.5856 4.4502 7.06858 4.54942 6.56977C4.64864 6.07096 4.89354 5.61277 5.25316 5.25315C5.61278 4.89353 6.07097 4.64863 6.56978 4.54941C7.06858 4.45019 7.58561 4.50111 8.05548 4.69574C8.52535 4.89036 8.92695 5.21995 9.2095 5.64282C9.49205 6.06569 9.64287 6.56285 9.64287 7.07143C9.64202 7.75315 9.37082 8.40671 8.88877 8.88876C8.40672 9.37082 7.75316 9.64201 7.07144 9.64286Z" fill="#F15E40"/>
                          </svg>                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-11 col-10 my-2 justify-content-start" style="text-align:justify">
                        <a class="link"
                        href="https://www.google.com/maps?q={{ urlencode($contacto->direccion) }}"
                        target="_blank"
                        style="color:#fff;">
                        {{ $contacto->direccion }}
                        </a>
                    </div>
                </div>
                <div class="row justify-content-start">
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2 iconosF">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                            <path d="M13.8857 0H1.54286C0.694286 0 0.00771428 0.675 0.00771428 1.5L0 10.5C0 11.325 0.694286 12 1.54286 12H13.8857C14.7343 12 15.4286 11.325 15.4286 10.5V1.5C15.4286 0.675 14.7343 0 13.8857 0ZM13.5771 3.1875L8.12314 6.5025C7.87628 6.6525 7.55229 6.6525 7.30543 6.5025L1.85143 3.1875C1.77408 3.14528 1.70634 3.08825 1.65231 3.01984C1.59829 2.95143 1.55911 2.87308 1.53713 2.78953C1.51515 2.70597 1.51084 2.61895 1.52446 2.53373C1.53808 2.44851 1.56934 2.36686 1.61636 2.29373C1.66337 2.22059 1.72516 2.15749 1.79799 2.10825C1.87081 2.059 1.95316 2.02463 2.04004 2.00722C2.12692 1.98981 2.21653 1.98972 2.30345 2.00696C2.39037 2.0242 2.47279 2.0584 2.54571 2.1075L7.71429 5.25L12.8829 2.1075C12.9558 2.0584 13.0382 2.0242 13.1251 2.00696C13.212 1.98972 13.3017 1.98981 13.3885 2.00722C13.4754 2.02463 13.5578 2.059 13.6306 2.10825C13.7034 2.15749 13.7652 2.22059 13.8122 2.29373C13.8592 2.36686 13.8905 2.44851 13.9041 2.53373C13.9177 2.61895 13.9134 2.70597 13.8914 2.78953C13.8695 2.87308 13.8303 2.95143 13.7763 3.01984C13.7222 3.08825 13.6545 3.14528 13.5771 3.1875Z" fill="#F15E40"/>
                          </svg>                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-10 my-2" style="text-align:justify">
                        <a class="link" href="mailto:{{ $contacto->email }}" style="color:#fff;">
                            {{ $contacto->email }}</a>
                    </div>
                </div>
                <div class="row justify-content-start">
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2 iconosF">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M3.11025 6.69487C4.35603 9.13102 6.33773 11.1127 8.77387 12.3585L10.6645 10.4679C10.7768 10.3554 10.9183 10.2765 11.0731 10.24C11.2278 10.2036 11.3897 10.2111 11.5404 10.2616C12.5304 10.5868 13.5659 10.7521 14.608 10.7511C14.8357 10.7519 15.0539 10.8426 15.2149 11.0036C15.3759 11.1646 15.4666 11.3828 15.4674 11.6105V14.6094C15.4666 14.8371 15.3759 15.0552 15.2149 15.2162C15.0539 15.3773 14.8357 15.468 14.608 15.4688C12.6895 15.4688 10.7899 15.0909 9.01744 14.3567C7.24503 13.6224 5.63459 12.5463 4.2781 11.1897C2.9216 9.83306 1.84561 8.22252 1.11157 6.45004C0.377533 4.67755 -0.000180514 2.77784 6.47179e-08 0.859375C0.000725221 0.631678 0.0914992 0.413513 0.252506 0.252506C0.413514 0.0914992 0.631678 0.000725156 0.859375 0H3.86788C4.09557 0.000725156 4.31374 0.0914992 4.47474 0.252506C4.63575 0.413513 4.72653 0.631678 4.72725 0.859375C4.72564 1.90149 4.8909 2.93714 5.21675 3.927C5.26561 4.07876 5.27142 4.24109 5.23356 4.39596C5.19569 4.55082 5.11562 4.69216 5.00225 4.80425L3.11025 6.69487Z" fill="#F15E40"/>
                          </svg>                    </div>
                    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-11 col-10  my-2 pe-5" style="text-align:justify">
                        <a class="link" href="tel:{{ $contacto->telefono }}" style="color:#fff;">
                            {{ $contacto->telefono }}</a>
                    </div>
                </div>
                {{-- @isset($contacto->wsp)
                <div class="row justify-content-start">
                    <div class="col-xl-1 col-lg-1 col-md-1 col-sm-1 col-2 my-2">
                        <i style="color:#Fff;" class="fab fa-whatsapp fa-lg"></i>
                    </div>
                    <div class="col-xl-0 col-lg-10 col-md-10 col-sm-11 col-10 my-2" style="text-align:justify">
                        <a class="link" href="tel:{{ $contacto->wsp }}" style="color:#fff">
                            {{ $contacto->wsp }}</a>
                    </div>
                </div>
                @endisset --}}
            </div>
            @endforeach
        </div>
    </div>
    <div class="row d-flex flex-row justify-content-center">
    </div>
</div>
<div class="container-fluid d-flex flex-row justify-content-center align-items-center flex-wrap py-1"
        style="background:#000;color:#fff;font-size:14px;height: 60px;}">
        <div class="d-flex flex-row justify-content-between align-items-center flex-wrap box_container">
            @if(session('locale') === 'es')
            <p class="p-0 m-0">Todos los derechos reservados por TYT S.A 2025</p>
            @else
            <p class="p-0 m-0">All rights reserved by TYT S.A 2025</p>
            @endif
            <!--<a target="_blank" href="https://nicolasfigueredo.vercel.app/" style="text-decoration: none;color:#fff;">By Nicolas Figueredo</a>-->
        </div>
</div>
@section('js')

    <script>        
// Al cargar la página, se revisa si el carrito fue abandonado

        $('.iconBuscar').click(function() {
            $('#search').toggle('ocultar_')
        });
    </script>
@endsection
