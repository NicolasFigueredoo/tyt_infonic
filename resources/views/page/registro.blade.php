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
        <div class="text-center px-3 mb-4" style="max-width: 700px; font-size: 16px; color: #333;">
            @if (session('locale') === 'es')
                Completá el siguiente formulario (solo te tomará un minuto) y registrate como cliente mayorista para acceder
                a nuestra lista de precios. Una vez completado, nuestro departamento de ventas se estará comunicando en los
                próximos cinco días hábiles.
            @else
                Fill out the following form (it will only take a minute) and register as a wholesale customer to access our
                price list. Once completed, our sales department will be in touch within the next five business days.
            @endif
        </div>
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

            {{-- FORM REGISTRO --}}
            <form id="formRegistro" class="col-12" method="post" action="{{ route('page.nuevocliente') }}"
                enctype="multipart/form-data">
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

                                $nameKey = 'campo_' . $campo->id;
                                $otroKey = 'campo_otro_' . $campo->id;

                                $oldValue = old($nameKey);

                                $oldArray = is_array($oldValue)
                                    ? $oldValue
                                    : (is_string($oldValue)
                                        ? json_decode($oldValue, true)
                                        : []);
                                $oldArray = is_array($oldArray) ? $oldArray : [];

                                $oldOtro = old($otroKey);

                                $showOtroSelectRadio = $oldValue === '__otro__';
                                $showOtroCheckbox = !empty($oldOtro);
                            @endphp

                            {{-- Texto corto --}}
                            @if ($campo->tipo === 'text')
                                <input type="text" class="form-control" name="{{ $nameKey }}"
                                    data-label="{{ $campo->label }}" value="{{ old($nameKey) }}"
                                    placeholder="{{ $campo->placeholder }}" {{ $campo->requerido ? 'required' : '' }}>

                            {{-- Texto largo --}}
                            @elseif($campo->tipo === 'textarea')
                                <textarea class="form-control" rows="3" name="{{ $nameKey }}" data-label="{{ $campo->label }}"
                                    placeholder="{{ $campo->placeholder }}" {{ $campo->requerido ? 'required' : '' }}>{{ old($nameKey) }}</textarea>

                            {{-- Email --}}
                            @elseif($campo->tipo === 'email')
                                <input type="email" class="form-control" name="{{ $nameKey }}"
                                    data-label="{{ $campo->label }}" value="{{ old($nameKey) }}"
                                    placeholder="{{ $campo->placeholder }}" {{ $campo->requerido ? 'required' : '' }}>

                            {{-- Número --}}
                            @elseif($campo->tipo === 'number')
                                <input type="number" class="form-control" name="{{ $nameKey }}"
                                    data-label="{{ $campo->label }}" value="{{ old($nameKey) }}"
                                    placeholder="{{ $campo->placeholder }}" {{ $campo->requerido ? 'required' : '' }}>

                            {{-- Link --}}
                            @elseif($campo->tipo === 'link')
                                <input type="url" class="form-control" name="{{ $nameKey }}"
                                    data-label="{{ $campo->label }}" value="{{ old($nameKey) }}"
                                    placeholder="{{ $campo->placeholder ?? 'https://' }}"
                                    {{ $campo->requerido ? 'required' : '' }}>

                            {{-- Select --}}
                            @elseif($campo->tipo === 'select')
                                <select class="form-control" name="{{ $nameKey }}" data-label="{{ $campo->label }}"
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
                                            data-label="{{ $campo->label }}"
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
                                            data-label="{{ $campo->label }}" id="campo_{{ $campo->id }}_otro"
                                            value="__otro__" {{ old($nameKey) === '__otro__' ? 'checked' : '' }}
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
                                            data-label="{{ $campo->label }}"
                                            id="campo_{{ $campo->id }}_{{ $loop->index }}"
                                            value="{{ $op }}"
                                            {{ in_array((string) $op, array_map('strval', old($nameKey, []))) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="campo_{{ $campo->id }}_{{ $loop->index }}">{{ $op }}</label>
                                    </div>
                                @endforeach

                                @if ($tieneOtro)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="chk_otro_{{ $campo->id }}"
                                            {{ $showOtroCheckbox ? 'checked' : '' }}
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
                                    data-label="{{ $campo->label }}" {{ $campo->requerido ? 'required' : '' }}>

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
                                                name="{{ $nameKey }}[]" data-label="{{ $campo->label }}"
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
                        {{-- type="button": no dispara submit, lo manejamos desde JS --}}
                        <button type="button" id="btnEnviar" style="background: #F15E40; border: white"
                            class="btn btn-success my-3">
                            @if (session('locale') === 'es')
                                Crear cuenta
                            @else
                                Create account
                            @endif
                        </button>

                        {{-- Botón oculto que dispara el submit real (activa reCAPTCHA v3) --}}
                        <button type="submit" id="btnSubmitReal" style="display:none"></button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Modal de confirmación --}}
    <div class="modal fade" id="modalConfirmarDatos" tabindex="-1" aria-labelledby="modalConfirmarDatosLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 2px solid #F15E40;">
                    <h5 class="modal-title" id="modalConfirmarDatosLabel" style="color: #F15E40; font-weight: bold;">
                        Revisá tus datos
                    </h5>
                </div>
                <div class="modal-body">
                    <p class="mb-4" style="font-size: 15px; color: #333;">
                        Por favor corroborá que tus datos de contacto sean los correctos.
                    </p>
                    <ul class="list-group list-group-flush" id="modalDatosLista"></ul>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" id="btnEditarDatos">
                        <i class="fas fa-pencil-alt me-1"></i> Editar datos
                    </button>
                    <button type="button" class="btn" id="btnConfirmarEnvio"
                        style="background:#F15E40; color:#fff; min-width: 140px;">
                        <i class="fas fa-check me-1"></i> Confirmar y enviar
                    </button>
                </div>
            </div>
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

        #modalDatosLista .list-group-item {
            padding: 10px 4px;
            font-size: 14px;
        }

        #modalDatosLista .list-group-item span:first-child {
            color: #555;
            min-width: 180px;
        }

        #modalDatosLista .list-group-item span:last-child {
            font-weight: 600;
            color: #222;
            text-align: right;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /* ---------- helpers de tipo "otro" ---------- */
            window.toggleImageCard = function (input) {
                input.closest('.image-choice-card').classList.toggle('selected', input.checked);
            };

            window.toggleOtro = function (select, campoId) {
                var input = document.getElementById('campo_otro_' + campoId);
                if (!input) return;
                input.style.display = select.value === '__otro__' ? 'block' : 'none';
                input.required = select.value === '__otro__';
            };

            window.toggleOtroRadio = function (radio, campoId) {
                var input = document.getElementById('campo_otro_' + campoId);
                if (!input) return;
                input.style.display = radio.value === '__otro__' ? 'block' : 'none';
                input.required = radio.value === '__otro__';
            };

            window.toggleOtroCheck = function (checkbox, campoId) {
                var input = document.getElementById('campo_otro_' + campoId);
                if (!input) return;
                input.style.display = checkbox.checked ? 'block' : 'none';
            };

            /* ---------- referencias ---------- */
            var btnEnviar    = document.getElementById('btnEnviar');
            var btnConfirmar = document.getElementById('btnConfirmarEnvio');
            var btnEditar    = document.getElementById('btnEditarDatos');
            var btnSubmit    = document.getElementById('btnSubmitReal');
            var form         = document.getElementById('formRegistro');
            var modalEl      = document.getElementById('modalConfirmarDatos');
            var lista        = document.getElementById('modalDatosLista');

            if (!btnEnviar || !form || !modalEl) {
                console.error('Elementos no encontrados', { btnEnviar, form, modalEl });
                return;
            }

            /* ---------- click "Crear cuenta" → validar y mostrar modal ---------- */
            btnEnviar.addEventListener('click', function () {
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                // Construir lista de datos del formulario
                lista.innerHTML = '';
                var visto = {};

                form.querySelectorAll('[data-label]').forEach(function (el) {
                    var label = el.getAttribute('data-label');
                    var tipo  = el.type;
                    var valor = '';

                    // Ignorar inputs internos de "otro"
                    if (el.name && el.name.indexOf('campo_otro_') === 0) return;

                    if (tipo === 'radio') {
                        if (!el.checked) return;
                        valor = el.value === '__otro__'
                            ? (document.getElementById('campo_otro_' + el.name.replace('campo_', '')) || {}).value || 'Otro'
                            : el.value;
                    } else if (tipo === 'checkbox') {
                        if (!el.checked) return;
                        valor = el.value;
                        // Acumular múltiples checkboxes del mismo label
                        if (visto[label]) {
                            var existing = lista.querySelector('[data-label-key="' + label + '"] span:last-child');
                            if (existing) existing.textContent += ', ' + valor;
                            return;
                        }
                    } else if (tipo === 'file') {
                        valor = el.files && el.files.length ? el.files[0].name : '(sin archivo)';
                    } else if (el.tagName === 'SELECT') {
                        valor = el.options[el.selectedIndex] ? el.options[el.selectedIndex].text : '';
                        if (valor === '-- Seleccioná una opción --') valor = '';
                        if (el.value === '__otro__') {
                            valor = (document.getElementById('campo_otro_' + el.name.replace('campo_', '')) || {}).value || 'Otro';
                        }
                    } else {
                        valor = el.value || '';
                    }

                    if (!valor && tipo !== 'checkbox') return;

                    visto[label] = true;

                    var li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-start';
                    li.setAttribute('data-label-key', label);
                    li.innerHTML = '<span>' + label + '</span><span>' + valor + '</span>';
                    lista.appendChild(li);
                });

                var modal = new bootstrap.Modal(modalEl);
                modal.show();
            });

            /* ---------- click "Confirmar y enviar" → submit real (dispara reCAPTCHA) ---------- */
            btnConfirmar.addEventListener('click', function () {
                btnSubmit.click();
            });

            /* ---------- click "Editar datos" → cerrar modal ---------- */
            btnEditar.addEventListener('click', function () {
                bootstrap.Modal.getInstance(modalEl).hide();
            });
        });
    </script>
@endsection