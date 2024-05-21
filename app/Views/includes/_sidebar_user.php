            <div class="col-md-3 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?= base_url('img/User-icon.png'); ?>" alt="Admin" class="rounded-circle" width="150">
                    
                    <div class="mt-3">
                      <h4><?= $userData['name'] ?></h4>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-regular fa-file" aria-hidden="true"></i><a href="<?= site_url('user_dashboard/transaksi') ?>">Transaksi</a></h6>
                    <span class="text-secondary">0</span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-regular fa-comments" aria-hidden="true"></i><a href="<?= site_url('user_dashboard') ?>">Biodata Diri</a></h6>
                    <span class="text-secondary"></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-regular fa-comment-dots" aria-hidden="true"></i>Daftar Alamat</h6>
                    <span class="text-secondary"><?= 3 ?></span>
                  </li>                  
                </ul>
              </div>
            </div>