@extends('layouts.newplantilla')

@section('content')
    <div class="d-flex justify-content-center" style="height: 26vh;">
        <div class="box_container py-5">
            @if (session('locale') === 'es')
            <span>Gracias por registrarte, te vamos a estar enviando un email cuando se active tu cuenta.</span>
        @else
        <span>Thank you for registering, we will send you an email when your account is activated.</span>
        @endif
        </div>
    </div>
@endsection