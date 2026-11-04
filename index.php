<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg bg-secondary">
    <div class="container-fluid px-4">
        <a class="navbar-brand text-white fw-bold" href="#">XSATA-STORE</a>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <!-- batas awal navigasi -->
        <?php
        include 'menu.php';
        ?>
        <!-- batas akhir navigasi -->
        <!-- batas awal konten -->
        <?php include 'content.php';?>
        <!-- batas akhir content -->
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>