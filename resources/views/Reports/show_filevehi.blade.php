@extends('adminlte::page')
@vite('resources/css/app.css')

@section('title', 'Crimanager')

@section('content_header')
    <h1 class="text-center">REGISTRO DEL VEHICULO USADO POR: {{ $criminal->first_name }} {{ $criminal->last_nameP }} {{ $criminal->last_nameM }}</h1>  

@stop
