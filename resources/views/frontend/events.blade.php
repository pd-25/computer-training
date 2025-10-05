@extends('frontend.layouts.app')

@section('content')

<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
                    <li class="list-inline-item text-white h3 font-secondary nasted">Events</li>
                </ul>
                <p class="text-lighten mb-0">Events are the most important part of our life.</p>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- events -->
<section class="section bg-gray">
    <div class="container">

        <div class="row justify-content-center">
            <!-- event -->
            <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
                <div class="card border-0 rounded-0 hover-shadow">
                    <div class="card-img position-relative">
                        <img class="card-img-top rounded-0" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTemWl2Ia4ID1_IiHuvbn4SBBi5_ZVZyXVSfQ&s" alt="event thumb">
                        <div class="card-date"><span>10</span><br>October</div>
                    </div>
                    <div class="card-body">
                        <!-- location -->
                        <p><i class="ti-location-pin text-primary mr-2"></i>Central Park, Dhaka</p>
                        <a href="{{ route('frontend.event-details') }}">
                            <h4 class="card-title">Child Marriage Awareness Protest</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- event -->
            <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
                <div class="card border-0 rounded-0 hover-shadow">
                    <div class="card-img position-relative">
                        <img class="card-img-top rounded-0" src="https://indiadidac.org/wp-content/uploads/2021/07/green-planet-your-hands-save-earth.jpg" alt="event thumb">
                        <div class="card-date"><span>15</span><br>October</div>
                    </div>
                    <div class="card-body">
                        <!-- location -->
                        <p><i class="ti-location-pin text-primary mr-2"></i>Greenfield Community Hall</p>
                        <a href="{{ route('frontend.event-details') }}">
                            <h4 class="card-title">Environmental Awareness Campaign</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- event -->
            <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
                <div class="card border-0 rounded-0 hover-shadow">
                    <div class="card-img position-relative">
                        <img class="card-img-top rounded-0" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQ-iw1crNeR8LQOT6-axx1S4Wu0FE2vEGoSw&s" alt="event thumb">
                        <div class="card-date"><span>20</span><br>October</div>
                    </div>
                    <div class="card-body">
                        <!-- location -->
                        <p><i class="ti-location-pin text-primary mr-2"></i>City Hall, Dhaka</p>
                        <a href="{{ route('frontend.event-details') }}">
                            <h4 class="card-title">Women Empowerment Seminar</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- event -->
            <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
                <div class="card border-0 rounded-0 hover-shadow">
                    <div class="card-img position-relative">
                        <img class="card-img-top rounded-0" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTemWl2Ia4ID1_IiHuvbn4SBBi5_ZVZyXVSfQ&s" alt="event thumb">
                        <div class="card-date"><span>10</span><br>October</div>
                    </div>
                    <div class="card-body">
                        <!-- location -->
                        <p><i class="ti-location-pin text-primary mr-2"></i>Central Park, Dhaka</p>
                        <a href="{{ route('frontend.event-details') }}">
                            <h4 class="card-title">Child Marriage Awareness Protest</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- event -->
            <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
                <div class="card border-0 rounded-0 hover-shadow">
                    <div class="card-img position-relative">
                        <img class="card-img-top rounded-0" src="https://indiadidac.org/wp-content/uploads/2021/07/green-planet-your-hands-save-earth.jpg" alt="event thumb">
                        <div class="card-date"><span>15</span><br>October</div>
                    </div>
                    <div class="card-body">
                        <!-- location -->
                        <p><i class="ti-location-pin text-primary mr-2"></i>Greenfield Community Hall</p>
                        <a href="{{ route('frontend.event-details') }}">
                            <h4 class="card-title">Environmental Awareness Campaign</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- event -->
            <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
                <div class="card border-0 rounded-0 hover-shadow">
                    <div class="card-img position-relative">
                        <img class="card-img-top rounded-0" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQQ-iw1crNeR8LQOT6-axx1S4Wu0FE2vEGoSw&s" alt="event thumb">
                        <div class="card-date"><span>20</span><br>October</div>
                    </div>
                    <div class="card-body">
                        <!-- location -->
                        <p><i class="ti-location-pin text-primary mr-2"></i>City Hall, Dhaka</p>
                        <a href="{{ route('frontend.event-details') }}">
                            <h4 class="card-title">Women Empowerment Seminar</h4>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile see all button -->
        <div class="row">
            <div class="col-12 text-center">
                <a href="course.html" class="btn btn-sm btn-outline-primary d-sm-none d-inline-block">see all</a>
            </div>
        </div>
    </div>
</section>
<!-- /events -->

@endsection