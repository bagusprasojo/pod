<!-- Di dalam view register.php -->
<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="height: 50vh;">
            <div class="card p-4" style="width: 400px;">                
                <?php
                    $success = session()->getFlashdata('success');
                    if ($success !== null) {
                        echo '<div class="alert alert-success">' . $success . '</div>';
                    }

                    $errors = session()->getFlashdata('errors');
                    if ($errors !== null) {
                        echo '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
                    } 
                ?>

                <h5>Silakan Login</h5>

                <form action="<?= site_url('login') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Username / Email" >
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-success w-100">Login</button>
                </form>            
                <div class="mt-3">
                <a href="#">Lupa Password</a> | <a href="<?= base_url('register');?>">Daftar</a>
                </div>
            </div>
        </div>
    </div>

<?php
    unset($_SESSION['errors']);
?>

<?= $this->endSection() ?>
