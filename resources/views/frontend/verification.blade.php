@extends('frontend.layouts.app')

@section('content')
<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <ul class="list-inline custom-breadcrumb mb-2">
          <li class="list-inline-item">
            <a class="h2 text-primary font-secondary" href="/">Home</a>
          </li>
          <li class="list-inline-item text-white h3 font-secondary nasted">Verify Your Certificate</li>
        </ul>
        <p class="text-lighten mb-0">Enter your registered Email and Enrollment Number to verify your certificate.</p>
      </div>
    </div>
  </div>
</section>

<!-- Verify Form -->
<section class="section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow p-4">
          <h4 class="text-center mb-4">Verify Your Certificate</h4>
          <form action="{{ route('frontend.verify.certificate') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="course_id" class="form-label">Select Your Course</label>
              <select name="course_id" id="course_id" class="form-control" required>
                <option value="">Choose your course</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}">{{ $course->course_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Registered Email</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
              <label for="enrollment_no" class="form-label">Enrollment Number</label>
              <input type="text" name="enrollment_no" id="enrollment_no" class="form-control" placeholder="Enter your enrollment number" required>
            </div>

            <div class="text-center">
              <button type="submit" class="btn btn-primary">View Certificate</button>
            </div>
          </form>


          @if(session('error'))
          <div class="alert alert-danger mt-3 text-center">{{ session('error') }}</div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection