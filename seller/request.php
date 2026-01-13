<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

$seller_id = $_SESSION['user_id'];
$requests = $db->query("SELECT * FROM book_requests ORDER BY request_date DESC")->fetchAll(PDO::FETCH_ASSOC);

// Handle listing a book from a request
if (isset($_GET['list_book'])) {
    $request_id = $_GET['list_book'];
    $request = $db->query("SELECT * FROM book_requests WHERE request_id = $request_id")->fetch(PDO::FETCH_ASSOC);
    
    if ($request) {
        // Pre-fill the add book form with request details
        $_SESSION['prefill_book'] = [
            'title' => $request['book_title'],
            'author' => $request['author'] ?? '',
            'isbn' => $request['isbn'] ?? ''
        ];
        header('Location: add_books.php');
        exit();
    }
}
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0"><i class="fas fa-bullhorn me-2"></i>Buyer Requests</h2>
        </div>
        
        <div class="card">
            <div class="card-body">
                <?php if (empty($requests)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-book fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No Book Requests</h4>
                    <p class="text-muted">Buyer requests for books will appear here</p>
                </div>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Author</th>
                                <th>ISBN</th>
                                <th>Requested By</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($requests as $request): ?>
                            <tr>
                                <td><?= $request['book_title'] ?></td>
                                <td><?= $request['author'] ?? 'N/A' ?></td>
                                <td><?= $request['isbn'] ?? 'N/A' ?></td>
                                <td><?= $request['requester_name'] ?></td>
                                <td><?= date('M d, Y', strtotime($request['request_date'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= $request['status'] === 'Open' ? 'warning' : 'success' ?>">
                                        <?= $request['status'] ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="requests.php?list_book=<?= $request['request_id'] ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-plus me-1"></i>List This Book
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

