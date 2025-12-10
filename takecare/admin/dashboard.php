<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = '127.0.0.1';
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

// Fetch counts
try {
    $total_users = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $total_admins = $conn->query("SELECT COUNT(*) FROM admins")->fetchColumn();
    $total_notices = $conn->query("SELECT COUNT(*) FROM notices")->fetchColumn();
    $total_doctors = $conn->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
    $total_appointments = $conn->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
    $total_messages = $conn->query("SELECT COUNT(*) FROM contacts")->fetchColumn();
    $total_blogs = $conn->query("SELECT COUNT(*) FROM blogs")->fetchColumn();
    $total_reports = $conn->query("SELECT COUNT(*) FROM reports")->fetchColumn();
} catch (PDOException $e) {
    $error = "Failed to fetch counts: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Takecare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --primary-color: #1a73e8;
            --purple: #6f42c1;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --info: #17a2b8;
            --white: #ffffff;
            --text-dark: #333333;
            --light-gray: #f0f7ff;
        }

        body {
            background: var(--light-gray);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 70px;
        }

        .ms-250 {
            margin-left: 250px;
            transition: margin-left 0.3s ease;
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .card h4 {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card p {
            margin: 0;
            color: #555;
            font-size: 0.9rem;
        }

        .text-purple {
            color: var(--purple);
        }

        .sidebar-toggle {
            position: fixed;
            top: 80px;
            left: 260px;
            z-index: 1001;
            background: var(--purple);
            color: var(--white);
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease, left 0.3s ease;
        }

        .sidebar-toggle.hidden {
            left: 10px;
        }

        .sidebar-toggle:hover {
            background: #5a32a3;
        }

        .sidebar-hidden {
            margin-left: 0 !important;
        }

        .alert {
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .ms-250 {
                margin-left: 0;
            }

            .sidebar-toggle {
                top: 70px;
                left: 10px;
            }

            .card {
                margin-bottom: 15px;
            }

            .card h4 {
                font-size: 1.5rem;
            }

            .card i {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <button class="sidebar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
    <main class="ms-250 p-4">
        <div class="container-fluid">
            <h2 class="mb-4">Dashboard</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <a href="manage_user.php" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_users); ?></h4>
                                <p class="mb-0 text-muted">Total Users</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="#" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-user-shield fa-2x text-purple mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_admins); ?></h4>
                                <p class="mb-0 text-muted">Total Admins</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="manage_notice.php" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-bullhorn fa-2x text-warning mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_notices); ?></h4>
                                <p class="mb-0 text-muted">Total Notices</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="manage_doctor.php" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-user-md fa-2x text-info mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_doctors); ?></h4>
                                <p class="mb-0 text-muted">Total Doctors</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="view_appointment.php" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-calendar-check fa-2x text-primary mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_appointments); ?></h4>
                                <p class="mb-0 text-muted">Total Appointments</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="manage_contact.php" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-envelope fa-2x text-purple mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_messages); ?></h4>
                                <p class="mb-0 text-muted">Total Messages</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="manage_blog.php" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-blog fa-2x text-success mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_blogs); ?></h4>
                                <p class="mb-0 text-muted">Total Blogs</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a href="manage_report.php" class="text-decoration-none">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="fas fa-flag fa-2x text-danger mb-2"></i>
                                <h4 class="mb-1"><?php echo htmlspecialchars($total_reports); ?></h4>
                                <p class="mb-0 text-muted">Total Reports</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-muted">Welcome to your admin dashboard</p>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const main = document.querySelector('.ms-250');
            sidebarToggle.addEventListener('click', function() {
                main.classList.toggle('sidebar-hidden');
                this.classList.toggle('hidden');
                if (this.classList.contains('hidden')) {
                    this.innerHTML = '<i class="fas fa-bars"></i>';
                } else {
                    this.innerHTML = '<i class="fas fa-times"></i>';
                }
            });
        });
    </script>
</body>
</html>