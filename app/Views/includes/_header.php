<style>
    .blue-span {
        background-color: lightblue;
        border-radius: 25px 25px 25px 25px;
        padding: 5px 20px; /* Untuk memberikan ruang di dalam span */
        margin: 0 10px; /* Untuk memberikan jarak antara span */
        font-weight: bold;
        font-size: 15px;
    }

    

    .blue-span:hover {
        background-color: lightcoral; /* Warna latar belakang saat hover */
        border-radius: 25px 25px 25px 25px;
    }
</style>

<header class="py-2" style="background-color: #e3f2fd;">
    <div style="display: flex; justify-content: center;">        
            <?php 
            $group_produks = get_group_produk();
            foreach ($group_produks as $group_produk) {
        ?>
            <a class="blue-span btn btn-sm" href="/shop/<?= $group_produk['id_group_produk'] ?>"> <?= $group_produk['name'] ?></a>
        <?php
            }
        ?>
        </div>
</header>

