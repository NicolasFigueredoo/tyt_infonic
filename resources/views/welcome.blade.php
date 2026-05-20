<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">



<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TyT</title>

    <meta name="public-path" content="{{ asset('/') }}">

    <meta name="base-url" content="{{ request()->getBaseUrl() }}">



    <meta name="storage-path" content="{{ asset(Storage::url('/')) }}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <link rel="stylesheet" href="{{ asset('images/icons/fontello/css/hard.css') }}?13">

    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.7/quill.snow.css">


    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-K45SRCK5');
    </script>
    <!-- End Google Tag Manager -->

</head>



<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K45SRCK5" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="app">prueba</div>

    <script src="{{ asset('js/app.js') }}?13"></script>

    <!-- Agregar los archivos JS de Quill -->

    <script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

    <script>
        // Inicializar Quill en el editor

        var editor = new Quill('#editor', {

            theme: 'snow'

        });
    </script>

</body>



</html>
