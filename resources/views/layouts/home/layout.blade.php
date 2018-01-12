<!DOCTYPE html>
<!-- Title -->
<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Required Meta Tags Always Come First -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">

<!-- Favicon -->
{{--<link rel="shortcut icon" href="favicon.ico">--}}


<!-- CSS Global Compulsory -->
<link rel="stylesheet" href="{{ asset('home') }}/assets/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('home') }}/assets/css/bootstrap-rtl.min.css">
<link rel="stylesheet" href="{{ asset('home') }}/assets/css/font-awesome.min.css">
<!-- CSS Global Icons -->
<!-- CSS Customization -->
<link rel="stylesheet" href="{{ asset('home') }}/assets/css/custom.css">
@yield('custom_styles')
<body>
@yield('content')

<script src="{{ asset('home') }}/assets/js/jquery-3.2.1.min.js"></script>
<script src="{{ asset('home') }}/assets/js/bootstrap.min.js"></script>
@yield('custom_scripts')
</body>


