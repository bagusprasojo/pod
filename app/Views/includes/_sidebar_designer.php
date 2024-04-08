            <div class="col-md-3 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?= base_url('img/User-icon.png'); ?>" alt="Admin" class="rounded-circle" width="150">
                    
                    <div class="mt-3">
                      <h4><?= $userData['name_designer'] ?></h4>
                      
                    </div>
                  </div>
                </div>
              </div>
              <div class="card mt-3">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-regular fa-file" aria-hidden="true"></i><a href="<?= site_url('designer_dashboard/add_produk') ?>">Produk</a></h6>
                    <span class="text-secondary"><?= 1 ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-regular fa-comments" aria-hidden="true"></i>Comment In</h6>
                    <span class="text-secondary"><?= 2 ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-regular fa-comment-dots" aria-hidden="true"></i>Comment Out</h6>
                    <span class="text-secondary"><?= 3 ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-regular fa-eye" aria-hidden="true"></i>Trash Report Views</h6>
                    <span class="text-secondary"><?= 4 ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-solid fa-person-walking-arrow-loop-left"></i>Follower</h6>
                    <span class="text-secondary"><?= $userData['follower_count'] ?></span>
                  </li>
                  <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                    <h6 class="mb-0"><i class="mr-2 fa-solid fa-person-walking-arrow-right"></i>Following</h6>
                    <span class="text-secondary"><?= $userData['following_count'] ?></span>
                  </li>
                </ul>
              </div>
            </div>