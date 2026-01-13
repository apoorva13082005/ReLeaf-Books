<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

$seller_id = $_SESSION['user_id'];

// Handle bundle creation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_bundle'])) {
    $bundle_name = $_POST['bundle_name'];
    $bundle_description = $_POST['bundle_description'];
    $bundle_price = $_POST['bundle_price'];
    $book_ids = $_POST['books'] ?? [];
    
    // In a real application, you would create a bundles table and bundle_items table
    // For this example, we'll just show a success message
    $success = "Bundle created successfully!";
}

// Get seller's books for bundle creation
$books = $db->query("SELECT * FROM books WHERE seller_id = $seller_id AND status = 'Available'")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="fas fa-gift me-2"></i>Book Bundles</h2>
        </div>
        
        <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Create New Bundle</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Bundle Name *</label>
                                <input type="text" class="form-control" name="bundle_name" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="bundle_description" rows="3"></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Select Books for Bundle *</label>
                                <?php if (!empty($books)): ?>
                                <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                    <?php foreach ($books as $book): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="books[]" value="<?= $book['book_id'] ?>" id="book<?= $book['book_id'] ?>">
                                        <label class="form-check-label" for="book<?= $book['book_id'] ?>">
                                            <?= $book['title'] ?> (₹<?= $book['price'] ?>)
                                        </label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php else: ?>
                                <p class="text-muted">No available books to add to bundle</p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Bundle Price (₹) *</label>
                                <input type="number" class="form-control" name="bundle_price" required min="1" step="0.01">
                                <small class="text-muted">Set a discounted price for the bundle</small>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" name="create_bundle" class="btn btn-primary" <?= empty($books) ? 'disabled' : '' ?>>Create Bundle</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Your Bundles</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-5">
                            <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No Bundles Created Yet</h4>
                            <p class="text-muted">Create your first bundle to offer discounted book sets</p>
                        </div>
                        
                        <!-- Sample bundle (would be dynamic in real application) -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h5 class="card-title">Computer Science Semester Bundle</h5>
                                        <p class="card-text">A collection of essential books for computer science students</p>
                                        <div class="d-flex align-items-center">
                                            <span class="text-success fw-bold me-2">₹1,499</span>
                                            <span class="text-muted text-decoration-line-through">₹1,899</span>
                                            <span class="badge bg-success ms-2">Save 21%</span>
                                        </div>
                                    </div>
                                    <span class="badge bg-info">3 books</span>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-sm btn-outline-primary me-2">Edit Bundle</button>
                                    <button class="btn btn-sm btn-outline-success me-2">View Details</button>
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

