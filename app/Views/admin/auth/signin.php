<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="saas" data-theme-colors="default">



<head>


    <?= $this->section('meta_info') ?>
    <title><?= "Sign In" ?></title>
    <meta name='base-url' content="<?= base_url() ?>">
    <?= $this->endSection() ?>
    <?= $this->renderSection('meta_info') ?>

    <?= $this->include('admin/partials/_head_cdn'); ?>

    <?= $this->renderSection('head_cdn'); ?>
</head>


<body>

    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-bg-fill galaxy-border-none">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="index.html" class="d-block">
                                                    <img src="assets/images/logo-light.png" alt="" height="18">
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>

                                                <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <div class="carousel-indicators">
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                        <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                    </div>
                                                    <div class="carousel-inner text-center text-white-50 pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" The theme is really great with an amazing customer support."</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">" Great! Clean code, clean design, easy for customization. Thanks very much! "</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end carousel -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p class="text-muted">Sign in to continue to Velzon.</p>
                                        </div>

                                        <!-- <div class="mt-4">
                                            <form action="https://themesbrand.com/velzon/html/master/index.html">

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" placeholder="Enter username">
                                                </div>

                                                <div class="mb-3">
                                                    <div class="float-end">
                                                        <a href="auth-pass-reset-cover.html" class="text-muted">Forgot password?</a>
                                                    </div>
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input">
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon material-shadow-none" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-success w-100" type="submit">Sign In</button>
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <div class="signin-other-title">
                                                        <h5 class="fs-13 mb-4 title">Sign In with</h5>
                                                    </div>

                                                    <div>
                                                        <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                        <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div> -->
                                        <div class="p-2 mt-4">

                                            <?= form_open('login', ['id' => 'loginForm', 'method' => 'POST']); ?>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email" value="<?= old('email') ?>">
                                                <span class="err text-danger" id="email_err"></span>
                                            </div>

                                            <div class="mb-3">
                                                <div class="float-end">
                                                    <a href="<?= base_url('admin/forget-password') ?>" class="text-muted">Forgot password?</a>
                                                </div>
                                                <label class="form-label" for="password-input">Password</label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input name="password" type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password-input">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                                <span class="err text-danger" id="password_err"></span>
                                            </div>

                                            <div class="form-check">
                                                <input name="remember_me" class="form-check-input" type="checkbox" value="1" id="auth-remember-check">
                                                <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                            </div>

                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-success w-100">
                                                    Sign In
                                                    <div class="spinner-border text-light form-loader" role="status" style="display:none;">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </button>
                                            </div>

                                            <?= form_close() ?>
                                        </div>

                                        <!-- <div class="mt-5 text-center">
                                            <p class="mb-0">Don't have an account ? <a href="auth-signup-cover.html" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>
                                        </div> -->
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer galaxy-border-none">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->


    <?= $this->include('admin/partials/_footer_cdn'); ?>

    <?= $this->renderSection('footer_cdn'); ?>

    <script>
        // Prevent pasting in the password input field
        document.getElementById('password-input').addEventListener('paste', function(event) {
            event.preventDefault();
            alert("Pasting is disabled in this field.");
        });

        // Disable context menu (right-click)
        document.getElementById('password-input').addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });

        function show_server_error(error = "") {
            error = error.trim() == "" ? "Server error! Please try again" : error.trim();
            new AWN({
                position: 'top-right' // Change this to your preferred position
            }).alert(error);
        }
        const base_url = $('[name="base-url"]').attr('content');

        $(document).ready(function() {

            $('#loginForm').submit(function(event) {
                event.preventDefault();
                const form = $('#loginForm');
                const formData = new FormData($(this)[0]);

                $.ajax({
                    url: `${base_url}loginSubmit`,
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {

                        form.find('[type="submit"]').prop('disabled', true);
                        form.find('.form-loader').fadeIn();

                        form.find('.err').text('');
                    },
                    success: function(data) {

                        form.find('[type="submit"]').prop('disabled', false);
                        form.find('.form-loader').fadeOut();
                        if (data.status == 1) {
                            new AWN({
                                position: 'top-right'
                            }).success('Logged in successfully');
                            redirect(`${base_url}dashboard`);
                        } else {
 
                            new AWN({
                                position: 'top-right'
                            }).alert(data.msg);
                            if (data.errors && Object.keys(data.errors).length > 0) {
                                for (const key in data.errors) {
                                    if (data.errors.hasOwnProperty(key)) {
                                        console.log(`${key}: ${data.errors[key]}`);
                                        $(`#${key}_err`).text(data.errors[key]);
                                    }
                                }
                            }
                        }

                    },
                    error: function(err) {
                        form.find('[type="submit"]').prop('disabled', false);
                        form.find('.form-loader').fadeOut();
                        show_server_error(err.statusText);
                    }
                })


            });

        });
    </script>
</body>



</html>