@extends('layouts.newplantilla')

@section('metadatos')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Trabajá con nosotros en TyT S.A." />
@endsection

@section('content')
<style>
    .btn-ficha {
        color: #fff;
        background-color: #F15E40;
        border-color: #F15E40;
    }
    .btn-ficha:hover {
        color: #F15E40;
        background-color: white;
        border-color: #F15E40;
    }
    .bordercont {
        border: 1px solid #D2D2D2 !important;
    }
    .oferta-card {
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 16px;
        background: #fff;
        cursor: pointer;
        transition: box-shadow 0.2s;
    }
    .oferta-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.10);
    }
    .oferta-titulo {
        font-weight: 700;
        font-size: 20px;
        color: #161414;
        margin-bottom: 6px;
    }
    .oferta-ubicacion {
        font-size: 14px;
        color: #666;
        margin-bottom: 4px;
    }
    .oferta-fecha {
        font-size: 13px;
        color: #999;
    }
    .oferta-detalle {
        display: none;
        margin-top: 16px;
        border-top: 1px solid #eee;
        padding-top: 16px;
    }
    .oferta-detalle.show {
        display: block;
    }
    .oferta-detalle h6 {
        font-weight: 700;
        color: #F15E40;
        margin-bottom: 6px;
    }
    .btn-postular {
        background: #F15E40;
        color: #fff;
        border: none;
        border-radius: 35px;
        padding: 8px 28px;
        font-size: 15px;
        font-weight: 600;
        margin-top: 12px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .btn-postular:hover {
        background: #d44e32;
    }
    .nosotros-box {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 28px;
        font-size: 15px;
        color: #333;
        line-height: 1.7;
    }
    .nosotros-box h5 {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 16px;
        color: #161414;
    }
    .contacto-box {
        background: #F15E40;
        color: #fff;
        border-radius: 8px;
        padding: 24px;
        margin-top: 16px;
    }
    .contacto-box a {
        color: #fff;
        text-decoration: none;
        font-size: 14px;
    }
    .contacto-box .contacto-nombre {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 12px;
    }
    .contacto-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 10px;
    }
    .contacto-row svg {
        flex-shrink: 0;
        margin-top: 2px;
    }
    /* Modal postulación */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }
    .modal-overlay.show {
        display: flex;
    }
    .modal-box {
        background: #fff;
        border-radius: 12px;
        padding: 36px;
        width: 100%;
        max-width: 540px;
        position: relative;
    }
    .modal-box h5 {
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 20px;
    }
    .modal-close {
        position: absolute;
        top: 16px; right: 20px;
        font-size: 22px;
        cursor: pointer;
        color: #666;
        background: none;
        border: none;
    }
    .form-label-emp {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 4px;
        display: block;
    }
    .form-control-emp {
        width: 100%;
        border: 1px solid #D2D2D2;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 14px;
        margin-bottom: 14px;
    }
    @media (max-width: 768px) {
        .empleos-layout {
            flex-direction: column !important;
        }
        .empleos-sidebar {
            width: 100% !important;
        }
    }
</style>


