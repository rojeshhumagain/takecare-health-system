<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$db   = 'takecare_db';
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

// Set correct upload directory (inside admin folder)
$uploadDir = __DIR__ . '/uploads/';
$uploadUrl = 'uploads/'; // For displaying in browser
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$error = $success = '';

// Handle Add Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_blog'])) {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'draft';
    $imageName = '';

    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($_FILES['image']['type'], $allowed) && $_FILES['image']['size'] <= 5*1024*1024 && in_array($ext, ['jpg','jpeg','png','webp'])) {
                $imageName = 'blog_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
            } else {
                $error = "Invalid image. Use JPEG/PNG/WebP, max 5MB.";
            }
        }

        if (!$error) {
            try {
                $stmt = $conn->prepare("INSERT INTO blogs (title, content, image, status, created_at) VALUES (?, ?, ?, ?, NOW())");
                $stmt->execute([$title, $content, $imageName, $status]);
                $success = "Blog added successfully!";
            } catch (Exception $e) {
                $error = "Failed to add blog: " . $e->getMessage();
            }
        }
    }
}

// Handle Update Blog
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_blog'])) {
    $id = (int)$_POST['blog_id'];
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $status = $_POST['status'] ?? 'draft';
    $imageName = $_POST['current_image'] ?? '';

    if (empty($title) || empty($content)) {
        $error = "Title and content are required.";
    } else {
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($_FILES['image']['type'], $allowed) && $_FILES['image']['size'] <= 5*1024*1024) {
                $imageName = 'blog_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
                // Delete old image
                if ($_POST['current_image'] && file_exists($uploadDir . $_POST['current_image'])) {
                    unlink($uploadDir . $_POST['current_image']);
                }
            } else {
                $error = "Invalid image.";
            }
        }

        if (!$error) {
            try {
                $stmt = $conn->prepare("UPDATE blogs SET title=?, content=?, image=?, status=? WHERE id=?");
                $stmt->execute([$title, $content, $imageName, $status, $id]);
                $success = "Blog updated successfully!";
            } catch (Exception $e) {
                $error = "Failed to update: " . $e->getMessage();
            }
        }
    }
}

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("SELECT image FROM blogs WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();
    if ($img && file_exists($uploadDir . $img)) unlink($uploadDir . $img);
    $conn->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
    header("Location: manage_blog.php?msg=deleted");
    exit();
}

// Fetch all blogs
$blogs = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - TakeCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card-header { background: #6f42c1; color: white; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background-color: #6f42c1; border: none; }
        .blog-card { transition: 0.3s; border-radius: 12px; overflow: hidden; }
        .blog-card:hover { box-shadow: 0 8px 25px rgba(111,66,193,0.15); transform: translateY(-5px); }
        .blog-img { height: 200px; overflow: hidden; background: #e9ecef; }
        .blog-img img { width: 100%; height: 100%; object-fit: cover; }
        .form-control, .form-select { border-radius: 8px; }
        .status-badge { font-size: 0.8rem; padding: 4px 10px; border-radius: 20px; }
        .status-published { background: #d4edda; color: #155724; }
        .status-draft { background: #fff3cd; color: #856404; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 text-primary"><i class="fas fa-blog"></i> Manage Blogs</h2>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBlogModal">
                    <i class="fas fa-plus"></i> Add New Blog
                </button>
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
            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    Blog deleted successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Search blogs by title or content...">
                </div>
            </div>

            <!-- Blogs Grid -->
            <div class="row g-4" id="blogsList">
                <?php foreach ($blogs as $b): ?>
                    <div class="col-md-6 col-lg-4 blog-item">
                        <div class="card blog-card h-100">
                            <div class="blog-img">
                                <?php if ($b['image'] && file_exists($uploadDir . $b['image'])): ?>
                                    <img src="<?= $uploadUrl . htmlspecialchars($b['image']) ?>" alt="<?= htmlspecialchars($b['title']) ?>">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-blog fa-4x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($b['title']) ?></h5>
                                <p class="card-text text-muted small">
                                    <?= htmlspecialchars(substr(strip_tags($b['content']), 0, 100)) ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="status-badge status-<?= $b['status'] ?>">
                                        <?= ucfirst($b['status']) ?>
                                    </span>
                                    <small class="text-muted">
                                        <?= date('M j, Y', strtotime($b['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-end gap-2">
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $b['id'] ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <a href="?delete_id=<?= $b['id'] ?>" class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Delete this blog permanently?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $b['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Edit Blog</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="blog_id" value="<?= $b['id'] ?>">
                                        <input type="hidden" name="current_image" value="<?= $b['image'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($b['title']) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Content</label>
                                            <textarea name="content" class="form-control" rows="6" required><?= htmlspecialchars($b['content']) ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                            <?php if ($b['image']): ?>
                                                <img src="<?= $uploadUrl . $b['image'] ?>" class="mt-2 rounded" style="height:80px;">
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="draft" <?= $b['status']=='draft'?'selected':'' ?>>Draft</option>
                                                <option value="published" <?= $b['status']=='published'?'selected':'' ?>>Published</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="update_blog" class="btn btn-primary">Update Blog</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</div>

<!-- Add Blog Modal -->
<div class="modal fade" id="addBlogModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Add New Blog</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="content" class="form-control" rows="6" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="add_blog" class="btn btn-success">Add Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Live Search
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const term = this.value.toLowerCase();
        document.querySelectorAll('.blog-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>
</body>
</html>