<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('img/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('img/favicon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/responsive-en.css') }}">
    
    <!-- Scripts -->
    <script type="text/javascript" src="{{ URL::asset('js/jquery-1.12.4.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<?php
if($group = $user->groups()->first()):
  if($group->getBackground()){
      $logo = URL::asset($group->getBackground());
  }
endif; ?>
<body <?php if($logo): ?>style="background:url('{{$logo}}') no-repeat"<?php endif; ?>>
    @include('admin.nav')
    @yield('content')
</body>
</html>
