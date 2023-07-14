<?= $this->extend('layouts/frontend.php') ?>

<?= $this->section('content') ?>

<?php
session_start();
if (!isset($_SESSION['user'])) 
{
    header('Location: '.base_url('login'));
    exit();
}
?>

<h1>Welcome, <?= $_SESSION['user']['name'] ?></h1>


<?= $this->endSection() ?>
