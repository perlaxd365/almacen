@extends('layout')

@section('title', 'Página principal')

@section('icon', 'home')

@section('date', DateUtil::getFecha($carbon::parse(Date::now())))

@section('content')

    @livewire('index')

@endsection
