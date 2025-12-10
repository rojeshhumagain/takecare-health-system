<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --primary-color: #6f42c1;
            --dark-primary: #5a32a3;
            --text-dark: #333333;
            --white: #ffffff;
        }

        .top-navbar {
            background-color: var(--white);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 0.75rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .navbar-brand span {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .navbar-brand a {
            text-decoration: none;
            color: var(--primary-color);
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .navbar-brand a:hover {
            color: var(--dark-primary);
        }

        .user-controls {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-controls .admin-name {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .user-controls .avatar {
            width: 32px;
            height: 32px;
            background-color: var(--primary-color);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .user-controls .btn-logout {
            background-color: #dc3545;
            color: var(--white);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .user-controls .btn-logout:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .top-navbar {
                padding: 0.5rem 1rem;
            }

            .navbar-brand span {
                font-size: 1rem;
            }

            .navbar-brand a {
                font-size: 0.8rem;
            }

            .user-controls .admin-name {
                font-size: 0.9rem;
            }

            .user-controls .avatar {
                width: 28px;
                height: 28px;
                font-size: 0.9rem;
            }

            .user-controls .btn-logout {
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <header class="top-navbar">
        <div class="navbar-brand">
            <span>Admin Panel</span>
            <a href="../index.php">
                <i class="fas fa-external-link-alt"></i> Visit Website
            </a>
        </div>
        <div class="user-controls">
            <span class="admin-name"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
            <div class="avatar">
                <i class="fas fa-user"></i>
            </div>
            <a href="logout.php" class="btn btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </header>
</body>
</html>