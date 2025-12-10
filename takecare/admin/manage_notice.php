<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

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

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/takecare/uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$editMode = false;
$notice = ['id' => '', 'title' => '', 'description' => '', 'image' => '', 'pdf' => ''];
$error = $success = '';

// Edit Mode
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM notices WHERE id = ?");
    $stmt->execute([$edit_id]);
    if ($row = $stmt->fetch()) {
        $notice = $row;
        $editMode = true;
    } else {
        $error = "Notice not found.";
    }
}

// Delete Notice
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("SELECT image, pdf FROM notices WHERE id = ?");
    $stmt->execute([$id]);
    $files = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($files) {
        if ($files['image'] && file_exists($uploadDir . $files['image'])) unlink($uploadDir . $files['image']);
        if ($files['pdf'] && file_exists($uploadDir . $files['pdf'])) unlink($uploadDir . $files['pdf']);
    }
    $conn->prepare("DELETE FROM notices WHERE id = ?")->execute([$id]);
    header("Location: manage_notice.php?msg=deleted");
    exit();
}

// Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $imageName = $editMode ? $notice['image'] : '';
    $pdfName = $editMode ? $notice['pdf'] : '';

    if (empty($title) || empty($description)) {
        $error = "Title and description are required.";
    } else {
        // Handle image upload
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($_FILES['image']['type'], $allowed) && $_FILES['image']['size'] <= 5*1024*1024 && in_array($ext, ['jpg','jpeg','png','webp'])) {
                $imageName = 'notice_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
                if ($editMode && $notice['image'] && file_exists($uploadDir . $notice['image'])) {
                    unlink($uploadDir . $notice['image']);
                }
            } else {
                $error = "Invalid image. Use JPEG/PNG/WebP, max 5MB.";
            }
        }

        // Handle PDF upload
        if (!empty($_FILES['pdf']['name']) && $_FILES['pdf']['error'] === 0) {
            if ($_FILES['pdf']['type'] === 'application/pdf' && $_FILES['pdf']['size'] <= 10*1024*1024) {
                $pdfName = 'notice_' . time() . '_' . rand(1000,9999) . '.' . pathinfo($_FILES['pdf']['name'], PATHINFO_EXTENSION);
                move_uploaded_file($_FILES['pdf']['tmp_name'], $uploadDir . $pdfName);
                if ($editMode && $notice['pdf'] && file_exists($uploadDir . $notice['pdf'])) {
                    unlink($uploadDir . $notice['pdf']);
                }
            } else {
                $error = "Invalid PDF. Max 10MB.";
            }
        }

        if (!$error) {
            try {
                if ($editMode) {
                    $sql = "UPDATE notices SET title=?, description=?, image=?, pdf=? WHERE id=?";
                    $conn->prepare($sql)->execute([$title, $description, $imageName, $pdfName, $edit_id]);
                    $success = "Notice updated successfully!";
                } else {
                    $sql = "INSERT INTO notices (title, description, image, pdf, created_at) VALUES (?,?,?, ?,NOW())";
                    $conn->prepare($sql)->execute([$title, $description, $imageName, $pdfName]);
                    $success = "Notice added successfully!";
                }
            } catch (Exception $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Fetch all notices
$notices = $conn->query("SELECT * FROM notices ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Notices - TakeCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card-header { background: #6f42c1; color: white; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background-color: #6f42c1; border: none; }
        .notice-card { 
            transition: 0.3s; 
            border-radius: 12px; 
            overflow: hidden; 
            height: 100%;
        }
        .notice-card:hover { 
            box-shadow: 0 8px 25px rgba(111,66,193,0.15); 
            transform: translateY(-5px); 
        }
        .notice-img { 
            height: 200px; 
            overflow: hidden; 
            background: #e9ecef; 
        }
        .notice-img img { 
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
        }
        .form-control, .form-select { border-radius: 8px; }
        .text-truncate { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 text-primary"><i class="fas fa-bullhorn"></i> Manage Notices</h2>
            </div>

            <!-- Success / Error Messages -->
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
            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> Notice deleted successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add/Edit Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas <?= $editMode ? 'fa-edit' : 'fa-plus' ?>"></i> <?= $editMode ? 'Edit Notice' : 'Add New Notice' ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Notice Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($notice['title']) ?>" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($notice['description']) ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload Image (Optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this)">
                                <?php if ($editMode && $notice['image']): ?>
                                    <img src="/takecare/uploads/<?= $notice['image'] ?>" class="mt-2 rounded" style="height:70px;">
                                <?php endif; ?>
                                <img id="imgPreview" class="mt-2 rounded" style="height:80px; display:none;">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload PDF (Optional)</label>
                                <input type="file" name="pdf" class="form-control" accept="application/pdf">
                                <?php if ($editMode && $notice['pdf']): ?>
                                    <a href="/takecare/uploads/<?= $notice['pdf'] ?>" target="_blank" class="btn btn-outline-primary btn-sm mt-2">
                                        <i class="fas fa-file-pdf"></i> View Current PDF
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save"></i> <?= $editMode ? 'Update' : 'Add' ?> Notice
                            </button>
                            <?php if ($editMode): ?>
                                <a href="manage_notice.php" class="btn btn-secondary btn-lg px-4 ms-2">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Search notices by title or description...">
                </div>
            </div>

            <!-- Notices List -->
            <div class="row g-4" id="noticesList">
                <?php foreach ($notices as $n): ?>
                    <div class="col-md-6 col-lg-4 notice-item">
                        <div class="card notice-card h-100">
                            <div class="notice-img">
                                <?php if ($n['image'] && file_exists($uploadDir . $n['image'])): ?>
                                    <img src="/takecare/uploads/<?= htmlspecialchars($n['image']) ?>" alt="<?= htmlspecialchars($n['title']) ?>">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-bullhorn fa-4x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($n['title']) ?></h5>
                                <p class="card-text text-muted small mb-2"><?= htmlspecialchars(substr(strip_tags($n['description']), 0, 80)) ?>...</p>
                                <?php if ($n['pdf'] && file_exists($uploadDir . $n['pdf'])): ?>
                                    <a href="/takecare/uploads/<?= $n['pdf'] ?>" target="_blank" class="btn btn-outline-primary btn-sm mb-2">
                                        <i class="fas fa-file-pdf"></i> View PDF
                                    </a>
                                <?php endif; ?>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">Added <?= date('M j, Y', strtotime($n['created_at'])) ?></small>
                                    <div>
                                        <a href="?edit_id=<?= $n['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="?delete_id=<?= $n['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this notice permanently?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($notices)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-bullhorn fa-5x text-muted mb-3"></i>
                            <p class="text-muted">No notices added yet. Add your first notice above!</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('imgPreview');
            prev.src = e.target.result;
            prev.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

// Live Search
document.getElementById('searchInput').addEventListener('keyup', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.notice-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(term) ? '' : 'none';
    });
});
</script>
</body>
</html>