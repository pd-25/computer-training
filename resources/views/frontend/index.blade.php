@extends('frontend.layouts.app')

@section('content')
<!-- hero slider -->
<section class="hero-section overlay bg-cover" data-background="{{ asset('frontend/images/banner/banner-1.jpg') }}">
  <div class="container">
    <div class="hero-slider">
      <!-- ===== Hero Carousel Slides ===== -->
      <div class="hero-slider">

        <!-- 1 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Empower Your Skills with Technical Education</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Learn in-demand trades like welding, printing, and electronics — build a career that stands strong in today’s industrial world.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 2 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Agriculture – The Root of Growth</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Master modern farming, horticulture, and agricultural technology to shape the future of sustainable food production.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 3 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Turn Passion into Profession</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                From beauty therapy to fashion and textile design — explore creative career paths that inspire and empower.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 4 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Step Into the Digital Era</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Join our computer and office management programs to become the digital backbone of any organization.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 5 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Safety First, Always</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Gain expertise in fire and safety management — because saving lives is the ultimate responsibility.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 6 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Hospitality with Heart</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Train with our hotel and tourism management programs to deliver excellence in global hospitality and tourism.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 7 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Ayurveda & Wellness Science</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Discover ancient healing with modern touch — study Ayurveda, Panchakarma, and therapeutic massage techniques.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 8 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Design Spaces that Inspire</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Learn interior and exterior design to create beautiful, functional environments that reflect creativity and balance.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 9 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">Power Up Your Career</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                Become a skilled electrician, technician, or mobile expert — drive the world of modern electrical innovation.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

        <!-- 10 -->
        <div class="hero-slider-item">
          <div class="row">
            <div class="col-md-8">
              <h1 class="text-white" data-animation-in="fadeInLeft" data-delay-in=".1">The Future Begins with Learning</h1>
              <p class="text-muted mb-4" data-animation-in="fadeInLeft" data-delay-in=".4">
                From technology to traditional arts, our diverse diploma courses open endless doors to opportunity.
              </p>
              <a href="{{ route('frontend.contact') }}" class="btn btn-primary" data-animation-in="fadeInLeft" data-delay-in=".7">Apply Now</a>
            </div>
          </div>
        </div>

      </div>
      <!-- ===== End Hero Carousel ===== -->

    </div>
  </div>
</section>
<!-- /hero slider -->

<!-- banner-feature -->
<section class="bg-gray overflow-md-hidden">
  <div class="container-fluid p-0">
    <div class="row no-gutters">
      <div class="col-xl-4 col-lg-5 align-self-end">
        <img class="img-fluid w-100" src="{{ asset('frontend/images/banner/banner-feature.png') }}" alt="banner-feature">
      </div>
      <div class="col-xl-8 col-lg-7">
        <div class="row feature-blocks bg-gray justify-content-between">

          <!-- 1 -->
          <div class="col-sm-6 col-xl-5 mb-xl-5 mb-lg-3 mb-4 text-center text-sm-left">
            <i class="ti-book mb-xl-4 mb-lg-3 mb-4 feature-icon"></i>
            <h3 class="mb-xl-4 mb-lg-3 mb-4">Scholarship Updates</h3>
            <p>Get the latest news on available scholarships and financial aid programs to support your educational journey and career growth.</p>
          </div>

          <!-- 2 -->
          <div class="col-sm-6 col-xl-5 mb-xl-5 mb-lg-3 mb-4 text-center text-sm-left">
            <i class="ti-blackboard mb-xl-4 mb-lg-3 mb-4 feature-icon"></i>
            <h3 class="mb-xl-4 mb-lg-3 mb-4">Notice Board</h3>
            <p>Stay informed with our latest announcements — including exam schedules, course updates, and important institutional notices.</p>
          </div>

          <!-- 3 -->
          <div class="col-sm-6 col-xl-5 mb-xl-5 mb-lg-3 mb-4 text-center text-sm-left">
            <i class="ti-agenda mb-xl-4 mb-lg-3 mb-4 feature-icon"></i>
            <h3 class="mb-xl-4 mb-lg-3 mb-4">Our Achievements</h3>
            <p>We are proud of our students’ success stories — from top exam results to professional placements across leading industries.</p>
          </div>

          <!-- 4 -->
          <div class="col-sm-6 col-xl-5 mb-xl-5 mb-lg-3 mb-4 text-center text-sm-left">
            <i class="ti-write mb-xl-4 mb-lg-3 mb-4 feature-icon"></i>
            <h3 class="mb-xl-4 mb-lg-3 mb-4">Admissions Open</h3>
            <p>Join our growing community of learners. Explore diploma and certification courses designed to build your dream career.</p>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- /banner-feature -->

