<?php
    $session = session();
    $userData = $session->get();

    // if (array_key_exists('username', $userData) && $userData['username'] != '') {
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="<?= site_url() ?>">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="col-md-9">
                <form class="d-flex ms-auto" action="proses_pencarian.php" method="GET">
                    <input type="text" class="form-control me-2" placeholder="Cari produk..." aria-label="Cari produk...">
                    <button class="btn btn-outline-dark" type="submit">Cari</button>
                </form>
            </div>
        </div>
            
            <ul class="navbar-nav ms-auto">
                <form class="d-flex">
                    <button class="btn btn-outline-dark me-1" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
                <form class="d-flex">
                    <?php if (is_logged_in()) {?>
                        <form class="d-flex">
                            <a class="btn btn-outline-dark me-1" href="<?= site_url('user_dashboard') ?>">
                                <i class="bi-person-fill me-1"></i>
                                <?=$userData['name']?>
                            </a>
                        </form>
                        <?php if ($userData['is_designer'] == '1') {?>
                            <form class="d-flex">
                                <a class="btn btn-outline-dark me-1" href="<?= site_url('designer_dashboard') ?>">
                                    <i class="bi-person-fill me-1"></i>
                                    <?=$userData['name_designer']?>                        
                                </a>
                            </form>
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
                </form>                
            </ul>


        </div>
    </div>
</nav>
