@extends('adminlte::page')

@section('title', 'Elashes')

@section('content_header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <h1>Home</h1>
@stop

@section('content')
    <div id="app">
    
        <example-component> </example-component>
    </div>
@stop

@section('css')
    
    
@stop

@section('js')

    
@stop