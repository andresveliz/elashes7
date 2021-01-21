@extends('adminlte::page')

@section('title', 'Elashes')

@section('content_header')
<meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>Operadores</h1>
@stop

@section('content')
<div id="app">
<operadores-component> </operadores-component>
</div>
@stop

@section('css')
    
    
@stop

@section('js')

    
@stop