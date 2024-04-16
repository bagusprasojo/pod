<?= $this->extend('templates/main_dashboard_designer') ?>



<?= $this->section('content') ?>
<div class="container mt-4 mb-4">
    <div class="main-body">
        <div class="row gutters-sm">
            <?php 
                include(APPPATH . 'Views/includes/_sidebar_designer.php');               
            ?>
            <div class="col-md-9">
              <form enctype="multipart/form-data" method="POST" action="<?= base_url('designer_dashboard/add_produk') ?>"> 
                  <?= csrf_field() ?>           
                  <div class="card mb-3" id="profile">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-sm-3">
                          <h6 class="mb-0">Upload Desain</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">                          
                          <input type="file" name="gambarInput" id="gambarInput" accept="image/png">
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
                                <?php foreach ($groupProduks as $groupProduk): ?>
                                <div class="col-md-6">
                                    <div class="card mb-3" id="data" style="display: block;">
                                        <div class="card-body">
                                            <table width="100%">
                                                <tr>
                                                    <td><input value="<?=$groupProduk['id_group_produk']?>" name="cb_<?=$groupProduk['id_group_produk']?>" id="cb_<?=$groupProduk['id_group_produk']?>" type="checkbox" class="checkbox"/>
                                                        <label for="cb_<?=$groupProduk['id_group_produk']?>"><b><?=$groupProduk['name']?></b></label><br>
                                                    </td>
                                                    <td>
                                                        <select name="select_<?=$groupProduk['id_group_produk']?>" id="select_<?=$groupProduk['id_group_produk']?>" class="form-control colorSelect">
                                                            <?php 
                                                                foreach ($produks as $produk): 
                                                                    if ($produk['id_group_produk'] == $groupProduk['id_group_produk']) {
                                                                        $selected = "";
                                                                        if ($produk['color'] == $groupProduk['color']){
                                                                            $selected = "selected";
                                                                        }

                                                            ?>
                                                                        <option <?= $selected ?> value="<?= $produk['color']?>" data-color="<?= $produk['color']?>" url-image="<?= base_url('assets/produk/' . $produk['url_image'])?>"><?= $produk['color_name'] ?></option>
                                                                
                                                            <?php } endforeach; ?>
                                                        </select>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <canvas id="canvas_<?=$groupProduk['id_group_produk']?>" style="display: none;"></canvas>
                                                        <img id="resultImage_<?=$groupProduk['id_group_produk']?>" style="width:100%; height: auto;" src="<?= base_url('assets/produk/' . $groupProduk['url'])?>">
                                                    </td>
                                                </tr>
                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach ?>
                            </div>    
                        </div>
                  </div>
                  <div class="card mb-3" id="data" style="display: block;">
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12">
                          <button type="submit"  class="btn btn-primary">Simpan</button>
                            
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
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

                    var checkboxs = document.querySelectorAll('.checkbox');

                    checkboxs.forEach(function(checkbox) {
                        checkbox.dispatchEvent(new Event('change'));
                    });
                };
                reader.readAsDataURL(file);                
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

        function mergeImage(url_image, sufix) {

            
            console.log("sufix : " + sufix);
            console.log("url_image : " + url_image);
            var fileInput1 = document.getElementById("gambarInput");
            var canvas = document.getElementById("canvas_" + sufix);
            
            var imgProdukSrc = url_image;

            var imgDesignSrc = URL.createObjectURL(fileInput1.files[0]);
            var resultImage = document.getElementById("resultImage_" + sufix);

            handleImageProcessing(canvas, imgProdukSrc, imgDesignSrc, resultImage);
            
        }

        function myFunction(url_image) {

            
            var fileInput1 = document.getElementById("gambarInput");
            var canvas = document.getElementById("canvas_o_hitam");
            var imgProdukSrc = url_image;

            var imgDesignSrc = URL.createObjectURL(fileInput1.files[0]);
            var resultImage = document.getElementById("resultImage");

            handleImageProcessing(canvas, imgProdukSrc, imgDesignSrc, resultImage);
            
        }
        
        // document.addEventListener("DOMContentLoaded", function() {
        //     const btn_groups = document.querySelectorAll('.btn_group');
            
        //     btn_groups.forEach(function(btn_group) {

        //         // console.log(btn_group.id);
        //         btn_group.addEventListener('click', function() {
        //             // Ambil nilai id group dari tombol
        //             var groupId = this.id.split('_')[2]; // Mendapatkan id group dari id tombol
        //             // console.log(groupId);

        //             // Ambil nilai option yang dipilih dari select di dalam group yang sesuai
        //             var select = document.querySelector('#btn_group_' + groupId).closest('tr').querySelector('select.colorSelect');
        //             var selectedOption = select.options[select.selectedIndex];

        //             // Ambil nilai url-image dari atribut data pada option yang dipilih
        //             var imageUrl = selectedOption.getAttribute('url-image');

        //             // Lakukan apapun yang perlu dilakukan dengan imageUrl
        //             // console.log('URL Image:', imageUrl);

        //             myFunction(imageUrl);
        //         });
        //     });
        // });

        document.addEventListener("DOMContentLoaded", function() {
            var selects = document.querySelectorAll('.colorSelect');
            
            selects.forEach(function(select) {

                select.addEventListener('change', function() {
                    var imageUrl = this.options[this.selectedIndex].getAttribute('url-image');
                    var sufix = this.id.split('_')[1];
                    mergeImage(imageUrl,sufix);
                    
                });
            });

            var checkboxs = document.querySelectorAll('.checkbox');
            
            checkboxs.forEach(function(checkbox) {

                checkbox.addEventListener('change', function() {
                    var sufix = this.id.split('_')[1];

                    var select = document.getElementById("select_" + sufix);
                    var selectedColor = select.options[select.selectedIndex].getAttribute('data-color');
                    var imageUrl = select.options[select.selectedIndex].getAttribute('url-image');
                    
                    
                    mergeImage(imageUrl,sufix);
                    
                });
            });
        });

        // function save_data(){
        //     alert('message?: DOMString');
        // }

    </script>

    

<?= $this->endSection() ?>