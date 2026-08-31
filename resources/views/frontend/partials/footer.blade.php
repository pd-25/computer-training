<!-- footer -->
<footer>
  <!-- newsletter -->
  <div class="newsletter">
    <div class="container">
      <div class="row">
        <div class="col-md-9 ml-auto bg-primary py-5 newsletter-block">
          <h3 class="text-white">Subscribe Now</h3>
          <form action="#">
            <div class="input-wrapper">
              <input type="email" class="form-control border-0" id="newsletter" name="newsletter" placeholder="Enter Your Email...">
              <button type="submit" value="send" class="btn btn-primary">Join</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- footer content -->
  <div class="footer bg-footer section border-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-sm-8 mb-5 mb-lg-0">
          <!-- logo -->
          <a class="logo-footer" href="index.html"><img class="img-fluid mb-4" src="{{ asset('./logo.png') }}" width="150" alt="logo"></a>
          <ul class="list-unstyled">
            <li class="mb-2">Sankar Azan Path, Hatigaon, Bhetapara Road, Near Hatigaon police station , PO- Hatigaon. Guwahati, Assam, 781038</li>
            <li class="mb-2">Company name- zagaran charitable trust</li>
            <li class="mb-2">+9864077781</li>
            <li class="mb-2">niteducation2024@gmail.com</li>
          </ul>
        </div>
        <!-- QUICK LINKS -->
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-5 mb-md-0">
          <h4 class="text-white mb-5">QUICK LINKS</h4>
          <ul class="list-unstyled">
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.index') }}">Home</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.about') }}">About</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.contact') }}">Contact</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.gallery') }}">Gallery</a></li>
          </ul>
        </div>
        <!-- COURSES -->
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-5 mb-md-0">
          <h4 class="text-white mb-5">COURSES</h4>
          <ul class="list-unstyled">
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.categories') }}">All Categories</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.franchise') }}">Get Franchise</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.franchise-mode') }}">Franchise Model</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.mission') }}">Mission</a></li>
          </ul>
        </div>
        
        <!-- STUDENT ZONE -->
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-5 mb-md-0">
          <h4 class="text-white mb-5">STUDENT ZONE</h4>
          <ul class="list-unstyled">
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.verification') }}">Student Zone</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.paynow') }}">Pay Now</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.wallet') }}">Wallet</a></li>
            <li class="mb-3"><a class="text-color" href="{{ route('frontend.computer-marksheet') }}">Computer Marksheet</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- copyright -->
  <div class="copyright py-4 bg-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-7 text-sm-left text-center">
          <p class="mb-0">Copyright &copy;
            <script>
              var CurrentYear = new Date().getFullYear()
              document.write(CurrentYear)
            </script> 
            , reserved by <a href="" class="text-muted">niote.in </a>
          </p>
        </div>
        <div class="col-sm-5 text-sm-right text-center">
          <ul class="list-inline">
            <li class="list-inline-item"><a class="d-inline-block p-2" href="https://facebook.com/themefisher/"><i class="ti-facebook text-primary"></i></a></li>
            <li class="list-inline-item"><a class="d-inline-block p-2" href="https://twitter.com/themefisher"><i class="ti-twitter-alt text-primary"></i></a></li>
            <li class="list-inline-item"><a class="d-inline-block p-2" href="https://github.com/themefisher"><i class="ti-github text-primary"></i></a></li>
            <li class="list-inline-item"><a class="d-inline-block p-2" href="https://instagram.com/themefisher/"><i class="ti-instagram text-primary"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</footer>
<!-- /footer -->
