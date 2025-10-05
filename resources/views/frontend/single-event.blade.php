@extends('frontend.layouts.app')

@section('content')

<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
                    <li class="list-inline-item text-white h3 font-secondary nasted">Event Details</li>
                </ul>
                <p class="text-lighten mb-0">Child Marriage Awareness Rally</p>
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
                <img src="{{ asset('frontend/images/events/event-1.jpg') }}" alt="Event Image" class="img-fluid rounded">
            </div>

            <!-- Event Details -->
            <div class="col-lg-6">
                <h2 class="mb-3">Child Marriage Awareness Rally</h2>
                <p class="text-muted m-0"><i class="ti-calendar mr-2"></i>October 10, 2025</p>
                <p class="text-muted m-0"><i class="ti-location-pin mr-2"></i>Central Park, Dhaka</p>

                <h5 class="mt-4">Event Description</h5>
                <p>
                    Join us in raising awareness about child marriage and promoting education for all children.
                    This rally will include speeches, educational workshops, and interactive sessions for the community.
                </p>

                <h5 class="mt-4">Contact & Registration</h5>
                <p>For more information and to register, contact us at <a href="mailto:info@socialevents.org">info@socialevents.org</a></p>

                <a href="{{ url('events') }}" class="btn btn-primary mt-3">Back to Events</a>
            </div>
        </div>
    </div>
</section>
<!-- /single event -->

@endsection