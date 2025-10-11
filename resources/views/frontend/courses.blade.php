@extends('frontend.layouts.app')

@section('title', $category->name . ' Courses')

<style>
    .course-description {
        text-align: justify;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

@section('content')

<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
                    <li class="list-inline-item text-primary h3 font-secondary nasted">{{ $category->name }}</li>
                    <li class="list-inline-item text-white h3 font-secondary nasted">Courses</li>
                </ul>
                <p class="text-lighten mb-0">Our courses offer a good compromise between the continuous assessment favoured by some universities and the emphasis placed on final exams by others.</p>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->



<!-- courses -->
<section class="section-sm">
    <div class="container">

        <!-- course list -->
        <div class="row justify-content-start">
            <!-- course item -->
            @foreach ($courses as $course)
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card p-0 border-primary rounded-0 hover-shadow">
                    <img class="card-img-top rounded-0" src="{{asset('storage/'.$course->image)}}" alt="course thumb">
                    <div class="card-body">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>{{ $course->duration }}</li>
                            <li class="list-inline-item"><a class="text-color" href="#">{{ $course->category->name }}</a></li>
                        </ul>
                        <a href="{{route('frontend.courses.details', $course->slug)}}">
                            <h4 class="card-title">{{ $course->course_name }}</h4>
                        </a>
                        <p class="card-text mb-4 course-description">
                            {{ $course->description }}
                        </p>
                        <a href="{{route('frontend.courses.details', $course->slug)}}" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- /course list -->
        <!-- mobile see all button -->
        <div class="row">
            <div class="col-12 text-center">
                <a href="courses.html" class="btn btn-sm btn-outline-primary d-sm-none d-inline-block">sell all</a>
            </div>
        </div>
    </div>
</section>
<!-- /courses -->


@endsection