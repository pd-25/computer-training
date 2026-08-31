@extends('admin.layout.main')
@section('title', 'All Franchise')

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
                        <h5 class="card-title w-100">All Approved Franchise</h5>
                        <form action="{{ route('admin.subadmins') }}" method="GET" class="w-50 d-flex gap-2">
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                placeholder="Search id & name...">

                            <button class="btn btn-primary" type="submit">Search</button>
                        </form>
                    </div>

                    <table class="table resposive">
                        <thead>
                            <tr>
                                <th scope="col">Franchise ID</th>
                                <th scope="col">Org/ Institute Name</th>
                                <th scope="col">Name</th>
                                <th scope="col">email</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subAdmins as $subadmin)
                            <tr>
                                <th scope="row">
                                    {{ $subadmin->subadmin_unique_id ?? 'NITE-00' . $subadmin->id }}
                                </th>

                                <td>{{ $subadmin->org_name }}</td>
                                <td>{{ $subadmin->name }}</td>
                                <td>{{ $subadmin->email }}</td>
                                <td>
                                    <a href="{{ route('admin.subadmins.loginAs', $subadmin->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-power"></i></a>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editSubAdminModal{{ $subadmin->id }}"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSubAdminModal{{ $subadmin->id }}"><i class="bi bi-trash"></i></button>
                                    
                                    @if ($subadmin->affiliation == 0)
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#giveAffiliationModal{{ $subadmin->id }}"><i class="bi bi-share"></i> Give Affiliation</button>
                                    @else
                                        <button class="btn btn-sm btn-success" disabled><i class="bi bi-check-circle"></i> Granted</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>



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
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.subadmins.add') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Franchise</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="" class="form-label">Org/ Institute Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter the org name" name="org_name" value="{{ old('org_name') }}" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter the name" name="name" value="{{ old('name') }}" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Profile Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" placeholder="Enter the email" name="email" value="{{ old('email') }}" autocomplete="off">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Enter the password" name="password" autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Confirm Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" placeholder="Enter the password" name="password_confirmation" autocomplete="new-password">
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
    @foreach ($subAdmins as $subadmin)
    <div class="modal fade" id="editSubAdminModal{{ $subadmin->id }}" tabindex="-1" aria-labelledby="editSubAdminLabel{{ $subadmin->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.subadmins.edit', $subadmin->id) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubAdminLabel{{ $subadmin->id }}">Edit Franchise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Org/ Institute Name<span class="text-danger">*</span></label>
                        <input type="text" name="org_name" class="form-control" value="{{ old('org_name', $subadmin->org_name) }}">
                    </div>

                    <div class="mb-3">
                        <label>Name<span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $subadmin->name) }}">
                    </div>

                    <div class="mb-3">
                        <label>Profile Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                        @if($subadmin->image)
                            <div class="mt-2">
                                <img src="{{ asset($subadmin->image) }}" alt="Current Image" width="50" height="50" style="object-fit:cover; border-radius:50%;">
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Email<span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $subadmin->email) }}">
                    </div>
                    <div class="mb-3">
                        <label>Password (Leave empty to keep current)</label>
                        <input type="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Delete Modal -->
    @foreach ($subAdmins as $subadmin)
    <div class="modal fade" id="deleteSubAdminModal{{ $subadmin->id }}" tabindex="-1" aria-labelledby="deleteSubAdminLabel{{ $subadmin->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.subadmins.delete', $subadmin->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSubAdminLabel{{ $subadmin->id }}">Delete Franchise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong>{{ $subadmin->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Give Affiliation Modal -->
    @foreach ($subAdmins as $subadmin)
    <div class="modal fade" id="giveAffiliationModal{{ $subadmin->id }}" tabindex="-1" aria-labelledby="giveAffiliationLabel{{ $subadmin->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.subadmins.affiliation', $subadmin->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="giveAffiliationLabel{{ $subadmin->id }}">Give Affiliation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to give affiliation to <strong>{{ $subadmin->name }}</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Give Affiliation</button>
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