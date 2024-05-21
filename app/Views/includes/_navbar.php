<?php
    $session = session();
    $userData = $session->get();

    // if (array_key_exists('username', $userData) && $userData['username'] != '') {
?>
<nav class="navbar  navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container">
        <!-- Navbar Brand -->
        <a class="navbar-brand" href="<?= site_url() ?>">POD Center</a>

        <!-- Input dan Tombol Pencarian -->
        <form class="d-flex ms-auto">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

            <!-- Tombol Toggler untuk Device Kecil -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">


            <ul class="navbar-nav">
                    <a class="btn btn-outline-dark me-1" href="<?= site_url('order/show_cart') ?>">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span id="span_jml_order" class="badge bg-dark text-white ms-1 rounded-pill"><?= get_jml_order_cart();?></span>
                    </a>
                
                    <?php if (is_logged_in()) {?>
                        <a class="btn btn-outline-dark me-1" href="<?= site_url('user_dashboard') ?>">
                            <i class="bi-person-fill me-1"></i>
                            <?=$userData['name']?>
                        </a>

                        <?php if ($userData['is_designer'] == '1') {?>
                            <a class="btn btn-outline-dark me-1" href="<?= site_url('designer_dashboard') ?>">
                                <i class="bi-person-fill me-1"></i>
                                <?=$userData['name_designer']?>                        
                            </a>                        
                        <?php }?>                        
                        
                        <a class="btn btn-outline-dark me-1" href="<?= site_url('/logout') ?>">
                            <i class="bi bi-door-open-fill me-1"></i>
                            Logout                        
                        </a>
                    <?php } else {?>
                        <a class="btn btn-outline-dark me-1" href="<?= site_url('/login') ?>">
                            <i class="bi bi-door-open-fill me-1"></i>
                            Login                     
                        </a>
                    <?php }?>
                
            </ul>
        </div>        
    </div>
</nav>


