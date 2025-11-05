@extends('frontend.layouts.app')

@section('content')
<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <ul class="list-inline custom-breadcrumb mb-2">
          <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
          <li class="list-inline-item text-white h3 font-secondary nasted">Franchise Login</li>
        </ul>
        <p class="text-lighten mb-0">Our courses offer a good compromise between the continuous assessment favoured by some universities and the emphasis placed on final exams by others.</p>
      </div>
    </div>
  </div>
</section>
<!-- /page title -->



<!-- Login Form -->
<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="section-title">Franchise Login</h2>
      </div>
      <div class="col-6">
        <form action="{{route('subadmin.login')}}" class="row" method="post">
            @csrf

          <div class="col-lg-12">
            <input type="text" class="form-control mb-4" id="email" name="email" placeholder="Enter Email ID">
          </div>
          <div class="col-lg-12">
            <input type="password" class="form-control mb-4" id="password" name="password" placeholder="Enter Provided Password">
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- /Login Form -->





@endsection