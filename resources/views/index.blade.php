@extends('master')

@section('content_header')
    <h1>Sites</h1>
@stop

@section('content')
    @parent
        @auth
            <script>window.location = "/sites";</script>
        @else
            Você ainda não fez seu login com a senha única USP <a href="/senhaunica/login"> Faça seu Login! </a>
        @endauth
@stop
