<?php echo $this->extend('admin/layout/app'); ?>


<?= $this->section('meta_info')?>
    <title><?= "Dashboard | " . APP_NAME ?></title>
<?=$this->endSection()?>

<?= $this->section('head_cdn') ?>
<!-- Include any CDN links specific to the dashboard if needed -->
<?= $this->endSection(); ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <!-- Dashboard welcome section -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Welcome to Your Dashboard, <?= session()->get('user')['name'] ?>!</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <!-- Profile picture display -->
                            <img src="<?= base_url('uploads/profile_pictures/' . session()->get('user')['picture']) ?>" alt="Profile Picture" class="rounded-circle" width="50" height="50">
                            <div class="ms-3">
                                <h5><?= session()->get('user')['name'] ?></h5>
                                <p class="text-muted"><?= session()->get('user')['email'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      

    </div>
    <!-- container-fluid -->
</div>

<?= $this->endSection(); ?>

<?= $this->section('footer_cdn') ?>
<!-- Include footer-specific CDN links if needed -->
<?= $this->endSection(); ?>
