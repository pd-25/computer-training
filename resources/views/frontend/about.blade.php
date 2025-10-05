@extends('frontend.layouts.app')

@section('content')
<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <ul class="list-inline custom-breadcrumb mb-2">
          <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
          <li class="list-inline-item text-white h3 font-secondary nasted">About Us</li>
        </ul>
        <p class="text-lighten mb-0">Our courses offer a good compromise between the continuous assessment favoured by some universities and the emphasis placed on final exams by others.</p>
      </div>
    </div>
  </div>
</section>
<!-- /page title -->

<!-- about -->
<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <img class="img-fluid w-100 mb-4" src="{{ asset('frontend/images/about/about-page.jpg') }}" alt="about image">
        <h2 class="section-title">ABOUT OUR JOURNY</h2>
        <p>Welcome to United Social Empowered Education (USEE) — an institution built on the belief that true learning inspires transformation. Our goal is to redefine education by empowering both individuals and communities through creative and impactful learning opportunities.</p>
        <p>We go beyond traditional academics, combining excellence in education with a strong sense of social purpose. At USEE, we cultivate a culture of lifelong learning and encourage students to use their knowledge to bring meaningful change to the world around them.</p>
      </div>
    </div>
  </div>
</section>
<!-- /about -->

<!-- funfacts -->
<section class="section-sm bg-primary">
  <div class="container">
    <div class="row">
      <!-- funfacts item -->
      <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
        <div class="text-center">
          <h2 class="count text-white" data-count="60">0</h2>
          <h5 class="text-white">TEACHERS</h5>
        </div>
      </div>
      <!-- funfacts item -->
      <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
        <div class="text-center">
          <h2 class="count text-white" data-count="50">0</h2>
          <h5 class="text-white">COURSES</h5>
        </div>
      </div>
      <!-- funfacts item -->
      <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
        <div class="text-center">
          <h2 class="count text-white" data-count="1000">0</h2>
          <h5 class="text-white">STUDENTS</h5>
        </div>
      </div>
      <!-- funfacts item -->
      <div class="col-md-3 col-sm-6 mb-4 mb-md-0">
        <div class="text-center">
          <h2 class="count text-white" data-count="3737">0</h2>
          <h5 class="text-white">SATISFIED CLIENT</h5>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /funfacts -->

<!-- success story -->
<section class="section bg-cover" data-background="{{ asset('frontend/images/backgrounds/success-story.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-sm-4 position-relative success-video">
        <a class="play-btn venobox" href="https://youtu.be/nA1Aqp0sPQo" data-vbtype="video">
          <i class="ti-control-play"></i>
        </a>
      </div>
      <div class="col-lg-6 col-sm-8">
        <div class="bg-white p-5">
          <h2 class="section-title">Success Stories</h2>
          <p>
            At <strong>United Social Empowered Education (USEE)</strong>, every success story begins with a dream — a dream to learn, grow, and create a better future. Over the years, we’ve helped thousands of learners turn their aspirations into achievements through quality education, skill development, and personal empowerment.
          </p>
          <p>
            One inspiring example is <strong>Anita Das</strong>, a student from a small town who joined our <em>Diploma in Office Management</em> course. With dedicated mentorship and hands-on training, Anita not only secured a stable job but also became a mentor for other young women in her community. Her journey reflects the heart of our mission — transforming education into empowerment.
          </p>
          <p>
            At USEE, we believe success is not just about individual growth, but about creating waves of positive change that uplift entire communities. Every student who walks through our doors carries the potential to become a beacon of hope, leadership, and progress.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /success story -->

<!-- teachers -->
<section class="section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="section-title">Our Teachers</h2>
      </div>
      <!-- teacher -->
      <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card border-0 rounded-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/teachers/teacher-1.jpg') }}" alt="teacher">
          <div class="card-body">
            <a href="teacher-single.html">
              <h4 class="card-title">Jacke Masito</h4>
            </a>
            <div class="d-flex justify-content-between">
              <span>Teacher</span>
              <ul class="list-inline">
                <li class="list-inline-item"><a class="text-color" href="https://facebook.com/themefisher"><i class="ti-facebook"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://github.com/themefisher"><i class="ti-google"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://instagram.com/themefisher/"><i class="ti-linkedin"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- teacher -->
      <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card border-0 rounded-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/teachers/teacher-2.jpg') }}" alt="teacher">
          <div class="card-body">
            <a href="teacher-single.html">
              <h4 class="card-title">Clark Malik</h4>
            </a>
            <div class="d-flex justify-content-between">
              <span>Teacher</span>
              <ul class="list-inline">
                <li class="list-inline-item"><a class="text-color" href="https://facebook.com/themefisher"><i class="ti-facebook"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://github.com/themefisher"><i class="ti-google"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://instagram.com/themefisher/"><i class="ti-linkedin"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- teacher -->
      <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card border-0 rounded-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/teachers/teacher-3.jpg') }}" alt="teacher">
          <div class="card-body">
            <a href="teacher-single.html">
              <h4 class="card-title">John Doe</h4>
            </a>
            <div class="d-flex justify-content-between">
              <span>Teacher</span>
              <ul class="list-inline">
                <li class="list-inline-item"><a class="text-color" href="https://facebook.com/themefisher"><i class="ti-facebook"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://github.com/themefisher"><i class="ti-google"></i></a></li>
                <li class="list-inline-item"><a class="text-color" href="https://instagram.com/themefisher/"><i class="ti-linkedin"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /teachers -->


@endsection