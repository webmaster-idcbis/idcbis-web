<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IDCBIS - Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud')</title>
    <meta name="description" content="@yield('meta_description', 'Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud - IDCBIS')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div id="app"></div>
</body>
</html>
