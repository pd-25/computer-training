<ul class="navbar-nav ml-auto text-center">
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('frontend.index') }}">Home</a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.about' ? 'active' : '@@about' }}">
        <a class="nav-link" href="{{ route('frontend.about') }}">About</a>
    </li>
    <li class="nav-item @@courses">
        <a class="nav-link" href="#">Director message</a>
    </li>
    <li class="nav-item @@events">
        <a class="nav-link" href="#">gallery</a>
    </li>
    <li class="nav-item @@blog">
        <a class="nav-link" href="#">certificate</a>
    </li>
    <li class="nav-item dropdown view">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
Others
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Mission</a></li>
            <li><a class="dropdown-item" href="#">vision</a></li>
            <li><a class="dropdown-item" href="#">Pay Now</a></li>
            <li><a class="dropdown-item" href="#">Marksheet</a></li>
            <li><a class="dropdown-item" href="#">Typing</a></li>
            <li><a class="dropdown-item" href="#">Franchise model</a></li>
            <li><a class="dropdown-item" href="#">Wallet</a></li>
            <li><a class="dropdown-item" href="#">verification</a></li>
            <li><a class="dropdown-item" href="#">verification</a></li>
        </ul>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'frontend.contact' ? 'active' : '@@contact' }}">
        <a class="nav-link" href="{{ route('frontend.contact') }}">CONTACT</a>
    </li>
</ul>
