
<?php
session_start();
require 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$total = $conn->query(
    "SELECT COUNT(*) AS jumlah FROM siswa"
)->fetch_assoc()['jumlah'];

$tanggal = date('Y-m-d');

$hadir = $conn->query(
    "SELECT COUNT(*) AS jumlah FROM absensi
     WHERE tanggal='$tanggal' AND status='Hadir'"
)->fetch_assoc()['jumlah'];

$izin = $conn->query(
    "SELECT COUNT(*) AS jumlah FROM absensi
     WHERE tanggal='$tanggal' AND status='Izin'"
)->fetch_assoc()['jumlah'];

$sakit = $conn->query(
    "SELECT COUNT(*) AS jumlah FROM absensi
     WHERE tanggal='$tanggal' AND status='Sakit'"
)->fetch_assoc()['jumlah'];

$alfa = $conn->query(
    "SELECT COUNT(*) AS jumlah FROM absensi
     WHERE tanggal='$tanggal' AND status='Alfa'"
)->fetch_assoc()['jumlah'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Absensi</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary p-3">
    <span class="navbar-brand">ABSENSI KELAS</span>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</nav>

<div class="container mt-4">

    <h3>Selamat Datang,
    <?= htmlspecialchars($_SESSION['nama_admin']) ?></h3>

    <p>Dashboard Sistem Absensi Kelas</p>

    <div class="row g-3">

        <?php
        $data = [
            ['Total Siswa', $total, 'primary'],
            ['Hadir Hari Ini', $hadir, 'success'],
            ['Izin', $izin, 'info'],
            ['Sakit', $sakit, 'warning'],
            ['Alfa', $alfa, 'danger']
        ];

        foreach ($data as $item):
        ?>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5><?= $item[0] ?></h5>
                    <h2 class="text-<?= $item[2] ?>">
                        <?= $item[1] ?>
                    </h2>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    </div>

    <div class="mt-4">
        <a href="siswa.php" class="btn btn-primary">
            Data Siswa
        </a>

        <a href="absensi.php" class="btn btn-success">
            Input Absensi
        </a>

        <a href="laporan.php" class="btn btn-dark">
            Laporan Absensi
        </a>
    </div>

</div>
</body>
</html>
