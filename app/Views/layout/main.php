<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<!-- Area Konten Utama -->
<div class="main-content">
    <!-- Di sinilah konten dari setiap halaman akan dimuat -->
    <?= $this->renderSection('content') ?>
</div>

<!-- Memuat komponen footer -->
<?= $this->include('layout/footer') ?>
