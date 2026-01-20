<?= $this->include('layout/header') ?>

<?= $this->include('sections/slider') ?>

<?php
// Pass the asisten data to the included section
echo $this->include('sections/asisten_lab_admin', ['asisten' => $asisten]);
?>

<?= $this->include('layout/footer') ?>z