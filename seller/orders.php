<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

$seller_id = $_SESSION['user_id'];
$orders = $db->query("SELECT o.*, b.title, b.author, u.name as buyer_name 
                     FROM orders o 
                     JOIN books b ON o.book_id = b.book_id 
                     JOIN users u ON o.buyer_id = u.id 
                     WHERE o.seller_id = $seller_id 
                     ORDER BY o.order_date DESC")->fetchAll(PDO::FETCH_ASSOC);

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['status'];
    $tracking_number = $_POST['tracking_number'] ?? '';
    
    $stmt = $db->prepare("UPDATE orders SET status = ?, tracking_number = ? WHERE order_id = ?");
    $stmt->execute([$new_status, $tracking_number, $order_id]);
    
    header('Location: orders.php?updated=true');
    exit();
}
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>Order Management</h2>
        </div>
        
        <?php if (isset($_GET['updated'])): ?>
        <div class="alert alert-success">Order status updated successfully!</div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <?php if (empty($orders)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Orders Yet</h4>
                    <p class="text-muted">Your orders will appear here once customers purchase your books</p>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Book</th>
                                <th>Buyer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= $order['order_id'] ?></td>
                                <td>
                                    <div><strong><?= $order['title'] ?></strong></div>
                                    <small class="text-muted">by <?= $order['author'] ?></small>
                                </td>
                                <td><?= $order['buyer_name'] ?></td>
                                <td><?= date('M d, Y', strtotime($order['order_date'])) ?></td>
                                <td>₹<?= $order['price'] ?></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $order['status'] === 'Completed' ? 'success' : 
                                        ($order['status'] === 'Shipped' ? 'info' : 
                                        ($order['status'] === 'Pending' ? 'warning' : 'secondary')) ?>">
                                        <?= $order['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $order['payment_status'] === 'Completed' ? 'success' : 'warning' ?>">
                                        <?= $order['payment_status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderModal<?= $order['order_id'] ?>">
                                        <i class="fas fa-edit"></i> Update
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Order Modal -->
                            <div class="modal fade" id="orderModal<?= $order['order_id'] ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Order #<?= $order['order_id'] ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST">
                                            <div class="modal-body">
                                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select" name="status" required>
                                                        <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                                        <option value="Shipped" <?= $order['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                                                        <option value="Delivered" <?= $order['status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                                                        <option value="Completed" <?= $order['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
                                                        <option value="Cancelled" <?= $order['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Tracking Number</label>
                                                    <input type="text" class="form-control" name="tracking_number" value="<?= $order['tracking_number'] ?? '' ?>" placeholder="Enter tracking number">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="update_status" class="btn btn-primary">Update Status</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

