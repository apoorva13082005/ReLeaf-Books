<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
?>

<div class="sidebar pt-4">
    <div class="text-center mb-4">
        <span class="rounded-circle bg-success text-white fw-bold" style="width:56px; height:56px; font-size:2rem; display:inline-flex; align-items:center; justify-content:center;">
            <?= strtoupper(substr($_SESSION['name'], 0, 1)); ?>
        </span> 
        <div class="mt-2 fw-bold"><?= htmlspecialchars($_SESSION['name']); ?></div>
        <div class="text-muted small">ID: <?= htmlspecialchars($_SESSION['user_id']); ?></div>
    </div>
    <ul class="nav flex-column px-3">
        <!-- 1. Dashboard -->
        <li class="nav-item mb-2">
            <a class="nav-link fw-bold" href="dashboard.php">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>
        <!-- 2. Inventory -->
        <li class="nav-item mb-2">
            <a class="nav-link fw-bold" data-bs-toggle="collapse" href="#inventoryMenu" role="button" aria-expanded="false" aria-controls="inventoryMenu">
                <i class="fas fa-boxes me-2"></i>Inventory <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="inventoryMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item"><a class="nav-link" href="add_book.php"><i class="fas fa-barcode me-2"></i>Add New Book</a></li>
                    <li class="nav-item"><a class="nav-link" href="my_books.php"><i class="fas fa-book me-2"></i>My Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="create_bundle.php"><i class="fas fa-layer-group me-2"></i>Create a Bundle</a></li>
                </ul>
            </div>
        </li>
        <!-- 3. Sales & Demand -->
        <li class="nav-item mb-2">
            <a class="nav-link fw-bold" data-bs-toggle="collapse" href="#salesMenu" role="button" aria-expanded="false" aria-controls="salesMenu">
                <i class="fas fa-shopping-cart me-2"></i>Sales & Demand <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="salesMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item"><a class="nav-link" href="orders.php"><i class="fas fa-receipt me-2"></i>Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="request.php"><i class="fas fa-user-tag me-2"></i>Buyer Requests</a></li>
                </ul>
            </div>
        </li>
        <!-- 4. Insights -->
        <li class="nav-item mb-2">
            <a class="nav-link fw-bold" data-bs-toggle="collapse" href="#insightsMenu" role="button" aria-expanded="false" aria-controls="insightsMenu">
                <i class="fas fa-chart-line me-2"></i>Insights <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="insightsMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item"><a class="nav-link" href="analytics.php"><i class="fas fa-chart-bar me-2"></i>Analytics & Performance</a></li>
                    <li class="nav-item"><a class="nav-link" href="reviews.php"><i class="fas fa-star me-2"></i>Reviews & Ratings</a></li>
                </ul>
            </div>
        </li>
        <!-- 5. Profile & Settings -->
        <li class="nav-item mb-2">
            <a class="nav-link fw-bold" data-bs-toggle="collapse" href="#profileMenu" role="button" aria-expanded="false" aria-controls="profileMenu">
                <i class="fas fa-user-cog me-2"></i>Profile & Settings <i class="fas fa-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="profileMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-user me-2"></i>My Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="bank_details.php"><i class="fas fa-university me-2"></i>Bank Details for Payouts</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item mt-3">
            <a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        </li>
    </ul>
</div>