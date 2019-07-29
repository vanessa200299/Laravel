<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Examen Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        html, body{
            background-color: #ECEFF1;
        }
    </style>
</head>
<body>
    <div id="app" class="uk-container">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>