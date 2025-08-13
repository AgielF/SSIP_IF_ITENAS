<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<main>
    <!-- Anda bisa menambahkan section berita di sini -->
    <?= $this->include('sections/agenda') ?>
    <?= $this->include('sections/topic') ?>
    
    <!-- TAMBAHKAN BARIS INI -->
    <?= $this->include('sections/visi_misi') ?>

</main>

<?= $this->include('layout/footer') ?>