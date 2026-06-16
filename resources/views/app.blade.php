<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IDCBIS - Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud')</title>
    <meta name="description" content="@yield('meta_description', 'Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud - IDCBIS')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/images/logo/logo32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/images/logo/logo180x180.png">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div id="app"></div>
</body>
</html>
