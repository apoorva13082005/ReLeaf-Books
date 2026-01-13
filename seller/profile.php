<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

$seller_id = $_SESSION['user_id'];
$seller = $db->query("SELECT * FROM users WHERE id = $seller_id")->fetch();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'] ?? '';
    $address = $_POST['address'] ?? '';
    
    try {
        $stmt = $db->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
        $stmt->execute([$name, $phone, $address, $seller_id]);
        $success = "Profile updated successfully!";
        // Refresh seller data
        $seller = $db->query("SELECT * FROM users WHERE id = $seller_id")->fetch();
    } catch (PDOException $e) {
        $error = "Error updating profile: " . $e->getMessage();
    }
}

// Get seller stats for profile
$books_count = $db->query("SELECT COUNT(*) FROM books WHERE seller_id = $seller_id")->fetchColumn();
$orders_count = $db->query("SELECT COUNT(*) FROM orders WHERE seller_id = $seller_id")->fetchColumn();
$total_earnings = $db->query("SELECT COALESCE(SUM(price), 0) FROM orders WHERE seller_id = $seller_id AND payment_status = 'Completed'")->fetchColumn();
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="row">
            <div class="col-lg-4">
                <!-- Profile Card -->
                <div class="card dashboard-card mb-4">
                    <div class="card-header bg-white text-center">
                        <div class="profile-avatar">
                            <div class="avatar-circle bg-success">
                                <span class="avatar-text"><?= strtoupper(substr($seller['name'], 0, 1)) ?></span>
                            </div>
                        </div>
                        <h4 class="mt-3 mb-1"><?= htmlspecialchars($seller['name']) ?></h4>
                        <p class="text-muted mb-0">Seller ID: #<?= $seller_id ?></p>
                        <span class="badge bg-success mt-2">Verified Seller</span>
                    </div>
                    <div class="card-body">
                        <div class="profile-stats">
                            <div class="stat-item">
                                <div class="stat-number"><?= $books_count ?></div>
                                <div class="stat-label">Books Listed</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number"><?= $orders_count ?></div>
                                <div class="stat-label">Orders</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">₹<?= number_format($total_earnings) ?></div>
                                <div class="stat-label">Earnings</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card dashboard-card">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="bank_details.php" class="btn btn-outline-primary">
                                <i class="fas fa-university me-2"></i>Bank Details
                            </a>
                            <a href="my_books.php" class="btn btn-outline-success">
                                <i class="fas fa-book me-2"></i>My Books
                            </a>
                            <a href="orders.php" class="btn btn-outline-info">
                                <i class="fas fa-shopping-cart me-2"></i>View Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <!-- Profile Edit Form -->
                <div class="card dashboard-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Profile Information</h5>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form method="post">
                            <input type="hidden" name="update_profile" value="1">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name *</label>
                                        <input type="text" name="name" class="form-control" 
                                               value="<?= htmlspecialchars($seller['name']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email Address</label>
                                        <input type="email" class="form-control" 
                                               value="<?= htmlspecialchars($seller['email']) ?>" readonly>
                                        <small class="text-muted">Email cannot be changed</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" name="phone" class="form-control" 
                                               value="<?= htmlspecialchars($seller['phone'] ?? '') ?>" 
                                               placeholder="+91 00000 00000">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" 
                                               value="<?= ucfirst($seller['role']) ?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" 
                                          placeholder="Enter your complete address"><?= htmlspecialchars($seller['address'] ?? '') ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Member Since</label>
                                <input type="text" class="form-control" 
                                       value="<?= date('F j, Y', strtotime($seller['created_at'])) ?>" readonly>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Update Profile
                                </button>
                                <a href="change_password.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-lock me-2"></i>Change Password
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="card dashboard-card mt-4">
                    <div class="card-header bg-white">
                        <h6 class="mb-0">Account Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="status-indicator bg-success"></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">Email Verification</div>
                                        <small class="text-muted">Verified</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="status-indicator bg-warning"></div>
                                    <div class="ms-3">
                                        <div class="fw-bold">Bank Account</div>
                                        <small class="text-muted">Pending verification</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-avatar {
    margin-top: -50px;
}
.avatar-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 4px solid white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.avatar-text {
    font-size: 2.5rem;
    font-weight: bold;
    color: white;
}
.profile-stats {
    display: flex;
    justify-content: space-around;
    text-align: center;
}
.stat-item {
    padding: 10px;
}
.stat-number {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary);
}
.stat-label {
    font-size: 0.9rem;
    color: #6c757d;
}
.status-indicator {
    width: 12px;
    height: 12px;
    border-radius: 50%;
}
</style>

