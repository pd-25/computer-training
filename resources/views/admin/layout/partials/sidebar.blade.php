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
                <span>Add Categories</span>
            </a>
        </li>

        <li class="nav-item {{ Route::is('admin.courses') ? 'active' : ''}}">
            <a class="nav-link " href="{{route('admin.courses')}}">
                <i class="bi bi-book"></i>
                <span>Add Courses</span>
            </a>
        </li>
        
        

       
        

    </ul>

</aside>