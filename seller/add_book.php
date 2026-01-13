<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';
$available_categories = [
    'Academic Textbooks',
    'Engineering & Technology',
    'Medical & Health Sciences',
    'UPSC & Civil Services',
    'School Level Books',
    'Fiction & Literature',
    'Non-Fiction',
    'Self-Help & Personal Development',
    'Competitive Exams',
    'Children\'s Books',
    'Computer Science & Programming',
    'Business & Economics',
    'Law & Legal Studies',
    'Arts & Photography',
    'Biographies & Memoirs'
];


// Fetch categories from database
// This should work after adding the name column
$categories = $db->query("SELECT * FROM book_categories ORDER BY book_id")->fetchAll(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $seller_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $isbn = $_POST['isbn'] ?? '';
    $edition = $_POST['edition'] ?? '';
    $book_condition = $_POST['book_condition'];
    $price = $_POST['price'];
    $description = $_POST['description'] ?? '';
    $selected_categories = $_POST['categories'] ?? [];
    
    // Calculate max price based on condition (DISCOUNT for second-hand)
    $max_price = $price;
    switch($book_condition) {
        case 'New-like':
            $max_price = $price * 0.7; // 30% discount
            break;
        case 'Good':
            $max_price = $price * 0.6; // 40% discount
            break;
        case 'Acceptable':
            $max_price = $price * 0.5; // 50% discount
            break;
    }
    
    // Handle image upload
    $image_url = '';
    if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/books/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES['book_image']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '_' . time() . '.' . $file_extension;
        $file_path = $upload_dir . $file_name;
        
        // Check if image file is actual image
        $check = getimagesize($_FILES['book_image']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['book_image']['tmp_name'], $file_path)) {
                $image_url = 'uploads/books/' . $file_name;
            }
        }
    }
    
    try {
        $db->beginTransaction();
        
        // Insert book - CORRECTED for your table structure
        $stmt = $db->prepare("INSERT INTO books (seller_id, title, author, isbn, edition, book_condition, price, max_price, description, image_url) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$seller_id, $title, $author, $isbn, $edition, $book_condition, $price, $max_price, $description, $image_url]);
        $book_id = $db->lastInsertId();
        
        // Insert categories into book_categories junction table
     if (!empty($category_name)) {
            $stmt = $db->prepare("INSERT INTO book_categories (book_id, name) VALUES (?, ?)");
            $stmt->execute([$book_id, $category_name]);
        }
        
        $db->commit();
        $success = "Book added successfully with category: $category_name!";
    } catch (PDOException $e) {
        $db->rollBack();
        $error = "Error adding book: " . $e->getMessage();
    }
}
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card dashboard-card">
                    <div class="card-header bg-white">
                        <h4 class="mb-0 text-success"><i class="fas fa-plus-circle me-2"></i>Add New Book</h4>
                        <p class="text-muted mb-0">List your book for sale on our platform</p>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" id="addBookForm" enctype="multipart/form-data">
                            <!-- Book Basic Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 text-success">
                                        <i class="fas fa-book me-2"></i>Book Information
                                    </h5>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookTitle" class="form-label">Book Title *</label>
                                        <input type="text" class="form-control" id="bookTitle" name="title" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookAuthor" class="form-label">Author *</label>
                                        <input type="text" class="form-control" id="bookAuthor" name="author" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="bookIsbn" class="form-label">ISBN</label>
                                        <input type="text" class="form-control" id="bookIsbn" name="isbn" placeholder="Optional">
                                        <small class="text-muted">13-digit ISBN number</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="bookEdition" class="form-label">Edition</label>
                                        <input type="text" class="form-control" id="bookEdition" name="edition" placeholder="e.g., 3rd Edition">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="categoryName" class="form-label">Category *</label>
                                        <select class="form-select" id="categoryName" name="category_name" required>
                                            <option value="">Select a Category</option>
                                            <?php foreach ($available_categories as $category): ?>
                                                <option value="<?= htmlspecialchars($category) ?>"><?= htmlspecialchars($category) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted">Choose the most relevant category for your book</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Or Add New Category</label>
                                        <input type="text" class="form-control" id="newCategory" placeholder="Type new category name">
                                        <button type="button" class="btn btn-outline-secondary mt-2" onclick="addNewCategory()">
                                            <i class="fas fa-plus me-2"></i>Add New Category
                                        </button>
                                    </div>
                                </div>
                            
                            </div>
                            
                            <!-- Condition & Pricing -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 text-success">
                                        <i class="fas fa-tag me-2"></i>Condition & Pricing
                                    </h5>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="bookCondition" class="form-label">Condition *</label>
                                        <select class="form-select" id="bookCondition" name="book_condition" required>
                                            <option value="New-like">New-like (30% off)</option>
                                            <option value="Good" selected>Good (40% off)</option>
                                            <option value="Acceptable">Acceptable (50% off)</option>
                                        </select>
                                        <small class="text-muted">Select the current condition of your book</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Original Price (₹) *</label>
                                        <input type="number" class="form-control" id="price" name="price" required min="1" step="0.01">
                                        <small class="text-muted">What you originally paid</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="maxPrice" class="form-label">Selling Price (₹)</label>
                                        <input type="number" class="form-control" id="maxPrice" name="max_price" readonly>
                                        <small class="text-muted">Calculated selling price</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bookImage" class="form-label">Book Cover Image</label>
                                        <input type="file" class="form-control" id="bookImage" name="book_image" accept="image/*">
                                        <small class="text-muted">Upload clear photos of front, back, and any damage</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Description -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 text-success">
                                        <i class="fas fa-align-left me-2"></i>Description
                                    </h5>
                                    <div class="mb-3">
                                        <label for="bookDescription" class="form-label">Book Description *</label>
                                        <textarea class="form-control" id="bookDescription" name="description" rows="4" required 
                                                  placeholder="Describe the book's condition, any highlights/notes, why you're selling, etc."></textarea>
                                        <small class="text-muted">Be honest about any damage or markings</small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Barcode Scanner -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 text-success">
                                        <i class="fas fa-barcode me-2"></i>Quick ISBN Scanner
                                    </h5>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Use our barcode scanner to automatically fill book details (mobile only)
                                    </div>
                                    
                                    <div class="text-center">
                                        <div class="mb-3">
                                            <div id="scannerPlaceholder" class="scanner-placeholder">
                                                <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">Click below to activate camera scanner</p>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-outline-success" id="startScanner">
                                            <i class="fas fa-camera me-2"></i>Activate ISBN Scanner
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg py-3">
                                    <i class="fas fa-check-circle me-2"></i>List Book for Sale
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.scanner-placeholder {
    width: 100%;
    height: 200px;
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.scanner-placeholder:hover {
    border-color: #2e8b57;
    background: #eafaf1;
}

.form-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    border-radius: 10px;
    background: #f8f9fa;
    border-left: 4px solid #2e8b57;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate selling price based on condition
    const conditionSelect = document.getElementById('bookCondition');
    const priceInput = document.getElementById('price');
    const maxPriceInput = document.getElementById('maxPrice');
    
    function calculateSellingPrice() {
        const condition = conditionSelect.value;
        const price = parseFloat(priceInput.value) || 0;
        let discount = 0;
        
        switch(condition) {
            case 'New-like':
                discount = 0.3; // 30% discount
                break;
            case 'Good':
                discount = 0.4; // 40% discount
                break;
            case 'Acceptable':
                discount = 0.5; // 50% discount
                break;
        }
        
        const sellingPrice = price * (1 - discount);
        maxPriceInput.value = sellingPrice.toFixed(2);
        
        // Update the option texts to show discounts
        const options = conditionSelect.options;
        for (let i = 0; i < options.length; i++) {
            if (options[i].value === 'New-like') options[i].text = 'New-like (30% off)';
            if (options[i].value === 'Good') options[i].text = 'Good (40% off)';
            if (options[i].value === 'Acceptable') options[i].text = 'Acceptable (50% off)';
        }
    }
    
    // Add event listeners
    conditionSelect.addEventListener('change', calculateSellingPrice);
    priceInput.addEventListener('input', calculateSellingPrice);
    
    // Also trigger calculation when page loads
    calculateSellingPrice();
    
    // Barcode scanner simulation
    const startScannerBtn = document.getElementById('startScanner');
    const scannerPlaceholder = document.getElementById('scannerPlaceholder');
    
    startScannerBtn.addEventListener('click', function() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            alert("Camera access requested. In production, this would activate your camera for barcode scanning.");
        } else {
            alert("Barcode scanner requires camera access. Please use a mobile device or enable camera permissions.");
        }
        
        // Simulate scanning a book
        setTimeout(() => {
            document.getElementById('bookTitle').value = "Introduction to Algorithms";
            document.getElementById('bookAuthor').value = "Thomas H. Cormen";
            document.getElementById('bookIsbn').value = "9780262033848";
            document.getElementById('bookEdition').value = "3rd Edition";
            document.getElementById('price').value = "2500";
            calculateSellingPrice(); // This should trigger the calculation
            
            scannerPlaceholder.innerHTML = `
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <p class="text-success fw-bold">ISBN Scanned Successfully!</p>
                <p class="text-muted small">Introduction to Algorithms detected</p>
            `;
        }, 2000);
    });
    
    // Form validation
    document.getElementById('addBookForm').addEventListener('submit', function(e) {
        const price = parseFloat(priceInput.value);
        if (price <= 0) {
            e.preventDefault();
            alert("Please enter a valid price greater than ₹0.");
            priceInput.focus();
        }
    });
});
</script>

