@extends('frontend.layouts.app')

@section('content')

<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="/">Home</a></li>
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
        <div class="row justify-content-center">
            <!-- course item -->
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card p-0 border-primary rounded-0 hover-shadow">
                    <img class="card-img-top rounded-0" src="{{ asset('frontend/images/courses/course-1.jpg') }}" alt="course thumb">
                    <div class="card-body">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>12 Months</li>
                            <li class="list-inline-item"><a class="text-color" href="#">Technical Education</a></li>
                        </ul>
                        <a href="#">
                            <h4 class="card-title">Diploma in Welding Technology</h4>
                        </a>
                        <p class="card-text mb-4">
                            Learn the art and science of industrial welding techniques and fabrication processes to build strong foundations in technical craftsmanship.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm">Apply now</a>
                    </div>
                </div>
            </div>

            <!-- course item -->
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card p-0 border-primary rounded-0 hover-shadow">
                    <img class="card-img-top rounded-0" src="{{ asset('frontend/images/courses/course-2.jpg') }}" alt="course thumb">
                    <div class="card-body">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>24 Months</li>
                            <li class="list-inline-item"><a class="text-color" href="#">Agriculture Education</a></li>
                        </ul>
                        <a href="#">
                            <h4 class="card-title">Diploma in Horticulture</h4>
                        </a>
                        <p class="card-text mb-4">
                            Gain expertise in plant cultivation, nursery management, and sustainable agricultural techniques for a greener future.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm">Apply now</a>
                    </div>
                </div>
            </div>

            <!-- course item -->
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card p-0 border-primary rounded-0 hover-shadow">
                    <img class="card-img-top rounded-0" src="{{ asset('frontend/images/courses/course-3.jpg') }}" alt="course thumb">
                    <div class="card-body">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>12 Months</li>
                            <li class="list-inline-item"><a class="text-color" href="#">Office Management</a></li>
                        </ul>
                        <a href="#">
                            <h4 class="card-title">Diploma in Office Computer Operator</h4>
                        </a>
                        <p class="card-text mb-4">
                            Learn essential office software, data management, and documentation skills to efficiently manage professional environments.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm">Apply now</a>
                    </div>
                </div>
            </div>

            <!-- course item -->
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card p-0 border-primary rounded-0 hover-shadow">
                    <img class="card-img-top rounded-0" src="{{ asset('frontend/images/courses/course-4.jpg') }}" alt="course thumb">
                    <div class="card-body">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>24 Months</li>
                            <li class="list-inline-item"><a class="text-color" href="#">Automobile Education</a></li>
                        </ul>
                        <a href="#">
                            <h4 class="card-title">Diploma in Automobile Technology</h4>
                        </a>
                        <p class="card-text mb-4">
                            Explore modern automobile systems, vehicle maintenance, and emerging automotive technologies for a successful career.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm">Apply now</a>
                    </div>
                </div>
            </div>

            <!-- course item -->
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card p-0 border-primary rounded-0 hover-shadow">
                    <img class="card-img-top rounded-0" src="{{ asset('frontend/images/courses/course-5.jpg') }}" alt="course thumb">
                    <div class="card-body">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>12 Months</li>
                            <li class="list-inline-item"><a class="text-color" href="#">Fire & Safety</a></li>
                        </ul>
                        <a href="#">
                            <h4 class="card-title">Diploma in Fire & Safety</h4>
                        </a>
                        <p class="card-text mb-4">
                            Train in fire prevention, industrial safety, and emergency management techniques to ensure safe working environments.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm">Apply now</a>
                    </div>
                </div>
            </div>

            <!-- course item -->
            <div class="col-lg-4 col-sm-6 mb-5">
                <div class="card p-0 border-primary rounded-0 hover-shadow">
                    <img class="card-img-top rounded-0" src="{{ asset('frontend/images/courses/course-6.jpg') }}" alt="course thumb">
                    <div class="card-body">
                        <ul class="list-inline mb-2">
                            <li class="list-inline-item"><i class="ti-calendar mr-1 text-color"></i>24 Months</li>
                            <li class="list-inline-item"><a class="text-color" href="#">Hotel Management</a></li>
                        </ul>
                        <a href="#">
                            <h4 class="card-title">Diploma in Hotel Management & Catering Science</h4>
                        </a>
                        <p class="card-text mb-4">
                            Master hospitality operations, culinary skills, and guest relations to build a rewarding career in the hotel industry.
                        </p>
                        <a href="#" class="btn btn-primary btn-sm">Apply now</a>
                    </div>
                </div>
            </div>
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