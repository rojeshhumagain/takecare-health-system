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
    die("Error: Database connection failed: " . $e->getMessage());
}

// Fetch published blogs
try {
    $stmt = $conn->prepare("SELECT id, title, content, image, created_at FROM blogs WHERE status = 'published' ORDER BY created_at DESC");
    $stmt->execute();
    $blogs = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Failed to fetch blogs: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ब्लग - Takecare.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --dark-blue: #1A2B40;
            --purple: #8A2BE2;
            --accent: #e24e1b;
            --white: #FFFFFF;
            --light-gray: #F0F0F0;
            --text-color: #333333;
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .blog-hero {
            background: linear-gradient(135deg, var(--purple), var(--dark-blue));
            color: var(--white);
            border-radius: 10px;
            text-align: center;
            padding: 40px 20px;
            margin-bottom: 30px;
        }

        .blog-card {
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .blog-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .blog-card-body {
            padding: 20px;
        }

        .blog-card-title {
            font-size: 1.5rem;
            color: var(--purple);
            margin-bottom: 10px;
        }

        .blog-card-text {
            color: var(--text-color);
            font-size: 1rem;
            margin-bottom: 15px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .blog-card .btn {
            background: linear-gradient(45deg, var(--purple), #A020F0);
            border: none;
            border-radius: 25px;
            color: var(--white);
            padding: 8px 20px;
            transition: background 0.3s ease;
        }

        .blog-card .btn:hover {
            background: linear-gradient(45deg, #A020F0, var(--purple));
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--purple), var(--dark-blue));
            color: var(--white);
            border-radius: 10px 10px 0 0;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.8rem;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-body img {
            max-width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .modal-body .blog-content {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .modal-body .blog-date {
            color: #555;
            font-size: 0.9rem;
            font-style: italic;
        }

        .modal-footer {
            border-top: none;
            padding: 15px 20px;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .blog-card img {
                height: 150px;
            }

            .blog-card-title {
                font-size: 1.3rem;
            }

            .blog-card-text {
                font-size: 0.9rem;
            }

            .modal-title {
                font-size: 1.5rem;
            }

            .modal-body img {
                max-height: 300px;
            }

            .modal-body .blog-content {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    

    <main class="container my-4">
        <section class="blog-hero">
            <h1 class="display-4">हाम्रा ब्लगहरू</h1>
            <p class="lead">स्वास्थ्य र कल्याण सम्बन्धी जानकारीमूलक लेखहरू पढ्नुहोस्। हाम्रा विशेषज्ञहरूले तपाईंको स्वास्थ्य सुधारका लागि उपयोगी सुझावहरू प्रदान गर्छन्।</p>
        </section>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <section class="row row-cols-1 row-cols-md-3 g-4">
            <?php if (!empty($blogs)): ?>
                <?php foreach ($blogs as $blog): ?>
                    <div class="col">
                        <div class="blog-card">
                            <img src="<?php echo htmlspecialchars($blog['image'] ? '/takecare/uploads/' . $blog['image'] : '/takecare/uploads/placeholder.jpg'); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            <div class="blog-card-body">
                                <h5 class="blog-card-title"><?php echo htmlspecialchars($blog['title']); ?></h5>
                                <p class="blog-card-text"><?php echo htmlspecialchars(substr($blog['content'], 0, 150)) . (strlen($blog['content']) > 150 ? '...' : ''); ?></p>
                                <button class="btn" data-bs-toggle="modal" data-bs-target="#blogModal<?php echo $blog['id']; ?>">थप पढ्नुहोस्</button>
                            </div>
                        </div>
                    </div>
                    <!-- Blog Modal -->
                    <div class="modal fade" id="blogModal<?php echo $blog['id']; ?>" tabindex="-1" aria-labelledby="blogModalLabel<?php echo $blog['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="blogModalLabel<?php echo $blog['id']; ?>"><?php echo htmlspecialchars($blog['title']); ?></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php if ($blog['image']): ?>
                                        <img src="/takecare/uploads/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                    <?php else: ?>
                                        <img src="/takecare/uploads/placeholder.jpg" alt="Placeholder">
                                    <?php endif; ?>
                                    <p class="blog-content"><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>
                                    <p class="blog-date">प्रकाशित: <?php echo date('Y-m-d H:i:s', strtotime($blog['created_at'])); ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">बन्द गर्नुहोस्</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">कुनै ब्लगहरू फेला परेन।</p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>