{{-- Contenido --}}
<div class="d-flex justify-content-center my-4">
    <div class="box_container">
        <div class="d-flex gap-4 empleos-layout">

            {{-- Lista de ofertas --}}
            <div style="flex:1; min-width:0;">

                @if($ofertas->isEmpty())
                    <div class="oferta-card text-center py-5">
                        <p style="color:#999; font-size:16px;">No hay ofertas disponibles en este momento.</p>
                    </div>
                @else
                    @foreach($ofertas as $oferta)
                    <div class="oferta-card" onclick="toggleDetalle({{ $oferta->id }})">
                        <div class="oferta-titulo">{{ $oferta->titulo }}</div>
                        @if($oferta->ubicacion)
                            <div class="oferta-ubicacion">
                                <i class="fas fa-map-marker-alt" style="color:#F15E40;"></i>
                                {{ $oferta->ubicacion }}
                            </div>
                        @endif
                        @if($oferta->fecha_publicacion)
                            <div class="oferta-fecha">
                                Publicado: {{ \Carbon\Carbon::parse($oferta->fecha_publicacion)->format('d/m/Y') }}
                            </div>
                        @endif

                        <div class="oferta-detalle" id="detalle-{{ $oferta->id }}">
                            @if($oferta->descripcion)
                                <h6>Descripción</h6>
                                <p style="font-size:14px; white-space:pre-line;">{{ $oferta->descripcion }}</p>
                            @endif
                            @if($oferta->requisitos)
                                <h6>Requisitos</h6>
                                <p style="font-size:14px; white-space:pre-line;">{{ $oferta->requisitos }}</p>
                            @endif
                            <button class="btn-postular" onclick="event.stopPropagation(); abrirModal({{ $oferta->id }}, '{{ addslashes($oferta->titulo) }}')">
                                Postularme
                            </button>
                        </div>
                    </div>
                    @endforeach
                @endif

            </div>

            {{-- Sidebar --}}
            <div class="empleos-sidebar" style="width:320px; flex-shrink:0;">

                {{-- Logo + nombre empresa --}}
                <div style="background:#fff; border:1px solid #e0e0e0; border-radius:8px; padding:20px; display:flex; align-items:center; gap:16px; margin-bottom:16px;">
                    <img src="{{ asset(Storage::url('logo/images.png')) }}" alt="TyT SA" style="width:80px; height:auto;">
                    <div>
                        <div style="font-weight:700; font-size:18px; color:#161414;">TyT SA</div>
                        <div style="font-size:13px; color:#666;">Oportunidades de empleo</div>
                    </div>
                </div>

                {{-- CV base general --}}
                <div class="mt-3">
                    <button class="btn-postular w-100" onclick="abrirModal(0, 'Base general')">
                        <i class="fas fa-upload me-2"></i> Subir CV a base general
                    </button>
                </div>

                {{-- Nosotros --}}
                <div class="nosotros-box mt-3">
                    <h5>Nosotros</h5>
                    <p>En TyT S.A. sabemos que detrás de cada logro hay personas comprometidas que hacen posible nuestro crecimiento día a día.</p>
                    <p>Somos una empresa argentina con más de 50 años de trayectoria en el mercado de accesorios automotrices y, a lo largo de este camino, hemos construido nuestra historia apoyándonos en valores que siguen guiando nuestro trabajo: la responsabilidad, el respeto y el trabajo en equipo.</p>
                    <p>Nos gusta sumar personas con ganas de aprender, aportar ideas y crecer junto a nosotros. Valoramos el compromiso, la colaboración y la actitud de quienes buscan dar lo mejor de sí en cada desafío.</p>
                    <p>Si te entusiasma ser parte de una empresa con experiencia, proyectos y nuevos desafíos por delante, te invitamos a compartir tu CV.</p>
                </div>

                {{-- Datos de contacto de la BD --}}
                @foreach($contactos as $contacto)
                <div class="contacto-box">
                    <div class="contacto-nombre">{{ $contacto->name }}</div>

                    @if($contacto->direccion)
                    <div class="contacto-row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="18" viewBox="0 0 13 18" fill="none">
                            <path d="M5.83177 16.9802C0.913195 9.85178 0 9.12058 0 6.49961C0 4.77581 0.684778 3.1226 1.90369 1.90369C3.1226 0.684778 4.77581 0 6.49961 0C8.22341 0 9.87661 0.684778 11.0955 1.90369C12.3144 3.1226 12.9992 4.77581 12.9992 6.49961C12.9992 9.12058 12.086 9.85178 7.16744 16.9802C7.09267 17.0882 6.99286 17.1763 6.87655 17.2373C6.76024 17.2982 6.6309 17.33 6.49961 17.33C6.36831 17.33 6.23898 17.2982 6.12267 17.2373C6.00636 17.1763 5.90655 17.0882 5.83177 16.9802ZM6.49961 9.20751C7.03518 9.20751 7.55873 9.04869 8.00404 8.75115C8.44935 8.4536 8.79643 8.03068 9.00138 7.53588C9.20634 7.04107 9.25996 6.49661 9.15548 5.97132C9.05099 5.44604 8.79309 4.96354 8.41438 4.58484C8.03568 4.20613 7.55318 3.94823 7.02789 3.84374C6.50261 3.73926 5.95815 3.79288 5.46334 3.99784C4.96854 4.20279 4.54562 4.54987 4.24807 4.99518C3.95053 5.44049 3.79171 5.96404 3.79171 6.49961C3.79171 7.21779 4.07701 7.90655 4.58484 8.41438C5.09267 8.92221 5.78143 9.20751 6.49961 9.20751Z" fill="white"/>
                        </svg>
                        <span style="font-size:14px;">{{ $contacto->direccion }}</span>
                    </div>
                    @endif

                    @if($contacto->email)
                    <div class="contacto-row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                            <path d="M15.7 3.963C15.7277 3.94244 15.7605 3.9299 15.7949 3.92675C15.8292 3.9236 15.8638 3.92997 15.8948 3.94514C15.9257 3.96032 15.9519 3.98373 15.9705 4.01281C15.9891 4.04189 15.9993 4.07551 16 4.11V10.5C16 10.8978 15.842 11.2794 15.5607 11.5607C15.2794 11.842 14.8978 12 14.5 12H1.5C1.10218 12 0.720644 11.842 0.43934 11.5607C0.158035 11.2794 0 10.8978 0 10.5L0 4.113C0.000368432 4.07836 0.0103538 4.0445 0.0288422 4.0152C0.0473307 3.9859 0.0735953 3.96231 0.104707 3.94707C0.135818 3.93182 0.170552 3.92552 0.205036 3.92886C0.23952 3.93221 0.272397 3.94507 0.3 3.966C1 4.51 1.928 5.2 5.116 7.516C5.778 8 6.891 9.009 8 9C9.116 9.009 10.25 7.975 10.884 7.513C14.072 5.2 15 4.506 15.7 3.963ZM8 8C8.725 8.013 9.769 7.088 10.294 6.706C14.441 3.697 14.756 3.434 15.713 2.684C15.8025 2.61393 15.8749 2.52438 15.9246 2.42215C15.9744 2.31992 16.0001 2.20769 16 2.094V1.5C16 1.10218 15.842 0.720643 15.5607 0.439339C15.2794 0.158034 14.8978 0 14.5 0H1.5C1.10218 0 0.720644 0.158034 0.43934 0.439339C0.158035 0.720643 0 1.10218 0 1.5L0 2.094C0.000118744 2.20789 0.0261037 2.32026 0.0759939 2.42264C0.125884 2.52502 0.198376 2.61473 0.288 2.685C1.244 3.432 1.56 3.698 5.707 6.707C6.231 7.088 7.275 8.013 8 8Z" fill="white"/>
                        </svg>
                        <a href="mailto:{{ $contacto->email }}">{{ $contacto->email }}</a>
                    </div>
                    @endif

                    @if($contacto->telefono)
                    <div class="contacto-row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M15.544 11.3069L12.044 9.80685C11.8944 9.74317 11.7282 9.72981 11.5704 9.76876C11.4126 9.80772 11.2717 9.89689 11.169 10.0229L9.619 11.9169C7.18597 10.7699 5.22798 8.81188 4.081 6.37885L5.975 4.82885C6.10123 4.72631 6.1906 4.58543 6.22958 4.42754C6.26856 4.26965 6.25501 4.10335 6.191 3.95385L4.691 0.453852C4.62081 0.292487 4.49646 0.160708 4.33944 0.0812825C4.18241 0.00185718 4.00258 -0.0202247 3.831 0.0188522L0.581 0.768852C0.415776 0.807065 0.26838 0.900146 0.162862 1.03291C0.0573448 1.16567 -6.52211e-05 1.33027 5.56045e-08 1.49985C5.56045e-08 5.34549 1.52767 9.03362 4.24695 11.7529C6.96623 14.4722 10.6544 15.9999 14.5 15.9999C14.6696 15.9999 14.8342 15.9425 14.9669 15.837C15.0997 15.7315 15.1928 15.5841 15.231 15.4189L15.981 12.1689C16.0198 11.9965 15.9973 11.816 15.9174 11.6585C15.8374 11.501 15.705 11.3762 15.543 11.3059L15.544 11.3069Z" fill="white"/>
                        </svg>
                        <a href="tel:{{ $contacto->telefono }}">{{ $contacto->telefono }}</a>
                    </div>
                    @endif

                    {{-- Email RRHH --}}
                    <div class="contacto-row mt-2" style="border-top:1px solid rgba(255,255,255,0.3); padding-top:10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="12" viewBox="0 0 16 12" fill="none">
                            <path d="M15.7 3.963C15.7277 3.94244 15.7605 3.9299 15.7949 3.92675C15.8292 3.9236 15.8638 3.92997 15.8948 3.94514C15.9257 3.96032 15.9519 3.98373 15.9705 4.01281C15.9891 4.04189 15.9993 4.07551 16 4.11V10.5C16 10.8978 15.842 11.2794 15.5607 11.5607C15.2794 11.842 14.8978 12 14.5 12H1.5C1.10218 12 0.720644 11.842 0.43934 11.5607C0.158035 11.2794 0 10.8978 0 10.5L0 4.113C0.000368432 4.07836 0.0103538 4.0445 0.0288422 4.0152C0.0473307 3.9859 0.0735953 3.96231 0.104707 3.94707C0.135818 3.93182 0.170552 3.92552 0.205036 3.92886C0.23952 3.93221 0.272397 3.94507 0.3 3.966C1 4.51 1.928 5.2 5.116 7.516C5.778 8 6.891 9.009 8 9C9.116 9.009 10.25 7.975 10.884 7.513C14.072 5.2 15 4.506 15.7 3.963ZM8 8C8.725 8.013 9.769 7.088 10.294 6.706C14.441 3.697 14.756 3.434 15.713 2.684C15.8025 2.61393 15.8749 2.52438 15.9246 2.42215C15.9744 2.31992 16.0001 2.20769 16 2.094V1.5C16 1.10218 15.842 0.720643 15.5607 0.439339C15.2794 0.158034 14.8978 0 14.5 0H1.5C1.10218 0 0.720644 0.158034 0.43934 0.439339C0.158035 0.720643 0 1.10218 0 1.5L0 2.094C0.000118744 2.20789 0.0261037 2.32026 0.0759939 2.42264C0.125884 2.52502 0.198376 2.61473 0.288 2.685C1.244 3.432 1.56 3.698 5.707 6.707C6.231 7.088 7.275 8.013 8 8Z" fill="white"/>
                        </svg>
                        <div>
                            <div style="font-size:12px; opacity:0.8; margin-bottom:2px;">RRHH</div>
                            <a href="mailto:rrhh@tytsa.com.ar">rrhh@tytsa.com.ar</a>
                        </div>
                    </div>
                </div>
                @endforeach

                

            </div>

        </div>
    </div>
