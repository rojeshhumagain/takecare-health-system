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

// Upload directory (inside admin folder)
$uploadDir = __DIR__ . '/uploads/';
$uploadUrl = 'uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$error = $success = '';

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("SELECT pdf_file, video_file FROM reports WHERE id = ?");
    $stmt->execute([$id]);
    $files = $stmt->fetch();
    if ($files['pdf_file'] && file_exists($uploadDir . $files['pdf_file'])) unlink($uploadDir . $files['pdf_file']);
    if ($files['video_file'] && file_exists($uploadDir . $files['video_file'])) unlink($uploadDir . $files['video_file']);
    $conn->prepare("DELETE FROM reports WHERE id = ?")->execute([$id]);
    $success = "Report deleted successfully!";
}

// Mark as Resolved
if (isset($_GET['resolve_id'])) {
    $id = (int)$_GET['resolve_id'];
    $conn->prepare("UPDATE reports SET status = 'resolved' WHERE id = ?")->execute([$id]);
    $success = "Report marked as resolved!";
}

// Fetch all reports
$reports = $conn->query("SELECT * FROM reports ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reports - TakeCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card-header { background: #6f42c1; color: white; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background-color: #6f42c1; border: none; }
        .report-card { transition: 0.3s; border-radius: 12px; overflow: hidden; }
        .report-card:hover { box-shadow: 0 8px 25px rgba(111,66,193,0.15); transform: translateY(-5px); }
        .status-badge { font-size: 0.8rem; padding: 5px 12px; border-radius: 20px; }
        .status-pending { background: #fff3cd; color: #856404; }
        .status-resolved { background: #d4edda; color: #155724; }
        .file-preview { max-height: 80px; object-fit: cover; border-radius: 8px; }
        .modal-body iframe, .modal-body video, .modal-body img { width: 100%; max-height: 70vh; border-radius: 10px; }
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
                <h2 class="h3 text-primary"><i class="fas fa-bug"></i> Manage User Reports</h2>
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
                    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Search by name, email, or issue...">
                </div>
            </div>

            <!-- Reports Grid -->
            <div class="row g-4" id="reportsList">
                <?php if (!empty($reports)): ?>
                    <?php foreach ($reports as $r): ?>
                        <div class="col-md-6 col-lg-4 report-item">
                            <div class="card report-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title text-primary mb-1"><?= htmlspecialchars($r['name']) ?></h5>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-envelope me-1"></i> <?= htmlspecialchars($r['email']) ?>
                                            </p>
                                        </div>
                                        <span class="status-badge status-<?= $r['status'] ?>">
                                            <?= ucfirst($r['status']) ?>
                                        </span>
                                    </div>

                                    <p class="text-muted small mb-2">
                                        <strong>Issue:</strong> <?= ucfirst(str_replace('_', ' ', $r['issue_type'])) ?>
                                    </p>

                                    <p class="text-muted small mb-3" style="height: 60px; overflow: hidden;">
                                        <?= nl2br(htmlspecialchars(substr($r['description'], 0, 100))) ?>
                                        <?= strlen($r['description']) > 100 ? '...' : '' ?>
                                    </p>

                                    <?php if ($r['pdf_file'] || $r['video_file']): ?>
                                        <div class="d-flex gap-2 mb-3 flex-wrap">
                                            <?php if ($r['pdf_file']): 
                                                $ext = strtolower(pathinfo($r['pdf_file'], PATHINFO_EXTENSION));
                                                if (in_array($ext, ['jpg','jpeg','png','gif'])): ?>
                                                    <img src="<?= $uploadUrl . $r['pdf_file'] ?>" class="file-preview" alt="Attachment">
                                                <?php else: ?>
                                                    <div class="text-center p-2 bg-light rounded">
                                                        <i class="fas fa-file-pdf fa-2x text-danger"></i><br>
                                                        <small>PDF</small>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if ($r['video_file']): ?>
                                                <div class="text-center p-2 bg-light rounded">
                                                    <i class="fas fa-video fa-2x text-primary"></i><br>
                                                    <small>Video</small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <small class="text-muted d-block mb-3">
                                        <i class="fas fa-clock"></i> 
                                        <?= date('M j, Y \a\t g:i A', strtotime($r['created_at'])) ?>
                                    </small>

                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $r['id'] ?>">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <?php if ($r['status'] === 'pending'): ?>
                                            <a href="?resolve_id=<?= $r['id'] ?>" class="btn btn-success btn-sm">
                                                <i class="fas fa-check"></i> Resolve
                                            </a>
                                        <?php endif; ?>
                                        <a href="?delete_id=<?= $r['id'] ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Delete this report permanently?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- View Full Report Modal -->
                        <div class="modal fade" id="viewModal<?= $r['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">
                                            <i class="fas fa-bug"></i> Report from <?= htmlspecialchars($r['name']) ?>
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Name:</strong> <?= htmlspecialchars($r['name']) ?></p>
                                                <p><strong>Email:</strong> 
                                                    <a href="mailto:<?= htmlspecialchars($r['email']) ?>"><?= htmlspecialchars($r['email']) ?></a>
                                                </p>
                                                <?php if ($r['address']): ?>
                                                    <p><strong>Address:</strong> <?= htmlspecialchars($r['address']) ?></p>
                                                <?php endif; ?>
                                                <p><strong>Issue Type:</strong> <?= ucfirst(str_replace('_', ' ', $r['issue_type'])) ?></p>
                                                <p><strong>Submitted:</strong> <?= date('F j, Y \a\t g:i A', strtotime($r['created_at'])) ?></p>
                                                <p><strong>Status:</strong> 
                                                    <span class="status-badge status-<?= $r['status'] ?>"><?= ucfirst($r['status']) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <p><strong>Description:</strong></p>
                                        <div class="bg-light p-3 rounded mb-4">
                                            <?= nl2br(htmlspecialchars($r['description'])) ?>
                                        </div>

                                        <?php if ($r['pdf_file']): 
                                            $fileUrl = $uploadUrl . $r['pdf_file'];
                                            $ext = strtolower(pathinfo($r['pdf_file'], PATHINFO_EXTENSION));
                                        ?>
                                            <p><strong>Attachment:</strong></p>
                                            <?php if (in_array($ext, ['jpg','jpeg','png','gif'])): ?>
                                                <img src="<?= $fileUrl ?>" class="img-fluid rounded" alt="Attachment">
                                            <?php else: ?>
                                                <iframe src="<?= $fileUrl ?>" style="height: 600px;" class="w-100"></iframe>
                                                <div class="text-center mt-2">
                                                    <a href="<?= $fileUrl ?>" class="btn btn-primary" download>
                                                        <i class="fas fa-download"></i> Download PDF
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if ($r['video_file']): ?>
                                            <p><strong>Video Evidence:</strong></p>
                                            <video controls class="w-100 rounded">
                                                <source src="<?= $uploadUrl . $r['video_file'] ?>" type="video/mp4">
                                                <source src="<?= $uploadUrl . $r['video_file'] ?>" type="video/webm">
                                                Your browser does not support video playback.
                                            </video>
                                            <div class="text-center mt-2">
                                                <a href="<?= $uploadUrl . $r['video_file'] ?>" class="btn btn-outline-primary" download>
                                                    <i class="fas fa-download"></i> Download Video
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="mailto:<?= htmlspecialchars($r['email']) ?>" class="btn btn-success">
                                            <i class="fas fa-reply"></i> Reply to User
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
                            <i class="fas fa-inbox fa-5x text-muted mb-4"></i>
                            <h4 class="text-muted">No reports submitted yet</h4>
                            <p class="text-muted">User reports will appear here when submitted.</p>
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
        document.querySelectorAll('.report-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>
</body>
</html>