<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@200..900&display=swap" rel="stylesheet">

        <title>Shop Homepage - Start Bootstrap Template</title>

        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="<?= base_url('css/styles.css') ?>" rel="stylesheet" />

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>plugins/table/datatable/datatables.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>plugins/table/datatable/dt-global_style.css">
        <script src="<?=base_url()?>plugins/table/datatable/datatables.js"></script>
        <style>
            .dataTables_paginate{
                float:right;
            }
            /* width */
            ::-webkit-scrollbar {
                width: 5px;
            }

            /* Track */
            ::-webkit-scrollbar-track {
                background: #d1d1d1; 
            }
            
            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: #d1d1d1; 
            }

            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: #d1d1d1; 
            }
            #sidebar ul.menu-categories li.menu:not(.active) > .dropdown-toggle[aria-expanded="true"] {
                background: #03759e;
            }
            .dt-buttons{
                margin-bottom:10px;
            }
            .dt-button{
                color: #fff !important;
                background-color: #03759e !important;
                border-color: #03759e;
                box-shadow: 0 10px 20px -10px#03759e;
            }

            .detail-first-line {
              font-optical-sizing: auto;
              font-weight:important;
              font-style:bold;
              font-variation-settings:"wdth" 100;
              font-size: 20px;
            }

            .detail-second-line {
              font-family: "Inconsolata", monospace;
              font-optical-sizing: auto;
              font-weight:!important;
              font-style: italic;
              font-variation-settings:"wdth" 100;
              font-size: 14px;
            }

        </style>

        <script src="<?=base_url()?>plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
        <script src="<?=base_url()?>plugins/table/datatable/button-ext/jszip.min.js"></script>    
        <script src="<?=base_url()?>plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
        <script src="<?=base_url()?>plugins/table/datatable/button-ext/buttons.print.min.js"></script>

    </head>
    
<body>
    <!-- Navbar -->
    
    <!-- Navigation-->
    <?php 
        include(APPPATH . 'Views/includes/_navbar.php');         
    ?>

    <!-- Content -->
    <div class="container mt-4 mb-4">
        <div class="main-body">
            <div class="row gutters-sm">
                <?php 
                    include(APPPATH . 'Views/includes/_sidebar_user.php');               
                ?>

                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
    
    <!-- Footer-->
    <?php 
        include(APPPATH . 'Views/includes/_footer.php'); 
    ?>        
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="<?= base_url('js/scripts.js') ?>"></script>

    <?= $this->renderSection('script') ?>

</body>
</html>
