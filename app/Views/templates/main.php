<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Homepage - Start Bootstrap Template</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= base_url('css/styles.css') ?>" rel="stylesheet" />
        <script src="https://kit.fontawesome.com/1f76d780ab.js" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <script src="https://pod.test/assets/js/libs/jquery-3.6.0.min.js"></script>
    </head>
    
<body>
    <!-- Navbar -->
    
    <!-- Navigation-->
    <?php 
        // session();
        include(APPPATH . 'Views/includes/_navbar.php'); 
        // include(APPPATH . 'Views/includes/_navbar2.php'); 
        include(APPPATH . 'Views/includes/_header.php'); 
    ?>

    <!-- Content -->
    <?= $this->renderSection('content') ?>
    
    <!-- Footer-->
    <?php 
        include(APPPATH . 'Views/includes/_footer.php'); 
    ?>        
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="<?= base_url('js/scripts.js') ?>"></script>

</body>
</html>