<!-- about us -->
<section class="section">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 order-2 order-md-1">
        <h2 class="section-title">About Us</h2>
        <p>Welcome to <strong>United Social Empowered Education (USEE)</strong> — an institution built on the belief that true learning inspires transformation. Our goal is to redefine education by empowering both individuals and communities through creative and impactful learning opportunities.</p>
        <p>We go beyond traditional academics, combining excellence in education with a strong sense of social purpose. At USEE, we cultivate a culture of lifelong learning and encourage students to use their knowledge to bring meaningful change to the world around them.</p>
        <a href="{{ route('frontend.about') }}" class="btn btn-outline-primary">Learn more</a>
      </div>
      <div class="col-md-6 order-1 order-md-2 mb-4 mb-md-0">
        <img class="img-fluid w-100" src="{{ asset('frontend/images/about/about-us.jpg') }}" alt="about image">
      </div>
    </div>
  </div>
</section>
<!-- /about us -->


<!-- courses -->
<section class="section-sm">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center section-title justify-content-between">
          <h2 class="mb-0 text-nowrap mr-3">Our Course</h2>
          <div class="border-top w-100 border-primary d-none d-sm-block"></div>
          <div>
            <a href="{{ route('frontend.courses') }}" class="btn btn-sm btn-outline-primary ml-sm-3 d-none d-sm-block">see all</a>
          </div>
        </div>
      </div>
    </div>
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
        <a href="{{ route('frontend.courses') }}" class="btn btn-sm btn-outline-primary d-sm-none d-inline-block">sell all</a>
      </div>
    </div>
  </div>
</section>
<!-- /courses -->

<!-- cta -->
<section class="section bg-primary">
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">
        <h6 class="text-white font-secondary mb-0">Click to Join the Advance Workshop</h6>
        <h2 class="section-title text-white">Training In Advannce Networking</h2>
        <a href="{{ route('frontend.contact') }}" class="btn btn-light">join now</a>
      </div>
    </div>
  </div>
</section>
<!-- /cta -->

<!-- success story -->
<section class="section bg-cover" data-background="{{ asset('frontend/images/backgrounds/success-story.jpg') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-sm-4 position-relative success-video">
        <a class="play-btn venobox" href="https://youtu.be/nA1Aqp0sPQo" data-vbtype="video">
          <i class="ti-control-play"></i>
        </a>
      </div>
      <div class="col-lg-6 col-sm-8">
        <div class="bg-white p-5">
          <h2 class="section-title">Success Stories</h2>
          <p>
            At <strong>United Social Empowered Education (USEE)</strong>, every success story begins with a dream — a dream to learn, grow, and create a better future. Over the years, we’ve helped thousands of learners turn their aspirations into achievements through quality education, skill development, and personal empowerment.
          </p>
          <p>
            One inspiring example is <strong>Anita Das</strong>, a student from a small town who joined our <em>Diploma in Office Management</em> course. With dedicated mentorship and hands-on training, Anita not only secured a stable job but also became a mentor for other young women in her community. Her journey reflects the heart of our mission — transforming education into empowerment.
          </p>
          <p>
            At USEE, we believe success is not just about individual growth, but about creating waves of positive change that uplift entire communities. Every student who walks through our doors carries the potential to become a beacon of hope, leadership, and progress.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /success story -->


