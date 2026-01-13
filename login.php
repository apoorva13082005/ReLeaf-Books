
<?php
session_start();
require_once 'database.php';
require_once 'AuthController.php';

$authController = new AuthController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $authController->login($email, $password);

  
if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];
    if ($user['role'] === 'seller') {
        header('Location: seller/dashboard.php');
    } else {
        header('Location: seller/customer.php');
    }
    exit();
} else {
    $error = "Invalid email or password.";
}
}
?>
<?php include 'header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Sign Up</a></p>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>