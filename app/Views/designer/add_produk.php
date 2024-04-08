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
                      <h6 class="mb-0">Upload Desain</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <input type="file" id="gambarInput" accept="image/png">
                    </div>
                  </div>                  
                               
                </div>
              </div>
              <div class="card mb-3" id="preview" style="display: none;">
                  <div class="card-body">
                      <div id="gambarPreview" style="text-align: center;">
                          
                      </div>
                  </div>
              </div>

              <div class="card mb-3" id="data" style="display: block;">
                <div class="card-body">
                  <div class="row  mb-3">
                    <div class="col-sm-2">
                      <h6 class="mb-0">Nama Desain</h6>
                    </div>
                    <div class="col-sm-10">
                      <input name="nama_desain" type="text" class="form-control" placeholder="Nama Desain">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <div class="col-sm-2">
                      <h6 class="mb-0">Tag</h6>
                    </div>
                    <div class="col-sm-10">
                      <input name="tag" type="text" class="form-control" placeholder="Tag">
                    </div>
                  </div>
                  
                  <div class="row mb-3">
                    <div class="col-sm-2">
                      <h6 class="mb-0">Deskripsi</h6>
                    </div>
                    <div class="col-sm-10">
                      <textarea name="deskripsi" class="form-control" aria-label="With textarea"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-3" id="data" style="display: block;">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <canvas id="canvas_o_hitam" style="display: none;"></canvas>
                      <img id="resultImage" style="width:100%; height: auto;" src="<?= base_url('img/produk/o_hitam.png')?>">
                    </div>
                    <div class="col-md-6">
                      <table class="table">
                        <thead class="thead-dark">
                          <tr>
                            
                            <th scope="col">Item</th>
                            <th scope="col">Aktif</th>
                            <th scope="col">Warna Dasar</th>
                          </tr>
                        </thead>
                        <tbody>
                          
                            <?php foreach ($groupProduks as $groupProduk): ?>
                              <tr>    
                                <td><button type="button" id="btn_group_<?=$groupProduk['id_group_produk']?>" class="btn btn-primary btn_group" style="width: 100%;"><?= $groupProduk['name'] ?></button></td>
                                <td><input id="checkbox_<?=$groupProduk['id_group_produk']?>" type="checkbox" ></td>
                                <td>
                                    <div  id="C"  class="row">
                                        <div id="A" class="col-sm-9">
                                            <select class="form-control colorSelect">
                                                <?php 
                                                    foreach ($produks as $produk): 
                                                        if ($produk['id_group_produk'] == $groupProduk['id_group_produk']){

                                                ?>
                                                    <option value="<?= $produk['color']?>" data-color="<?= $produk['color']?>" url-image="<?= base_url($produk['url_image'])?>"><?= $produk['color_name'] ?></option>
                                                    
                                                <?php } endforeach; ?>
                                            </select>
                                        </div>

                                        <div id="B"  class="col-sm-1">  
                                            <div class="selectedColor mb-2" style="border-radius: 50%; width: 40px; height: 40px; display: inline-block; margin-left: 1px;"></div>
                                        </div>

                                        
                                        
                                    </div>  
                                </td>
                              </tr>
                                
                            <?php endforeach; ?>                        
                            
                        </tbody>
                      </table>
                        
                    </div>
                  </div>
                </div>
              </div>

              

              
            </div>

            
          </div>

        </div>
    </div>

    <script>
        const gambarInput = document.getElementById('gambarInput');
        const gambarPreview = document.getElementById('gambarPreview');
        const btn_o_neck = document.getElementById('btn_o_neck');
        const btn_v_neck = document.getElementById('btn_v_neck');
        const hitamCheckbox = document.getElementById('hitamCheckbox');
        const previewDiv = document.getElementById("preview");
        const dataDiv = document.getElementById("data");

        gambarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.src = event.target.result;
                    img.style.minWidth = "300px";
                    img.style.maxWidth = "300px";
                    img.style.height = "auto";
                    gambarPreview.innerHTML = '';
                    gambarPreview.appendChild(img);

                    previewDiv.style.display = "block";
                    dataDiv.style.display = "block";
                };
                reader.readAsDataURL(file);

                var resultImage = document.getElementById("resultImage"); 
                var srcLama = resultImage.src;              
                resultImage.src = "<?= base_url('img/produk/default.png') ?>";
                // alert('message?: DOMString')
                // resultImage.src = srcLama;

                // myFunction(resultImage.src);
                // resultImage.src = srcLama;
            }
        });


        function handleImageProcessing(canvas, imgProdukSrc, imgDesignSrc, resultImage) {
            var ctx = canvas.getContext("2d");

            var imgProduk = new Image();
            var imgDesign = new Image();

            imgProduk.onload = function () {
                canvas.width = imgProduk.width;
                canvas.height = imgProduk.height;

                ctx.drawImage(imgProduk, 0, 0);

                imgDesign.onload = function () {
                    
                    var width = canvas.width / 4;
                    var height = (width * imgDesign.height) / imgDesign.width;

                    var x = (canvas.width - width) / 2;
                    var y = (canvas.height - height) / 3;


                    ctx.drawImage(imgDesign, x, y, width, height);

                    // Gabungkan gambar 1 dan gambar 2
                    var mergedImage = new Image();
                    mergedImage.src = canvas.toDataURL("image/png");
                    mergedImage.style.display = "block";

                    resultImage.src = mergedImage.src;
                    resultImage.style.display = "block";
                };


                imgDesign.src = imgDesignSrc;
                
            };

            imgProduk.src = imgProdukSrc;
        }

        function myFunction(url_image) {

            
            var fileInput1 = document.getElementById("gambarInput");
            var canvas = document.getElementById("canvas_o_hitam");
            var imgProdukSrc = url_image;

            var imgDesignSrc = URL.createObjectURL(fileInput1.files[0]);
            var resultImage = document.getElementById("resultImage");

            handleImageProcessing(canvas, imgProdukSrc, imgDesignSrc, resultImage);
            
        }
        
        document.addEventListener("DOMContentLoaded", function() {
            const btn_groups = document.querySelectorAll('.btn_group');
            
            btn_groups.forEach(function(btn_group) {

                // console.log(btn_group.id);
                btn_group.addEventListener('click', function() {
                    // Ambil nilai id group dari tombol
                    var groupId = this.id.split('_')[2]; // Mendapatkan id group dari id tombol
                    // console.log(groupId);

                    // Ambil nilai option yang dipilih dari select di dalam group yang sesuai
                    var select = document.querySelector('#btn_group_' + groupId).closest('tr').querySelector('select.colorSelect');
                    var selectedOption = select.options[select.selectedIndex];

                    // Ambil nilai url-image dari atribut data pada option yang dipilih
                    var imageUrl = selectedOption.getAttribute('url-image');

                    // Lakukan apapun yang perlu dilakukan dengan imageUrl
                    // console.log('URL Image:', imageUrl);

                    myFunction(imageUrl);
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            var selects = document.querySelectorAll('.colorSelect');
            
            selects.forEach(function(select) {

                console.log('XYZ');
                select.addEventListener('change', function() {
                    var selectedColor = this.options[this.selectedIndex].getAttribute('data-color');
                    var imageUrl = this.options[this.selectedIndex].getAttribute('url-image');
                    // var selectedColorElement = this.parentElement.parentElement.nextElementSibling.querySelector('.selectedColor');
                    console.log(this.parentElement.id);
                    console.log(this.parentElement.nextElementSibling);
                    // console.log(this.parentElement.prevElementSibling.id);

                    var selectedColorElement = this.parentElement.nextElementSibling.querySelector('.selectedColor');
                
                    // Atur warna dari elemen "selectedColor" sesuai dengan warna yang dipilih
                    selectedColorElement.style.backgroundColor = selectedColor;
                    myFunction(imageUrl);
                    // console.log(selectedColorElement);
                    
                    // selectedColorElement.style.backgroundColor = selectedColor;
                });
            });
        });

    </script>

<?= $this->endSection() ?>