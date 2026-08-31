@extends('subadmin.layout.main')
@section('title', 'Dashboard | ')
@section('content')
    <section class="section dashboard">

        <div class="row">

          
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card sales-card">

                    <div class="card-body">
                        <h5 class="card-title">Total Students</h5>

                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-group-fill"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{ $totalStudents }}</h6>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            @if(Auth::guard('subadmin')->user()->affiliation == 1)
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">Affiliation Certificate</h5>
                        <div class="d-flex align-items-center">
                             <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-check"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Granted</h6>
                                <span class="text-success small pt-1 fw-bold">Active</span>
                                <div class="mt-2">
                                     <a href="{{ route('subadmin.affiliation.certificate') }}" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bi bi-download"></i> Download / Print
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(Auth::guard('subadmin')->user()->id_card_status == 1)
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title">ID Card</h5>
                        <div class="d-flex align-items-center">
                             <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-person-badge"></i>
                            </div>
                            <div class="ps-3">
                                <h6>Generated</h6>
                                <span class="text-success small pt-1 fw-bold">Active</span>
                                <div class="mt-2">
                                     <a href="{{ route('subadmin.my_idcard') }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="bi bi-download"></i> View / Download
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

    </section>
@endsection
