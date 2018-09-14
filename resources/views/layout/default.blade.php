<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'JCCM') }} | {{$page_title}}</title>

    <link href="https://fonts.googleapis.com/css?family=Abel|Open+Sans+Condensed:300" rel="stylesheet">
    <link rel="icon" href="{{ asset('img/fav1.jpg') }}" type="image/x-icon"/>
    <link rel="shortcut icon" href="{{ asset('img/fav1.jpg') }}" type="image/x-icon"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/global.css') }}" rel="stylesheet" type="text/css">
    @yield('css')
</head>

<body>

@yield('content')

<script src="{{asset('/js/app.js')}}"></script>
@yield('js')

</body>

</html>
