<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="saas" data-theme-colors="default">
<head>
    <?= $this->section('meta_info') ?>
    <title><?= "Sign Up" ?></title>
    <meta name='base-url' content="<?= base_url() ?>">
    <?= $this->endSection() ?>
    <?= $this->renderSection('meta_info') ?>
    <?= $this->include('admin/partials/_head_cdn'); ?>
    <?= $this->renderSection('head_cdn'); ?>
</head>
<body>
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
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
                                                    <!-- Carousel content here -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Join Us!</h5>
                                            <p class="text-muted">Sign up to create an account on Velzon.</p>
                                        </div>
                                        <div class="p-2 mt-4">
                                            <?= form_open('register', ['id' => 'registerForm', 'method' => 'POST']); ?>
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" value="<?= old('name') ?>">
                                                <span class="err text-danger" id="name_err"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" value="<?= old('email') ?>">
                                                <span class="err text-danger" id="email_err"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <div class="position-relative auth-pass-inputgroup">
                                                    <input type="password" name="password" class="form-control pe-5" id="password" placeholder="Enter password">
                                                    <button class="btn btn-link position-absolute end-0 top-0 text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                </div>
                                                <span class="err text-danger" id="password_err"></span>
                                            </div>
                                            <div class="mb-3">
                                                <label for="picture" class="form-label">Profile Picture</label>
                                                <input type="file" name="picture" class="form-control" id="picture">
                                                <span class="err text-danger" id="picture_err"></span>
                                            </div>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-success w-100">
                                                    Sign Up
                                                    <div class="spinner-border text-light form-loader" role="status" style="display:none;">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </button>
                                            </div>
                                            <?= form_close() ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer galaxy-border-none">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0">&copy;
                                <script>document.write(new Date().getFullYear())</script> Velzon. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <?= $this->include('admin/partials/_footer_cdn'); ?>
    <?= $this->renderSection('footer_cdn'); ?>
    <script>
        const base_url = $('[name="base-url"]').attr('content');

        $(document).ready(function() {
            $('#registerForm').submit(function(event) {
                event.preventDefault();
                const form = $('#registerForm');
                const formData = new FormData($(this)[0]);

                $.ajax({
                    url: `${base_url}registerSubmit`,
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
                            alert('Registration successful! Please log in.');
                            window.location.href = `${base_url}signin`;
                        } else {
                            if (data.errors && Object.keys(data.errors).length > 0) {
                                for (const key in data.errors) {
                                    $(`#${key}_err`).text(data.errors[key]);
                                }
                            }
                        }
                    },
                    error: function(err) {
                        form.find('[type="submit"]').prop('disabled', false);
                        form.find('.form-loader').fadeOut();
                        alert("Server error! Please try again.");
                    }
                });
            });
        });
    </script>
</body>
</html>
