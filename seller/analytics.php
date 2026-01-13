<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

$seller_id = $_SESSION['user_id'];

// Sample analytics data (in real app, you would query the database)
$total_books = rand(15, 50);
$books_sold = rand(5, 25);
$total_revenue = rand(5000, 25000);
$avg_rating = number_format(rand(35, 50) / 10, 1); // 3.5 to 5.0

// Monthly sales data for chart
$monthly_sales = [
    'January' => rand(5, 15),
    'February' => rand(5, 15),
    'March' => rand(5, 15),
    'April' => rand(5, 15),
    'May' => rand(5, 15),
    'June' => rand(5, 15),
    'July' => rand(5, 15),
    'August' => rand(5, 15),
    'September' => rand(5, 15),
    'October' => rand(5, 15),
    'November' => rand(5, 15),
    'December' => rand(5, 15)
];

// Top selling books
$top_books = [
    ['title' => 'Python Crash Course', 'sales' => 8, 'revenue' => 3600],
    ['title' => 'Data Structures', 'sales' => 6, 'revenue' => 2280],
    ['title' => 'Organic Chemistry', 'sales' => 5, 'revenue' => 2600],
    ['title' => 'UPSC GS Paper 1', 'sales' => 4, 'revenue' => 2400]
];
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 text-success"><i class="fas fa-chart-pie me-2"></i>Analytics & Performance</h2>
            <div class="btn-group">
                <button class="btn btn-outline-primary">Last 7 Days</button>
                <button class="btn btn-primary">Last 30 Days</button>
                <button class="btn btn-outline-primary">Last 90 Days</button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(46, 139, 87, 0.1); color: var(--primary);">
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-value"><?= $total_books ?></div>
                    <div class="stat-title">Total Books Listed</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(255, 107, 53, 0.1); color: var(--accent);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-value"><?= $books_sold ?></div>
                    <div class="stat-title">Books Sold</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(138, 90, 68, 0.1); color: var(--secondary);">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div class="stat-value">₹<?= number_format($total_revenue) ?></div>
                    <div class="stat-title">Total Revenue</div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(52, 152, 219, 0.1); color: #3498db;">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-value"><?= $avg_rating ?>/5</div>
                    <div class="stat-title">Average Rating</div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <div class="row g-4 mb-4">
            <div class="col-lg-8">
                <div class="chart-container">
                    <h5 class="mb-4">Monthly Sales Performance</h5>
                    <canvas id="salesChart" height="250"></canvas>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="chart-container">
                    <h5 class="mb-4">Top Selling Books</h5>
                    <div class="list-group">
                        <?php foreach ($top_books as $book): ?>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= $book['title'] ?></h6>
                                <small class="text-muted"><?= $book['sales'] ?> sold</small>
                            </div>
                            <span class="badge bg-success rounded-pill">₹<?= number_format($book['revenue']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Metrics -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="chart-container">
                    <h5 class="mb-4">Sales by Category</h5>
                    <canvas id="categoryChart" height="250"></canvas>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="chart-container">
                    <h5 class="mb-4">Performance Metrics</h5>
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <h3 class="text-success"><?= rand(70, 95) ?>%</h3>
                                <small>Conversion Rate</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="p-3 bg-light rounded">
                                <h3 class="text-success"><?= rand(1, 3) ?> days</h3>
                                <small>Avg. Time to Sell</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <h3 class="text-success"><?= rand(15, 45) ?>%</h3>
                                <small>Repeat Customers</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <h3 class="text-success">₹<?= number_format(rand(300, 800)) ?></h3>
                                <small>Avg. Order Value</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_keys($monthly_sales)) ?>,
            datasets: [{
                label: 'Books Sold',
                data: <?= json_encode(array_values($monthly_sales)) ?>,
                backgroundColor: 'rgba(46, 139, 87, 0.7)',
                borderColor: '#2e8b57',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Category Chart
    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    const categoryChart = new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: ['Academic', 'Fiction', 'Non-Fiction', 'Exam Prep'],
            datasets: [{
                data: [40, 25, 20, 15],
                backgroundColor: [
                    'rgba(46, 139, 87, 0.8)',
                    'rgba(255, 107, 53, 0.8)',
                    'rgba(138, 90, 68, 0.8)',
                    'rgba(52, 152, 219, 0.8)'
                ]
            }]
        }
    });
});
</script>

