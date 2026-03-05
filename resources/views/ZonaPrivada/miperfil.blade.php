@extends('layouts.newplantilla')

@section('content')
<style>
    label {
        font-weight: 600;
        color: #F15E40;
        margin-bottom: 5px;
    }
    input {
        margin-bottom: 10px;
    }
</style>
    <div class="d-flex justify-content-center py-5">
        <form class="box_container" method="post" action="{{ route('page.update.cliente') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="form-group col-12">
                    <label for="username">Razon social</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="{{ $user->razonSocial }}" required disabled>
                </div>
                <div >

                    <div class="form-group col-12">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="{{ $user->nombre }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido"
                            value="{{ $user->apellido }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="cuit">Cuit</label>
                        <input type="number" class="form-control" id="cuit" name="cuit"
                            value="{{ $user->cuit }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="celular">Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular"
                            value="{{ $user->telefono }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="direccion">Direccion</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                            value="{{ $user->direccion }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad"
                            value="{{ $user->localidad }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="provincia">Provincia</label>
                        <input type="text" class="form-control" id="provincia" name="provincia"
                            value="{{ $user->provincia }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="cp">Codigo postal</label>
                        <input type="number" class="form-control" id="cp" name="cp"
                            value="{{ $user->cp }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="transporte">Transporte</label>
                        <input type="text" class="form-control" id="transporte" name="transporte"
                            value="{{ $user->transporte }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="direccionEntrega">Direccion de entrega</label>
                        <input type="text" class="form-control" id="direccionEntrega" name="direccionEntrega"
                            value="{{ $user->direccionEntrega }}" >
                    </div>
    
                    <div class="form-group col-12">
                        <label for="iva">IVA</label>
                        <select class="form-control" id="iva" name="iva" >
                            <option @if ($user->iva == 'responsable inscripto') selected @endif value="responsable inscripto">Responsable
                                inscripto</option>
                            <option @if ($user->iva == 'responsable no inscripto') selected @endif value="responsable no inscripto">
                                Responsable no inscripto</option>
                            <option @if ($user->iva == 'monotributo') selected @endif value="monotributo">Monotributo</option>
                            <option @if ($user->iva == 'exento') selected @endif value="exento">Exento</option>
                            <option @if ($user->iva == 'cliente del exterior') selected @endif value="cliente del exterior">Cliente del
                                exterior</option>
                        </select>
                    </div>
                </div>

                <div class="form-group col-12">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" value="{{$user->email}}" name="email" >
                </div>

                <div class="form-group col-12">
                    <label for="password" class="col-md-4 col-form-label ">Contrase&ntilde;a</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" autocomplete="new-password" >
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group col-12">
                    <button type="submit" style="background: #F15E40; border: #F15E40" class="btn btn-success my-3">Guardar</button>
                </div>

                @isset($mensajeForm)

                <span style="color: green"> {{$mensajeForm}} </span>

                    
                @endisset

            </div>
        </form>

    </div>
@endsection


