
<?php
session_start();
require 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$data = $conn->query(
    "SELECT siswa.*, kelas.nama_kelas
     FROM siswa
     LEFT JOIN kelas ON siswa.id_kelas=kelas.id_kelas
     ORDER BY siswa.id_siswa DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-4">

<h2>Data Siswa</h2>

<a href="dashboard.php" class="btn btn-secondary">Kembali</a>
<a href="tambah_siswa.php" class="btn btn-primary">Tambah Siswa</a>

<table class="table table-bordered mt-3">
<thead class="table-primary">
<tr>
    <th>No</th>
    <th>NIS</th>
    <th>Nama</th>
    <th>Jenis Kelamin</th>
    <th>Kelas</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>
<?php $no=1; while($s=$data->fetch_assoc()): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= htmlspecialchars($s['nis']) ?></td>
    <td><?= htmlspecialchars($s['nama_siswa']) ?></td>
    <td><?= $s['jenis_kelamin']=='L'?'Laki-laki':'Perempuan' ?></td>
    <td><?= htmlspecialchars($s['nama_kelas'] ?? '-') ?></td>
    <td>
        <a href="hapus_siswa.php?id=<?= $s['id_siswa'] ?>"
           class="btn btn-danger btn-sm"
           onclick="return confirm('Hapus siswa?')">
           Hapus
        </a>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

</body>
</html>
