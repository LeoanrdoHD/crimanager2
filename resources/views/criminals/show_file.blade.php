@extends('adminlte::page')
@vite('resources/css/app.css')

@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">FICHA DEL DELINCUENTE: {{ $criminal->first_name }} {{ $criminal->last_name }}</h1>  

@stop
