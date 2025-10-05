@extends('frontend.layouts.app')

@section('content')

<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
                    <li class="list-inline-item text-white h3 font-secondary nasted">Our Photos</li>
                </ul>
                <p class="text-lighten mb-0">Get inspired and learn from the best.</p>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- gallery -->
<section class="section-sm">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-6 mb-4">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQi8X7QCQGsf_omaTDvvggoF5M5OWIHZzxMRC9MwX1rNsjPGY7ULeLr5GDRXryIAmWD9Z4&usqp=CAU" class="img-fluid rounded" alt="Gallery Image 1">
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToxkfT7QOoKRJifKg3KSbrQaPpGb6FwVPNUQ&s" class="img-fluid rounded" alt="Gallery Image 2">
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQft2vuU4YfVJQva-0j1x889GmSg-SuULTLZA&s" class="img-fluid rounded" alt="Gallery Image 3">
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <img src="https://continentalhospitals.com/images/blogs/d48f6d324d0c832eac5b0ee20184dff4.jpg" class="img-fluid rounded" alt="Gallery Image 4">
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <img src="https://info.totalwellnesshealth.com/hubfs/MentalHeatlh.png" class="img-fluid rounded" alt="Gallery Image 5">
            </div>
            <div class="col-lg-4 col-sm-6 mb-4">
                <img src="https://www.eventbrite.com/blog/wp-content/uploads/2022/06/rooftop-yoga.jpg" class="img-fluid rounded" alt="Gallery Image 6">
            </div>
        </div>
    </div>
</section>
<!-- /gallery -->

@endsection