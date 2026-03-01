@extends('admin.layout.main')
@section('title', 'All Course Assigned Students')

<style>
    /* Alert */
    #alert-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .alert {
        min-width: 280px;
        max-width: 360px;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        color: #fff;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        animation: slideIn 0.4s ease, fadeOut 0.5s ease 4s forwards;
    }

    .alert-success {
        background-color: #16a34a !important;
        color: white !important;
        border: none;
    }

    .alert-danger {
        background-color: #dc2626 !important;
        color: white !important;
        border: none;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateX(0);
        }

        to {
            opacity: 0;
            transform: translateX(100%);
        }
    }

    .badge-subadmin {
        background-color: #6c757d;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
    }
</style>

@section('content')
<section class="section dashboard">

    <div class="row">
        <div class="col-xxl-12 col-md-12">
            <div class="card info-card sales-card">

                <div class="card-body">
                    <div class="d-flex justify-between align-items-center">
                        <h5 class="card-title w-100">All Course Assigned Students</h5>

                        <form action="{{ route('admin.student.assigned-students') }}" method="GET" class="w-50 d-flex gap-2">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search enrollment, email, name, or subadmin...">

                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Subadmin</th>
                                <th>Assigned Courses</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $students->firstItem() + $index }}</td>
                                <td style="text-transform: capitalize;">{{ $student->name }}</td>
                                <td>
                                    <p class="m-0 fw-bold">Enrollment: {{ $student->enrollment_no }}</p>
                                    <p class="m-0">Email: {{ $student->email }}</p>
                                </td>
                                <td>
                                    @if($student->subadmin)
                                        <p class="m-0"><strong style="text-transform: capitalize;">{{ $student->subadmin->org_name }}</strong></p>
                                        <p class="m-0"><strong style="text-transform: capitalize;">{{ $student->subadmin->name }}</strong></p>
                                        <small class="text-muted">{{ $student->subadmin->email }}</small>
                                    @else
                                        <span class="text-muted">No Subadmin</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!empty($student->assigned_course_id))
                                    <ul class="mb-0">
                                        @foreach($student->assigned_course_id as $courseId)
                                        @php
                                        $course = $courses->firstWhere('id', $courseId);
                                        @endphp
                                        @if($course)
                                        <li>Enrollment: <strong>{{ $course->course_unique_id }}</strong></li>
                                        <li>Name: <strong>{{ $course->course_name }}</strong></li>
                                        <li>Duration: <strong>{{ $course->duration }} Months</strong></li>
                                        <hr class="my-2">
                                        @endif
                                        @endforeach
                                    </ul>
                                    @else
                                    <span class="text-muted">No Courses Assigned</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <button class="btn btn-sm btn-success" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewIdCard{{ $student->id }}">
                                            <i class="bi bi-credit-card"></i> View ID
                                        </button>
                                        
                                        <button class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewMarksheet{{ $student->id }}">
                                            <i class="bi bi-file-earmark-text"></i> Marksheet
                                        </button>
                                        
                                        <button class="btn btn-sm btn-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewCertificate{{ $student->id }}">
                                            <i class="bi bi-award"></i> Certificate
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No students with assigned courses found.</td>
                            </tr>
                            @endforelse
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="d-flex justify-content-end">
                                        @if ($students->hasPages())
                                        <div class="d-flex justify-content-center align-items-center gap-2 mt-3">
                                            <!-- Prev Button -->
                                            <a href="{{ $students->appends(['search' => request('search')])->previousPageUrl() ?? '#' }}"
                                                class="btn btn-outline-primary btn-sm {{ $students->onFirstPage() ? 'disabled' : '' }}">
                                                Prev
                                            </a>

                                            <!-- Current Page Input -->
                                            <input type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ $students->currentPage() }}"
                                                readonly
                                                style="width: 60px;">

                                            <span>/</span>

                                            <!-- Last Page Input -->
                                            <input type="text"
                                                class="form-control form-control-sm text-center"
                                                value="{{ $students->lastPage() }}"
                                                readonly
                                                style="width: 60px;">

                                            <!-- Next Button -->
                                            <a href="{{ $students->appends(['search' => request('search')])->nextPageUrl() ?? '#' }}"
                                                class="btn btn-outline-primary btn-sm {{ !$students->hasMorePages() ? 'disabled' : '' }}">
                                                Next
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>

            </div>
        </div>
    </div>

    <!-- View ID Card Modal -->
    @foreach($students as $student)
    <div class="modal fade" id="viewIdCard{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View ID Card - {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if(!empty($student->assigned_course_id))
                    @foreach($student->assigned_course_id as $courseId)
                    @php
                    $course = $courses->firstWhere('id', $courseId);
                    @endphp
                    @if($course)
                    <div class="card mb-3">
                        <div class="card-header text-dark">
                            <strong>{{ $course->course_name }}</strong>
                            <small class="d-block">{{ $course->course_unique_id }} | Duration: {{ $course->duration }} Months</small>
                        </div>
                        <div class="card-body">
                            <button type="button"
                                class="btn btn-primary w-100"
                                onclick="window.open('{{ route('admin.student.id-card', ['student_id' => $student->id, 'course_id' => $courseId]) }}', '_blank')">
                                <i class="bi bi-eye"></i> View ID Card
                            </button>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        No courses assigned to this student.
                    </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

