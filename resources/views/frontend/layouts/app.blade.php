<!DOCTYPE html>

<html lang="en">
<head>

  <meta charset="utf-8">
  <title>Educenter - Education HTML Template</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Construction Html5 Template">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
  <meta name="author" content="Themefisher">
  <meta name="generator" content="Themefisher Educenter HTML Template v1.0">
  
  <meta name="theme-name" content="educenter" />

  <link rel="stylesheet" href="{{ asset('frontend/plugins/bootstrap/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/plugins/slick/slick.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/plugins/themify-icons/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/plugins/animate/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/plugins/aos/aos.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/plugins/venobox/venobox.css') }}">

  <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

  <link rel="shortcut icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('frontend/images/favicon.png') }}" type="image/x-xicon">

</head>

<body>
  <div class="preloader">
    <img src="{{ asset('frontend/images/preloader.gif') }}" alt="preloader">
  </div>

  @if (request()->path() == '/')
    @include('frontend.partials.header')
  @else
    @include('frontend.partials.about_header')
  @endif

  @yield('content')

  @include('frontend.partials.footer')

  <script src="{{ asset('frontend/plugins/jQuery/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/plugins/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/plugins/slick/slick.min.js') }}"></script>
  <script src="{{ asset('frontend/plugins/aos/aos.js') }}"></script>
  <script src="{{ asset('frontend/plugins/venobox/venobox.min.js') }}"></script>
  <script src="{{ asset('frontend/plugins/filterizr/jquery.filterizr.min.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcABaamniA6OL5YvYSpB3pFMNrXwXnLwU"></script>
  <script src="{{ asset('frontend/plugins/google-map/gmap.js') }}"></script>

  <script src="{{ asset('frontend/js/script.js') }}"></script>

</body>
</html>
