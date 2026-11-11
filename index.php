
<?php
session_start();

// Cek apakah admin sudah login
if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>
