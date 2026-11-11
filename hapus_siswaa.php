
<?php
session_start();
require 'config/koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);

    $stmt = $conn->prepare(
        "DELETE FROM siswa WHERE id_siswa=?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: siswa.php");
exit;
?>
