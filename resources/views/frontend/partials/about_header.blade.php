<!-- header -->
<style>
  /* Remove fixed positioning from header */
  .header {
    position: relative;
  }

  /* Make navigation sticky instead */
  .navigation.sticky-top {
    position: sticky;
    top: 0;
    z-index: 1020;
  }

  /* Full width navigation with reduced height */
  .navigation {
    background-color: #182b45;
    /* Orange/yellow color from your image */
  }

  .navigation .navbar {
    min-height: 50px;
    /* Reduced height */
  }

  .navigation .nav-link {
    padding: 0.75rem 1rem !important;
    /* Reduced padding */
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    color: #fff !important;
  }

  .navigation .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
  }

  .navigation .navbar-nav {
    margin-left: 0 !important;
    /* Remove initial space */
  }

  /* Remove the ml-auto class effect and center menu */
  .navigation .navbar-nav.ml-auto {
    margin: 0 auto;
  }

  /* Dropdown styles */
  .navigation .dropdown-menu {
    margin-top: 0;
    border-radius: 0;
  }

  /* Active state */
  .navigation .nav-item.active .nav-link {
    background-color: rgba(255, 255, 255, 0.2);
  }

  /* Mobile responsive */
  @media (max-width: 991px) {
    .navigation .navbar-nav {
      text-align: left;
    }

    .navigation .nav-link {
      padding: 0.5rem 1rem !important;
    }
  }
</style>
<header class="header">
  <!-- Top section with social & quick links (optional - can be removed if not needed) -->
  <div class="top-header py-2 bg-light border-bottom">
    <div class="container">
      <div class="row no-gutters align-items-center">
        <div class="col-lg-4 text-center text-lg-left">
          <ul class="list-inline d-inline mb-0">
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://facebook.com/themefisher/"><i class="ti-facebook"></i></a></li>
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://twitter.com/themefisher"><i class="ti-twitter-alt"></i></a></li>
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://github.com/themefisher"><i class="ti-github"></i></a></li>
            <li class="list-inline-item mx-0"><a class="d-inline-block p-2 text-color" href="https://instagram.com/themefisher/"><i class="ti-instagram"></i></a></li>
          </ul>
        </div>
        <div class="col-lg-8 text-center text-lg-right">
          <ul class="list-inline mb-0">
            <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="notice.html">notice</a></li>
            <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="{{ route('frontend.events') }}">EVENTS</a></li>
            <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="#loginModal" data-toggle="modal" data-target="#loginModal">login</a></li>
            <li class="list-inline-item"><a class="text-uppercase text-color p-sm-2 py-2 px-0 d-inline-block" href="#signupModal" data-toggle="modal" data-target="#signupModal">register</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Logo and Contact Info Bar -->
  <div class="top-bar bg-white py-3 border-bottom">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-6 text-center text-md-left mb-3 mb-md-0">
          <a href="{{ route('frontend.index') }}">
            <img src="{{ asset('./logo.png') }}" alt="Global Education & Technoworld" style="max-height: 120px;">
          </a>
        </div>
        <div class="col-lg-6 col-md-6 text-center text-md-right">
          <div class="contact-info">
            <div class="mb-2">
              <a href="mailto:niteducation2024@gmail.com" class="text-dark d-inline-block">
                <i class="ti-email mr-2"></i><span class="font-weight-bold">niteducation2024@gmail.com</span>
              </a> &nbsp;&nbsp;&nbsp;&nbsp;
              <a href="tel:9864077781" class="text-dark d-inline-block">
                <i class="ti-mobile mr-2"></i><span class="font-weight-bold">+91-9864077781</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Navigation Menu - Full Width -->
  <div class="navigation w-100 sticky-top">
    <div class="container-fluid px-0">
      <nav class="navbar navbar-expand-lg navbar-dark p-0" style="background-color: #182b45;">
        <div class="container">
          <button class="navbar-toggler rounded-0" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navigation">
            @include('frontend.partials.menu')
          </div>
        </div>
      </nav>
    </div>
  </div>
</header>
<!-- /header -->
<!-- Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0 border-0 p-4">
            <div class="modal-header border-0">
                <h3>Register</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login">
                    <form action="#" class="row">
                        <div class="col-12">
                            <input type="text" class="form-control mb-3" id="signupPhone" name="signupPhone" placeholder="Phone">
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control mb-3" id="signupName" name="signupName" placeholder="Name">
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control mb-3" id="signupEmail" name="signupEmail" placeholder="Email">
                        </div>
                        <div class="col-12">
                            <input type="password" class="form-control mb-3" id="signupPassword" name="signupPassword" placeholder="Password">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">SIGN UP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0 border-0 p-4">
            <div class="modal-header border-0">
                <h3>Login</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" class="row">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="loginPhone" name="loginPhone" placeholder="Phone">
                    </div>
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="loginName" name="loginName" placeholder="Name">
                    </div>
                    <div class="col-12">
                        <input type="password" class="form-control mb-3" id="loginPassword" name="loginPassword" placeholder="Password">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">LOGIN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
