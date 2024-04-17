<?= $this->extend('templates/main') ?>



<?= $this->section('content') ?>

<style>
    /* Style untuk radio button */
    /* Merah */
    <?php foreach ($colors as $color) {
        $kelas = strtolower($color['color_name']);
        $kelas = preg_replace('/\s+/', '', $kelas);
    ?>
            input[type="radio"].<?= $kelas ?> + label::before {
            background-color: <?= $color['color'] ?>;
        }
    <?php } ?>
    

    /* Hide default radio button */
    input[type="radio"] {
        display: none;
    }

    /* Style untuk label */
    label {
        display: inline-block;
        cursor: pointer;
        padding-left: 15px; /* Ruang untuk radio button yang disesuaikan */
        position: relative;
        margin-right: 10px;
    }

    /* Style untuk menandai radio button yang terpilih */
    input[type="radio"] + label::before {
        content: "";
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 1px solid black;
        position: absolute;
        left: 0;
        top: 0;
    }

    input[type="radio"]:checked + label::before {
        content: "";
        display: inline-block;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid black;
        position: absolute;
        left: 0;
        top: 0;
    }
</style>
    <section class="py-10">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row justify-content-left">
                <div class="col-sm-6">
                    <div class="card h-100">
                        <canvas id="canvas" style="display: none;"></canvas>
                        <img id="resultImage" class="resultImage" src="<?= base_url('assets/produk/' . $desain['url_image']) ?>" alt="..." />
                        
                    </div>
                </div>
                <div class="col-sm-6">                    
                    <div>
                        <p class="h3"><?= $desain['judul']; ?></p>
                        <p>didesain oleh <strong><a href="#"><?= $desain['name']; ?></a></strong></p>
                        <small class="text-muted"><?= $desain['deskripsi']; ?></small>
                        <hr>
                        <p class="h6 warna">Warna : </p>

                        <div class="mb-4">
                            <!-- <form> -->
                        <?php foreach ($colors as $color) {
                                $kelas = strtolower($color['color_name']);
                                $kelas = preg_replace('/\s+/', '', $kelas);
                        ?>
                            <input id_produk="<?=$color['id_produk']?>" url_image="<?=$color['url_image']?>" nama_warna="<?=$color['color_name']?>" type="radio" id="<?=$kelas?>" class="<?=$kelas?>" name="color" value="<?=$color['color']?>"><label for="<?=$kelas?>"></label>
                        <?php }?>
                            <!-- </form> -->
                        </div>
                        <div><p class="h6">Ukuran : </p></div>
                        <div class="container">
                          <div class="row">
                            <div class="card col mx-1">XS</div>
                            <div class="card col mx-1">S</div>
                            <div class="card col mx-1">M</div>
                            <div class="card col mx-1">L</div>
                            <div class="card col mx-1">XL</div>
                            <div class="card col mx-1">XXL</div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<script type="text/javascript">
    function mergeImage(url_image,url_desain) {
            
        var canvas = document.getElementById("canvas");        
        var resultImage = document.getElementById("resultImage");

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
            // console.log(url_image);
            // console.log(sufix);

            // mergeImage(url_image, url_desain, sufix);
        

    });

    $(document).ready(function() {        
        $('input[type="radio"]').click(function() {
            var selectedColor = $(this).attr('nama_warna');
            var url_image = '<?= base_url('assets/produk/') ?>' + $(this).attr('url_image');
            var url_desain = '<?= base_url('assets/desain/') . $desain['url_desain'];?>';

            console.log(url_desain);

            $.ajax({
                url: '<?= base_url('produk_size_list_') ?>/' + $(this).attr('id_produk'), // URL endpoint untuk produk_size_list_ dengan parameter id_produk
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Memperbarui tampilan produk size menggunakan data yang diterima dari server
                    // Misalnya, Anda dapat memperbarui daftar produk size di dalam HTML
                    console.log(response); // Anda dapat menampilkan atau melakukan operasi lain dengan data yang diterima
                },
                error: function(xhr, status, error) {
                    console.error(error); // Tangani kesalahan jika terjadi
                }
            });

            $('.warna').text('Warna : ' + selectedColor);            
            $('#resultImage').attr('src', url_image);

            mergeImage(url_image, url_desain);
        });
    });

</script>
<?= $this->endSection() ?>