<?php
if (session_status() === PHP_SESSION_NONE) session_start();

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
    die("Database connection failed: " . $e->getMessage());
}

// Fetch only published blogs
try {
    $stmt = $conn->prepare("SELECT id, title, content, image, created_at FROM blogs WHERE status = 'published' ORDER BY created_at DESC");
    $stmt->execute();
    $blogs = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Failed to load blogs.";
}
?>

<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ब्लग - TakeCare Nepal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #6f42c1;
            --dark: #5a32a3;
            --light: #f8f9fa;
        }
        body {
            background-color: var(--light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        .hero {
            background: linear-gradient(135deg, var(--primary), #8a2be2);
            color: white;
            padding: 70px 20px;
            text-align: center;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        .hero h1 { font-size: 2.8rem; font-weight: 700; }
        .hero p { font-size: 1.2rem; opacity: 0.95; }

        .blog-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            height: 100%;
        }
        .blog-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(111,66,193,0.2);
        }
        .blog-img {
            height: 220px;
            overflow: hidden;
        }
        .blog-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s;
        }
        .blog-card:hover .blog-img img { transform: scale(1.08); }

        .blog-card-body { padding: 25px; }
        .blog-title {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 12px;
        }
        .blog-preview {
            color: #555;
            line-height: 1.7;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .read-more {
            background: linear-gradient(45deg, var(--primary), #8a2be2);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
        }
        .read-more:hover {
            background: linear-gradient(45deg, #8a2be2, var(--primary));
            transform: translateY(-2px);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), #8a2be2);
            color: white;
        }
        .modal-blog-img {
            max-height: 400px;
            object-fit: cover;
            border-radius: 12px;
            margin: 20px auto;
            display: block;
            width: 100%;
        }
        .blog-content {
            font-size: 1.1rem;
            line-height: 1.9;
            text-align: justify;
        }
        .blog-meta {
            color: #666;
            font-style: italic;
            text-align: center;
            margin-top: 25px;
        }
    </style>
</head>
<body>

<?php include 'header1.php'; ?>

<div class="container my-5">
    <div class="hero">
        <h1>हाम्रा स्वास्थ्य ब्लगहरू</h1>
        <p>विशेषज्ञ चिकित्सकहरूबाट स्वास्थ्य, पोषण, रोग निवारण र जीवनशैली सम्बन्धी उपयोगी जानकारीहरू</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($blogs)): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($blogs as $blog): ?>
                <div class="col">
                    <div class="blog-card">
                        <div class="blog-img">
                            <?php 
                            // Correct path: admin/uploads/
                            $imagePath = $blog['image'] 
                                ? 'admin/uploads/' . htmlspecialchars($blog['image'])
                                : 'assets/images/placeholder.jpg';
                            ?>
                            <img src="<?= $imagePath ?>" 
                                 alt="<?= htmlspecialchars($blog['title']) ?>"
                                 onerror="this.src='assets/images/placeholder.jpg'">
                        </div>
                        <div class="blog-card-body">
                            <h5 class="blog-title"><?= htmlspecialchars($blog['title']) ?></h5>
                            <p class="blog-preview">
                                <?= htmlspecialchars(substr(strip_tags($blog['content']), 0, 120)) ?>
                                <?= strlen(strip_tags($blog['content'])) > 120 ? '...' : '' ?>
                            </p>
                            <p class="text-muted small">
                                <i class="far fa-calendar"></i>
                                <?= date('F j, Y', strtotime($blog['created_at'])) ?>
                            </p>
                            <button class="btn read-more" data-bs-toggle="modal" data-bs-target="#blogModal<?= $blog['id'] ?>">
                                थप पढ्नुहोस्
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Full Blog Modal -->
                <div class="modal fade" id="blogModal<?= $blog['id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content border-0 rounded-4">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= htmlspecialchars($blog['title']) ?></h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <?php if ($blog['image']): ?>
                                    <img src="admin/uploads/<?= htmlspecialchars($blog['image']) ?>" 
                                         class="modal-blog-img" 
                                         alt="<?= htmlspecialchars($blog['title']) ?>">
                                <?php endif; ?>

                                <div class="blog-content">
                                    <?= nl2br(htmlspecialchars($blog['content'])) ?>
                                </div>

                                <div class="blog-meta">
                                    प्रकाशित मिति: <?= date('F j, Y \म\ा g:i A', strtotime($blog['created_at'])) ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    बन्द गर्नुहोस्
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-blog fa-5x text-muted mb-4"></i>
            <h3 class="text-muted">अहिलेसम्म कुनै ब्लग प्रकाशित भएको छैन</h3>
            <p class="text-muted">चाँडै नयाँ लेखहरू यहाँ उपलब्ध हुनेछन्।</p>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>