<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Traves">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Traves') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{mix("css/app.css")}}" rel="stylesheet">
    <link href="{{mix("css/admin/main.css")}}" rel="stylesheet">
    
    <script src="{{mix("js/app.js")}}"></script>
</head>
<body id="page-top" @isset($body_class) class="{{$body_class}}" @endisset>

    <!-- Page Wrapper -->
    <div id="wrapper">
        @auth
            @if(!isset($SHOW_SIDEBAR) OR $SHOW_SIDEBAR)
                @include('admin.parts.sidebar')
            @endif
        @endauth
        
       
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
            
                @include('admin.parts.topbar')
