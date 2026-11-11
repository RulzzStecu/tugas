
<?php
session_start();
require 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$tanggal = $_GET['tanggal'] ?? date('Y-m-d');

$stmt = $conn->prepare(
    "SELECT siswa.nis, siswa.nama_siswa,
            kelas.nama_kelas, absensi.status,
            absensi.keterangan
     FROM absensi
     JOIN siswa ON absensi.id_siswa=siswa.id_siswa
     LEFT JOIN kelas ON siswa.id_kelas=kelas.id_kelas
     WHERE absensi.tanggal=?
     ORDER BY siswa.nama_siswa"
);

$stmt->bind_param("s", $tanggal);
$stmt->execute();
$data = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-4">

<h2>Laporan Absensi Kelas</h2>

<form method="GET" class="mb-3">
    <input type="date" name="tanggal"
    value="<?= htmlspecialchars($tanggal) ?>"
    class="form-control" style="max-width:250px">

    <button class="btn btn-primary mt-2">Tampilkan</button>
    <button type="button" onclick="window.print()"
    class="btn btn-success mt-2">Cetak Laporan</button>
</form>

<table class="table table-bordered">
<thead class="table-primary">
<tr>
    <th>No</th>
    <th>NIS</th>
    <th>Nama</th>
    <th>Kelas</th>
    <th>Status</th>
    <th>Keterangan</th>
</tr>
</thead>

<tbody>
<?php $no=1; while($r=$data->fetch_assoc()): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($r['nis']) ?></td>
    <td><?= htmlspecialchars($r['nama_siswa']) ?></td>
    <td><?= htmlspecialchars($r['nama_kelas'] ?? '-') ?></td>
    <td><?= htmlspecialchars($r['status']) ?></td>
    <td><?= htmlspecialchars($r['keterangan'] ?? '') ?></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<a href="dashboard.php" class="btn btn-secondary">Kembali</a>

</body>
</html>
