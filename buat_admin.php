
<?php
require 'config/koneksi.php';

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$nama = "Administrator";

$stmt = $conn->prepare(
    "INSERT INTO admin (username, password, nama_admin)
     VALUES (?, ?, ?)"
);

$stmt->bind_param("sss", $username, $password, $nama);

if ($stmt->execute()) {
    echo "Admin berhasil dibuat!";
} else {
    echo "Gagal: " . $stmt->error;
}
?>
