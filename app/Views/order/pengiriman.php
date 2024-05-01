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
        	<div class="col-sm-8">
        		<div class="card col-sm-12 mb-2 px-2">
        			<p class="h5">Alamat Pengiriman</p>
        			<div class="row">
        				<div class="col col-sm-1"><i class="fa fa-location-dot h6"> </i></div>
        				<div class="col col-sm-11"><strong><?= $alamat['label']  ?></strong></div>
        			</div>
        			<div class="row">
        				<div class="col col-sm-12"><?= $alamat['alamat']  ?></div>
        				<div class="col col-sm-12"><?= $alamat['kecamatan'] . ', ' . $alamat['kabupaten'] . ', ' . $alamat['provinsi'] . ', ' . $alamat['kode_pos'];?></div>
        			</div>
        			<div class="row my-3">
        				<div class="col col-sm-12"><a href="" class="btn btn-primary" >Ganti Alamat</a></div>
        			</div>
		    	</div>	
		    	<div class="card col-sm-12 px-2">
		    		<p class="h5">Pilih Jasa Pengiriman</p>
        			<div class="row">
        				<div class="col col-sm-1"><i class="fa-solid fa-truck"></i></div>
        				<div class="col col-sm-11"><strong>Jasa Pengiriman</strong></div>
        			</div>                
        			<div class="row">
        				<div class="col col-sm-12 px-3 py-3">
        					<select id="opt_ekspedisi" class="form-select" aria-label="Pilih ekspedisi">
							  <option value="" selected disabled hidden>Pilih ekspedisi</option>
							  <?php foreach ($ekspedisis as $ekspedisi) {?>

							  	<option uuid_ekspedisi="<?= $ekspedisi['uuid_ekspedisi'] ?>" value="<?= $ekspedisi['id_ekspedisi'] ?>"><?= $ekspedisi['nama'] ?></option>	
							  	
							  <?php }?>						  
							</select>
        				</div>
        			</div>
		    	</div>	
                
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
						<span class="h6">Ongkos Kirim : </span>
					</div>
					<div class="col-sm-6 d-flex justify-content-end px-10">
						<span id="s_ongkir" class="h6 px-2"><?= uang($ongkir) ?></span>
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
				<button id="button_bayar" type="button" class="btn btn-primary mb-3">Pilih Pembayaran</button>
					
				
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

	function formatCurrency(amount) {
		    return amount.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });
	}

	function IsiSummaryData(response){
		var dpp = response['dpp'];
		$("#s_dpp").text(formatCurrency(dpp));

    	var ppn = response['ppn'];
		$("#s_ppn").text(formatCurrency(ppn));

		var ongkir = response['ongkir'];
		$("#s_ongkir").text(formatCurrency(ongkir));
    	
    	var total = response['total'];
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

	$(document).on('click', '#button_bayar', function() {
		$.ajax({
	        url: '<?= base_url('/order/bayar_midtrans') ?>/<?= $uuid_order ?>',
	        type: 'GET',
	        dataType: 'json',
	        success: function(response) {
	        	console.log(response);

	        	if (response['status']){
	        		window.location.replace(response['url_redirect']);                 	
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

	$(document).ready(function(){
    $('#opt_ekspedisi').change(function(){
    	var uuid_ekspedisi = $('option:selected', this).attr('uuid_ekspedisi');
	        
        $.ajax({
        	url: '<?= base_url('/order/get_ongkir') ?>/<?= $uuid_order ?>/' + uuid_ekspedisi,
	        type: 'GET',
	        dataType: 'json',
	        success: function(response) {
	        	console.log(response);
	        	if (response['status']) {	        		
	        		IsiSummaryData(response);
	        		$('#button_order').attr('href', '<?= base_url('/order/checkout/') ?>' + uuid_ekspedisi);
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
});

    
</script>
<?= $this->endSection() ?>