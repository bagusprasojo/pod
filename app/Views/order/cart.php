<?= $this->extend('templates/main') ?>



<?= $this->section('content') ?>
<style type="text/css">
	.resultImage {
	    height: 110px;
	    width: auto;
	}

	.header-row {
        border: 1px solid #ccc; /* Tambahkan border */
        background-color: #f2f2f2; /* Tambahkan warna latar belakang */
        padding: 10px; /* Tambahkan padding agar tampilan lebih baik */
        margin-left: 1px;
        margin-right: 1px;
    }
</style>
<section class="py-10">
    <div class="container px-4 px-lg-5 my-5 ">
        <div class="row justify-content-left">
        	<div class="card col-sm-8 px-2 mx-1">
        		<div class="row justify-content-left mt-2 header-row">
        			<div class="col-sm-2 d-flex justify-content-center">
						<span class="h6">Item</span>
					</div>
					<div class="col-sm-4">
						
					</div>
					<div class="col-sm-6 d-flex align-items-start justify-content-end">
						<span class="h6">Harga & Qty</span>
					</div>
					
					
        		</div>
                <?php foreach ($data_carts as $data_cart) {?>
					<div id="baris_<?=$data_cart['id_cart']?>"  class="row justify-content-left mt-2">
						<div class="col-sm-2">
							<canvas id="canvas_<?=$data_cart['id_cart']?>" style="display: none;"></canvas>
                        	<img id="resultImage_<?=$data_cart['id_cart']?>" class="resultImage" src="<?= base_url('assets/produk/' . $data_cart['url_image']) ?>" alt="..." />
						</div>
						<div class="col-sm-7">
							<a href="#"><span class="h6"><?= $data_cart['desain'] ?></span></a><br>
							<span class=""><?= $data_cart['group_produk'] . ' ' . $data_cart['size'] ?></span><br>
							<span class=""><?= $data_cart['color_name'] ?></span><br>
							<a href="<?= site_url('order/remove_item_cart/' . $data_cart['uuid_cart']) ?>" class="btn btn-danger btn-sm">Hapus</a>
						</div>
						<div class="col-sm-3 ">
							<div class="row">
								<div class="col d-flex justify-content-center">
									<?= uang($data_cart['harga']) ?>										
								</div>
							</div>
							<div class="row">
								<div class="col d-flex justify-content-center">
									<button id_cart = "<?= $data_cart['id_cart'] ?>" uuid_cart = "<?= $data_cart['uuid_cart'] ?>" class="btn btn-secondary button-minus" id="button_minus_<?= $data_cart['id_cart'] ?>"> <i class="fa fa-minus"></i></button>
									<input disabled id="qty_<?= $data_cart['id_cart'] ?>" type="text" class="form-control text-center"  value="<?= $data_cart['qty'] ?>">
									<button id_cart = "<?= $data_cart['id_cart'] ?>" uuid_cart = "<?= $data_cart['uuid_cart'] ?>" class="btn btn-secondary button-plus" id="button_plus_<?= $data_cart['id_cart'] ?>"> <i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<hr class="mx-2 mt-1" style="width: 95%;">
	
					</div>
					
					
				<?php } ?>
		    </div>
		    <div class="card col-sm-3 px-2">
		    	<div class="row justify-content-left mt-2 header-row">
        			<div class="col-sm-12 d-flex justify-content-center">
						<span class="h6">Total Belanja</span>
					</div>					
				</div>
				<div class="row justify-content-left mt-2">
        			<div class="col-sm-6 d-flex justify-content-end">
						<span class="h6">Subtotal : </span>
					</div>
					<div class="col-sm-6 d-flex justify-content-end px-10">
						<span id="s_dpp" class="h6 px-2"><?= uang($dpp) ?></span>
					</div>
				</div>

				<div class="row justify-content-left mt-2">
        			<div class="col-sm-6 d-flex justify-content-end">
						<span class="h6">PPN : </span>
					</div>
					<div class="col-sm-6 d-flex justify-content-end px-10">
						<span id="s_ppn" class="h6 px-2"><?= uang($ppn) ?></span>
					</div>
				</div>
				<div class="row justify-content-left mt-2">
        			<div class="col-sm-6 d-flex justify-content-end">
						<span class="h6">Total : </span>
					</div>
					<div class="col-sm-6 d-flex justify-content-end px-10">
						<span id="s_total" class="h6 px-2"><?= uang($total) ?></span>
					</div>
				</div>
									
				<hr>
				<?php $uuid_user = ''; ?>
				<a type="button" href="<?= base_url('/order/pengiriman'); ?>" class="btn btn-primary mb-3">Beli</a>
					
				
		    </div>
        </div>
    </div>
