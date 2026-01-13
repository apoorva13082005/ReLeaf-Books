
<?php
session_start();
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/AuthController.php';

$authController = new AuthController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $result = $authController->register($name, $password, $email, $role);

    if ($result) {
        header('Location: login.php');
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Email may already exist.";
        header('Location: signup.php');
        exit();
    }
} else {
    header('Location: signup.php');
    exit();
}
?>