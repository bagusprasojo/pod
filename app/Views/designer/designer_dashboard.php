<?= $this->extend('templates/main_dashboard_designer') ?>



<?= $this->section('content') ?>
<div class="container mt-4 mb-4">
    <div class="main-body">
        <div class="row gutters-sm">
            <?php 
                include(APPPATH . 'Views/includes/_sidebar_designer.php');               
            ?>
            <div class="col-md-9">
              <div class="card mb-3" id="profile">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Designer Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?= $userData['name_designer'] ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?= $userData['name'] ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= $userData['email'] ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <?= $userData['address'] ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-12">
                      <a class="btn btn-info " target="__blank" href="">Change Password</a>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row gutters-sm">
                <div class="col-sm-12 mb-3">
                  <div class="card h-100">
                    <div class="card-body">
                      <h5 class="d-flex align-items-center mb-3">Trash Report by <?= $userData['name'];?></h5>
                      
                      

                      
                    </div>
                  </div>
                </div>                
              </div>



            </div>
          </div>

        </div>
    </div>
<?= $this->endSection() ?>