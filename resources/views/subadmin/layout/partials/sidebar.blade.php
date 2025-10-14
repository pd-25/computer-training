<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item {{ Route::is('subadmin.dashboard') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('subadmin.dashboard')}}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('subadmin.students') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('subadmin.students')}}">
                <i class="ri-group-fill"></i>
                <span>Students</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('subadmin.course-assign') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('subadmin.course-assign')}}">
                <i class="ri-book-fill"></i>
                <span>Course Assign</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.subadmins.return') }}">
                <i class="bi bi-shield-lock"></i>
                <span>Back To Admin</span>
            </a>
        </li>








    </ul>

</aside>