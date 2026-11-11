
<?php
session_start();
require 'config/koneksi.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare(
        "SELECT * FROM admin WHERE username = ?"
    );
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $admin = $stmt->get_result()->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin'] = $admin['id_admin'];
        $_SESSION['nama_admin'] = $admin['nama_admin'];

        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto shadow" style="max-width:400px">
        <div class="card-body">
            <h3 class="text-center">Login Admin</h3>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <label>Username</label>
                <input type="text" name="username"
                class="form-control mb-3" required>

                <label>Password</label>
                <input type="password" name="password"
                class="form-control mb-3" required>

                <button class="btn btn-primary w-100">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
