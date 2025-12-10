<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
   <?php include 'sidebar.php'; ?>
    <!-- Main Content -->
    <?php include 'header.php'; ?>
        <!-- Dashboard Section -->
    <?php include 'dashboard.php'; ?>
    <?php include 'manage_user.php'; ?>
    <?php include 'manage_contact.php'; ?>

        <!-- Notices Section -->
        <section class="content-section" id="notices">
            <div class="page-header">
                <h1>Manage Notices</h1>
                <button class="btn btn-primary" onclick="openModal('noticeModal')">
                    <i class="fas fa-plus"></i>
                    Add Notice
                </button>
            </div>
            <div class="notices-grid" id="noticesGrid">
                <!-- Notices will be populated here -->
            </div>
        </section>
    </div>


    <!-- Confirmation Modal -->
    <div class="modal" id="confirmModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirm Action</h2>
                <button class="modal-close" onclick="closeModal('confirmModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <p id="confirmMessage">Are you sure you want to perform this action?</p>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('confirmModal')">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmBtn">Confirm</button>
            </div>
        </div>
    </div>

    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <script src="script.js"></script>
</body>
</html>
