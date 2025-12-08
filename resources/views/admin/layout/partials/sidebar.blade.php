<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('admin.categories') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.categories')}}">
                <i class="bi bi-list"></i>
                <span>Manage Categories</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('admin.courses') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.courses')}}">
                <i class="bi bi-book"></i>
                <span>Manage Courses</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('admin.students') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.students')}}">
                <i class="ri-group-fill"></i>
                <span>All Students</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('admin.student.assigned-students') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.student.assigned-students')}}">
                <i class="ri-group-fill"></i>
                <span>Assigned Students</span>
            </a>
        </li>



        <li class="nav-item {{ Route::is('admin.franchise') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.franchise')}}">
                <i class="bi bi-inbox-fill"></i>
                <span>Franchise Requests</span>
            </a>
        </li>


        
        <li class="nav-item {{ Route::is('admin.subadmins') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.subadmins')}}">
                <i class="bi bi-fingerprint"></i>
                <span>Manage Franchise</span>
            </a>
        </li>


        
        <li class="nav-item {{ Route::is('admin.payments') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.payments')}}">
                <i class="bi bi-currency-rupee"></i>
                <span>Payments Requests</span>
            </a>
        </li>





    </ul>

</aside>