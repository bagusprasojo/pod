<!-- Di dalam view register.php -->
<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
    <style>
        .hidden {
            display: none;
        }
    </style>

    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
            <div class="card p-4" style="width: 400px;">

                
                <?php
                    $errors = session()->getFlashdata('errors');
                    if ($errors !== null) {
                        echo '<div class="alert alert-danger">' . implode('<br>', $errors) . '</div>';
                    }
                ?>

                <form action="<?= site_url('register'); ?>" method="post">
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?= isset($_SESSION['old']['username']) ? $_SESSION['old']['username'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email"value="<?= isset($_SESSION['old']['email']) ? $_SESSION['old']['email'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="konf_password" class="form-control" placeholder="Konfirmasi Password">
                    </div>
                    <?php
                      $checkbox_checked = "";
                      if(isset($_SESSION['old']['is_designer'])){                        
                        if($_SESSION['old']['is_designer'] == '1'){
                            $checkbox_checked = "checked";
                        }
                      }

                      // die();

                    ?>
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Nama" value="<?= isset($_SESSION['old']['name']) ? $_SESSION['old']['name'] : '' ?>">
                    </div>
                    <div class="mb-3">
                        <textarea name="alamat" class="form-control" placeholder="Alamat"></textarea>
                    </div>

                    <div class="form-check mb-3">
                      <input id = "is_designer" name = "is_designer" class="form-check-input" type="checkbox" value="1" id="is_designer" <?= $checkbox_checked ?>
                      <label class="form-check-label" for="is_designer">
                        Saya juga mendaftar sebagai designer
                      </label>
                    </div>

                    <?php 
                        $hidden = "hidden";
                        if($checkbox_checked == 'checked'){
                            $hidden = "";
                        }
                    ?>
                    <div id="textInputDesginer" class="mb-3 <?= $hidden ?>">
                        <input type="text" id="name_designer" name="name_designer" class="form-control" placeholder="Nama Designer" value="<?= isset($_SESSION['old']['name_designer']) ? $_SESSION['old']['name_designer'] : '' ?>">
                    </div>
                    
                    
                    <button type="submit" class="btn btn-success w-100">Daftar</button>
                </form>
            </div>
        </div>
    </div>

<?php
    unset($_SESSION['errors']);
    unset($_SESSION['old']);    
?>

<script>
    var checkbox = document.getElementById('is_designer');
    var textInputDiv = document.getElementById('textInputDesginer');
    checkbox.addEventListener('change', function() {
        // Jika checkbox tercentang, tampilkan div input text
        if (checkbox.checked) {
            textInputDiv.classList.remove('hidden');
        } else {
            textInputDiv.classList.add('hidden');
        }
    });
</script>

<?= $this->endSection() ?>
