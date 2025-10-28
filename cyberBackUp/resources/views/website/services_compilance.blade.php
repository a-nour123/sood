<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Advanced Controls | Home</title>
  <meta content="" name="Advanced Controls| Home">
  <meta content="" name="Advanced Controls">

  <!-- Favicons -->
  <link href="{{asset('website/new_version/assets/images/favicon.png')}}" rel="icon">
  <link href="{{asset('website/new_version/assets/images/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;700&display=swap" rel="stylesheet">
  <!-- Heading Font -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Signature Font -->
  <link href="https://fonts.googleapis.com/css2?family=Italianno&display=swap" rel="stylesheet">
  <!-- Vendor CSS Files -->
  <link href="{{asset('website/new_version/assets/vendor/bootstrap/css/bootstrap.min.css')}}"  rel="stylesheet">
  <link href="{{asset('website/new_version/assets/vendor/bootstrap-icons/bootstrap-icons.min.css')}}" rel="stylesheet">
  <link href="{{asset('website/new_version/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('website/new_version/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('website/new_version/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">



  <!-- Main CSS File -->
  <link href="{{asset('website/new_version/assets/stylesheets/styles.css')}}" rel="stylesheet">

</head>

<body>

  <!-- Loader -->
  <div id="preloader"></div>
  <!-- Loader -->

 <!-- header -->
  <header id="header" class="header d-flex align-items-center">

    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="{{route('website.index')}}" class="logo d-flex align-items-center logo-bg">
        <img src="{{asset('website/new_version/assets/images/logo-symbol-invert.png')}}"  alt="">
      </a>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="{{route('website.index')}}">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li class="dropdown"><a href="#services"><span>Services</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="{{route('website.cybermode')}}">Platforms</a></li>
              <li><a href="{{route('website.services_consultation')}}">Consultation</a></li>
              <li><a href="{{route('website.services_compilance')}}">compilance</a></li>
              <li><a href="{{route('website.services_solutions')}}">Solutions</a></li>
            </ul>

          </li>
          <li><a href="cybermode/{{route('website.index')}}">GRC Platform</a></li>
                  <li><a href="#faq">FAQs</a></li>

          <!-- <li><a href="#recent-posts">News</a></li> -->
          <li><a href="#contact">Contact Us</a></li>

        </ul>
      </nav><!-- .navbar -->

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header>
  <!-- End Header -->

  <!-- Hero Section -->
  <section id="hero" class="hero">
    <div class="container position-relative">
      <div class="row gy-5" data-aos="fade-in">
        <div class="col-lg-12  order-lg-1 d-flex flex-column justify-content-center text-center caption">

<p></p><p></p><p></p><p></p>

          <h3>WE'RE LEADERS IN Cybersecurity</h3>
