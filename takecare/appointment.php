<?php
session_start();

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

// Initialize variables
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $doctor_id = filter_input(INPUT_POST, 'doctor_id', FILTER_VALIDATE_INT);
    $patient_name = filter_input(INPUT_POST, 'patient_name', FILTER_SANITIZE_STRING);
    $appointment_date = filter_input(INPUT_POST, 'appointment_date', FILTER_SANITIZE_STRING);
    $appointment_time = filter_input(INPUT_POST, 'appointment_time', FILTER_SANITIZE_STRING);
    $reason = filter_input(INPUT_POST, 'reason', FILTER_SANITIZE_STRING);

    if (!$doctor_id || !$patient_name || !$appointment_date || !$appointment_time || !$reason) {
        $error = "All fields are required.";
    } else {
        // Validate date and time
        $date = DateTime::createFromFormat('Y-m-d', $appointment_date);
        $time = DateTime::createFromFormat('H:i', $appointment_time);
        if (!$date || $date < new DateTime('today') || !$time) {
            $error = "Invalid date or time.";
        } else {
            try {
                // Check if doctor exists
                $stmt = $conn->prepare("SELECT id FROM doctors WHERE id = :id");
                $stmt->execute(['id' => $doctor_id]);
                if (!$stmt->fetch()) {
                    $error = "Doctor not found.";
                } else {
                    // Insert appointment
                    $stmt = $conn->prepare("
                        INSERT INTO appointments (doctor_id, patient_name, appointment_date, appointment_time, reason, created_at)
                        VALUES (:doctor_id, :patient_name, :appointment_date, :appointment_time, :reason, NOW())
                    ");
                    $stmt->execute([
                        'doctor_id' => $doctor_id,
                        'patient_name' => $patient_name,
                        'appointment_date' => $appointment_date,
                        'appointment_time' => $appointment_time,
                        'reason' => $reason
                    ]);
                    $message = "Appointment booked successfully!";
                }
            } catch (PDOException $e) {
                $error = "Failed to book appointment: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Status | Takecare.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background: linear-gradient(135deg, #f0f7ff, #e1ecfe);
            color: #333333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
        }

        .page-title {
            font-size: 2.2rem;
            color: #0d47a1;
            margin-bottom: 15px;
        }

        .success-message {
            color: #2e7d32;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .error-message {
            color: #dc3545;
            font-size: 1.1rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            border: none;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0d47a1, #1a73e8);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Appointment Status</h1>
        </div>
        <?php if ($message): ?>
            <p class="success-message"><?php echo htmlspecialchars($message); ?></p>
            <div class="text-center">
                <a href="doctor.php" class="btn btn-primary">Back to Doctors</a>
            </div>
        <?php elseif ($error): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <div class="text-center">
                <a href="doctor.php" class="btn btn-primary">Back to Doctors</a>
            </div>
        <?php else: ?>
            <p class="error-message">Invalid request. Please try again.</p>
            <div class="text-center">
                <a href="doctor.php" class="btn btn-primary">Back to Doctors</a>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>