@extends('frontend.layouts.app')

@section('title', 'All Course Categories')

@section('content')

<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
                    <li class="list-inline-item text-white h3 font-secondary nasted">All Categories</li>
                    <p class="text-lighten mb-0">Our courses offer a good compromise between the continuous assessment favoured by some universities and the emphasis placed on final exams by others.</p>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- categories -->
<section class="section bg-gray">
    <div class="container">

        <div class="row justify-content-start">
            <!-- category -->
            @foreach ($categories as $category)
            <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
                <div class="card border-0 rounded-0 hover-shadow">
                    <div class="card-img position-relative">
                        <img class="card-img-top rounded-0" src="{{asset('storage/'.$category->image)}}" alt="category">
                        <div class="card-date"><i class="ti-book" style="font-size: 2.5rem;"></i></div>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('frontend.courses', $category->slug) }}">
                            <h4 class="card-title">{{$category->name}}</h4>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- /categories -->



@endsection