<!-- events -->
<section class="section bg-gray">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="d-flex align-items-center section-title justify-content-between">
          <h2 class="mb-0 text-nowrap mr-3">Upcoming Events</h2>
          <div class="border-top w-100 border-primary d-none d-sm-block"></div>
          <div>
            <a href="{{ route('frontend.events') }}" class="btn btn-sm btn-outline-primary ml-sm-3 d-none d-sm-block">see all</a>
          </div>
        </div>
      </div>
    </div>
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


<!-- testimonials -->
<section class="section bg-light">
  <div class="container">
    <div class="row justify-content-center mb-5">
      <div class="col-12 text-center">
        <h2 class="mb-3">What People Say</h2>
        <p class="text-muted">Hear from our community about our social initiatives and events.</p>
      </div>
    </div>
    <div class="row">
      <!-- testimonial 1 -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <div class="d-flex align-items-center mb-3">
            <img src="https://wac-cdn.atlassian.com/dam/jcr:ba03a215-2f45-40f5-8540-b2015223c918/Max-R_Headshot%20(1).jpg?cdnVersion=3005" alt="User" class="rounded-circle mr-3" width="60" height="60">
            <div>
              <h5 class="mb-0">Ayesha Rahman</h5>
              <small class="text-muted">Volunteer</small>
            </div>
          </div>
          <p class="mb-0">“Participating in the child marriage awareness campaign was life-changing. The community support was incredible!”</p>
        </div>
      </div>
      <!-- testimonial 2 -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <div class="d-flex align-items-center mb-3">
            <img src="https://wac-cdn.atlassian.com/dam/jcr:ba03a215-2f45-40f5-8540-b2015223c918/Max-R_Headshot%20(1).jpg?cdnVersion=3005" alt="User" class="rounded-circle mr-3" width="60" height="60">
            <div>
              <h5 class="mb-0">Rafiq Hasan</h5>
              <small class="text-muted">Community Leader</small>
            </div>
          </div>
          <p class="mb-0">“The environmental campaign really helped raise awareness about local pollution issues. Truly inspiring!”</p>
        </div>
      </div>
      <!-- testimonial 3 -->
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card border-0 shadow-sm p-4 h-100">
          <div class="d-flex align-items-center mb-3">
            <img src="https://wac-cdn.atlassian.com/dam/jcr:ba03a215-2f45-40f5-8540-b2015223c918/Max-R_Headshot%20(1).jpg?cdnVersion=3005" alt="User" class="rounded-circle mr-3" width="60" height="60">
            <div>
              <h5 class="mb-0">Sadia Khan</h5>
              <small class="text-muted">Event Participant</small>
            </div>
          </div>
          <p class="mb-0">“I loved attending the women empowerment seminar. It gave me so much confidence to speak up in my community.”</p>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /testimonials -->



<!-- teachers -->
<!-- <section class="section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="section-title">Our Teachers</h2>
      </div> -->
<!-- teacher -->
<!-- <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card border-0 rounded-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/teachers/teacher-1.jpg') }}" alt="teacher">
          <div class="card-body">
            <a href="teacher-single.html">
              <h4 class="card-title">Jacke Masito</h4>
            </a>
            <p>Teacher</p>
            <ul class="list-inline">
              <li class="list-inline-item"><a class="text-color" href="https://facebook.com/themefisher"><i class="ti-facebook"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://github.com/themefisher"><i class="ti-google"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://instagram.com/themefisher/"><i class="ti-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div> -->
