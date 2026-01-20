<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

    <!-- 
      Karena file ini meng-extend layout utama, semua variabel yang dikirim 
      dari controller (seperti $asisten) akan tersedia di sini dan 
      di semua file yang di-include dari sini.
    -->
    <?= $this->include('sections/asisten_lab') ?>

<?= $this->endSection() ?>
