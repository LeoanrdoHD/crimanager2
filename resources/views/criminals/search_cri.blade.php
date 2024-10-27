@extends('adminlte::page')
@vite('resources/css/app.css')
@section('title', 'Crimanager')

@section('content_header')
    <h1>BUSQUEDA DE DELINCUENTE</h1>
@stop

@section('content')
    <ul>
        @foreach ($criminals as $criminal)
        <li>
         {{$criminal->first_name}}
         {{$criminal->last_name}}
         {{$criminal->identity_number}}
        </li>
            
        @endforeach  

    </ul> 
@stop