<!-- teacher -->
<!-- <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card border-0 rounded-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/teachers/teacher-2.jpg') }}" alt="teacher">
          <div class="card-body">
            <a href="teacher-single.html">
              <h4 class="card-title">Clark Malik</h4>
            </a>
            <p>Teacher</p>
            <ul class="list-inline">
              <li class="list-inline-item"><a class="text-color" href="https://facebook.com/themefisher"><i class="ti-facebook"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://github.com/themefisher"><i class="ti-google"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://instagram.com/themefisher/"><i class="ti-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div> -->
<!-- teacher -->
<!-- <div class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card border-0 rounded-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/teachers/teacher-3.jpg') }}" alt="teacher">
          <div class="card-body">
            <a href="teacher-single.html">
              <h4 class="card-title">John Doe</h4>
            </a>
            <p>Teacher</p>
            <ul class="list-inline">
              <li class="list-inline-item"><a class="text-color" href="https://facebook.com/themefisher"><i class="ti-facebook"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://github.com/themefisher"><i class="ti-google"></i></a></li>
              <li class="list-inline-item"><a class="text-color" href="https://instagram.com/themefisher/"><i class="ti-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div> -->
<!-- </div>
  </div>
</section> -->
<!-- /teachers -->

<!-- blog -->
<section class="section pt-0">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="section-title">Latest News</h2>
      </div>
    </div>
    <div class="row justify-content-center">
      <!-- blog post -->
      <article class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card rounded-0 border-bottom border-primary border-top-0 border-left-0 border-right-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/blog/post-1.jpg') }}" alt="Post thumb">
          <div class="card-body">
            <!-- post meta -->
            <ul class="list-inline mb-3">
              <li class="list-inline-item mr-3 ml-0">September 15, 2025</li>
              <li class="list-inline-item mr-3 ml-0">By Ayesha Rahman</li>
            </ul>
            <a href="blog-single.html">
              <h4 class="card-title">Child Marriage Awareness Rally in Dhaka</h4>
            </a>
            <p class="card-text">Local volunteers gathered to spread awareness about child marriage and promote education for all children.</p>
            <a href="blog-single.html" class="btn btn-primary btn-sm">read more</a>
          </div>
        </div>
      </article>
      <!-- blog post -->
      <article class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card rounded-0 border-bottom border-primary border-top-0 border-left-0 border-right-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/blog/post-2.jpg') }}" alt="Post thumb">
          <div class="card-body">
            <ul class="list-inline mb-3">
              <li class="list-inline-item mr-3 ml-0">September 22, 2025</li>
              <li class="list-inline-item mr-3 ml-0">By Rafiq Hasan</li>
            </ul>
            <a href="blog-single.html">
              <h4 class="card-title">Community Clean-Up Drive in Dhanmondi</h4>
            </a>
            <p class="card-text">Residents came together to clean local parks and lakes, raising awareness about environmental responsibility.</p>
            <a href="blog-single.html" class="btn btn-primary btn-sm">read more</a>
          </div>
        </div>
      </article>
      <!-- blog post -->
      <article class="col-lg-4 col-sm-6 mb-5 mb-lg-0">
        <div class="card rounded-0 border-bottom border-primary border-top-0 border-left-0 border-right-0 hover-shadow">
          <img class="card-img-top rounded-0" src="{{ asset('frontend/images/blog/post-3.jpg') }}" alt="Post thumb">
          <div class="card-body">
            <ul class="list-inline mb-3">
              <li class="list-inline-item mr-3 ml-0">October 1, 2025</li>
              <li class="list-inline-item mr-3 ml-0">By Sadia Khan</li>
            </ul>
            <a href="blog-single.html">
              <h4 class="card-title">Women Empowerment Workshop Success</h4>
            </a>
            <p class="card-text">A workshop focused on skill-building and leadership for women in the community saw enthusiastic participation.</p>
            <a href="blog-single.html" class="btn btn-primary btn-sm">read more</a>
          </div>
        </div>
      </article>
    </div>
  </div>
</section>
<!-- /blog -->

@endsection