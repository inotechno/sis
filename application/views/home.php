<!DOCTYPE html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title><?= _APP_NAME ?></title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/images/' . _LOGO_MINI) ?>" />
    <!-- Place favicon.ico in the root directory -->

    <!-- ======== CSS here ======== -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/front/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/front/css/lineicons.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/front/css/animate.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/front/css/main.css" />

    <script>
        var logo_src = '<?= base_url('assets/images/' . _LOGO_FULL) ?>';
    </script>
</head>

<body>
    <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

    <!-- ======== preloader start ======== -->
    <div class="preloader">
        <div class="loader">
            <div class="spinner">
                <div class="spinner-container">
                    <div class="spinner-rotator">
                        <div class="spinner-left">
                            <div class="spinner-circle"></div>
                        </div>
                        <div class="spinner-right">
                            <div class="spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- preloader end -->

    <!-- ======== header start ======== -->
    <header class="header">
        <div class="navbar-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="index.html">
                                <img src="<?= base_url('assets/images/' . _LOGO_FULL) ?>" alt="Logo" />
                            </a>

                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a class="page-scroll active" href="#home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#features">Features</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="page-scroll" href="#about">Unggulan</a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="page-scroll" href="#why">More Features</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= site_url('login') ?>">Login</a>
                                    </li>
                                </ul>
                            </div>
                            <!-- navbar collapse -->
                        </nav>
                        <!-- navbar -->
                    </div>
                </div>
                <!-- row -->
            </div>
            <!-- container -->
        </div>
        <!-- navbar area -->
    </header>
    <!-- ======== header end ======== -->

    <!-- ======== hero-section start ======== -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center position-relative">
                <div class="col-lg-6">
                    <div class="hero-content">
                        <h1 class="wow fadeInUp" data-wow-delay=".4s">
                            <!-- <?= _NAMA_PESANTREN ?> -->
                            Aplikasi ADM Pondok Pesantren
                        </h1>
                        <p class="wow fadeInUp" data-wow-delay=".6s">
                            Aplikasi yang di gunakan untuk pesantren mengolah data menjadi informasi dan dapat di akses oleh orang tua santri untuk melihat informasi yang ada.
                        </p>
                        <a href="javascript:void(0)" class="main-btn border-btn btn-hover wow fadeInUp" data-wow-delay=".6s">Login Wali Santri</a>
                        <a href="#features" class="scroll-bottom">
                            <i class="lni lni-arrow-down"></i></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-img wow fadeInUp" data-wow-delay=".5s">
                        <img src="<?= base_url() ?>assets/front/img/hero/hero-update.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======== hero-section end ======== -->

    <!-- ======== feature-section start ======== -->
    <section id="features" class="feature-section pt-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-bootstrap"></i>
                        </div>
                        <div class="content">
                            <h3>Responsive</h3>
                            <p>
                                aplikasi yang dapat menyesuaikan dengan berbagai macam layar.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-layout"></i>
                        </div>
                        <div class="content">
                            <h3>User Friendly</h3>
                            <p>
                                Penggunaan yang sangat mudah dan bisa di gunakan oleh siapapun.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="single-feature">
                        <div class="icon">
                            <i class="lni lni-coffee-cup"></i>
                        </div>
                        <div class="content">
                            <h3>Mobile Support</h3>
                            <p>
                                Sudah support aplikasi mobile seperti android / IOS
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======== feature-section end ======== -->

    <!-- ======== about-section start ======== -->
    <section id="about" class="about-section pt-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="about-img">
                        <img src="<?= base_url() ?>assets/front/img/about/about-update-1.png" alt="" class="w-100" />
                        <img src="<?= base_url() ?>assets/front/img/about/about-left-shape.svg" alt="" class="shape shape-1" />
                        <img src="<?= base_url() ?>assets/front/img/about/left-dots.svg" alt="" class="shape shape-2" />
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6">
                    <div class="about-content">
                        <div class="section-title mb-30">
                            <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                                Pembelian Produk / Jasa Untuk Santri
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                Wali santri yang ingin membelikan produk untuk santri supaya tidak perlu datang untuk memberikan bawaan dari rumah, silahkan gunakan aplikasi ini untuk pemesanan dan pembayaran.
                            </p>
                        </div>
                        <a href="javascript:void(0)" class="main-btn btn-hover border-btn wow fadeInUp" data-wow-delay=".6s">Discover More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======== about-section end ======== -->

    <!-- ======== about2-section start ======== -->
    <section id="about" class="about-section pt-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6 col-lg-6">
                    <div class="about-content">
                        <div class="section-title mb-30">
                            <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                                Berbagai Macam Metode Pembayaran
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                Aplikasi ini juga sudah di dukung berbagai macam metode pembayaran, jadi anda bisa mengirim pembayaran dengan mudah.
                            </p>
                        </div>
                        <ul>
                            <li>Bank Transfer</li>
                            <li>E-Wallets</li>
                            <li>Retail</li>
                            <li>Credit Card</li>
                            <li>Qr Code</li>
                        </ul>
                        <a href="javascript:void(0)" class="main-btn btn-hover border-btn wow fadeInUp" data-wow-delay=".6s">Learn More</a>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 order-first order-lg-last">
                    <div class="about-img-2">
                        <img src="<?= base_url() ?>assets/front/img/about/about-update-2.png" alt="" class="w-100" />
                        <img src="<?= base_url() ?>assets/front/img/about/about-right-shape.svg" alt="" class="shape shape-1" />
                        <img src="<?= base_url() ?>assets/front/img/about/right-dots.svg" alt="" class="shape shape-2" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======== about2-section end ======== -->

    <!-- ======== feature-section start ======== -->
    <section id="why" class="feature-extended-section pt-100">
        <div class="feature-extended-wrapper">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-5 col-xl-6 col-lg-8 col-md-9">
                        <div class="section-title text-center mb-60">
                            <h2 class="mb-25 wow fadeInUp" data-wow-delay=".2s">
                                More Features
                            </h2>
                            <p class="wow fadeInUp" data-wow-delay=".4s">
                                masih ada beberapa lagi fitur yang ada di aplikasi ini.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-feature-extended">
                            <div class="icon">
                                <i class="lni lni-user"></i>
                            </div>
                            <div class="content">
                                <h3>Biodata Anak</h3>
                                <p>
                                    Wali santri dapat melihat biodata anak yang berada dipesantren ini.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-feature-extended">
                            <div class="icon">
                                <i class="lni lni-money-protection"></i>
                            </div>
                            <div class="content">
                                <h3>Tabungan</h3>
                                <p>
                                    Wali santri dapat melihat tabungan anak yang sudah di setorkan pada pesantren.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-feature-extended">
                            <div class="icon">
                                <i class="lni lni-notepad"></i>
                            </div>
                            <div class="content">
                                <h3>Lihat SPP</h3>
                                <p>
                                    Wali santri dapat melihat history pembayaran SPP yang di lakukan oleh anaknya.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-feature-extended">
                            <div class="icon">
                                <i class="lni lni-money-location"></i>
                            </div>
                            <div class="content">
                                <h3>Tambah Saldo</h3>
                                <p>
                                    Wali santri dapat melakukan penambahan saldo untuk anak, melalui rekening bank apapun.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-feature-extended">
                            <div class="icon">
                                <i class="lni lni-layers"></i>
                            </div>
                            <div class="content">
                                <h3>Maklumat</h3>
                                <p>
                                    Wali santri dapat melihat artikel maklumat atau informasi yang di keluarkan oleh pesantren.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-feature-extended">
                            <div class="icon">
                                <i class="lni lni-rocket"></i>
                            </div>
                            <div class="content">
                                <h3>Pesan Barang</h3>
                                <p>
                                    Wali santri dapat memesan barang yang di inginkan untuk anaknya, supaya tidak perlu datang langsung ke pesantren.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======== feature-section end ======== -->

    <!-- ======== subscribe-section start ======== -->
    <section id="contact" class="subscribe-section pt-120">
        <div class="container">
            <div class="subscribe-wrapper img-bg">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-7">
                        <div class="section-title mb-15">
                            <h2 class="text-white mb-25">Subscribe Our Newsletter</h2>
                            <p class="text-white pr-5">
                                Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed
                                diam nonumy eirmod tempor
                            </p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-5">
                        <form action="#" class="subscribe-form">
                            <input type="email" name="subs-email" id="subs-email" placeholder="Your Email" />
                            <button type="submit" class="main-btn btn-hover">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======== subscribe-section end ======== -->

    <!-- ======== footer start ======== -->
    <footer class="footer">
        <div class="container">
            <div class="widget-wrapper">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6">
                        <div class="footer-widget">
                            <div class="logo mb-30">
                                <a href="index.html">
                                    <img width="150" src="<?= base_url('assets/images/' . _LOGO_FULL) ?>" alt="" />
                                </a>
                            </div>
                            <p class="desc mb-30 text-white">
                                <?= _ALAMAT ?>
                            </p>
                            <ul class="socials">
                                <li>
                                    <a href="jvascript:void(0)">
                                        <i class="lni lni-facebook-filled"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="jvascript:void(0)">
                                        <i class="lni lni-twitter-filled"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="jvascript:void(0)">
                                        <i class="lni lni-instagram-filled"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="jvascript:void(0)">
                                        <i class="lni lni-linkedin-original"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-2 col-md-6">
                        <div class="footer-widget">
                            <h3>About Us</h3>
                            <ul class="links">
                                <li><a href="javascript:void(0)">Home</a></li>
                                <li><a href="javascript:void(0)">Feature</a></li>
                                <li><a href="javascript:void(0)">About</a></li>
                                <li><a href="javascript:void(0)">Testimonials</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3>Features</h3>
                            <ul class="links">
                                <li><a href="javascript:void(0)">How it works</a></li>
                                <li><a href="javascript:void(0)">Privacy policy</a></li>
                                <li><a href="javascript:void(0)">Terms of service</a></li>
                                <li><a href="javascript:void(0)">Refund policy</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-6">
                        <div class="footer-widget">
                            <h3>Other Products</h3>
                            <ul class="links">
                                <li><a href="jvascript:void(0)">Accounting Software</a></li>
                                <li><a href="jvascript:void(0)">Billing Software</a></li>
                                <li><a href="jvascript:void(0)">Booking System</a></li>
                                <li><a href="jvascript:void(0)">Tracking System</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- ======== footer end ======== -->

    <!-- ======== scroll-top ======== -->
    <a href="#" class="scroll-top btn-hover">
        <i class="lni lni-chevron-up"></i>
    </a>

    <!-- ======== JS here ======== -->
    <script src="<?= base_url() ?>assets/front/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>assets/front/js/wow.min.js"></script>
    <script src="<?= base_url() ?>assets/front/js/main.js"></script>
</body>

</html>