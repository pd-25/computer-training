@extends('frontend.layouts.app')
@section('title', 'Franchise Opportunities')
@section('content')
<!-- page title -->
<section class="page-title-section overlay" data-background="{{ asset('frontend/images/backgrounds/page-title.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-inline custom-breadcrumb mb-2">
                    <li class="list-inline-item"><a class="h2 text-primary font-secondary" href="{{ url('/') }}">Home</a></li>
                    <li class="list-inline-item text-white h3 font-secondary nasted">Franchise</li>
                </ul>
                <p class="text-lighten mb-0">Join our growing network of education partners.</p>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->


<!-- franchise requirements -->
<section class="section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="{{ asset('frontend/images/about/about-page.jpg') }}" alt="Franchise Requirements" class="img-fluid rounded shadow">
            </div>
            <div class="col-lg-6">
                <h2 class="section-title">Franchise Requirements</h2>
                <p class="mb-4">We're looking for passionate individuals committed to educational excellence. Here's what you need:</p>
                <ul class="list-unstyled">
                    <li class="mb-3"><i class="ti-check-box text-primary mr-2"></i> <strong>Investment:</strong> Initial investment starting from $50,000</li>
                    <li class="mb-3"><i class="ti-check-box text-primary mr-2"></i> <strong>Space:</strong> Minimum 1,500 sq ft facility in a commercial area</li>
                    <li class="mb-3"><i class="ti-check-box text-primary mr-2"></i> <strong>Background:</strong> Education or business management experience preferred</li>
                    <li class="mb-3"><i class="ti-check-box text-primary mr-2"></i> <strong>Commitment:</strong> Full-time dedication to growing the franchise</li>
                    <li class="mb-3"><i class="ti-check-box text-primary mr-2"></i> <strong>Passion:</strong> Genuine interest in education and community development</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- /franchise requirements -->

<!-- application form -->
<section class="section bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <h2 class="section-title">Apply for Franchise</h2>
                <p class="mb-4">Take the first step towards owning your own education franchise. Fill out the form below and our franchise team will contact you within 24-48 hours.</p>

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <form action="{{ route('frontend.franchise.submit') }}" method="POST" class="row" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control mb-3 @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter your name" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control mb-3 @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" placeholder="Enter your email" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control mb-3 @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" placeholder="Enter phone number" required>
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Profile Image <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control mb-3 @error('image') is-invalid @enderror" accept="image/*" required>
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City <span class="text-danger">*</span></label>
                        <input type="text" name="city" class="form-control mb-3 @error('city') is-invalid @enderror"
                            placeholder="City*" value="{{ old('city') }}" required>
                        @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <input type="text" name="state" class="form-control mb-3 @error('state') is-invalid @enderror"
                            placeholder="State/Province" value="{{ old('state') }}">
                        @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <input type="number" name="investment" class="form-control mb-3 @error('investment') is-invalid @enderror"
                            placeholder="Available Investment Amount*" value="{{ old('investment') }}" min="0" step="1000" required>
                        @error('investment')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <input type="text" name="experience" class="form-control mb-3 @error('experience') is-invalid @enderror"
                            placeholder="Enter Your Organization or Institution Name*" value="{{ old('experience') }}">
                        @error('experience')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <textarea name="message" class="form-control mb-3 @error('message') is-invalid @enderror"
                            rows="5" placeholder="Tell us why you're interested in our franchise and any questions you have...">{{ old('message') }}</textarea>
                        @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input @error('terms') is-invalid @enderror"
                                id="terms" name="terms" {{ old('terms') ? 'checked' : '' }} required>
                            <label class="custom-control-label" for="terms">
                                I agree to receive information about franchise opportunities
                            </label>
                            @error('terms')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">SUBMIT APPLICATION</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow mb-4">
                    <div class="card-body">
                        <h4 class="mb-3">Franchise Support Office</h4>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <i class="ti-location-pin mr-2 text-primary"></i>
                                <small>Sankar Azan Path, Hatigaon, Bhetapara Road, Near Hatigaon police station , PO- Hatigaon. Guwahati, Assam, 781038</small>
                            </li>
                            <li class="mb-3">
                                <i class="ti-email mr-2 text-primary"></i>
                                <small>niteducation2024@gmail.com</small>
                            </li>
                            <li class="mb-3">
                                <i class="ti-mobile mr-2 text-primary"></i>
                                <small>+9864077781</small>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- <div class="card border-0 shadow">
          <div class="card-body">
            <h4 class="mb-3">Download Brochure</h4>
            <p class="mb-3">Get detailed information about our franchise opportunities.</p>
            <a href="{{ asset('downloads/franchise-brochure.pdf') }}" class="btn btn-outline-primary btn-block" download>
              <i class="ti-download mr-2"></i>Download PDF
            </a>
          </div>
        </div> -->
            </div>
        </div>
    </div>
</section>
<!-- /application form -->


<!-- franchise info -->
<section class="section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Why Partner With Us?</h2>
                <p class="mb-5">Join a proven education brand and build a successful business while making a difference in your community.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <i class="ti-medall icon text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4>Proven Brand</h4>
                        <p>Benefit from our established reputation and proven educational methodology trusted by thousands of students.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <i class="ti-book icon text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4>Complete Training</h4>
                        <p>Comprehensive training program covering operations, curriculum delivery, and business management.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <i class="ti-headphone-alt icon text-primary mb-3" style="font-size: 3rem;"></i>
                        <h4>Ongoing Support</h4>
                        <p>Dedicated support team to help you succeed with marketing, operations, and academic guidance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /franchise info -->

@endsection