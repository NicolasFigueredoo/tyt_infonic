@extends('layouts.newplantilla')

@section('content')
    <div style="color:#F15E40;font-size:32px; margin-top: 80px" class="py-3 text-center">
        @if (session('locale') === 'es')
            <b>Quiero ser cliente</b>
        @else
            <b>I want to be a client</b>
        @endif
    </div>

    <div class="d-flex justify-content-center">
        @if (session('success'))
            <div class="alert alert-success box_container">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger box_container">{{ session('error') }}</div>
        @endif
    </div>

    <div class="d-flex justify-content-center">
        <div
            class="d-flex flex-row justify-content-start align-items-center align-items-md-start flex-wrap m-1 m-md-5 box_container">

            {{-- FORM LOGIN --}}
            <form class="col-4" method="POST" action="{{ route('login.clientes') }}">
                @csrf
                <span style="color:#F15E40;font-size:24px;">
                    @if (session('locale') === 'es')
                        <b>Iniciar sesi&oacute;n</b>
                    @else
                        <b>login</b>
                    @endif
                </span>
                <div class="mt-3 form-group row d-flex justify-content-start align-items-center">
                    <div class="col-md-10">
                        <span style="color:#000;font-size:16px;">
                            @if (session('locale') === 'es')
                                <b>Email</b>
                            @else
                                <b>Mail</b>
                            @endif
                        </span>
                        <input style="background:transparent;color:#000;border-color:#F15E40;" id="username" type="text"
                            class="form-control @error('username') is-invalid @enderror" name="username"
                            value="{{ old('username') }}" autocomplete="username" autofocus>
                    </div>
                </div>
                <div class="mt-3 form-group row d-flex justify-content-start align-items-center">
                    <div class="col-md-10">
                        <span style="color:#000;font-size:16px;"><b>
                                @if (session('locale') === 'es')
                                    Contraseña
                                @else
                                    Password
                                @endif
                            </b></span>
                        <input style="background:transparent;color:#000;border-color:#F15E40;" id="password"
                            type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                            autocomplete="current-password">
                    </div>
                </div>
                <div class="mt-3 form-group row mb-0 d-flex justify-content-start align-items-center">
                    <div class="col-md-10 d-flex justify-content-center align-items-center">
                        <button style="background:#F15E40;color: #fff;" type="submit" class="btn w-100">
                            @if (session('locale') === 'es')
                                INGRESAR
                            @else
                                GET INTO
                            @endif
                        </button>
                    </div>
                </div>
            </form>

            {{-- FORM REGISTRO --}}
            <form class="col-8" method="post" action="{{ route('page.nuevocliente') }}" enctype="multipart/form-data">
                @csrf
                <div class="row px-4">

                    @foreach ($camposDinamicos as $campo)
                        <div class="form-group col-12 mb-4">
                            <label>
                                {{ $campo->label }}
                                @if ($campo->requerido)
                                    <span style="color:red">*</span>
                                @endif
                            </label>

                            @php
                                $opciones = $campo->opciones ? json_decode($campo->opciones, true) : [];
                                $tieneOtro = $campo->tiene_otro ?? false;

                                $nameKey = 'campo_' . $campo->id; // ej: campo_12
                                $otroKey = 'campo_otro_' . $campo->id; // ej: campo_otro_12

                                // Valor old del campo principal
                                $oldValue = old($nameKey);

                                // Para checkboxes/image_choice viene como array
                                $oldArray = is_array($oldValue)
                                    ? $oldValue
                                    : (is_string($oldValue)
                                        ? json_decode($oldValue, true)
                                        : []);
                                $oldArray = is_array($oldArray) ? $oldArray : [];

                                // Valor del "otro" (si existe)
                                $oldOtro = old($otroKey);

                                // Mostrar input "otro" si:
                                // - en select: old == '__otro__'
                                // - en radio: old == '__otro__'
                                // - en checkbox: si existe oldOtro (porque el checkbox "Otro" en tu UI no tiene name)
                                $showOtroSelectRadio = $oldValue === '__otro__';
                                $showOtroCheckbox = !empty($oldOtro);
                            @endphp

                            {{-- Texto corto --}}
                            @if ($campo->tipo === 'text')
                                <input type="text" class="form-control" name="{{ $nameKey }}"
                                    value="{{ old($nameKey) }}" placeholder="{{ $campo->placeholder }}"
                                    {{ $campo->requerido ? 'required' : '' }}>

                                {{-- Texto largo --}}
                            @elseif($campo->tipo === 'textarea')
                                <textarea class="form-control" rows="3" name="{{ $nameKey }}" placeholder="{{ $campo->placeholder }}"
                                    {{ $campo->requerido ? 'required' : '' }}>{{ old($nameKey) }}</textarea>

                                {{-- Email --}}
                            @elseif($campo->tipo === 'email')
                                <input type="email" class="form-control" name="{{ $nameKey }}"
                                    value="{{ old($nameKey) }}" placeholder="{{ $campo->placeholder }}"
                                    {{ $campo->requerido ? 'required' : '' }}>

                                {{-- Número --}}
                            @elseif($campo->tipo === 'number')
                                <input type="number" class="form-control" name="{{ $nameKey }}"
                                    value="{{ old($nameKey) }}" placeholder="{{ $campo->placeholder }}"
                                    {{ $campo->requerido ? 'required' : '' }}>

                                {{-- Link --}}
                            @elseif($campo->tipo === 'link')
                                <input type="url" class="form-control" name="{{ $nameKey }}"
                                    value="{{ old($nameKey) }}" placeholder="{{ $campo->placeholder ?? 'https://' }}"
                                    {{ $campo->requerido ? 'required' : '' }}>

                                {{-- Select --}}
                            @elseif($campo->tipo === 'select')
                                <select class="form-control" name="{{ $nameKey }}"
                                    {{ $campo->requerido ? 'required' : '' }}
                                    @if ($tieneOtro) onchange="toggleOtro(this, {{ $campo->id }})" @endif>
                                    <option value="">-- Seleccioná una opción --</option>
                                    @foreach ($opciones as $op)
                                        <option value="{{ $op }}"
                                            {{ (string) old($nameKey) === (string) $op ? 'selected' : '' }}>
                                            {{ $op }}
                                        </option>
                                    @endforeach
                                    @if ($tieneOtro)
                                        <option value="__otro__" {{ old($nameKey) === '__otro__' ? 'selected' : '' }}>Otro
                                        </option>
                                    @endif
                                </select>

                                @if ($tieneOtro)
                                    <input type="text" class="form-control mt-2" id="campo_otro_{{ $campo->id }}"
                                        name="{{ $otroKey }}" value="{{ old($otroKey) }}"
                                        placeholder="Especificá cuál..."
                                        style="display: {{ $showOtroSelectRadio ? 'block' : 'none' }}">
                                @endif

                                {{-- Radio --}}
                            @elseif($campo->tipo === 'radio')
                                @foreach ($opciones as $op)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{ $nameKey }}"
                                            id="campo_{{ $campo->id }}_{{ $loop->index }}"
                                            value="{{ $op }}"
                                            {{ (string) old($nameKey) === (string) $op ? 'checked' : '' }}
                                            {{ $campo->requerido && $loop->first ? 'required' : '' }}
                                            @if ($tieneOtro) onchange="toggleOtroRadio(this, {{ $campo->id }})" @endif>
                                        <label class="form-check-label"
                                            for="campo_{{ $campo->id }}_{{ $loop->index }}">{{ $op }}</label>
                                    </div>
                                @endforeach

                                @if ($tieneOtro)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="{{ $nameKey }}"
                                            id="campo_{{ $campo->id }}_otro" value="__otro__"
                                            {{ old($nameKey) === '__otro__' ? 'checked' : '' }}
                                            onchange="toggleOtroRadio(this, {{ $campo->id }})">
                                        <label class="form-check-label" for="campo_{{ $campo->id }}_otro">Otro</label>
                                    </div>

                                    <input type="text" class="form-control mt-2" id="campo_otro_{{ $campo->id }}"
                                        name="{{ $otroKey }}" value="{{ old($otroKey) }}"
                                        placeholder="Especificá cuál..."
                                        style="display: {{ $showOtroSelectRadio ? 'block' : 'none' }}">
                                @endif

                                {{-- Checkbox --}}
                            @elseif($campo->tipo === 'checkbox')
                                @foreach ($opciones as $op)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="{{ $nameKey }}[]"
                                            id="campo_{{ $campo->id }}_{{ $loop->index }}"
                                            value="{{ $op }}"
                                            {{ in_array((string) $op, array_map('strval', old($nameKey, []))) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="campo_{{ $campo->id }}_{{ $loop->index }}">{{ $op }}</label>
                                    </div>
                                @endforeach

                                @if ($tieneOtro)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            id="chk_otro_{{ $campo->id }}" {{ $showOtroCheckbox ? 'checked' : '' }}
                                            onchange="toggleOtroCheck(this, {{ $campo->id }})">
                                        <label class="form-check-label" for="chk_otro_{{ $campo->id }}">Otro</label>
                                    </div>

                                    <input type="text" class="form-control mt-2" id="campo_otro_{{ $campo->id }}"
                                        name="{{ $otroKey }}" value="{{ old($otroKey) }}"
                                        placeholder="Especificá cuál..."
                                        style="display: {{ $showOtroCheckbox ? 'block' : 'none' }}">
                                @endif

                                {{-- Archivo --}}
                            @elseif($campo->tipo === 'file')
                                <input type="file" class="form-control" name="{{ $nameKey }}"
                                    {{ $campo->requerido ? 'required' : '' }}>
                                {{-- Nota: por seguridad, los file inputs NO pueden precargarse con old() --}}

                                {{-- Elección por imagen --}}
                            @elseif($campo->tipo === 'image_choice')
                                <div class="image-choice-grid">
                                    @foreach ($opciones as $i => $op)
                                        @php
                                            $val = $op['label'] ?? 'Opción ' . ($i + 1);
                                            $checked = in_array((string) $val, array_map('strval', old($nameKey, [])));
                                        @endphp

                                        <label class="image-choice-card {{ $checked ? 'selected' : '' }}"
                                            for="campo_{{ $campo->id }}_{{ $i }}">
                                            <input type="checkbox" class="image-choice-input"
                                                name="{{ $nameKey }}[]"
                                                id="campo_{{ $campo->id }}_{{ $i }}"
                                                value="{{ $val }}" {{ $checked ? 'checked' : '' }}
                                                onchange="toggleImageCard(this)">
                                            <img src="{{ asset('storage/' . $op['path']) }}"
                                                alt="{{ $op['label'] ?? '' }}" />
                                            @if (!empty($op['label']))
                                                <span class="image-choice-label">{{ $op['label'] }}</span>
                                            @endif
                                            <span class="image-choice-check"><i class="fas fa-check"></i></span>
                                        </label>
                                    @endforeach
                                </div>
                            @endif

                            @error($nameKey)
                                <div style="color:red">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                    <div class="form-group col-12 mb-4">
                        <button type="submit" style="background: #F15E40; border: white" class="btn btn-success my-3">
                            @if (session('locale') === 'es')
                                Crear cuenta
                            @else
                                Create account
                            @endif
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <style>
        .image-choice-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-top: 10px;
        }

        .image-choice-card {
            position: relative;
            cursor: pointer;
            border: 3px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            width: 160px;
            text-align: center;
            transition: border-color .2s, box-shadow .2s;
            user-select: none;
        }

        .image-choice-card:hover {
            border-color: #F15E40;
        }

        .image-choice-card.selected {
            border-color: #F15E40;
            box-shadow: 0 0 0 3px rgba(241, 94, 64, .25);
        }

        .image-choice-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .image-choice-card img {
            width: 100%;
            height: 120px;
            object-fit: contain;
            padding: 8px;
            background: #fafafa;
        }

        .image-choice-label {
            display: block;
            padding: 6px 8px;
            font-size: .85rem;
            font-weight: 500;
            border-top: 1px solid #eee;
        }

        .image-choice-check {
            display: none;
            position: absolute;
            top: 6px;
            right: 6px;
            background: #F15E40;
            color: #fff;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            align-items: center;
            justify-content: center;
            font-size: .75rem;
        }

        .image-choice-card.selected .image-choice-check {
            display: flex;
        }
    </style>

    <script>
        function toggleImageCard(input) {
            input.closest('.image-choice-card').classList.toggle('selected', input.checked);
        }

        function toggleOtro(select, campoId) {
            var input = document.getElementById('campo_otro_' + campoId);
            input.style.display = select.value === '__otro__' ? 'block' : 'none';
            input.required = select.value === '__otro__';
        }

        function toggleOtroRadio(radio, campoId) {
            var input = document.getElementById('campo_otro_' + campoId);
            input.style.display = radio.value === '__otro__' ? 'block' : 'none';
            input.required = radio.value === '__otro__';
        }

        function toggleOtroCheck(checkbox, campoId) {
            var input = document.getElementById('campo_otro_' + campoId);
            input.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
@endsection
