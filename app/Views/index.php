<?= $this->extend('templates/main') ?>
<?= $this->section('content') ?>
    <section class="py-10">
        <div class="container px-4 px-lg-5 mt-5">
            HOME
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