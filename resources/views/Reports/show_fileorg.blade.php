@extends('adminlte::page')
@vite('resources/css/app.css')

@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">REGISTRO DE LA ORGANIZACION CRIMINA: {{ $criminal->first_name }} {{ $criminal->last_nameP }} {{ $criminal->last_nameM }}</h1>  

@stop

