<!DOCTYPE html>
<html lang="en" style="scroll-behavior: smooth;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

    <!-- title -->
    <title> Via - Store</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="assets/img/logo.png">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css') }}">
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <style>
        .subtitle {
            letter-spacing: 0px !important;
        }
    </style>

</head>

<body>

    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

    <!-- header -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo">
                            <a href="/">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="logo" width="75">
                            </a>
                        </div>
                        <!-- logo -->

                        <!-- menu start -->
                        <nav class="main-menu" dir="rtl">
                            <ul>
                                <li class="current-list-item"><a href="/">الرئيسية</a></li>
                                @if ((Auth::user() && Auth::user()->role == 'admin') || (Auth::user() && Auth::user()->role == 'superadmin'))
                                    <li><a href="/dashboard"> لوحة التحكم </a></li>
                                @endif
                                @if ((Auth::user() && Auth::user()->role == 'admin') || (Auth::user() && Auth::user()->role == 'superadmin'))
                                    <li><a href="/addproduct">اضافة منتج</a></li>
                                @endif
                                <li><a href="/product">المنتجات</a></li>

                                @if ((Auth::user() && Auth::user()->role == 'admin') || (Auth::user() && Auth::user()->role == 'superadmin'))
                                    <li><a href="/addcategory">اضافة قسم</a></li>
                                @endif

                                <li><a href="/category">الاقسام</a></li>
                                <li><a href="/reviews">اراء العملاء</a></li>
                                <li><a href="/about">من نحن</a></li>
                                <li><a href="/contact"> تواصل معنا </a></li>



                                <!-- Authentication Links -->
                                @guest
                                    @if (Route::has('login'))
                                        <li>
                                            <a href="{{ route('login') }}">تسجيل دخول</a>
                                        </li>
                                    @endif

                                    @if (Route::has('register'))
                                        <li>
                                            <a href="{{ route('register') }}">مستخدم جديد</a>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <a href="#">
                                            {{ Auth::user()->name }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            تسجيل الخروج
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest


                                <li>
                                    <div class="header-icons">
                                        <a class="shopping-cart" href="/cart"><i class="fas fa-shopping-cart"></i></a>
                                        <a class="mobile-hide search-bar-icon" href="#"><i
                                                class="fas fa-search"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                        <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                        <div class="mobile-menu"></div>
                        <!-- menu end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->
    <!-- search area -->
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <h3 style="letter-spacing: 0;">البحث عن جميع المنتجات الخاصة بنا</h3>

                            <form action="{{ url('/search') }}" method="GET">
                                <input type="text" name="searchkey" value="{{ request('searchkey') }}"
                                    placeholder="ابحث عن المنتجات" required>
                                <button type="submit">
                                    بحث <i class="fas fa-search"></i>
                                </button>
                            </form>

                            {{-- عرض رسالة عند وجود كلمة بحث --}}
                            @if (request('searchkey'))
                                <p class="mt-2">نتائج البحث عن: <strong>"{{ request('searchkey') }}"</strong></p>
                            @endif

                            {{-- إذا لا توجد نتائج --}}
                            @if (isset($products) && $products->isEmpty())
                                <p class="mt-3 text-danger">لا توجد منتجات مطابقة للبحث</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end search area -->

    <!-- home page slider -->
    <div class="homepage-slider">
        <!-- single home slider -->
        <div class="single-homepage-slider homepage-bg-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-7 offset-lg-1 offset-xl-0">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle"> متعة التسوق عبر فروعنا </p>
                                <h1> احدث صيحات الموضة والتسوق </h1>
                                <div class="hero-btns">
                                    <a href="/login" class="boxed-btn"> سجل معنا </a>
                                    <a href="{{ route('contact.page') }}" class="bordered-btn"> تواصل معنا </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- single home slider -->
        <div class="single-homepage-slider homepage-bg-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle"> احدث الالكترونيات </p>
                                <h1> منتجات اصلية مع ضمان </h1>
                                <div class="hero-btns">
                                    <a href="/login" class="boxed-btn"> سجل معنا </a>
                                    <a href="{{ route('contact.page') }}" class="bordered-btn"> تواصل معنا </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- single home slider -->
        <div class="single-homepage-slider homepage-bg-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-right">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle"> اواع الماكولات الشرقية والغربية </p>
                                <h1> طعم خيالي </h1>
                                <div class="hero-btns">
                                    <a href="/login" class="boxed-btn"> سجل معنا </a>
                                    <a href="{{ route('contact.page') }}" class="bordered-btn"> تواصل معنا </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end home page slider -->

    @yield('content')



    <!-- footer -->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title"> من نحن </h2>
                        <p style="text-align: justify">
                            <span class="orange-text fw-bold"> Via -
                            </span> ستايل يواكبك إنت وعائلتك
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box get-in-touch">
                        <h2 class="widget-title"> التواصل معنا </h2>
                        <ul>
                            <li>العراق - بابل </li>
                            <li>zaed4149@gmail.com</li>
                            <li>+964 773 9770 366</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box pages">
                        <h2 class="widget-title">الصفحات</h2>
                        <ul>
                            <li><a href="/">الرئيسية</a></li>
                            <li><a href="/product"> المنتجات </a></li>
                            <li><a href="/about"> من نحن </a></li>
                            <li><a href="{{ route('contact.page') }}"> تواصل معنا </a></li>

                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box subscribe">
                        <h2 class="widget-title"> حسابك </h2>
                        @guest
                            @if (Route::has('login'))
                                <p>
                                    <a href="{{ route('login') }}" class=" text-white">تسجيل دخول</a>
                                </p>
                            @endif

                            @if (Route::has('register'))
                                <p>
                                    <a href="{{ route('register') }}"class=" text-white">مستخدم جديد</a>
                                </p>
                            @endif
                        @else
                            <p>
                                {{ Auth::user()->name }}

                            </p>
                            <p>
                                <a href="{{ route('logout') }}"class=" text-white"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    تسجيل الخروج
                                </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            </p>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end footer -->

    <!-- copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12" dir="rtl">
                    <p>&copy كل الحقوق محفوظة بواسطة <a href="#" target="_blank"><span class="orange-text">
                                Via </span></a></p>

                    </p>
                </div>
                <div class="col-lg-6 text-right col-md-12">
                    <div class="social-icons">
                        <ul>
                            <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end copyright -->

    <!-- jquery -->
    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css" />
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- count down -->
    <script src="{{ asset('assets/js/jquery.countdown.js') }}"></script>
    <!-- isotope -->
    <script src="{{ asset('assets/js/jquery.isotope-3.0.6.min.js') }}"></script>
    <!-- waypoints -->
    <script src="{{ asset('assets/js/waypoints.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!-- magnific popup -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- mean menu -->
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <!-- sticker js -->
    <script src="{{ asset('assets/js/sticker.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @yield('scripts')

    @stack('styles')

    @stack('scripts')
</body>

</html>
