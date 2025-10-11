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
                <span>Manage Students</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('admin.subadmins') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.subadmins')}}">
                <i class="bi bi-fingerprint"></i>
                <span>Manage Subadmins</span>
            </a>
        </li>
        
        

       
        

    </ul>

</aside>