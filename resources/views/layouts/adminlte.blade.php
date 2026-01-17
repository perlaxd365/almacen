<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Almacén')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">

        {{-- Navbar --}}
        @include('layouts.partials.navbar')

        {{-- Sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- Contenido --}}
        <div class="content-wrapper p-3">
            @yield('content')
        </div>

    </div>

    @livewireScripts
</body>

</html>
