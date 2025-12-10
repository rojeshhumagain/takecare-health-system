<?php
include '../includes/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// Handle delete and reindex
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    if ($stmt->execute([$id])) {
        $conn->exec("SET @count = 0;");
        $conn->exec("UPDATE users SET id = @count := @count + 1;");
        $conn->exec("ALTER TABLE users AUTO_INCREMENT = 1;");
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully']);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete user']);
        exit;
    }
}

// Handle update
if (isset($_POST['update']) && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : null;

    if (empty($name) || empty($email)) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Name and email are required.']);
        exit;
    }

    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt_check->execute([$email, $id]);
    if ($stmt_check->rowCount() > 0) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Email already in use by another user.']);
        exit;
    }

    $update_fields = ["name = ?", "email = ?"];
    $params = [$name, $email];

    if ($password) {
        $update_fields[] = "password = ?";
        $params[] = $password;
    }

    $params[] = $id;
    $sql = "UPDATE users SET " . implode(", ", $update_fields) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt->execute($params)) {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => ['name' => $name, 'email' => $email]
        ]);
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
        exit;
    }
}

$stmt = $conn->prepare("SELECT * FROM users ORDER BY id ASC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - TakeCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
        }
        .container-box {
            margin-top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .edit-form {
            display: none;
        }
        .edit-form.active {
            display: table-row;
        }
        .update-message {
            color: #28a745;
            font-size: 0.9em;
        }
        .update-message.error {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main class="ms-250 p-4" style="margin-left: 250px;">
        <div class="container-box">
            <h2 class="mb-4">Manage Users</h2>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td class="user-name-<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></td>
                                <td class="user-email-<?= $user['id'] ?>"><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm edit-btn" data-id="<?= $user['id'] ?>"><i class="fas fa-edit"></i> Edit</button>
                                    <a href="manage_users.php?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash"></i> Delete</a>
                                </td>
                            </tr>
                            <tr class="edit-form" id="edit-form-<?= $user['id'] ?>">
                                <td colspan="4">
                                    <form id="edit-form-data-<?= $user['id'] ?>" class="p-0">
                                        <input type="hidden" name="edit_id" value="<?= htmlspecialchars($user['id']) ?>">
                                        <input type="hidden" name="update" value="1">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="password" class="form-control" name="password" placeholder="New password (optional)">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                <button type="button" class="btn btn-secondary btn-sm cancel-btn" data-id="<?= $user['id'] ?>">Cancel</button>
                                            </div>
                                        </div>
                                        <div class="update-message" id="message-<?= $user['id'] ?>"></div>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($users)): ?>
                            <tr><td colspan="4" class="text-center">No users found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        // Show edit form
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                document.getElementById('edit-form-' + id).classList.add('active');
            });
        });

        // Hide edit form
        document.querySelectorAll('.cancel-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                document.getElementById('edit-form-' + id).classList.remove('active');
                document.getElementById('message-' + id).textContent = '';
            });
        });

        // Handle form submit with AJAX
        document.querySelectorAll('form[id^="edit-form-data-"]').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                const id = form.querySelector('input[name="edit_id"]').value;
                const formData = new FormData(form);

                fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    const msg = document.getElementById('message-' + id);
                    if (data.status === 'success') {
                        document.querySelector('.user-name-' + id).textContent = data.data.name;
                        document.querySelector('.user-email-' + id).textContent = data.data.email;
                        msg.textContent = data.message;
                        msg.className = 'update-message';
                        form.querySelector('input[name="password"]').value = '';
                        document.getElementById('edit-form-' + id).classList.remove('active');
                    } else {
                        msg.textContent = data.message;
                        msg.className = 'update-message error';
                    }
                    setTimeout(() => msg.textContent = '', 3000);
                })
                .catch(() => {
                    const msg = document.getElementById('message-' + id);
                    msg.textContent = 'Error: Failed to update user.';
                    msg.className = 'update-message error';
                });
            });
        });
    </script>
</body>
</html>
