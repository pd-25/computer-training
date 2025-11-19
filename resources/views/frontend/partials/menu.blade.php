<ul class="navbar-nav text-center w-100 justify-content-center" style="background-color: #182b45;">
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('frontend.index') }}">Home</a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.about' ? 'active' : '@@about' }}">
        <a class="nav-link" href="{{ route('frontend.about') }}">About</a>
    </li>
    <li class="nav-item @@courses">
        <a class="nav-link" href="#">Director message</a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.gallery' ? 'active' : '@@gallery' }}">
        <a class="nav-link" href="{{ route('frontend.gallery') }}">Gallery</a>
    </li>
    <li class="nav-item dropdown view">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Course Categories
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

            @foreach ($categories as $category)
            <li>
                <a class="dropdown-item" href="{{ route('frontend.courses', $category->slug) }}">
                    {{ $category->name }}
                </a>
            </li>
            @endforeach

            <li>
                <a class="dropdown-item" href="{{ route('frontend.categories') }}">
                    All Categories
                </a>
            </li>

        </ul>
    </li>
    <li class="nav-item dropdown view">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Others
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.mission' ? 'active' : '' }}" href="{{ route('frontend.mission') }}">Mission</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.vision' ? 'active' : '' }}" href="{{ route('frontend.vision') }}">vision</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.paynow' ? 'active' : '' }}" href="{{ route('frontend.paynow') }}">Pay Now</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.computer-marksheet' ? 'active' : '' }}" href="{{ route('frontend.computer-marksheet') }}">Computer Marksheet</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.typing' ? 'active' : '' }}" href="{{ route('frontend.typing') }}">Typing</a></li>
            <!-- <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.certificate' ? 'active' : '' }}" href="{{ route('frontend.certificate') }}">Certificate</a></li> -->
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.franchise-mode' ? 'active' : '' }}" href="{{ route('frontend.franchise-mode') }}">Franchise model</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.wallet' ? 'active' : '' }}" href="{{ route('frontend.wallet') }}">Wallet</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.verification' ? 'active' : '' }}" href="{{ route('frontend.verification') }}">Certificate verification</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.student-zone' ? 'active' : '' }}" href="{{ route('frontend.student-zone') }}">Student Zone</a></li>
            <li><a class="dropdown-item {{ Route::currentRouteName() == 'frontend.franchise' ? 'active' : '' }}" href="{{ route('frontend.franchise') }}">Get Franchise</a></li>
        </ul>
    </li>
    <li class="nav-item dropdown view">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            Login
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ route('admin.showlogin') }}">Admin Login</a></li>
            <li><a class="dropdown-item" href="{{ route('frontend.franchise-login') }}">Franchise Login</a></li>
        </ul>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.contact' ? 'active' : '@@contact' }}">
        <a class="nav-link" href="{{ route('frontend.contact') }}">CONTACT</a>
    </li>
</ul>