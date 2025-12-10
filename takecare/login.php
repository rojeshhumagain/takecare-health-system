<?php
session_start();
require_once "includes/db.php";

// Handle Login
if (isset($_POST['login'])) {
    $email = trim($_POST['login_email']);
    $password = trim($_POST['login_password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit;
        } else {
            $login_error = "Incorrect password.";
        }
    } else {
        $login_error = "User not found.";
    }
}

// Handle Registration
if (isset($_POST['register'])) {
    $name = trim($_POST['register_name']);
    $email = trim($_POST['register_email']);
    $password = password_hash(trim($_POST['register_password']), PASSWORD_DEFAULT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $register_error = "Email already registered.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $password])) {
            $register_success = "Registration successful. Please log in.";
        } else {
            $register_error = "Registration failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login & Register - TakeCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
        }
        .container-box {
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .toggle-link {
            cursor: pointer;
            color: blue;
        }
    </style>
</head>
<body>

<div class="container-box">
    <h4 class="text-center mb-4" id="formTitle">Login to TakeCare</h4>

    <!-- Login Form -->
    <form method="POST" id="loginForm" <?= isset($register_success) ? 'style="display:none;"' : '' ?>>
        <?php if (isset($login_error)) echo "<div class='alert alert-danger'>$login_error</div>"; ?>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="login_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="login_password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        <p class="mt-3 text-center">Don't have an account? <span class="toggle-link" onclick="toggleForms()">Register</span></p>
    </form>

    <!-- Register Form -->
    <form method="POST" id="registerForm" <?= isset($register_success) ? '' : 'style="display:none;"' ?>>
        <?php
        if (isset($register_error)) echo "<div class='alert alert-danger'>$register_error</div>";
        if (isset($register_success)) echo "<div class='alert alert-success'>$register_success</div>";
        ?>
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="register_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="register_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="register_password" class="form-control" required>
        </div>
        <button type="submit" name="register" class="btn btn-success w-100">Register</button>
        <p class="mt-3 text-center">Already have an account? <span class="toggle-link" onclick="toggleForms()">Login</span></p>
    </form>
</div>

<script>
function toggleForms() {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const formTitle = document.getElementById("formTitle");
    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
        formTitle.innerText = "Login to TakeCare";
    } else {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
        formTitle.innerText = "Register for TakeCare";
    }
}
</script>

</body>
</html>
