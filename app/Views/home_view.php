<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<main>
    <!-- Anda bisa menambahkan section berita di sini -->
    <?= $this->include('sections/jadwal_praktikum') ?>

    <!-- Section Berita -->
    <?= $this->include('sections/berita_kegiatan', ['berita_list' => $berita_list ?? []]) ?>

    <?php
        // Kirimkan variabel $fields ke dalam section 'topic'
        // Pastikan variabel $fields ada (didefinisikan di controller)
        if (isset($fields)) {
            echo $this->include('sections/topic', ['fields' => $fields]);
        }
    ?>

    <!-- TAMBAHKAN BARIS INI -->
    <?= $this->include('sections/visi_misi') ?>

</main>

<?= $this->include('layout/footer') ?>
