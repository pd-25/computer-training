<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="utf-8">
  <title>@yield('title', 'National institute of technical education')</title>

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

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('./logo.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('./logo.png') }}" type="image/png">

  <style>
    .whatsapp-float {
      position: fixed;
      width: 60px;
      height: 60px;
      bottom: 25px;
      right: 25px;
      background-color: #25d366;
      color: #fff;
      border-radius: 50%;
      text-align: center;
      font-size: 30px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
      z-index: 1000;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease-in-out;
    }

    .whatsapp-float:hover {
      background-color: #20ba5a;
      transform: scale(1.1);
    }
  </style>
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

  <!-- WhatsApp Floating Button -->
  <a href="https://wa.me/9864077781" target="_blank" class="whatsapp-float" title="Chat on WhatsApp">
    <img src="{{asset('assets/wp.png')}}" width="40" alt="">
  </a>

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