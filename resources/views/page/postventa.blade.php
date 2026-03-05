@extends('layouts.plantilla')

@section('metadatos')

<meta name="description" content="{{$metadatos->descripcion}}"/>
<meta name="keywords" content="{{$metadatos->keyword}}"/>
@endsection

@section('content')
<style>
  .btn-ficha{
    color: #fff;
    background-color: #00A651;
    border-color: #00A651;
}
.btn-ficha:hover{
    color: #00A651;
    background-color: white;
    border-color: #00A651;
	
}
</style>
<div class="row justify-content-center align-items-center" style="background:#F5F5F5;height:174px;">
  <p class="box_container pt-5" style="color:#00A651;font-weight:600;font-size:40px;line-height:46.88px">POST VENTA</p>
</div>
<div class="d-flex justify-content-center my-5">
  <div class="box_container d-flex justify-content-start align-items-start flex-wrap">
    <div class="col-12 col-md-6 p-0 ps-md-1" data-aos="fade-right" data-aos-easing="linear" data-aos-duration="800">
      {!!$postventa->texto!!}
    </div>    
  </div>
</div>

<div class="d-flex justify-content-center my-5">
  <div class="box_container d-flex justify-content-center align-items-start flex-wrap">
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-between w-100">
      <div class="col">
        <div class="card">          
          <div class="card-body d-flex justify-content-center align-items-center flex-column">
            <img src="{{asset(Storage::url($postventa->imagen))}}">
            <h5 class="py-5 card-title">{{$postventa->titulo}}</h5>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">          
          <div class="card-body d-flex justify-content-center align-items-center flex-column">
            <img src="{{asset(Storage::url($postventa->imagen2))}}">
            <h5 class="py-5 card-title">{{$postventa->titulo2}}</h5>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card">          
          <div class="card-body d-flex justify-content-center align-items-center flex-column">
            <img src="{{asset(Storage::url($postventa->imagen3))}}">
            <h5 class="py-5 card-title">{{$postventa->titulo3}}</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="d-flex justify-content-center pt-5 mt-5" style="background: #F5F5F5;">
  <div class="box_container d-flex justify-content-center align-items-start flex-wrap">      
    <div class="col-12 col-md-3">
      {!!$postventa->texto2!!}
    </div>
    <div class="col-12 col-md-9">
      <form data-aos="fade-left" data-aos-easing="linear" data-aos-duration="800" method="post" id="form" action="{{route('page.postventapost')}}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 ">
                <input type="text" class="form-control bordercont" id="nombre" name="nombre" required placeholder="Nombre y apellido*">
            </div>
            <div class="col-md-6 ">
                <input type="email" class="form-control bordercont" id="email" name="email" required placeholder="E-Mail*">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-4">
                <input type="text" class="form-control bordercont" id="telefono" name="telefono" required placeholder="Teléfono">
            </div>
            <div class="col-md-6 mt-4">
                <input type="text" class="form-control bordercont" id="empresa" name="empresa" required placeholder="Empresa">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-4">
                <textarea class="form-control bordercont" id="mensaje" name="mensaje" rows="6"  cols="10" placeholder="Mensaje*"></textarea>
            </div>
            <div class="col-md-6 ">
                <div class="form-group ">   
                        {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                    @error('g-recaptcha-response')
                    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                    @enderror
                </div>                             
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center my-4">
            <p class="m-0 pe-4" style="font-size:18px;color:#939598;">* campos obligatorios</p>
            <button type="submit" class="btn btn-ficha font-weight-bold px-5 float-right" style="font-size: 18px;border-radius:0px;">Enviar mensaje
            </button>	
        </div> 
    </form>
    </div>
    
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!--Alertify-->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script>
///ENVIO AJAX
$('#form').on('submit',function(e){
    e.preventDefault();
    data = new FormData();    
    data.append( 'nombre', document.getElementById("nombre").value);
    data.append( 'email', document.getElementById("email").value);
    data.append( 'telefono', document.getElementById("telefono").value);
    data.append( 'empresa', document.getElementById("empresa").value);    
    data.append( 'mensaje', document.getElementById("mensaje").value);   
    data.append( '_token', document.querySelector('[name="_token"]').value);
    $.ajax({           
        url: '{{route('page.postventapost')}}',
        data: data,
        type: "post",
        processData: false,  // tell jQuery not to process the data
        contentType: false,   // tell jQuery not to set contentType      
        success: function (response) {                  
            swal(response,"","success");
        },
        error: function(response){
            console.log(response);
            swal("Algo salió mal","","error");
        }
    });
});
</script>
@endsection