<p></p><p></p>
          <div class="d-flex justify-content-center">
            <a href="#about" class="btn-get-started">Get Started</a>
            <a href="{{asset('website/new_version/assets/introduction.mp4 ')}}" class="glightbox btn-watch-video d-flex align-items-center"><i
                class="bi bi-play-circle"></i><span>Watch Video</span></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End Hero Section -->

  <!--Waves Container-->
  <div class="waves-wraper">
    <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
    viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
    <defs>
    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
    </defs>
    <g class="parallax">
    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
    <use xlink:href="#gentle-wave" x="48" y="3" fill="#44225c" />
    <use xlink:href="#gentle-wave" x="48" y="5" fill="#a7a7a7" />
    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
    </g>
    </svg>
  </div>
  <!--Waves end-->





   <!-- About Us Section -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
       <p></p> <p></p>
          <h2></h2><h2>Cybersecurity Compliance Services</h2>
        </div>

        <div class="row gy-4">
          <div class="col-lg-6">
            <div class="content ps-0 ps-lg-5">
              <p>Advanced Controls IT Co. is a leading Saudi
                Arabian company specializing in providing
                services in information security and
                cybersecurity. The company is distinguished by
                its deep expertise and qualified team to meet
                clients' needs in this vital field. We are
                committed to supporting Saudi Arabia's Vision
                2030 by providing advanced technologies and
                platforms that enhance economic export
                capabilities and help organizations comply with
                international standards, thereby improving their
                overall security posture.</p>
            </div>










          </div>
          <div class="col-lg-6">
            <img src="{{asset('website/new_version/assets/images/compliance.png')}}" class="img-fluid rounded-4 mb-4" alt="">
          </div>




        </div>














    </section><!-- End About Us Section -->




  <main id="main">




        </div><!-- End recent posts list -->

      </div>
    </section><!-- End Recent Blog Posts Section -->





    <!-- Downloadd App Start -->
    <!-- <div id="download-app" class="download-app-promo">
      <div class="download-app-promo-text">
          <div class="download-app-promo-text__tagline">The best way to get information on the go</div><br>
          <div class="download-app-promo-text__download">Download the TechTheme App.</div>
      </div>
      <div class="download-app-promo__section">
          <div class="download-app-promo-subsection">
              <a class="download-app-promo-subsection--link download-app-promo-subsection--playstore" href="#" target="_parent">
                  <img class="download-app-promo__play-store" src="assets/images/google_play_store.svg" alt="google play">
              </a>
              <a class="download-app-promo-subsection--link download-app-promo-subsection--appstore" href="#" target="_parent">
                  <img class="download-app-promo__app-store" src="assets/images/ios_app_store.svg" alt="ios app store">
              </a>
          </div>
      </div>
  </div> -->
  <!-- Downloadd App End -->


  </main><!-- End #main -->

  <!-- Footer -->
  <footer id="footer" class="footer-section">
    <div class="container">
        <div class="footer-content pt-5 pb-5">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-50">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <a href="{{route('website.index')}}" class="logo d-flex align-items-center logo-bg">
                              <img src="{{asset('website/new_version/ssets/images/logo.png ')}}" alt="">
                            </a>
                        </div>
                        <div class="footer-text">
                            <p>WE'RE LEADERS IN Cybersecurity.</p>
                        </div>
                        <div class="footer-social-icon">
                            <span>Follow us</span>
                            <a href="https://www.linkedin.com/company/advancedcontrols/" target="_blank"><i class="bi bi-linkedin"></i></a>
                            <!-- <a href="#"><i class="bi bi-twitter"></i></a>
                            <a href="#"><i class="bi bi-google"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                            <a href="#"><i class="bi bi-whatsapp"></i></a> -->
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Useful Links</h3>
                        </div>
                        <ul>
                            <li><a href="{{route('website.index')}}"><i class="bi bi-chevron-double-right"></i>Home</a></li>
                            <li><a href="{{route('website.index')}}#about"><i class="bi bi-chevron-double-right"></i>About Us</a></li>
                            <li><a href="{{route('website.index')}}#services"><i class="bi bi-chevron-double-right"></i>Our Services</a></li>
                            <li><a href="{{route('website.index')}}#Cybermode"><i class="bi bi-chevron-double-right"></i>GRC Platform</a></li>
                            <li><a href="{{route('website.index')}}#faq"><i class="bi bi-chevron-double-right"></i>FAQs</a></li>
                            <li><a href="{{route('website.index')}}#contact"><i class="bi bi-chevron-double-right"></i>Contact Us</a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Contact:</h3>
                        </div>
                        <div class="contact-info">
                          <h6>Address:</h6>
                          <p><i class="bi bi-geo-alt-fill"></i> Kingdom of Saudi Arabia - Riyadh
                            RPPQ+8P Qurtubah, Al Thumama Road</p>
                          <!-- Change  'Wall%20Street,%20NYC' with your own business name -->
                          <p><a href="https://maps.app.goo.gl/gweZmqT7NBtJ8LhT6" target="_blank">Get Directions</a></p>
                        </div>
                        <div class="contact-info">
                          <h6>Phone:</h6>
                          <p><i class="bi bi-telephone-fill"></i> +966 505 970 841</p>
                        </div>
                        <div class="contact-info">
                          <h6>Email:</h6>
                          <p><i class="bi bi-envelope-fill"></i> info@advancedcontrols.sa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-area">
        <div class="container">
            <div class="row">
                <!-- <div class="col-xl-6 col-lg-6 text-left text-lg-left">
                    <div class="copyright-text">
                        <p>TechTheme © 2023 - Designed by Zr Themes.</p>
                    </div>
                </div> -->
                <div class="col-xl-6 col-lg-6">
                    <div class="footer-menu">
                        <ul>
                            <li><a href="privcay.html">Privcay Policy</a></li>
                            <li><a href="terms.html">Terms &amp; Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </footer>
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>


  <!-- Vendor JS Files -->
  <script src="{{asset('website/new_version/assets/javascripts/jquery.min.js ')}}"></script>
  <script src="{{asset('website/new_version/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('website/new_version/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('website/new_version/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('website/new_version/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('website/new_version/assets/javascripts/plugins.js ')}}"></script>
  <script src="{{asset('website/new_version/assets/javascripts/validator.min.js')}}"></script>
  <script src="{{asset('website/new_version/assets/javascripts/contactform.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('website/new_version/assets/javascripts/main.js')}}"></script>

</body>

</html>