</section>

<script>
	function mergeImage(url_image,url_desain, id_cart) {
            
        var cnv = "canvas_" + id_cart;
        console.log(cnv);
        var canvas = document.getElementById("canvas_" + id_cart);        
        var resultImage = document.getElementById("resultImage_" + id_cart);

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
        <?php foreach ($data_carts as $data_cart) {?>
            var url_image = '<?php echo base_url("assets/produk/") . $data_cart['url_image']; ?>';
            var url_desain = '<?php echo base_url("assets/desain/") . $data_cart['url_desain']; ?>';
            var id_cart = '<?php echo $data_cart['id_cart']; ?>';
            console.log(url_image);
            console.log(url_desain);
            console.log(id_cart);

            mergeImage(url_image, url_desain, id_cart);
        <?php }?>

    })

	function formatCurrency(amount) {
		    return amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
	}

	function IsiSummaryData(response){
		console.log('ini dpp');

		var dpp = response['dpp'];
		$("#s_dpp").text(formatCurrency(dpp));

		console.log('ini ppn');
    	var ppn = response['ppn'];
		$("#s_ppn").text(formatCurrency(ppn));

		console.log('ini ongkir');
		var ongkir = response['ongkir'];
		$("#s_ongkir").text(formatCurrency(ongkir));
    	
    	var total = response['total'];
    	console.log('ini total');
    	// console.log('response["total"]');
		$("#s_total").text(formatCurrency(total));
	}

    	
    $(document).on('click', '.button-minus', function() {
	    var id_cart = $(this).attr('id_cart');
	    
	    $.ajax({
	        url: '<?= base_url('/order/add_qty_cart') ?>/' + $(this).attr('uuid_cart') + '/-1',
	        type: 'GET',
	        dataType: 'json',
	        success: function(response) {
	        	console.log(response);
	        	if (response['qty_akhir'] == 0) {
	        		
	        		$('#span_jml_order').text(response['jml_order']);
	                $('#baris_'  + id_cart).empty(); // Menghapus isi dari div dengan kelas .baris_01
	            } else {
	            	$('#qty_' + id_cart).val(response['qty_akhir']);	            	
	            }
	            IsiSummaryData(response);                   
	        },
	        error: function(xhr, status, error) {
	            console.error(error);
	        }
	    });
	});

	$(document).on('click', '.button-plus', function() {
	    var id_cart = $(this).attr('id_cart');
	    
	    $.ajax({
	        url: '<?= base_url('/order/add_qty_cart') ?>/' + $(this).attr('uuid_cart') + '/1',
	        type: 'GET',
	        dataType: 'json',
	        success: function(response) {
	        	console.log(response);

	        	if (response['status']){
	        		$('#qty_' + id_cart).val(response['qty_akhir']);
	            	IsiSummaryData(response);                   	
	        	} else {
	        		Swal.fire({
	                    icon: 'warning',
	                    title: 'Oops...',
	                    text: response['pesan'],
	                    confirmButtonColor: '#3085d6',
	                    cancelButtonColor: '#d33',
	                    confirmButtonText: 'OK'
	                });
	        	}
	            
	        },
	        error: function(xhr, status, error) {
	            console.error(error);
	        }
	    });
	});

    
</script>
<?= $this->endSection() ?>