
<?php
session_start();
require 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $id_siswa = (int)$_POST['id_siswa'];
    $status = $_POST['status'];
    $keterangan = $_POST['keterangan'] ?? '';

    if (!in_array($status, ['Hadir','Izin','Sakit','Alfa'], true)) {
        die("Status tidak valid");
    }

    $stmt = $conn->prepare(
        "INSERT INTO absensi
         (id_siswa, tanggal, status, keterangan)
         VALUES (?, ?, ?, ?)
         ON DUPLICATE KEY UPDATE
         status=VALUES(status),
         keterangan=VALUES(keterangan)"
    );

    $stmt->bind_param(
        "isss",
        $id_siswa,
        $tanggal,
        $status,
        $keterangan
    );

    $stmt->execute();
}

$siswa = $conn->query("SELECT * FROM siswa ORDER BY nama_siswa");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Absensi</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">

<h2>Input Absensi Siswa</h2>

<form method="POST">

    <label>Tanggal</label>
    <input type="date" name="tanggal"
    value="<?= date('Y-m-d') ?>"
    class="form-control mb-3" required>

    <label>Nama Siswa</label>
    <select name="id_siswa" class="form-control mb-3" required>
        <?php while($s=$siswa->fetch_assoc()): ?>
        <option value="<?= $s['id_siswa'] ?>">
            <?= htmlspecialchars($s['nama_siswa']) ?>
        </option>
        <?php endwhile; ?>
    </select>

    <label>Status Kehadiran</label>
    <select name="status" class="form-control mb-3" required>
        <option value="Hadir">Hadir</option>
        <option value="Izin">Izin</option>
        <option value="Sakit">Sakit</option>
        <option value="Alfa">Alfa</option>
    </select>

    <label>Keterangan</label>
    <textarea name="keterangan"
    class="form-control mb-3"></textarea>

    <button class="btn btn-success">Simpan Absensi</button>
    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>

</form>

</body>
</html>
