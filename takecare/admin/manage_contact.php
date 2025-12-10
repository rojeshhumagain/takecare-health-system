<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$db = 'takecare_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$error = $success = '';

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $conn->prepare("DELETE FROM contacts WHERE id = ?")->execute([$id]);
    $success = "Contact deleted successfully!";
}

// Update Status (Quick Action)
if (isset($_GET['mark_resolved'])) {
    $id = (int)$_GET['mark_resolved'];
    $conn->prepare("UPDATE contacts SET status = 'resolved' WHERE id = ?")->execute([$id]);
    $success = "Contact marked as resolved!";
}

// Fetch all contacts
$contacts = $conn->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Contacts - TakeCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card-header { background: #6f42c1; color: white; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background-color: #6f42c1; border: none; }
        .contact-card { transition: 0.3s; border-radius: 12px; overflow: hidden; }
        .contact-card:hover { box-shadow: 0 8px 25px rgba(111,66,193,0.15); transform: translateY(-5px); }
        .status-badge { font-size: 0.8rem; padding: 5px 12px; border-radius: 20px; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-resolved { background: #d4edda; color: #155724; }
        .message-preview { font-size: 0.92rem; color: #6c757d; }
        .form-control, .form-select { border-radius: 8px; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 text-primary"><i class="fas fa-envelope"></i> Manage Contact Messages</h2>
            </div>

            <!-- Messages -->
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Search by name, email or message...">
                </div>
            </div>

            <!-- Contacts Grid -->
            <div class="row g-4" id="contactsList">
                <?php if (!empty($contacts)): ?>
                    <?php foreach ($contacts as $c): ?>
                        <div class="col-md-6 col-lg-4 contact-item">
                            <div class="card contact-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title text-primary mb-1"><?= htmlspecialchars($c['name']) ?></h5>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($c['email']) ?>
                                            </p>
                                        </div>
                                        <span class="status-badge status-<?= $c['status'] ?>">
                                            <?= ucfirst($c['status']) ?>
                                        </span>
                                    </div>

                                    <div class="message-preview mb-3">
                                        <?= nl2br(htmlspecialchars(substr($c['message'], 0, 120))) ?>
                                        <?= strlen($c['message']) > 120 ? '...' : '' ?>
                                    </div>

                                    <small class="text-muted d-block mb-3">
                                        <i class="fas fa-clock"></i> 
                                        <?= date('M j, Y \a\t g:i A', strtotime($c['created_at'])) ?>
                                    </small>

                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $c['id'] ?>">
                                            <i class="fas fa-eye"></i> View
                                        </button>

                                        <?php if ($c['status'] === 'pending'): ?>
                                            <a href="?mark_resolved=<?= $c['id'] ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Mark Resolved
                                            </a>
                                        <?php endif; ?>

                                        <a href="?delete_id=<?= $c['id'] ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Delete this message permanently?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- View Full Message Modal -->
                        <div class="modal fade" id="viewModal<?= $c['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            <i class="fas fa-envelope"></i> Message from <?= htmlspecialchars($c['name']) ?>
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Name:</strong> <?= htmlspecialchars($c['name']) ?></p>
                                                <p><strong>Email:</strong> 
                                                    <a href="mailto:<?= htmlspecialchars($c['email']) ?>">
                                                        <?= htmlspecialchars($c['email']) ?>
                                                    </a>
                                                </p>
                                                <p><strong>Received:</strong> 
                                                    <?= date('F j, Y \a\t g:i A', strtotime($c['created_at'])) ?>
                                                </p>
                                                <p><strong>Status:</strong> 
                                                    <span class="status-badge status-<?= $c['status'] ?>">
                                                        <?= ucfirst($c['status']) ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <p><strong>Message:</strong></p>
                                        <div class="bg-light p-3 rounded">
                                            <?= nl2br(htmlspecialchars($c['message'])) ?>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="mailto:<?= htmlspecialchars($c['email']) ?>" class="btn btn-primary">
                                            <i class="fas fa-reply"></i> Reply via Email
                                        </a>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-envelope-open-text fa-5x text-muted mb-4"></i>
                            <h4 class="text-muted">No messages yet</h4>
                            <p class="text-muted">All contact form submissions will appear here.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Live Search
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const term = this.value.toLowerCase();
        document.querySelectorAll('.contact-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>
</body>
</html>