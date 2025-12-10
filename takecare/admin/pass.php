<?php
// Run this script once to create an admin user
require '../includes/db.php';
$username = 'takecare';
$password = password_hash('takecare@123', PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin_users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $password]);

echo "Admin user created.";
?>