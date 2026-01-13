
<?php
session_start();
require_once 'database.php';
require_once 'AuthController.php';

$authController = new AuthController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $result = $authController->register($name, $password, $email, $role);

    if ($result) {
        header('Location: login.php');
        exit();
    } else {
        $error = "Registration failed. Email may already exist.";
    }
}
?>

<?php include 'header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Sign Up</h2>
            <form method="post" action="signup_process.php">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select class="form-select" name="role" required>
                        <option value="buyer">Buyer</option>
                        <option value="seller">Seller</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>