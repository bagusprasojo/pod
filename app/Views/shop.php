<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
    <section class="py-10">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-3 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-left">
                <?php foreach($desains as $desain) { ?>
                <div class="col mb-3">
                    <div class="card h-100">
                        <!-- Product image-->
                        <canvas id="canvas_<?=$desain['id_desain']?>" style="display: none;"></canvas>
                        <a href="<?=base_url('/detail/' . $desain['uuid_desain_gp'])?>">
                            <img id="resultImage_<?=$desain['id_desain']?>" class="card-img-top" src="<?= base_url('assets/produk/' . $desain['url_image']) ?>" alt="..." />
                        </a>
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder"><?= $desain['nama'] ?></h5>
                                <!-- Product name-->
                                <div class="text-secondary">by <?= $desain['user'] ?></div>
                                <!-- Product price-->
                                <div class="fw-bolder text-danger"><?= uang($desain['harga_min']) . ' - ' . uang($desain['harga_max']); ?></div>
                                
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">
                                <a class="btn btn-outline-dark mt-auto" href="<?=base_url('/detail/' . $desain['uuid_desain_gp'])?>">View Detail</a>
                                <a class="btn btn-outline-dark mt-auto" href="<?=base_url('/detail/' . $desain['uuid_desain_gp'])?>">Beli</a>

                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
                
            </div>
            <div>
                <?= $pager->links() ?>
            </div>
        </div>
    </section>

<script type="text/javascript">
    function mergeImage(url_image,url_desain, sufix) {
            
        var canvas = document.getElementById("canvas_" + sufix);        
        var resultImage = document.getElementById("resultImage_" + sufix);

        handleImageProcessing(canvas, url_image, url_desain, resultImage);
        
    }

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

    document.addEventListener("DOMContentLoaded", function() {
        <?php foreach($desains as $desain) { ?>
            var url_image = '<?php echo base_url("assets/produk/") . $desain['url_image']; ?>';
            var url_desain = '<?php echo base_url("assets/desain/") . $desain['url_desain']; ?>';
            var sufix = '<?php echo $desain['id_desain']; ?>';
            console.log(url_image);
            console.log(sufix);

            mergeImage(url_image, url_desain, sufix);
        <?php }?>

    })
</script>
<?= $this->endSection() ?>