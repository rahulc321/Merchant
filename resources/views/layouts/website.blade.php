<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Courses | Education</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="./assets_new/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="./assets_new/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets_new/css/owl.carousel.min.css">
    <link rel="stylesheet" href="./assets_new/css/slicknav.css">
    <link rel="stylesheet" href="./assets_new/css/flaticon.css">
    <link rel="stylesheet" href="./assets_new/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="./assets_new/css/gijgo.css">
    <link rel="stylesheet" href="./assets_new/css/animate.min.css">
    <link rel="stylesheet" href="./assets_new/css/animated-headline.css">
    <link rel="stylesheet" href="./assets_new/css/magnific-popup.css">
    <link rel="stylesheet" href="./assets_new/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="./assets_new/css/themify-icons.css">
    <link rel="stylesheet" href="./assets_new/css/slick.css">
    <link rel="stylesheet" href="./assets_new/css/nice-select.css">
    <link rel="stylesheet" href="./assets_new/css/style.css">

</head>

<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="./assets_new/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <header>
        <!-- Header Start -->
        <div class="header-area header-transparent">
            <div class="main-header ">
                <div class="header-bottom  header-sticky">
                    <div class="container-fluid">
                        <div class="row align-items-center">
                            <!-- Logo -->
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="#"><img src="./assets_new/img/logo/logo.png" alt=""></a>
                                </div>
                            </div>
                            <div class="col-xl-10 col-lg-10">
                                <div class="menu-wrapper d-flex align-items-center justify-content-end">
                                    <!-- Main-menu -->
                                    <div class="main-menu d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">
                                                <li class="active"><a href="/">Home</a></li>
                                                
                                                <li><a href="{{url('/about')}}">About</a></li>
                                                 
                                                <li><a href="{{url('/contact')}}">Contact</a></li>
                                                <!-- Button -->
                                                <li class="button-header margin-left "><a href="{{url('joinMerchant')}}" class="btn">Join Merchant</a>
                                                </li>
                                                <li class="button-header"><a href="/login" class="btn btn3">Log
                                                        in</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-lg-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    @yield('content')


    <footer>
        <div class="footer-wrappper footer-bg">
             
            <!-- footer-bottom area -->
            <div class="footer-bottom-area">
                <div class="container">
                    <div class="footer-border">
                        <div class="row d-flex align-items-center">
                            <div class="col-xl-12 ">
                                <div class="footer-copy-right text-center">
                                    <p>
                                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                        Copyright &copy;<script>
                                        document.write(new Date().getFullYear());
                                        </script> All rights reserved </a>
                                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </div>
    </footer>
    <!-- Scroll Up -->
    <div id="back-top">
        <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
    </div>

    <!-- JS here -->
    <script src="./assets_new/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="./assets_new/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="./assets_new/js/popper.min.js"></script>
    <script src="./assets_new/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="./assets_new/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="./assets_new/js/owl.carousel.min.js"></script>
    <script src="./assets_new/js/slick.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="./assets_new/js/wow.min.js"></script>
    <script src="./assets_new/js/animated.headline.js"></script>
    <script src="./assets_new/js/jquery.magnific-popup.js"></script>

    <!-- Date Picker -->
    <script src="./assets_new/js/gijgo.min.js"></script>
    <!-- Nice-select, sticky -->
    <script src="./assets_new/js/jquery.nice-select.min.js"></script>
    <script src="./assets_new/js/jquery.sticky.js"></script>
    <!-- Progress -->
    <script src="./assets_new/js/jquery.barfiller.js"></script>

    <!-- counter , waypoint,Hover Direction -->
    <script src="./assets_new/js/jquery.counterup.min.js"></script>
    <script src="./assets_new/js/waypoints.min.js"></script>
    <script src="./assets_new/js/jquery.countdown.min.js"></script>
    <script src="./assets_new/js/hover-direction-snake.min.js"></script>

    <!-- contact js -->
    <script src="./assets_new/js/contact.js"></script>
    <script src="./assets_new/js/jquery.form.js"></script>
    <script src="./assets_new/js/jquery.validate.min.js"></script>
    <script src="./assets_new/js/mail-script.js"></script>
    <script src="./assets_new/js/jquery.ajaxchimp.min.js"></script>

    <!-- Jquery Plugins, main Jquery -->
    <script src="./assets_new/js/plugins.js"></script>
    <script src="./assets_new/js/main.js"></script>

</body>

</html>