<?php
// Database connection using PDO
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
    die('Error: Database connection failed: ' . $e->getMessage());
}

// Ensure uploads directory exists
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/takecare/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Fetch notices from the database
try {
    $stmt = $conn->query("SELECT * FROM notices ORDER BY created_at DESC");
    $notices = $stmt->fetchAll();
} catch (PDOException $e) {
    $error_message = 'Failed to fetch notices: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Public Notices - Takecare.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --dark-blue: #1A2B40;
            --purple: #8A2BE2;
            --white: #FFFFFF;
            --light-gray: #F0F0F0;
            --text-color: #333333;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
        }

        .container {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--dark-blue);
            text-align: center;
            margin-bottom: 2.5rem;
            position: relative;
        }

        .page-title::after {
            content: '';
            width: 100px;
            height: 4px;
            background: linear-gradient(45deg, var(--purple), #A020F0);
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .notice-card {
            border: none;
            border-radius: 12px;
            background-color: var(--white);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .notice-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        .notice-card .card-img-top {
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #e0e0e0;
        }

        .notice-card .card-body {
            padding: 1.5rem;
        }

        .notice-card .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-blue);
            margin-bottom: 0.75rem;
        }

        .notice-card .card-text {
            font-size: 0.95rem;
            color: var(--text-color);
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .notice-card .card-footer {
            background-color: var(--light-gray);
            padding: 1rem 1.5rem;
            border-top: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notice-card .card-footer .text-muted {
            font-size: 0.85rem;
        }

        .btn-purple {
            background: linear-gradient(45deg, var(--purple), #A020F0);
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.3s ease;
        }

        .btn-purple:hover {
            background: linear-gradient(45deg, #A020F0, var(--purple));
        }

        .no-notices {
            text-align: center;
            font-size: 1.1rem;
            color: var(--text-color);
            padding: 2rem;
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        @media (max-width: 768px) {
            .container {
                padding: 2rem 1rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .notice-card .card-img-top {
                height: 150px;
            }

            .notice-card .card-title {
                font-size: 1.1rem;
            }

            .notice-card .card-text {
                font-size: 0.9rem;
            }

            .notice-card .card-footer {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
            }

            .btn-purple {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>

    <div class="container">
        <h2 class="page-title">सार्वजनिक स्वास्थ्य सूचना</h2>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <div class="row<?php echo !empty($notices) ? ' g-4' : ''; ?>">
            <?php if (!empty($notices)): ?>
                <?php foreach ($notices as $row): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card notice-card h-100">
                            <?php if (!empty($row['image']) && file_exists($uploadDir . $row['image'])): ?>
                                <img src="/takecare/uploads/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="Notice Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                                <p class="card-text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted"><?php echo date('F j, Y', strtotime($row['created_at'])); ?></small>
                                <?php if (!empty($row['pdf']) && file_exists($uploadDir . $row['pdf'])): ?>
                                    <a href="/takecare/uploads/<?php echo rawurlencode($row['pdf']); ?>" target="_blank" class="btn btn-purple">
                                        <i class="fas fa-file-pdf"></i> View PDF
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="no-notices">No notices available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>