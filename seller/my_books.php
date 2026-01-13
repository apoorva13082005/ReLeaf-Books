<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

$seller_id = $_SESSION['user_id'];
$books = $db->query("SELECT * FROM books WHERE seller_id = $seller_id ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Handle book deletion
if (isset($_GET['delete'])) {
    $book_id = $_GET['delete'];
    $db->query("DELETE FROM books WHERE book_id = $book_id AND seller_id = $seller_id");
    header('Location: my_books.php?deleted=true');
    exit();
}

// Handle status change
if (isset($_GET['toggle_status'])) {
    $book_id = $_GET['toggle_status'];
    $book = $db->query("SELECT status FROM books WHERE book_id = $book_id AND seller_id = $seller_id")->fetch(PDO::FETCH_ASSOC);
    $new_status = $book['status'] === 'Available' ? 'Sold' : 'Available';
    $db->query("UPDATE books SET status = '$new_status' WHERE book_id = $book_id AND seller_id = $seller_id");
    header('Location: my_books.php?status_updated=true');
    exit();
}
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="fas fa-book me-2"></i>My Books</h2>
            <a href="add_books.php" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New Book
            </a>
        </div>
        
        <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-success">Book deleted successfully!</div>
        <?php endif; ?>
        
        <?php if (isset($_GET['status_updated'])): ?>
        <div class="alert alert-success">Book status updated successfully!</div>
        <?php endif; ?>
        
        <div class="row">
            <?php if (empty($books)): ?>
            <div class="col-12">
                <div class="card text-center py-5">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Books Added Yet</h4>
                    <p class="text-muted">Start by adding your first book to sell</p>
                    <a href="add_book.php" class="btn btn-primary mt-3">Add Your First Book</a>
                </div>
            </div>
            <?php else: ?>
            <?php foreach ($books as $book): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-img-top bg-light text-center py-4">
                        <i class="fas fa-book-open fa-3x text-secondary"></i>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-<?= $book['status'] === 'Available' ? 'success' : 'secondary' ?>">
                                <?= $book['status'] ?>
                            </span>
                            <span class="badge bg-info">₹<?= $book['price'] ?></span>
                        </div>
                        <h5 class="card-title"><?= $book['title'] ?></h5>
                        <p class="card-text text-muted">by <?= $book['author'] ?></p>
                        <p class="card-text"><small class="text-muted">Condition: <?= $book['book_condition'] ?></small></p>
                        <p class="card-text"><small class="text-muted">Added: <?= date('M d, Y', strtotime($book['created_at'])) ?></small></p>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <a href="edit_book.php?id=<?= $book['book_id'] ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <a href="my_books.php?toggle_status=<?= $book['book_id'] ?>" class="btn btn-sm btn-outline-<?= $book['status'] === 'Available' ? 'warning' : 'success' ?>">
                                <i class="fas fa-<?= $book['status'] === 'Available' ? 'times' : 'check' ?> me-1"></i>
                                <?= $book['status'] === 'Available' ? 'Mark Sold' : 'Mark Available' ?>
                            </a>
                            <a href="my_books.php?delete=<?= $book['book_id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this book?')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

