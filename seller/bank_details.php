<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'seller') {
    header('Location: ../login.php');
    exit();
}
require_once '../database.php';

$seller_id = $_SESSION['user_id'];

// Check if bank details exist
$bank_details = $db->query("SELECT * FROM seller_bank_details WHERE seller_id = $seller_id")->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_bank_details'])) {
    $account_holder_name = $_POST['account_holder_name'];
    $account_number = $_POST['account_number'];
    $bank_name = $_POST['bank_name'];
    $ifsc_code = $_POST['ifsc_code'];
    $branch_name = $_POST['branch_name'];
    $account_type = $_POST['account_type'];
    
    try {
        if ($bank_details) {
            // Update existing details
            $stmt = $db->prepare("UPDATE seller_bank_details SET 
                account_holder_name = ?, account_number = ?, bank_name = ?, 
                ifsc_code = ?, branch_name = ?, account_type = ?, is_verified = FALSE 
                WHERE seller_id = ?");
            $stmt->execute([$account_holder_name, $account_number, $bank_name, $ifsc_code, $branch_name, $account_type, $seller_id]);
        } else {
            // Insert new details
            $stmt = $db->prepare("INSERT INTO seller_bank_details 
                (seller_id, account_holder_name, account_number, bank_name, ifsc_code, branch_name, account_type) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$seller_id, $account_holder_name, $account_number, $bank_name, $ifsc_code, $branch_name, $account_type]);
        }
        
        $success = "Bank details updated successfully! They will be verified within 24-48 hours.";
        // Refresh bank details
        $bank_details = $db->query("SELECT * FROM seller_bank_details WHERE seller_id = $seller_id")->fetch();
    } catch (PDOException $e) {
        $error = "Error updating bank details: " . $e->getMessage();
    }
}
?>

<?php include '../header.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="container-fluid p-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card dashboard-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h4 class="mb-0"><i class="fas fa-university me-2"></i>Bank Details for Payouts</h4>
                        <?php if ($bank_details && $bank_details['is_verified']): ?>
                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Verified</span>
                        <?php elseif ($bank_details): ?>
                        <span class="badge bg-warning"><i class="fas fa-clock me-1"></i>Under Review</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <?php if (isset($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                        <?php endif; ?>
                        <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Your bank details are securely stored and will be used for all payout transactions. 
                            Verification may take 24-48 hours.
                        </div>

                        <form method="post">
                            <input type="hidden" name="update_bank_details" value="1">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Account Holder Name *</label>
                                        <input type="text" name="account_holder_name" class="form-control" 
                                               value="<?= htmlspecialchars($bank_details['account_holder_name'] ?? '') ?>" 
                                               required pattern="[A-Za-z\s]+" title="Only letters and spaces allowed">
                                        <small class="text-muted">Must match your bank account</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Account Number *</label>
                                        <input type="text" name="account_number" class="form-control" 
                                               value="<?= htmlspecialchars($bank_details['account_number'] ?? '') ?>" 
                                               required pattern="[0-9]{9,18}" title="9-18 digit account number">
                                        <small class="text-muted">No spaces or special characters</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Bank Name *</label>
                                        <input type="text" name="bank_name" class="form-control" 
                                               value="<?= htmlspecialchars($bank_details['bank_name'] ?? '') ?>" required>
                                        <small class="text-muted">e.g., State Bank of India, HDFC Bank</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">IFSC Code *</label>
                                        <input type="text" name="ifsc_code" class="form-control" 
                                               value="<?= htmlspecialchars($bank_details['ifsc_code'] ?? '') ?>" 
                                               required pattern="[A-Z]{4}0[A-Z0-9]{6}" title="Valid IFSC code format">
                                        <small class="text-muted">11 character IFSC code</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Branch Name</label>
                                        <input type="text" name="branch_name" class="form-control" 
                                               value="<?= htmlspecialchars($bank_details['branch_name'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Account Type *</label>
                                        <select name="account_type" class="form-select" required>
                                            <option value="Savings" <?= ($bank_details['account_type'] ?? '') === 'Savings' ? 'selected' : '' ?>>Savings Account</option>
                                            <option value="Current" <?= ($bank_details['account_type'] ?? '') === 'Current' ? 'selected' : '' ?>>Current Account</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4 p-3 bg-light rounded">
                                <h6 class="mb-2"><i class="fas fa-shield-alt me-2 text-success"></i>Security Notice</h6>
                                <p class="small mb-0">Your bank details are encrypted and stored securely. 
                                We never share your financial information with third parties.</p>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-save me-2"></i>
                                    <?= $bank_details ? 'Update Bank Details' : 'Save Bank Details' ?>
                                </button>
                            </div>
                        </form>

                        <?php if ($bank_details): ?>
                        <div class="mt-4">
                            <h6 class="border-bottom pb-2">Verification Status</h6>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Last Updated</small>
                                    <div class="fw-bold"><?= date('M j, Y g:i A', strtotime($bank_details['updated_at'])) ?></div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Status</small>
                                    <div class="fw-bold">
                                        <?php if ($bank_details['is_verified']): ?>
                                            <span class="text-success">Verified</span>
                                        <?php else: ?>
                                            <span class="text-warning">Pending Verification</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control:read-only {
    background-color: #f8f9fa;
}
</style>

