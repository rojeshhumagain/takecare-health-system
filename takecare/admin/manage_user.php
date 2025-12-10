<?php
include '../includes/db.php';
session_start();



// Delete user and reindex IDs
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

// Update user
if (isset($_POST['update']) && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash(trim($_POST['password']), PASSWORD_DEFAULT) : null;

    if (empty($name) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Name and email are required.']);
        exit;
    }

    $stmt_check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $stmt_check->execute([$email, $id]);
    if ($stmt_check->rowCount() > 0) {
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
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully', 'data' => ['name' => $name, 'email' => $email]]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update user']);
        exit;
    }
}

// Fetch all users
$stmt = $conn->prepare("SELECT * FROM users ORDER BY id ASC");
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users - TakeCare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .user-card {
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .user-card:hover {
            transform: translateY(-2px);
        }
        .edit-form {
            display: none;
        }
        .edit-form.active {
            display: block;
        }
        .update-message {
            font-size: 0.85rem;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <main class="container mt-5" style="margin-left: 250px;">
        <h3 class="mb-4">Manage Users</h3>
        <div class="row g-4">
            <?php foreach ($users as $user): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card user-card p-3">
                        <div>
                            <h5 class="user-name-<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></h5>
                            <p class="user-email-<?= $user['id'] ?> text-muted"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-warning edit-btn" data-id="<?= $user['id'] ?>">Edit</button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="<?= $user['id'] ?>">Delete</button>
                        </div>

                        <!-- Hidden edit form -->
                        <form id="edit-form-data-<?= $user['id'] ?>" class="mt-3 edit-form" method="POST">
                            <input type="hidden" name="edit_id" value="<?= $user['id'] ?>">
                            <input type="hidden" name="update" value="1">
                            <div class="mb-2">
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
                            </div>
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
                            </div>
                            <div class="mb-2">
                                <input type="password" name="password" class="form-control" placeholder="New Password (optional)">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                <button type="button" class="btn btn-sm btn-secondary cancel-btn" data-id="<?= $user['id'] ?>">Cancel</button>
                            </div>
                            <div class="update-message text-success" id="message-<?= $user['id'] ?>"></div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($users)): ?>
                <p class="text-center text-muted">No users found.</p>
            <?php endif; ?>
        </div>
    </main>

    <script>
        // Show edit form
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                document.getElementById('edit-form-data-' + id).classList.add('active');
            });
        });

        // Cancel edit
        document.querySelectorAll('.cancel-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.getAttribute('data-id');
                document.getElementById('edit-form-data-' + id).classList.remove('active');
                document.getElementById('message-' + id).textContent = '';
            });
        });

        // Update user via AJAX
        document.querySelectorAll('form[id^="edit-form-data-"]').forEach(form => {
            form.addEventListener('submit', e => {
                e.preventDefault();
                const id = form.querySelector('[name="edit_id"]').value;
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
                        msg.classList.remove('text-danger');
                        msg.classList.add('text-success');
                        form.querySelector('[name="password"]').value = '';
                        form.classList.remove('active');
                    } else {
                        msg.textContent = data.message;
                        msg.classList.remove('text-success');
                        msg.classList.add('text-danger');
                    }
                    setTimeout(() => msg.textContent = '', 3000);
                })
                .catch(() => {
                    const msg = document.getElementById('message-' + id);
                    msg.textContent = 'Error: Could not update user.';
                    msg.classList.add('text-danger');
                });
            });
        });

        // Delete user via AJAX
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                if (confirm('Are you sure you want to delete this user?')) {
                    fetch(`?delete=${id}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'success') {
                                alert(data.message); // Simple popup
                                location.reload(); // Refresh page
                            } else {
                                alert('Failed to delete user.');
                            }
                        })
                        .catch(() => alert('Error occurred while deleting.'));
                }
            });
        });
    </script>
</body>
</html>
