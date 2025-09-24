@extends('frontend.layouts.app')

@section('content')
<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <ul class="list-inline custom-breadcrumb mb-2">
          <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="index.html">Home</a></li>
          <li class="list-inline-item text-white h3 font-secondary nasted">Contact</li>
        </ul>
        <p class="text-lighten mb-0">Get in touch with us.</p>
      </div>
    </div>
  </div>
</section>
<!-- /page title -->

<!-- contact -->
<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mb-4 mb-lg-0">
        <h2 class="section-title">Contact With Us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione numquam ipsam recusandae a sint officiis, laudantium esse suscipit animi aperiam. Culpa in assumenda tempore, eligendi doloremque. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio, quidem.</p>
        <form action="#" class="row">
          <div class="col-md-6">
            <input type="text" class="form-control mb-3" placeholder="Your Name">
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control mb-3" placeholder="Your Email">
          </div>
          <div class="col-12">
            <input type="text" class="form-control mb-3" placeholder="Subject">
          </div>
          <div class="col-12">
            <textarea name="message" class="form-control mb-3" placeholder="Your Message"></textarea>
          </div>
          <div class="col-12">
            <button class="btn btn-primary">SEND MESSAGE</button>
          </div>
        </form>
      </div>
      <div class="col-lg-4">
        <h2 class="section-title">Our Office</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione numquam ipsam recusandae a sint officiis, laudantium esse suscipit animi aperiam.</p>
        <ul class="list-unstyled">
          <li class="mb-2"><i class="ti-location-pin mr-3 text-primary"></i>23621 15 Mile Rd #C104, Clinton MI, 48035, New York, USA</li>
          <li class="mb-2"><i class="ti-email mr-3 text-primary"></i>Email: contact@edublink.com</li>
          <li class="mb-2"><i class="ti-mobile mr-3 text-primary"></i>Phone:+1 (2) 345 6789</li>
        </ul>
        <img src="{{ asset('frontend/images/about/about-page.jpg') }}" alt="google map" class="img-fluid w-100">
      </div>
    </div>
  </div>
</section>
<!-- /contact -->
@endsection
