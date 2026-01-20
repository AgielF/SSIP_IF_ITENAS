<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<?php
// Pass the publicationData to the included section
echo $this->include('sections/publikasi_ilmiah_admin', ['publicationData' => $publicationData]);
?>

<?= $this->include('layout/footer') ?>