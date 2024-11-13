<?= $this->extend('admin/layout/app'); ?>

<?= $this->section('meta_info') ?>
    <title><?= "Profile Update | " . APP_NAME ?></title>
    <style>
    .card-img-top {
        width: 100%;         
        height: 200px;       
        object-fit: cover;    
    }
    </style>
<?= $this->endSection() ?>

<?= $this->section('head_cdn') ?>
<!-- Add any required CDN links for the header -->
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Update Profile</h4>

                        <!-- Display Flash Message for Success or Error -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <!-- Profile Update Form -->
                        <form method="POST" action="<?= base_url('profile/update') ?>" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $user->name) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user->email) ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="picture">Profile Picture</label>
                                <input type="file" class="form-control" id="picture" name="picture">
                                <?php if ($user->picture): ?>
                                    <img src="<?= base_url('uploads/profile_pictures/' . $user->picture) ?>" alt="Profile Picture" class="mt-2" width="100">
                                <?php endif; ?>
                            </div>

                            <!-- Password Update Fields (Optional) -->
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password (optional)">
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm new password (optional)">
                            </div>

                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->

<?= $this->endSection(); ?>

<?= $this->section('footer_cdn') ?>
<!-- Add footer CDN links if necessary -->
<?= $this->endSection(); ?>
