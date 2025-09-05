<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<main>
    <!-- Anda bisa menambahkan section berita di sini -->
    <?= $this->include('sections/agenda') ?>

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
