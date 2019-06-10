<!DOCTYPE html>
<html>
<head>
  <title>@yield('title', 'Weibo App') - Laravel 入门教程</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body>
@include('layouts._header')
@include('shared._messages')

<div class="container">
  <div class="offset-md-1 col-md-10">
    @yield('content')
    @include('layouts._footer')
  </div>
</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>