<!-- View Marksheet Modal -->
    @foreach($students as $student)
    <div class="modal fade" id="viewMarksheet{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Marksheet - {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if(!empty($student->assigned_course_id))
                    @foreach($student->assigned_course_id as $courseId)
                    @php
                    $course = $courses->firstWhere('id', $courseId);
                    if (!$course) continue;

                    $duration = (int)$course->duration;
                    $years = floor($duration / 12);
                    $remainingMonths = $duration % 12;

                    $availableMarks = \App\Models\Mark::where('student_id', $student->id)
                        ->where('course_id', $courseId)
                        ->pluck('year')
                        ->toArray();
                    @endphp

                    @if(!empty($availableMarks))
                    <div class="card mb-3">
                        <div class="card-header bg-primary text-white">
                            <strong>{{ $course->course_name }}</strong>
                            <small class="d-block">{{ $course->course_unique_id }} | Duration: {{ $course->duration }} Months</small>
                        </div>
                        <div class="card-body">
                            <label class="form-label fw-bold">Select Year/Duration:</label>

                            <div class="row">
                                @foreach($availableMarks as $yr)
                                @php
                                $label = "";
                                if ($duration < 12) {
                                    $label = $duration . " Month" . ($duration > 1 ? "s" : "");
                                } else {
                                    if ($yr <= $years) {
                                        $label = "Year " . $yr;
                                    } else if ($yr > $years && $remainingMonths > 0) {
                                        $label = $remainingMonths . " Month" . ($remainingMonths > 1 ? "s" : "");
                                    }
                                }
                                @endphp

                                <div class="col-md-12 mb-3 border rounded p-3">
                                    <p class="fw-bold mb-2">{{ $label }} Marksheet</p>

                                    <div class="row g-2 mb-2">
                                        <div class="col-md-4">
                                            <label class="form-label small">Session From</label>
                                            <input type="date" class="form-control form-control-sm"
                                                id="session_from_{{ $student->id }}_{{ $courseId }}_{{ $yr }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Session To</label>
                                            <input type="date" class="form-control form-control-sm"
                                                id="session_to_{{ $student->id }}_{{ $courseId }}_{{ $yr }}">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label small">Issue Date</label>
                                            <input type="date" class="form-control form-control-sm"
                                                id="issue_date_{{ $student->id }}_{{ $courseId }}_{{ $yr }}">
                                        </div>
                                    </div>

                                    <button type="button"
                                        class="btn btn-outline-primary w-100"
                                        onclick="openMarksheet({{ $student->id }}, {{ $courseId }}, {{ $yr }}, '{{ route('admin.student.marksheet', ['student_id' => $student->id, 'course_id' => $courseId]) }}')">
                                        <i class="bi bi-eye"></i> View {{ $label }} Marksheet
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        No marks available for <strong>{{ $course->course_name }}</strong>
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        No courses assigned to this student.
                    </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- View Certificate Modal -->
    @foreach($students as $student)
    <div class="modal fade" id="viewCertificate{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Certificate - {{ $student->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if(!empty($student->assigned_course_id))
                    @foreach($student->assigned_course_id as $courseId)
                    @php
                    $course = $courses->firstWhere('id', $courseId);
                    if (!$course) continue;

                    $hasMarks = \App\Models\Mark::where('student_id', $student->id)
                        ->where('course_id', $courseId)
                        ->exists();
                    @endphp

                    @if($hasMarks)
                    <div class="card mb-3">
                        <div class="card-header text-dark">
                            <strong>{{ $course->course_name }}</strong>
                            <small class="d-block">{{ $course->course_unique_id }} | Duration: {{ $course->duration }} Months</small>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <label class="form-label small">Issue Date Certificate</label>
                                <input type="date" class="form-control form-control-sm"
                                    id="issue_date_cert_{{ $student->id }}_{{ $courseId }}">
                            </div>
                            <button type="button"
                                class="btn btn-primary w-100"
                                onclick="openCertificate({{ $student->id }}, {{ $courseId }}, '{{ route('admin.student.certificate', ['student_id' => $student->id, 'course_id' => $courseId]) }}')">
                                <i class="bi bi-eye"></i> View Certificate
                            </button>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        No marks available for <strong>{{ $course->course_name }}</strong>. Certificate cannot be generated.
                    </div>
                    @endif
                    @endforeach
                    @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        No courses assigned to this student.
                    </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <script>
        function openMarksheet(studentId, courseId, year, baseUrl) {
            const sessionFrom = document.getElementById(`session_from_${studentId}_${courseId}_${year}`).value;
            const sessionTo   = document.getElementById(`session_to_${studentId}_${courseId}_${year}`).value;
            const issueDate   = document.getElementById(`issue_date_${studentId}_${courseId}_${year}`).value;

            if (!sessionFrom || !sessionTo || !issueDate) {
                alert('Please fill Session From, Session To, and Issue Date.');
                return;
            }

            const url = `${baseUrl}?year=${year}&session_from=${sessionFrom}&session_to=${sessionTo}&issue_date=${issueDate}`;
            window.open(url, '_blank');
        }

        function openCertificate(studentId, courseId, baseUrl) {
            const issueDateCert = document.getElementById(`issue_date_cert_${studentId}_${courseId}`).value;

            if (!issueDateCert) {
                alert('Please fill Issue Date Certificate.');
                return;
            }

            const url = `${baseUrl}?issue_date_certificate=${issueDateCert}`;
            window.open(url, '_blank');
        }
    </script>

    <!-- Alerts -->
    <div id="alert-container">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
        @endif
    </div>

    <!-- Alert -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.querySelectorAll("#alert-container .alert").forEach(el => {
                    el.remove();
                });
            }, 2500);
        });
    </script>

</section>
@endsection