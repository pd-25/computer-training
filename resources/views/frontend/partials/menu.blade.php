<ul class="navbar-nav ml-auto text-center">
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('frontend.index') }}">Home</a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.about' ? 'active' : '@@about' }}">
        <a class="nav-link" href="{{ route('frontend.about') }}">About</a>
    </li>
    <li class="nav-item @@courses">
        <a class="nav-link" href="courses.html">COURSES</a>
    </li>
    <li class="nav-item @@events">
        <a class="nav-link" href="events.html">EVENTS</a>
    </li>
    <li class="nav-item @@blog">
        <a class="nav-link" href="blog.html">BLOG</a>
    </li>
    <li class="nav-item dropdown view">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Pages
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="teacher.html">Teacher</a></li>
            <li><a class="dropdown-item" href="teacher-single.html">Teacher Single</a></li>
            <li><a class="dropdown-item" href="notice.html">Notice</a></li>
            <li><a class="dropdown-item" href="notice-single.html">Notice Details</a></li>
            <li><a class="dropdown-item" href="research.html">Research</a></li>
            <li><a class="dropdown-item" href="scholarship.html">Scholarship</a></li>
            <li><a class="dropdown-item" href="course-single.html">Course Details</a></li>
            <li><a class="dropdown-item" href="event-single.html">Event Details</a></li>
            <li><a class="dropdown-item" href="blog-single.html">Blog Details</a></li>

            <li class="dropdown-item dropdown dropleft">
                <a class="dropdown-toggle" href="#" id="navbarDropdownSubmenu" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sub Menu
                </a>
                <ul class="dropdown-menu dropdown-submenu" aria-labelledby="navbarDropdownSubmenu">
                    <li><a class="dropdown-item" href="#!">Sub Menu 01</a></li>
                    <li><a class="dropdown-item" href="#!">Sub Menu 02</a></li>
                    <li><a class="dropdown-item" href="#!">Sub Menu 03</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.contact' ? 'active' : '@@contact' }}">
        <a class="nav-link" href="{{ route('frontend.contact') }}">CONTACT</a>
    </li>
</ul>
