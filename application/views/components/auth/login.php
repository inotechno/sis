<div class="container bg-white mt-5 p-0">
    <div class="row no-gutters">
        <div class="col-sm-6 align-self-center">
            <div class="sign-in-from">
                <h1 class="mb-0">Sign in</h1>
                <p>
                    Enter your email address and password to access
                    admin panel.
                </p>
                <form class="mt-4" id="form-login" method="POST">
                    <div class="form-group">
                        <label for="inputemail">Email address</label>
                        <input type="email" class="form-control mb-0" id="inputemail" placeholder="Enter email" name="email" />
                    </div>
                    <div class="form-group">
                        <label for="inputpassword">Password</label>
                        <a href="<?= site_url('forgot-password') ?>" class="float-right">Forgot password?</a>
                        <input type="password" class="form-control mb-0" id="inputpassword" placeholder="Password" name="password" />
                    </div>
                    <div class="d-inline-block w-100">
                        <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1">
                            <input type="checkbox" class="custom-control-input" name="remember_me" id="customCheck1" />
                            <label class="custom-control-label" for="customCheck1">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">
                            Sign in
                        </button>
                    </div>
                    <div class="sign-info">
                        <ul class="iq-social-media">
                            <li>
                                <a href="#"><i class="ri-facebook-box-line"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="ri-twitter-line"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="ri-instagram-line"></i></a>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-6 text-center">
            <div class="sign-in-detail text-white">
                <a class="sign-in-logo mb-5" href="#"><img src="<?= base_url('assets') ?>/images/logo-full.png" class="img-fluid" alt="logo" /></a>
                <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                    <div class="item">
                        <img src="<?= base_url('assets') ?>/front/img/hero/hero-update.png" class="img-fluid mb-4" alt="logo" />
                        <h4 class="mb-1 text-white">
                            Akses Wali Santri
                        </h4>
                        <p>
                           Wali santri dapat mengakses aplikasi secara bebas.
                        </p>
                    </div>
                    <div class="item">
                        <img src="<?= base_url('assets') ?>/front/img/about/about-update-1.png" class="img-fluid mb-4" alt="logo" />
                        <h4 class="mb-1 text-white">
                            Order Product
                        </h4>
                        <p>
                           Wali santri dapat order product untuk anak yang ada di pesantren dengan mudah.
                        </p>
                    </div>
                    <div class="item">
                        <img src="<?= base_url('assets') ?>/front/img/about/about-update-2.png" class="img-fluid mb-4" alt="logo" />
                        <h4 class="mb-1 text-white">
                            Banyak Metode Pembayaran
                        </h4>
                        <p>
                            Banyak metode pembayaran yang bisa di gunakan untuk wali santri membayar pesanan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>