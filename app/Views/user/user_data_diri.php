<?= $this->extend('templates/main_dashboard_user') ?>



<?= $this->section('content') ?>

<div class="col-md-9">
  <div class="card mb-3" id="profile">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">User Name</h6>
        </div>
        <div class="col-sm-9 text-secondary">
          <?= $userData['username'] ?>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">Nama Lengkap</h6>
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
          <h6 class="mb-0">Alamat Utama</h6>
        </div>
        <div class="col-sm-9 text-secondary">
            <?= $userData['address'] ?>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-12">
          <a class="btn btn-info " target="__blank" href="">Ganti Password</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>