@extends('frontend.layouts.app')

@section('title', $course->course_name . '-' . $course->category->name)

@section('content')

<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
                    <li class="list-inline-item text-white h3 font-secondary nasted">Course Details</li>
                </ul>
                <p class="text-lighten mb-0">{{ $course->course_name }}</p>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- single event -->
<section class="section">
    <div class="container">
        <div class="row">
            <!-- Event Image -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('storage/'.$course->image) }}" alt="Event Image" class="img-fluid rounded">
            </div>

            <!-- Course Details -->
            <div class="col-lg-6">
                <h2 class="mb-3">{{ $course->course_name }}</h2>
                <p class="text-muted m-0"><i class="ti-timer mr-2"></i>{{ $course->duration }}</p>
                <p class="text-muted m-0"><i class="ti-list mr-2"></i>{{ $course->category->name }}</p>

                <h5 class="mt-4">Course Description</h5>
                <p>
                    {{ $course->description }}
                </p>

                <h5 class="mt-4">Contact & Registration</h5>
                <p>For more information and to register, contact us at <a href="mailto:">info@xyz.org</a></p>

                <a href="#" class="btn btn-primary mt-3">Apply Now</a>
            </div>
        </div>
    </div>
</section>
<!-- /single event -->

@endsection