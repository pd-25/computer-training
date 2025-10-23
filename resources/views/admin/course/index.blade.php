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

                    </div>

                    <table class="table resposive">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Image</th>
                                <th>Course Name</th>
                                <th>Subjects</th>
                                <th>Duration</th>
                                <th scope="col">Category Name</th>
                                <th>Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td><img src="{{asset('storage/'.$course->image)}}" class="img-fluid" alt="" width="50px" height="50px"></td>
                                <td>{{$course->course_name}}</td>
                                <td>
                                    @php
                                    $subjects = json_decode($course->subjects, true);
                                    @endphp

                                    @if($subjects && count($subjects) > 0)
                                    <ul class="m-0 p-0" style="list-style-type: none;">
                                        @foreach($subjects as $subject)
                                        <li>{{ $subject['subject_name'] }} ({{ $subject['min_marks'] }} - {{ $subject['max_marks'] }})</li>
                                        @endforeach
                                    </ul>
                                    @else
                                    <span class="text-muted">No subjects</span>
                                    @endif
                                </td>

                                <td>{{$course->duration}}</td>
                                <td>{{$course->category->name}}</td>
                                <td>
                                    <button class="btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#exampleModalDesc{{$course->id}}">
                                        <i class="bi bi-info"></i>
                                    </button> &nbsp;
                                </td>
                                <td>
                                    <button class="btn btn-warning p-2" data-bs-toggle="modal" data-bs-target="#exampleModalEdit{{$course->id}}">
                                        <i class="bi bi-pencil"></i>
                                    </button> &nbsp;

                                    <button class="btn btn-danger p-2" data-bs-toggle="modal" data-bs-target="#exampleModalDelete{{$course->id}}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="6">
                                    <div class="pagination-wrapper text-center py-3">
                                        <form method="GET" action="" class="pagination-form d-inline-flex align-items-center justify-content-center gap-2">

                                            <button type="submit" name="page" value="{{ $courses->currentPage() - 1 }}"
                                                class="btn btn-outline-primary"
                                                {{ $courses->onFirstPage() ? 'disabled' : '' }}>
                                                Prev
                                            </button>

                                            <div class="d-flex align-items-center gap-1">
                                                <input type="text" class="form-control text-center" value="{{ $courses->currentPage() }}" readonly style="width: 60px;">
                                                <span>/</span>
                                                <input type="text" class="form-control text-center" value="{{ $courses->lastPage() }}" readonly style="width: 60px;">
                                            </div>

                                            <button type="submit" name="page" value="{{ $courses->currentPage() + 1 }}"
                                                class="btn btn-outline-primary"
                                                {{ !$courses->hasMorePages() ? 'disabled' : '' }}>
                                                Next
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>

                    </table>
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

                    <div class="mb-3" id="subjects-section">
                        <label class="form-label">Add Subjects<span class="text-danger">*</span></label>

                        <div class="subject-group d-flex mb-2 gap-2">
                            <input type="text" class="form-control" name="subjects[0][subject_name]" placeholder="Enter subject name" required>
                            <input type="number" class="form-control" name="subjects[0][min_marks]" placeholder="Enter minimum marks" required>
                            <input type="number" class="form-control" name="subjects[0][max_marks]" placeholder="Enter maximum marks" required>
                            <button type="button" class="btn btn-success add-subject">+</button>
                        </div>
                    </div>


                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="duration" class="form-label">Duration</label>
                        <input type="text" class="form-control" name="duration" id="duration" placeholder="e.g., 3 months">
                    </div>
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
    <div class="modal fade" id="exampleModalEdit{{$course->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form class="modal-content" action="{{ route('admin.courses.edit', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @if($course->image)
                    <img src="{{ asset('storage/'.$course->image) }}" class="img-fluid mb-2" width="100" height="100" alt="Course Image">
                    @endif

                    <div class="mb-3">
                        <label for="courseImage{{$course->id}}" class="form-label">Course Image</label>
                        <input type="file" class="form-control" name="image" id="courseImage{{$course->id}}" accept="image/*">
                        <small class="mt-1">Upto 3MB</small>
                    </div>

                    <div class="mb-3">
                        <label for="courseName{{$course->id}}" class="form-label">Course Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="course_name" id="courseName{{$course->id}}" value="{{ $course->course_name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoryId{{$course->id}}" class="form-label">Category<span class="text-danger">*</span></label>
                        <select class="form-select" name="category_id" id="categoryId{{$course->id}}" required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $course->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="subjects-section-{{$course->id}}">
                        <label class="form-label">Edit Subjects<span class="text-danger">*</span></label>

                        @php
                        $subjects = json_decode($course->subjects, true) ?? [];
                        @endphp

                        @foreach($subjects as $i => $subj)
                        <div class="subject-group d-flex mb-2 gap-2">
                            <input type="text" class="form-control" name="subjects[{{$i}}][subject_name]" value="{{ $subj['subject_name'] }}" required>
                            <input type="number" class="form-control" name="subjects[{{$i}}][min_marks]" value="{{ $subj['min_marks'] }}" required>
                            <input type="number" class="form-control" name="subjects[{{$i}}][max_marks]" value="{{ $subj['max_marks'] }}" required>
                            <button type="button" class="btn btn-success add-subject">+</button>
                            <button type="button" class="btn btn-danger remove-subject">x</button>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label for="description{{$course->id}}" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description{{$course->id}}" rows="3">{{ $course->description }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="duration{{$course->id}}" class="form-label">Duration</label>
                        <input type="text" class="form-control" name="duration" id="duration{{$course->id}}" value="{{ $course->duration }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
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

    <!-- Description Modal -->
    @foreach($courses as $course)
    <div class="modal fade" id="exampleModalDesc{{$course->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Description</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p>{{ $course->description }}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <!-- <button type="submit" class="btn btn-danger">Delete</button> -->
                </div>
            </div>
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
        document.addEventListener("DOMContentLoaded", function() {
            let index = 1; // Start index for dynamic fields
            const section = document.getElementById("subjects-section");

            section.addEventListener("click", function(e) {
                if (e.target.classList.contains("add-subject")) {
                    e.preventDefault();

                    const newRow = document.createElement("div");
                    newRow.classList.add("subject-group", "d-flex", "mb-2", "gap-2");
                    newRow.innerHTML = `
                <input type="text" class="form-control" name="subjects[${index}][subject_name]" placeholder="Enter subject name" required>
                <input type="number" class="form-control" name="subjects[${index}][min_marks]" placeholder="Enter minimum marks" required>
                <input type="number" class="form-control" name="subjects[${index}][max_marks]" placeholder="Enter maximum marks" required>
                <button type="button" class="btn btn-danger remove-subject">x</button>
            `;
                    section.appendChild(newRow);
                    index++;
                }

                if (e.target.classList.contains("remove-subject")) {
                    e.preventDefault();
                    e.target.parentElement.remove();
                }
            });
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('[id^="subjects-section-"]').forEach(function(section) {
                let index = section.querySelectorAll('.subject-group').length;

                section.addEventListener("click", function(e) {
                    if (e.target.classList.contains("add-subject")) {
                        e.preventDefault();

                        const newRow = document.createElement("div");
                        newRow.classList.add("subject-group", "d-flex", "mb-2", "gap-2");
                        newRow.innerHTML = `
                    <input type="text" class="form-control" name="subjects[${index}][subject_name]" placeholder="Enter subject name" required>
                    <input type="number" class="form-control" name="subjects[${index}][min_marks]" placeholder="Enter minimum marks" required>
                    <input type="number" class="form-control" name="subjects[${index}][max_marks]" placeholder="Enter maximum marks" required>
                    <button type="button" class="btn btn-danger remove-subject">x</button>
                `;
                        section.appendChild(newRow);
                        index++;
                    }

                    if (e.target.classList.contains("remove-subject")) {
                        e.preventDefault();
                        e.target.parentElement.remove();
                    }
                });
            });
        });
    </script>


</section>
@endsection