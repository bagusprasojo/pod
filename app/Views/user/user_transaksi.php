<?= $this->extend('templates/main_dashboard_user') ?>





<?= $this->section('content') ?>

<style>
    .blue-span {
        background-color: lightblue;
        border-radius: 25px 25px 25px 25px;
        padding: 5px 20px; /* Untuk memberikan ruang di dalam span */
        margin: 0 1px; /* Untuk memberikan jarak antara span */
        font-weight: normal;
        font-size: 15px;
    }

    .selected-span {
        background-color: cyan;
        border-radius: 25px 25px 25px 25px;
        padding: 5px 20px; /* Untuk memberikan ruang di dalam span */
        margin: 0 1px; /* Untuk memberikan jarak antara span */
        font-weight: normal;
        font-size: 15px;
    }

    

    .blue-span:hover {
        background-color: lightcoral; /* Warna latar belakang saat hover */
        border-radius: 25px 25px 25px 25px;
    }
</style>

<div class="col-md-9">
  <div class="card mb-3" id="profile">
    <div class="card-body">
      <div class="row">
        <div class="col-md-7">

          <div class="input-group mb-3">
            <input type="text" class="form-control" id="filter_data" value="<?= $filter_data ?>" name="filter_data" placeholder="Cari transaksimu di sini" />
          </div>
        </div>  
        <div class="col-md-5">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <label class="input-group-text" for="inputGroupSelect01">Periode</label>
            </div>


            

              <input type="text" class="form-control"  id="daterange" name="daterange" value="<?= $filter_tgl ?>"  />
            
          </div>
        </div>  
      </div>
      <div class="row">
        <div class="col-sm-12">
          <strong>Status</strong>
          <button class="filter <?= ($status == 'Semua' ? 'selected-span' : 'blue-span') ?> btn btn-sm" onclick="Filter('Semua','')"> Semua	 </button>
          <button class="filter <?= ($status == 'Dibuat' ? 'selected-span' : 'blue-span') ?> btn btn-sm" onclick="Filter('Dibuat','')"> Dibuat </button>
          <button class="filter <?= ($status == 'Menunggu Pembayaran' ? 'selected-span' : 'blue-span') ?> btn btn-sm" onclick="Filter('Menunggu Pembayaran','')"> Menunggu Pembayaran </button>
          <button class="filter <?= ($status == 'Dibayar' ? 'selected-span' : 'blue-span') ?> btn btn-sm" onclick="Filter('Dibayar','')"> Dibayar </button>
          <button class="filter <?= ($status == 'Dikirim' ? 'selected-span' : 'blue-span') ?> btn btn-sm" onclick="Filter('Dikirim','')"> Dikirim </button>
          <button class="filter <?= ($status == 'Selesai' ? 'selected-span' : 'blue-span') ?> btn btn-sm" onclick="Filter('Selesai','')"> Selesai </button>
        </div>        
      </div>

      <?php foreach ($orders as $order) { ?>
      <div class="row px-2">
        <div class="card mt-2">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-2">
                <p class="h6">Tanggal</p> 
                <?= $order['tgl_order'] ?>
              </div>
              <div class="col-sm-2">
                <p class="h6">Status</p>
                <?= $order['status'] ?>
              </div>
              <div class="col-sm-3">
                <p class="h6">Ekspedisi</p>
                <?= $order['ekspedisi'] ?>
              </div>
              <div class="col-sm-2">
                <p class="h6">Total</p>
                <?= uang($order['total']) ?>
              </div>
              <div class="col-sm-3">
                <a class="btn btn-sm btn-primary">Detail</a>
                <a class="btn btn-sm btn-primary">History</a>
              </div>               
            </div>

            <?php foreach ($orderDetails as $detail) { ?>
            <?php  if ($order['id_order'] == $detail['id_order']) { ?>
              
            
              <div class="row mt-2">
                <div class="col-sm-2">
                  Gambar
                </div>
                <div class="col-sm-10">
                  <div class="row">
                    <p class="h6"><?= $detail['nama_group_produk'] . '-' . $detail['nama_desain'] . '-' . $detail['color_name']. '-' . $detail['size']?></p>
                    <?= $detail['qty'] . ' barang x ' . $detail['harga']?>

                  </div>

                </div>
              </div>
            <?php }} ?>

          </div>
        </div>
      </div>
      <?php } ?>
      
      <div class="row">
        <div class="col col-md-12">
          <?= $pager->links() ?>
        </div>
      </div>
    </div>      
  </div>
</div>

<script>

  function Filter(status, periode) {

    console.log(status);
    console.log(periode);

    var filterData = $('#filter_data').val();

    var daterange = periode;    
    if (periode == ''){
      daterange = $('#daterange').val();      
    }
    
    var url = '<?= site_url('user_dashboard/transaksi') ?>?status=' + status 
                                                                    + '&filter_data=' + filterData
                                                                    + '&filter_tgl=' + daterange;
    window.location.href = url;

  }

    $(function() {
      $('input[name="daterange"]').daterangepicker({
        opens: 'left'
      }, function(start, end, label) {
        

        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        // alert('message?: DOMString');

        Filter($('.selected-span').text().trim(), start.format('MM-DD-YYYY') + ' - ' +  end.format('MM-DD-YYYY'))
        
      });
    });


    $(document).ready(function() {
        var input = $('#filter_data');

        // Add an event listener for the 'keydown' event
        input.on('keydown', function(event) {
            if (event.key === 'Enter' || event.keyCode === 13) {
                event.preventDefault();

                var status = $('.selected-span').val(); // Replace with actual status value
                console.log(status);

                var periode = $("#daterange").val(); // Replace with actual periode value
                console.log(periode);

                Filter(status, periode);
            }
        });

        $('.filter').click(function(event) {
            event.preventDefault(); // Mencegah aksi default dari link yang diklik

            var selectedLink = $(this); // Mengambil link yang diklik

            // Mengubah kelas link yang diklik
            selectedLink.addClass('selected-span').removeClass('blue-span');

            // Mengubah kelas link lainnya
            $('.filter').not(selectedLink).removeClass('selected-span').addClass('blue-span');

            // var filterData = $('#filter_data').val();

            // $.ajax({
            //     url: <?= site_url('user_dashboard/transaksi') ?>,
            //     method: 'GET',
            //     data: { filter: filterData },
            //     success: function(response) {
            //         // Lakukan sesuatu dengan respons AJAX
            //     },
            //     error: function(xhr, status, error) {
            //         // Tangani kesalahan AJAX
            //     }
            // });
        });
    });

</script>

<?= $this->endSection() ?>