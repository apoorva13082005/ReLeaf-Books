<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}

// Sample reviews data
$reviews = [
    [
        'user' => 'Rahul Sharma',
        'rating' => 5,
        'book' => 'Python Crash Course',
        'comment' => 'Excellent condition! The book was exactly as described and delivered quickly.',
        'date' => '2 days ago',
        'verified' => true
    ],
    [
        'user' => 'Priya Patel',
        'rating' => 4,
        'book' => 'Data Structures',
        'comment' => 'Good book with some highlights. Fair price for the condition.',
        'date' => '1 week ago',
        'verified' => true
    ],
    [
        'user' => 'Amit Kumar',
        'rating' => 5,
        'book' => 'Organic Chemistry',
        'comment' => 'Perfect! Better than expected. Will buy from this seller again.',
        'date' => '2 weeks ago',
        'verified' => false
    ],
    [
        'user' => 'Neha Singh',
        'rating' => 3,
        'book' => 'UPSC GS Paper 1',
        'comment' => 'Book had more wear than described, but still usable for my needs.',
        'date' => '3 weeks ago',
        'verified' => true
    ]
];

// Calculate average rating
$total_rating = 0;
foreach ($reviews as $review) {
    $total_rating += $review['rating'];
}
$average_rating = count($reviews) > 0 ? $total_rating / count($reviews) : 0;
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0 text-success"><i class="fas fa-star me-2"></i>Reviews & Ratings</h2>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <span class="display-4 fw-bold text-success"><?= number_format($average_rating, 1) ?></span>
                    <span class="text-muted">/5</span>
                </div>
                <div>
                    <div class="text-warning">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star<?= $i <= round($average_rating) ? '' : '-half-alt' ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <small class="text-muted">Based on <?= count($reviews) ?> reviews</small>
                </div>
            </div>
        </div>

        <!-- Rating Summary -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card dashboard-card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Rating Distribution</h5>
                    </div>
                    <div class="card-body">
                        <?php for ($i = 5; $i >= 1; $i--): 
                            $count = count(array_filter($reviews, function($r) use ($i) { return $r['rating'] == $i; }));
                            $percentage = count($reviews) > 0 ? ($count / count($reviews)) * 100 : 0;
                        ?>
                        <div class="row align-items-center mb-2">
                            <div class="col-1">
                                <span class="text-warning"><?= $i ?> <i class="fas fa-star"></i></span>
                            </div>
                            <div class="col-8">
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: <?= $percentage ?>%"></div>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <small class="text-muted"><?= $count ?> (<?= round($percentage) ?>%)</small>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Review Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-3">
                            <div class="display-1 text-success"><?= round($average_rating * 20) ?>%</div>
                            <p class="text-muted">Positive Reviews</p>
                        </div>
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="p-2">
                                    <div class="h5 mb-0"><?= count($reviews) ?></div>
                                    <small class="text-muted">Total Reviews</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-2">
                                    <div class="h5 mb-0"><?= count(array_filter($reviews, function($r) { return $r['verified']; })) ?></div>
                                    <small class="text-muted">Verified</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews List -->
        <div class="card dashboard-card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Reviews</h5>
                <div class="btn-group">
                    <button class="btn btn-outline-primary active">All</button>
                    <button class="btn btn-outline-primary">5 Star</button>
                    <button class="btn btn-outline-primary">4 Star</button>
                    <button class="btn btn-outline-primary">3 Star</button>
                </div>
            </div>
            <div class="card-body">
                <?php if (count($reviews) > 0): ?>
                    <?php foreach ($reviews as $review): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1"><?= $review['user'] ?></h6>
                                <div class="text-warning mb-1">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-alt' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <small class="text-muted">For: <?= $review['book'] ?></small>
                            </div>
                            <div class="text-end">
                                <small class="text-muted"><?= $review['date'] ?></small>
                                <?php if ($review['verified']): ?>
                                    <div><span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Verified</span></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <p class="mb-0"><?= $review['comment'] ?></p>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-success me-2">
                                <i class="fas fa-thumbs-up me-1"></i>Helpful
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-reply me-1"></i>Reply
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-star fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Reviews Yet</h5>
                        <p class="text-muted">Your reviews will appear here once customers rate your books</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
