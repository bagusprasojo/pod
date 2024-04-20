<?= $this->extend('templates/main_dashboard_designer') ?>



<?= $this->section('content') ?>
<div class="container mt-4 mb-4">
    <div class="main-body">
        <div class="row">
            <?php 
                include(APPPATH . 'Views/includes/_sidebar_designer.php');               
            ?>
            <div class="col-md-9" >
                <div class="mb-3">
                    <a class="btn btn-primary" href="<?php echo base_url('/designer_dashboard/add_desain')?>" role="button">Add Desain</a>
                </div>
                <div class="card s-3 table-responsive">
                    <table id="desain-table" class="table dt-table-hover" >
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Tag</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>                    
                </div>
            </div>
        </div>
    </div>
</div>



<?= $this->endSection() ?>

<?= $this->section('script') ?>

<script>
        $(document).ready(function() {
            console.log('Masuk Ready');
            $('#desain-table').DataTable({
                processing: true,
                serverSide: true,
                
                ajax: '<?= base_url('/designer_dashboard/desain_list_') ?>'
            });
        });
    </script>

<?= $this->endSection() ?>

