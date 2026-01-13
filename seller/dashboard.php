<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

// Get stats from DB with default values
$seller_id = $_SESSION['user_id'];

// Books uploaded (default to 0 if no books)
$books_uploaded = $db->query("SELECT COUNT(*) FROM books WHERE seller_id = $seller_id")->fetchColumn();
$books_uploaded = $books_uploaded ? $books_uploaded : 0;

// Books sold (default to 0 if no sales)
$books_sold = $db->query("SELECT COUNT(*) FROM books WHERE seller_id = $seller_id AND status = 'Sold'")->fetchColumn();
$books_sold = $books_sold ? $books_sold : 0;

// Books pending (default to 0 if no pending)
$books_pending = $db->query("SELECT COUNT(*) FROM books WHERE seller_id = $seller_id AND status = 'Available'")->fetchColumn();
$books_pending = $books_pending ? $books_pending : 0;

// Recent orders (empty array if none)
$recent_orders = $db->query("SELECT o.*, b.title as book_title, u.name as customer_name 
                             FROM orders o 
                             JOIN books b ON o.book_id = b.book_id 
                             JOIN users u ON o.buyer_id = u.id 
                             WHERE o.seller_id = $seller_id 
                             ORDER BY o.order_date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
$recent_orders = $recent_orders ? $recent_orders : [];

// Recent book requests (empty array if none)
$recent_requests = $db->query("SELECT * FROM book_requests ORDER BY request_date DESC LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
$recent_requests = $recent_requests ? $recent_requests : [];

// Estimated revenue (default to 0 if no sales)
$revenue_result = $db->query("SELECT SUM(price) as total_revenue FROM orders WHERE seller_id = $seller_id AND payment_status = 'Completed'")->fetch(PDO::FETCH_ASSOC);
$estimated_revenue = $revenue_result['total_revenue'] ? $revenue_result['total_revenue'] : 0;

// Example eco impact
$eco_water = $books_sold * 200; // 200L per book
$eco_co2 = $books_sold * 1; // 1kg per book
$trees_saved = $books_sold * 0.01; // Approximation
?>
<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<style>
/* Custom CSS to fix the layout issues */
.main-content {
    margin-left: 250px;
    padding-top: 20px;
    min-height: 100vh;
    background-color: #f8f9fa;
}

.dashboard-container {
    padding: 20px;
    max-width: 1400px;
    margin: 0 auto;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: transform 0.3s, box-shadow 0.3s;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    font-size: 24px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 5px;
    color: #2c3e50;
}

.stat-title {
    font-size: 14px;
    color: #7f8c8d;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.chart-container {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    margin-bottom: 25px;
    height: 100%;
}

.eco-stat-item {
    transition: transform 0.3s;
}

.eco-stat-item:hover {
    transform: scale(1.03);
}

.eco-stat-item i {
    font-size: 32px;
}

.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    color: #2c3e50;
}

.table-hover tbody tr:hover {
    background-color: rgba(52, 152, 219, 0.05);
}

.dashboard-header {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    margin-bottom: 25px;
}

@media (max-width: 992px) {
    .main-content {
        margin-left: 0;
    }
    
    .stat-card {
        margin-bottom: 15px;
    }
}

/* Animation for stats */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.stat-card {
    animation: fadeIn 0.6s ease-out forwards;
}

.stat-card:nth-child(2) { animation-delay: 0.1s; }
.stat-card:nth-child(3) { animation-delay: 0.2s; }
.stat-card:nth-child(4) { animation-delay: 0.3s; }
</style>

<div class="main-content">
    <div class="dashboard-container">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-1 text-success fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Seller Dashboard</h2>
                    <p class="text-muted mb-0">Welcome back, <?= $_SESSION['name'] ?>! Here's your selling overview.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addBookModal">
                        <i class="fas fa-plus me-2"></i>Add New Book
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(46, 139, 87, 0.1); color: #2e8b57;">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-value"><?= $books_uploaded ?></div>
                    <div class="stat-title">Books Uploaded</div>
                    <div class="text-success small mt-auto">
                        <i class="fas fa-arrow-up me-1"></i> Your inventory
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(255, 107, 53, 0.1); color: #ff6b35;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value"><?= $books_sold ?></div>
                    <div class="stat-title">Books Sold</div>
                    <div class="text-success small mt-auto">
                        <i class="fas fa-rupee-sign me-1"></i> Total sales
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(138, 90, 68, 0.1); color: #8a5a44;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-value"><?= $books_pending ?></div>
                    <div class="stat-title">Pending Listings</div>
                    <div class="text-success small mt-auto">
                        <i class="fas fa-eye me-1"></i> Available for sale
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(52, 152, 219, 0.1); color: #3498db;">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div class="stat-value">₹<?= number_format($estimated_revenue) ?></div>
                    <div class="stat-title">Estimated Revenue</div>
                    <div class="text-success small mt-auto">
                        From completed orders
                    </div>
                </div>
            </div>
        </div>

        <!-- Eco Impact Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="chart-container">
                    <h5 class="mb-4"><i class="fas fa-leaf me-2 text-success"></i>Your Environmental Impact</h5>
                    <div class="eco-stats">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="eco-stat-item text-center p-4 rounded mb-3" style="background-color: rgba(46, 139, 87, 0.1);">
                                    <i class="fas fa-tint fa-2x mb-3" style="color: #2e8b57;"></i>
                                    <h3><?= number_format($eco_water) ?> L</h3>
                                    <p class="mb-0">Water Saved</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="eco-stat-item text-center p-4 rounded mb-3" style="background-color: rgba(255, 107, 53, 0.1);">
                                    <i class="fas fa-cloud fa-2x mb-3" style="color: #ff6b35;"></i>
                                    <h3><?= number_format($eco_co2, 2) ?> kg</h3>
                                    <p class="mb-0">CO₂ Saved</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="eco-stat-item text-center p-4 rounded mb-3" style="background-color: rgba(138, 90, 68, 0.1);">
                                    <i class="fas fa-tree fa-2x mb-3" style="color: #8a5a44;"></i>
                                    <h3><?= number_format($trees_saved, 2) ?></h3>
                                    <p class="mb-0">Trees Equivalent</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <p class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                By selling <?= $books_sold ?> used books, you've made a positive environmental impact!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders and Book Requests -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Recent Orders</h5>
                        <a href="orders.php" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <?php if (!empty($recent_orders)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_orders as $order): ?>
                                <tr>
                                    <td><?= substr($order['book_title'], 0, 15) ?>...</td>
                                    <td><?= $order['customer_name'] ?></td>
                                    <td><?= date('M d', strtotime($order['order_date'])) ?></td>
                                    <td>₹<?= $order['price'] ?></td>
                                    <td><span class="badge bg-<?= $order['status'] == 'Completed' ? 'success' : 'warning' ?>"><?= $order['status'] ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No orders yet</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0"><i class="fas fa-book me-2 text-info"></i>Recent Book Requests</h5>
                        <a href="requests.php" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <?php if (!empty($recent_requests)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Requested By</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_requests as $request): ?>
                                <tr>
                                    <td><?= substr($request['book_title'], 0, 20) ?>...</td>
                                    <td><?= $request['requester_name'] ?></td>
                                    <td><?= date('M d', strtotime($request['request_date'])) ?></td>
                                    <td>
                                        <a href="add_books.php?title=<?= urlencode($request['book_title']) ?>&author=<?= urlencode($request['author']) ?>" class="btn btn-sm btn-outline-success">
                                            List This Book
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-book fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No book requests</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Book Modal -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Add New Book</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBookForm" action="add_book.php" method="POST">
                    <div class="mb-3">
                        <label for="bookTitle" class="form-label">Book Title *</label>
                        <input type="text" class="form-control" id="bookTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookAuthor" class="form-label">Author *</label>
                        <input type="text" class="form-control" id="bookAuthor" name="author" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookIsbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="bookIsbn" name="isbn">
                    </div>
                    <div class="mb-3">
                        <label for="bookEdition" class="form-label">Edition</label>
                        <input type="text" class="form-control" id="bookEdition" name="edition">
                    </div>
                    <div class="mb-3">
                        <label for="bookCondition" class="form-label">Condition *</label>
                        <select class="form-select" id="bookCondition" name="condition" required>
                            <option value="New-like">New-like</option>
                            <option value="Good" selected>Good</option>
                            <option value="Acceptable">Acceptable</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bookPrice" class="form-label">Price (₹) *</label>
                        <input type="number" class="form-control" id="bookPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookMaxPrice" class="form-label">Maximum Price (₹) *</label>
                        <input type="number" class="form-control" id="bookMaxPrice" name="max_price" required>
                    </div>
                    <div class="mb-3">
                        <label for="bookDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="bookDescription" name="description" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addBookForm" class="btn btn-primary">Add Book</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-calculate max price based on condition
        document.getElementById('bookCondition').addEventListener('change', function() {
            const price = parseFloat(document.getElementById('bookPrice').value) || 0;
            calculateMaxPrice(this.value, price);
        });
        
        document.getElementById('bookPrice').addEventListener('input', function() {
            const condition = document.getElementById('bookCondition').value;
            const price = parseFloat(this.value) || 0;
            calculateMaxPrice(condition, price);
        });
        
        function calculateMaxPrice(condition, price) {
            let multiplier = 1;
            switch(condition) {
                case 'New-like':
                    multiplier = 1.1;
                    break;
                case 'Good':
                    multiplier = 1.05;
                    break;
                case 'Acceptable':
                    multiplier = 1.0;
                    break;
            }
            document.getElementById('bookMaxPrice').value = (price * multiplier).toFixed(2);
        }
    });
</script>
