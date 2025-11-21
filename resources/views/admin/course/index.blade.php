@extends('admin.layout.main')
@section('title', 'All Courses')

<style>
    .fixed-btn {
        position: fixed;
        bottom: 50px;
        right: 30px;
        width: 50px;
        height: 50px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 50%;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .fixed-btn:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

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
</style>
@section('content')
<section class="section dashboard">

    <div class="row">


        <div class="col-xxl-12 col-md-12">
            <div class="card info-card sales-card">

                <div class="card-body">
                    <div class="d-flex justify-between align-items-center">
                        <h5 class="card-title w-100">All Courses</h5>

                        <form action="{{ route('admin.courses') }}" method="GET" class="w-50 d-flex gap-2">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search id & name...">

                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Course ID</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Course Name</th>
                                    <th scope="col">Duration</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <th scope="row">
                                        {{ $course->course_unique_id ?? 'NITE000' . $course->id }}
                                    </th>

                                    <td>
                                        @if($course->image)
                                        <img src="{{ asset('storage/' . $course->image) }}"
                                            class="img-thumbnail"
                                            alt="{{ $course->course_name }}"
                                            width="60"
                                            height="60"
                                            style="object-fit: cover;">
                                        @else
                                        <img src="{{ asset('images/default-course.png') }}"
                                            class="img-thumbnail"
                                            alt="No image"
                                            width="60"
                                            height="60">
                                        @endif
                                    </td>

                                    <td>
                                        <strong>{{ $course->course_name }}</strong>
                                        <br>
                                        @if($course->category)
                                        <span class="badge bg-success">{{ $course->category->name }}</span>
                                        @else
                                        <span class="text-muted">No category</span>
                                        @endif
                                    </td>

                                    <!--<td>
                                        @php
                                        $subjects = json_decode($course->subjects, true);
                                        @endphp

                                        @if($subjects && count($subjects) > 0)
                                        <ul class="list-unstyled mb-0">
                                            @foreach($subjects as $index => $subject)
                                            <li class="mb-1">
                                                <span class="badge bg-info text-dark">
                                                    {{ $subject['subject_name'] ?? 'N/A' }}
                                                </span>
                                                <small class="text-muted">
                                                    ({{ $subject['min_marks'] ?? 0 }} - {{ $subject['max_marks'] ?? 0 }})
                                                </small>
                                            </li>
                                            @endforeach
                                        </ul>
                                        <small class="text-muted">Total: {{ count($subjects) }} subjects</small>
                                        @else
                                        <span class="text-muted">No subjects assigned</span>
                                        @endif
                                    </td> -->

                                    <td>
                                        @if($course->duration)
                                        <span class="badge bg-secondary">{{ $course->duration }} Months</span>
                                        @else
                                        <span class="text-muted">Not specified</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- View Details -->
                                            <button class="btn btn-sm btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewModal{{ $course->id }}"
                                                title="View Details">
                                                <i class="bi bi-info-circle"></i>
                                            </button>
                                            &nbsp;
                                            <!-- Edit -->
                                            <button class="btn btn-sm btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#exampleModalEdit{{ $course->id }}"
                                                title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            &nbsp;
                                            <!-- Delete -->
                                            <button class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#exampleModalDelete{{ $course->id }}"
                                                title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                        <p class="text-muted mt-2">No courses found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                            @if($courses->hasPages())
                            <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <div class="pagination-wrapper text-center py-3">
                                            <form method="GET" action="" class="pagination-form d-inline-flex align-items-center justify-content-center gap-2">
                                                <!-- Preserve any existing query parameters -->
                                                @foreach(request()->except('page') as $key => $value)
                                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                                @endforeach

                                                <button type="submit" name="page" value="{{ $courses->currentPage() - 1 }}"
                                                    class="btn btn-outline-primary btn-sm"
                                                    {{ $courses->onFirstPage() ? 'disabled' : '' }}>
                                                    <i class="bi bi-chevron-left"></i> Prev
                                                </button>

                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-muted">Page</span>
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        value="{{ $courses->currentPage() }}" readonly style="width: 50px;">
                                                    <span class="text-muted">of</span>
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        value="{{ $courses->lastPage() }}" readonly style="width: 50px;">
                                                </div>

                                                <button type="submit" name="page" value="{{ $courses->currentPage() + 1 }}"
                                                    class="btn btn-outline-primary btn-sm"
                                                    {{ !$courses->hasMorePages() ? 'disabled' : '' }}>
                                                    Next <i class="bi bi-chevron-right"></i>
                                                </button>
                                            </form>

                                            <div class="text-muted mt-2 small">
                                                Showing {{ $courses->firstItem() }} to {{ $courses->lastItem() }} of {{ $courses->total() }} courses
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!-- Add Button -->
    <button class="fixed-btn" data-bs-toggle="modal" data-bs-target="#exampleModalAdd">
        Add
    </button>

    <!-- Add Modal -->
    <div class="modal fade" id="exampleModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form class="modal-content" action="{{ route('admin.courses.add') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="courseImage" class="form-label">Course Image</label>
                        <input type="file" class="form-control" name="image" id="courseImage" accept="image/*">
                        <small class="mt-1">Upto 3MB</small>
                    </div>

                    <div class="mb-3">
                        <label for="courseName" class="form-label">Course Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter the course name" name="course_name" id="courseName" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoryId" class="form-label">Category<span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" id="categoryId" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duration (in months)</label>
                        <input type="number" class="form-control" id="durationInput" name="duration" placeholder="E.g. 24">
                    </div>

                    <div id="yearsContainer"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    @foreach($courses as $course)
    @php
    $courseSubjects = json_decode($course->subjects, true);
    @endphp
    <div class="modal fade" id="exampleModalEdit{{ $course->id }}" tabindex="-1" aria-labelledby="exampleModalEditLabel{{ $course->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form class="modal-content" action="{{ route('admin.courses.edit', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalEditLabel{{ $course->id }}">Edit Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="courseImageEdit{{ $course->id }}" class="form-label">Course Image</label>
                        <input type="file" class="form-control" name="image" id="courseImageEdit{{ $course->id }}" accept="image/*">
                        <small class="mt-1">Upto 3MB</small>
                        @if($course->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $course->image) }}" alt="Current Image" width="100" class="img-thumbnail">
                            <small class="text-muted d-block">Current Image</small>
                        </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="courseNameEdit{{ $course->id }}" class="form-label">Course Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter the course name" name="course_name" id="courseNameEdit{{ $course->id }}" value="{{ $course->course_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoryIdEdit{{ $course->id }}" class="form-label">Category<span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" id="categoryIdEdit{{ $course->id }}" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descriptionEdit{{ $course->id }}" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="descriptionEdit{{ $course->id }}" rows="3">{{ $course->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Duration (in months)</label>
                        <input type="number" class="form-control duration-input-edit" data-course-id="{{ $course->id }}" name="duration" placeholder="E.g. 24" value="{{ $course->duration }}">
                    </div>

                    <div id="yearsContainerEdit{{ $course->id }}">
                        @if($courseSubjects && is_array($courseSubjects))
                        @foreach($courseSubjects as $year => $subjects)
                        <div class="mb-3 p-3 border rounded year-container">
                            <h5>Year {{ $year }}</h5>
                            <div class="year-subjects-area" data-year="{{ $year }}">
                                @foreach($subjects as $index => $subject)
                                <div class="d-flex gap-2 mb-2 subject-row">
                                    <input type="text" name="subjects[{{ $year }}][{{ $index }}][subject_name]" class="form-control" placeholder="Subject name" value="{{ $subject['subject_name'] ?? '' }}" required>
                                    <input type="number" name="subjects[{{ $year }}][{{ $index }}][min_marks]" class="form-control" placeholder="Min marks" value="{{ $subject['min_marks'] ?? '' }}" required>
                                    <input type="number" name="subjects[{{ $year }}][{{ $index }}][max_marks]" class="form-control" placeholder="Max marks" value="{{ $subject['max_marks'] ?? '' }}" required>
                                    @if($index == 0)
                                    <button type="button" class="btn btn-success add-subject-edit" data-year="{{ $year }}" data-course-id="{{ $course->id }}">+</button>
                                    @else
                                    <button type="button" class="btn btn-danger remove-subject-edit">-</button>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach




    <!-- View Details Modal -->
    @foreach($courses as $course)
    <div class="modal fade" id="viewModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-dark">
                    <h5 class="modal-title">Course Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @php
                    // Decode subjects for THIS specific course
                    $courseSubjects = json_decode($course->subjects, true);
                    @endphp

                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}"
                                class="img-fluid rounded"
                                alt="{{ $course->course_name }}">
                            @else
                            <div class="bg-light p-4 rounded">
                                <i class="bi bi-image" style="font-size: 3rem;"></i>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Course ID:</th>
                                    <td>{{ $course->course_unique_id ?? 'NITE000' . $course->id }}</td>
                                </tr>
                                <tr>
                                    <th>Course Name:</th>
                                    <td>{{ $course->course_name }}</td>
                                </tr>
                                <tr>
                                    <th>Category:</th>
                                    <td>{{ $course->category->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Duration:</th>
                                    <td>{{ $course->duration ?? 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Description:</h6>
                    <p>{{ $course->description ?? 'No description available' }}</p>

                    <hr>

                    <h6 class="mb-3">Subjects by Year:</h6>
                    @if($courseSubjects && is_array($courseSubjects) && count($courseSubjects) > 0)
                    @foreach($courseSubjects as $year => $subjects)
                    <div class="mb-4">
                        <h6 class="text-primary">
                            <i class="bi bi-calendar-check"></i> Year {{ $year }}
                            <span class="badge bg-primary">{{ count($subjects) }} Subject(s)</span>
                        </h6>

                        @if(is_array($subjects) && count($subjects) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">#</th>
                                        <th width="40%">Subject Name</th>
                                        <th width="25%">Min Marks</th>
                                        <th width="25%">Max Marks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $index => $subject)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ ucfirst($subject['subject_name'] ?? 'N/A') }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-warning text-dark">
                                                {{ $subject['min_marks'] ?? 0 }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $subject['max_marks'] ?? 0 }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p class="text-muted ms-3">No subjects for this year</p>
                        @endif
                    </div>
                    @endforeach

                    @php
                    // Calculate total subjects across all years
                    $totalSubjects = 0;
                    foreach($courseSubjects as $subjects) {
                    if(is_array($subjects)) {
                    $totalSubjects += count($subjects);
                    }
                    }
                    @endphp

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        <strong>Total:</strong> {{ count($courseSubjects) }} Year(s) | {{ $totalSubjects }} Subject(s)
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> No subjects assigned to this course
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


    <!-- Delete Modal -->
    @foreach($courses as $course)
    <div class="modal fade" id="exampleModalDelete{{$course->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.courses.delete', $course->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete this course?</p>
                    <p class="text-danger">{{ $course->course_name }}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach



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


    <!-- Alerts script -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            setTimeout(() => {
                document.querySelectorAll("#alert-container .alert").forEach(el => {
                    el.remove();
                });
            }, 2500);
        });
    </script>

    <script>
        // ========================
        // ADD MODAL FUNCTIONALITY
        // ========================
        document.getElementById("durationInput").addEventListener("input", function() {
            let duration = parseInt(this.value);
            let years = Math.floor(duration / 12);

            let container = document.getElementById("yearsContainer");
            container.innerHTML = ""; // Clear old data

            for (let i = 1; i <= years; i++) {
                let yearDiv = document.createElement("div");
                yearDiv.classList.add("mb-3", "p-3", "border", "rounded");

                yearDiv.innerHTML = `
                <h5>Year ${i}</h5>
                <div id="year-${i}-subjects">
                    <div class="d-flex gap-2 mb-2 subject-row">
                        <input type="text" name="subjects[${i}][0][subject_name]" class="form-control" placeholder="Subject name" required>
                        <input type="number" name="subjects[${i}][0][min_marks]" class="form-control" placeholder="Min marks" required>
                        <input type="number" name="subjects[${i}][0][max_marks]" class="form-control" placeholder="Max marks" required>
                        <button type="button" class="btn btn-success add" data-year="${i}">+</button>
                    </div>
                </div>
            `;

                container.appendChild(yearDiv);
            }

            // Add subject event handler for ADD modal
            container.addEventListener("click", function(e) {
                if (e.target.classList.contains("add")) {
                    let year = e.target.getAttribute("data-year");
                    let subjectArea = document.getElementById(`year-${year}-subjects`);

                    let index = subjectArea.querySelectorAll(".subject-row").length;

                    let newRow = document.createElement("div");
                    newRow.classList.add("d-flex", "gap-2", "mb-2", "subject-row");

                    newRow.innerHTML = `
                    <input type="text" name="subjects[${year}][${index}][subject_name]" class="form-control" placeholder="Subject name" required>
                    <input type="number" name="subjects[${year}][${index}][min_marks]" class="form-control" placeholder="Min marks" required>
                    <input type="number" name="subjects[${year}][${index}][max_marks]" class="form-control" placeholder="Max marks" required>
                    <button type="button" class="btn btn-danger remove">-</button>
                `;

                    subjectArea.appendChild(newRow);
                }

                if (e.target.classList.contains("remove")) {
                    e.target.parentElement.remove();
                }
            });
        });

        // ========================
        // EDIT MODAL FUNCTIONALITY
        // ========================

        // Handle duration change in EDIT modal
        document.addEventListener("input", function(e) {
            if (e.target.classList.contains("duration-input-edit")) {
                let duration = parseInt(e.target.value);
                let years = Math.floor(duration / 12);
                let courseId = e.target.getAttribute("data-course-id");
                let container = document.getElementById(`yearsContainerEdit${courseId}`);

                // Get current years count
                let currentYears = container.querySelectorAll(".year-container").length;

                // If increasing years, add new year sections
                if (years > currentYears) {
                    for (let i = currentYears + 1; i <= years; i++) {
                        let yearDiv = document.createElement("div");
                        yearDiv.classList.add("mb-3", "p-3", "border", "rounded", "year-container");

                        yearDiv.innerHTML = `
                        <h5>Year ${i}</h5>
                        <div class="year-subjects-area" data-year="${i}">
                            <div class="d-flex gap-2 mb-2 subject-row">
                                <input type="text" name="subjects[${i}][0][subject_name]" class="form-control" placeholder="Subject name" required>
                                <input type="number" name="subjects[${i}][0][min_marks]" class="form-control" placeholder="Min marks" required>
                                <input type="number" name="subjects[${i}][0][max_marks]" class="form-control" placeholder="Max marks" required>
                                <button type="button" class="btn btn-success add-subject-edit" data-year="${i}" data-course-id="${courseId}">+</button>
                            </div>
                        </div>
                    `;

                        container.appendChild(yearDiv);
                    }
                }
                // If decreasing years, remove extra year sections
                else if (years < currentYears) {
                    let yearContainers = container.querySelectorAll(".year-container");
                    for (let i = currentYears; i > years; i--) {
                        if (yearContainers[i - 1]) {
                            yearContainers[i - 1].remove();
                        }
                    }
                }
            }
        });

        // Handle add/remove subjects in EDIT modal
        document.addEventListener("click", function(e) {
            // Add subject button
            if (e.target.classList.contains("add-subject-edit")) {
                let year = e.target.getAttribute("data-year");
                let courseId = e.target.getAttribute("data-course-id");
                let subjectArea = e.target.closest(".year-subjects-area");

                let index = subjectArea.querySelectorAll(".subject-row").length;

                let newRow = document.createElement("div");
                newRow.classList.add("d-flex", "gap-2", "mb-2", "subject-row");

                newRow.innerHTML = `
                <input type="text" name="subjects[${year}][${index}][subject_name]" class="form-control" placeholder="Subject name" required>
                <input type="number" name="subjects[${year}][${index}][min_marks]" class="form-control" placeholder="Min marks" required>
                <input type="number" name="subjects[${year}][${index}][max_marks]" class="form-control" placeholder="Max marks" required>
                <button type="button" class="btn btn-danger remove-subject-edit">-</button>
            `;

                subjectArea.appendChild(newRow);
            }

            // Remove subject button
            if (e.target.classList.contains("remove-subject-edit")) {
                e.target.closest(".subject-row").remove();
            }
        });

        // Reset form when modals close
        document.addEventListener("hidden.bs.modal", function(e) {
            if (e.target.id === "exampleModalAdd") {
                document.getElementById("yearsContainer").innerHTML = "";
                document.getElementById("durationInput").value = "";
            }
        });
    </script>


</section>
@endsection