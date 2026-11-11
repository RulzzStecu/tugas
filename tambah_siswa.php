
<?php
session_start();
require 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $jk = $_POST['jk'];
    $kelas = (int)$_POST['kelas'];

    $stmt = $conn->prepare(
        "INSERT INTO siswa
         (nis, nama_siswa, jenis_kelamin, id_kelas)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("sssi", $nis, $nama, $jk, $kelas);

    if ($stmt->execute()) {
        header("Location: siswa.php");
        exit;
    } else {
        $error = "Gagal menambahkan siswa. Pastikan NIS belum digunakan.";
    }
}

$kelas = $conn->query("SELECT * FROM kelas");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="container mt-5">

<h2>Tambah Data Siswa</h2>

<?php if(isset($error)): ?>
<div class="alert alert-danger">
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<form method="POST">

    <label>NIS</label>
    <input type="text" name="nis" class="form-control mb-3" required>

    <label>Nama Siswa</label>
    <input type="text" name="nama" class="form-control mb-3" required>

    <label>Jenis Kelamin</label>
    <select name="jk" class="form-control mb-3" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <label>Kelas</label>
    <select name="kelas" class="form-control mb-3" required>
        <?php while($k=$kelas->fetch_assoc()): ?>
        <option value="<?= $k['id_kelas'] ?>">
            <?= htmlspecialchars($k['nama_kelas']) ?>
        </option>
        <?php endwhile; ?>
    </select>

    <button class="btn btn-primary">Simpan</button>
    <a href="siswa.php" class="btn btn-secondary">Kembali</a>

</form>
</body>
</html>