</div>

{{-- Modal postulación --}}
<div class="modal-overlay" id="modal-postulacion">
    <div class="modal-box">
        <button class="modal-close" onclick="cerrarModal()">&times;</button>
        <h5>Postularme — <span id="modal-titulo-oferta"></span></h5>
        <form id="form-postulacion" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="oferta_id" id="input-oferta-id">

            <div class="row">
                <div class="col-6">
                    <label class="form-label-emp">Nombre *</label>
                    <input type="text" name="nombre" class="form-control-emp" required>
                </div>
                <div class="col-6">
                    <label class="form-label-emp">Apellido *</label>
                    <input type="text" name="apellido" class="form-control-emp" required>
                </div>
            </div>

            <label class="form-label-emp">Dirección *</label>
            <input type="text" name="direccion" class="form-control-emp" required>

            <label class="form-label-emp">Teléfono *</label>
            <input type="tel" name="telefono" class="form-control-emp" required>

            <label class="form-label-emp">Email *</label>
            <input type="email" name="email" class="form-control-emp" required>

            <label class="form-label-emp">CV (PDF, DOC, DOCX — máx. 5MB) *</label>
            <input type="file" name="cv" class="form-control-emp" accept=".pdf,.doc,.docx" required>

            <div id="msg-postulacion" style="display:none; margin-bottom:10px; font-weight:600;"></div>

            <div class="d-flex justify-content-end gap-2 mt-2">
                <button type="button" onclick="cerrarModal()" style="border-radius:35px; padding:8px 24px; border:1px solid #ccc; background:#fff; cursor:pointer;">Cancelar</button>
                <button type="submit" class="btn-postular" style="margin-top:0;">Enviar postulación</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDetalle(id) {
        const el = document.getElementById('detalle-' + id);
        el.classList.toggle('show');
    }

    function abrirModal(id, titulo) {
        document.getElementById('input-oferta-id').value = id;
        document.getElementById('modal-titulo-oferta').textContent = titulo;
        document.getElementById('msg-postulacion').style.display = 'none';
        document.getElementById('form-postulacion').reset();
        document.getElementById('input-oferta-id').value = id;
        document.getElementById('modal-postulacion').classList.add('show');
    }

    function cerrarModal() {
        document.getElementById('modal-postulacion').classList.remove('show');
    }

    document.getElementById('form-postulacion').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        const data = new FormData(form);
        const msg  = document.getElementById('msg-postulacion');

        fetch('{{ route('page.empleos.post') }}', {
            method: 'POST',
            body: data,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(r => r.json())
        .then(res => {
            if (res.mensaje) {
                msg.style.color   = 'green';
                msg.textContent   = res.mensaje;
                msg.style.display = 'block';
                form.reset();
                setTimeout(() => cerrarModal(), 3000);
            }
            if (res.errors) {
                const errores = Object.values(res.errors).flat().join(' | ');
                msg.style.color   = 'red';
                msg.textContent   = errores;
                msg.style.display = 'block';
            }
        })
        .catch(() => {
            msg.style.color   = 'red';
            msg.textContent   = 'Ocurrió un error. Intentá de nuevo.';
            msg.style.display = 'block';
        });
    });
</script>

@endsection