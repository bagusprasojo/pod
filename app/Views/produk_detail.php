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
    

    /* Hide default radio button warna*/
    input[type="radio"].radio_warna {
        display: none;
    }

    /* Hide default radio button warna*/
    input[type="radio"].radio_ukuran {
        display: none;
    }

    /* Style untuk label */
    label {
        display: inline-block;
        cursor: pointer;
        padding-left: 10px; /* Ruang untuk radio button yang disesuaikan */
        position: relative;
        margin-right: 40px;
    }

    /* Style untuk menandai radio button yang terpilih */
    input[type="radio"] + label::before {
        content: "";
        display: inline-block;
        width: 40px;
        height: 20px;
        border-radius: 10%;
        border: 1px solid black;
        position: absolute;
        left: 0;
        top: 0;
    }

    input[type="radio"]:checked + label::before {
        content: "";
        display: inline-block;
        width: 40px;
        height: 20px;
        border-radius: 10%;
        border: 3px solid black;
        position: absolute;
        left: 0;
        top: 0;
    }

    /*.selected {
        background-color: #f0f0f0; /* Atur warna latar belakang sesuai kebutuhan Anda */
        border: 2px solid blue; /* Atur border sesuai kebutuhan Anda */
    }*/
</style>
    <section class="py-10">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row justify-content-left">
                <div class="col-sm-4">
                    <div class="card h-100">
                        <canvas id="canvas" style="display: none;"></canvas>
                        <img id="resultImage" class="resultImage" src="<?= base_url('assets/produk/' . $desain['url_image']) ?>" alt="..." />                        
                    </div>
                </div>
                <div class="col-sm-8">
                    <form action="<?= site_url('order/add_cart') ?>" method="POST" enctype="multipart/form-data"  id="orderForm"> 
                        <?= csrf_field() ?>   
                        <input type="hidden" name="id_desain" value="<?= $desain['id_desain']; ?>">

                        <div class="row justify-content-left">
                            <p class="h3"><?= $desain['judul']; ?></p>
                                <p>didesain oleh <strong><a href="#"><?= $desain['name']; ?></a></strong></p>
                                <small class="text-muted"><?= $desain['deskripsi']; ?></small>
                                <hr>
                                <!-- <input type="file" name="image" class="form-control mb-3" id="image_hasil_akhir"> -->
                                
                            <div class="col-sm-8">
                                <div><p class="h6 warna">Warna : </p></div>

                                <div class="mb-4">
                                    
                                    <?php foreach ($colors as $color) {
                                            $kelas = strtolower($color['color_name']);
                                            $kelas = preg_replace('/\s+/', '', $kelas);
                                            $id = "id_" . $kelas;
                                            $kelas = 'radio_warna ' . $kelas;
                                            
                                            $checked = "";
                                            if($color['color'] == $desain['color']){
                                                $checked = "checked";
                                            }

                                    ?>
                                        <input <?= $checked ?> id_produk="<?=$color['id_produk']?>" url_image="<?=$color['url_image']?>" nama_warna="<?=$color['color_name']?>" type="radio" id="<?=$id?>" class="<?=$kelas?>" name="id_produk" value="<?=$color['id_produk']?>">
                                        <label class="label_warna" for="<?=$id?>"></label>
                                    <?php }?>
                                        
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div><p class="h6 mb-4">Ukuran : </p></div>
                                <div class="ukuran" >
                                    <!-- <input type="radio">XS</input> <div class="card col mx-1"></div>
                                    <div class="card col mx-1">S</div>
                                    <div class="card col mx-1">M</div>
                                    <div class="card col mx-1">L</div>
                                    <div class="card col mx-1">XL</div>
                                    <div class="card col mx-1">XXL</div> -->
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-left">
                            <hr>
                            <div class="col-sm-6">
                                <div class="row justify-content-left">
                                    <div class="col-sm-6 harga"></div>
                                    <div class="col-sm-6 stock"></div>
                                </div>
                            </div>
                            <div class="col-sm-6"><button type="submit" id="btn_add_to_cart" class="btn btn-primary">+ Keranjang</button></div>
                        </div>
                    </form>
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

                // console.log('Hasil : ');
                // console.log(resultImage.src);
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
        $(document).on('click', 'input.radio_ukuran[type="radio"]', function() {
            $('.label_ukuran').removeClass('selected');

            console.log($('.label_ukuran').removeClass(''));

            // Menambahkan kelas 'selected' ke div ukuran yang sesuai dengan radio button yang dipilih
            $(this).next().addClass('selected');

            // Mengatur semua radio button dengan kelas 'radio_warna' ke unchecked
            $('input.radio_ukuran[type="radio"]').prop('checked', false);

            // Mengatur radio button yang dipilih menjadi checked
            $(this).prop('checked', true);

            var harga = parseInt($(this).attr('harga'));
            var angkaDiformat = "Rp" + harga.toLocaleString('id-ID');
            var p_harga = $("<p>").addClass("h4").text(angkaDiformat);
            $(".harga").html(p_harga);

            var stock = parseInt($(this).attr('stock'));
            var p_stock = $("<p>").addClass("h4").text("Stock : " + $(this).attr('stock'));
            $(".stock").html(p_stock);

            if (stock > 0){
                $("#btn_add_to_cart").show();    
            } else {
                $("#btn_add_to_cart").hide();
            }
            

        });

        $(document).on('click', 'input.radio_warna[type="radio"]', function() {
            var selectedColor = $(this).attr('nama_warna');
            var url_image = '<?= base_url('assets/produk/') ?>' + $(this).attr('url_image');
            var url_desain = '<?= base_url('assets/desain/') . $desain['url_desain'];?>';

            console.log(url_desain);

            $.ajax({
                url: '<?= base_url('produk_size_list_') ?>/' + $(this).attr('id_produk'), // URL endpoint untuk produk_size_list_ dengan parameter id_produk
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log(response); 
                    // Anda dapat menampilkan atau melakukan operasi lain 
                    $('.ukuran').empty();
                    $('.harga').empty();
                    $('.stock').empty();

                    // Menambahkan ukuran produk dari data JSON yang diterima
                    $.each(response, function(index, product) {
                        var radioId = 'ukuran_' + product.id_produk_size;
                
                        // Buat radio button dan label untuk setiap ukuran produk
                        var radioInput = $('<input>').attr({
                            type: 'radio',
                            class: 'radio_ukuran',
                            harga: product.harga,
                            stock: product.stock,
                            value: product.id_produk_size,
                            name: 'id_produk_size',
                            id: radioId
                        });
                        var label = $('<label>').attr({
                            for: radioId,
                            class:'label_ukuran'
                        }).text(product.size);

                        // Tambahkan radio button dan label ke dalam elemen '.ukuran'
                        $('.ukuran').append(radioInput).append(label);

                        $("#btn_add_to_cart").hide();


                        
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error); // Tangani kesalahan jika terjadi
                }
            });

            $('.warna').text('Warna : ' + selectedColor);            
            $('#resultImage').attr('src', url_image);

            mergeImage(url_image, url_desain);
        });

        $('input.radio_warna:checked').trigger('click');
    });

    $('#orderForm').submit(function(event) {
        event.preventDefault(); // Mencegah submit form default

        var formData = new FormData(this);        
        var canvas = document.getElementById('canvas');
        canvas.toBlob(function(blob) {
            formData.append('image', blob, 'hasil_akhir.png');

            console.log(blob);

            // Kirim data form dengan Ajax
            $.ajax({
                url: '<?= site_url('order/add_cart') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    window.history.back(); 
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: response['pesan'],
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }, 'image/png');
    });

</script>
<?= $this->endSection() ?>