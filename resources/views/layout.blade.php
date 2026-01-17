@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    @include('plantilla.style')
    <header class="header" >
        @include('plantilla.link')
        <h1 id="title" class="text-center"> <a href="{{ URL::route(Route::current()->getName()) }}">@yield('title')</a>
        </h1>
        <p id="description" class="text-center">
            @yield('desc')
        </p>
    </header>

@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>

@stop

@livewireStyles

@section('css')

@stop

@section('js')

    @include('plantilla.script')


    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>

@livewireScripts
@stop
