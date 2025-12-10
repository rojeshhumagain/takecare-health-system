<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

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
    die("Connection failed: " . $e->getMessage());
}

$error = $success = '';

// Handle Delete
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $conn->prepare("DELETE FROM appointments WHERE id = ?")->execute([$id]);
    $success = "Appointment deleted successfully!";
}

// Fetch doctors for filter
$doctors = $conn->query("SELECT id, name FROM doctors ORDER BY name")->fetchAll();

// Fetch appointments with filters
$filter_doctor = $_GET['doctor'] ?? '';
$filter_date = $_GET['date'] ?? '';

$sql = "SELECT a.*, d.name AS doctor_name FROM appointments a JOIN doctors d ON a.doctor_id = d.id WHERE 1=1";
$params = [];

if ($filter_doctor) {
    $sql .= " AND a.doctor_id = ?";
    $params[] = $filter_doctor;
}
if ($filter_date) {
    $sql .= " AND a.appointment_date = ?";
    $params[] = $filter_date;
}

$sql .= " ORDER BY a.appointment_date DESC, a.appointment_time DESC";
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$appointments = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments - TakeCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card-header { background: #6f42c1; color: white; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background-color: #6f42c1; border: none; }
        .appt-card { transition: 0.3s; border-radius: 12px; overflow: hidden; }
        .appt-card:hover { box-shadow: 0 8px 25px rgba(111,66,193,0.15); transform: translateY(-5px); }
        .status-badge { font-size: 0.8rem; padding: 5px 12px; border-radius: 20px; }
        .status-upcoming { background: #d1ecf1; color: #0c5460; }
        .status-today { background: #d4edda; color: #155724; }
        .status-past { background: #f8d7da; color: #721c24; }
        .form-control, .form-select { border-radius: 8px; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 text-primary"><i class="fas fa-calendar-check"></i> Manage Appointments</h2>
            </div>

            <!-- Messages -->
            <?php if ($success): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle"></i> <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Doctor</label>
                            <select name="doctor" class="form-select">
                                <option value="">All Doctors</option>
                                <?php foreach ($doctors as $doc): ?>
                                    <option value="<?= $doc['id'] ?>" <?= $filter_doctor == $doc['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($doc['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="<?= htmlspecialchars($filter_date) ?>">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Apply Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Search by patient name, doctor, or reason...">
                </div>
            </div>

            <!-- Appointments Grid -->
            <div class="row g-4" id="appointmentsList">
                <?php if (!empty($appointments)): ?>
                    <?php foreach ($appointments as $a): 
                        $apptDate = $a['appointment_date'];
                        $today = date('Y-m-d');
                        $status = ($apptDate > $today) ? 'upcoming' : (($apptDate == $today) ? 'today' : 'past');
                        $statusText = ($apptDate > $today) ? 'Upcoming' : (($apptDate == $today) ? 'Today' : 'Past');
                    ?>
                        <div class="col-md-6 col-lg-4 appt-item">
                            <div class="card appt-card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h5 class="card-title text-primary mb-1"><?= htmlspecialchars($a['patient_name']) ?></h5>
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-user-md me-1"></i> Dr. <?= htmlspecialchars($a['doctor_name']) ?>
                                            </p>
                                        </div>
                                        <span class="status-badge status-<?= $status ?>">
                                            <?= $statusText ?>
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <p class="mb-1">
                                            <i class="fas fa-calendar-alt text-primary"></i>
                                            <strong><?= date('D, M j, Y', strtotime($apptDate)) ?></strong>
                                        </p>
                                        <p class="mb-1">
                                            <i class="fas fa-clock text-primary"></i>
                                            <?= date('g:i A', strtotime($a['appointment_time'])) ?>
                                        </p>
                                    </div>

                                    <p class="text-muted small mb-3">
                                        <strong>Reason:</strong><br>
                                        <?= nl2br(htmlspecialchars(substr($a['reason'], 0, 80))) ?>
                                        <?= strlen($a['reason']) > 80 ? '...' : '' ?>
                                    </p>

                                    <small class="text-muted d-block mb-3">
                                        Booked: <?= date('M j, Y \a\t g:i A', strtotime($a['created_at'])) ?>
                                    </small>

                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal<?= $a['id'] ?>">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $a['id'] ?>">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <a href="?delete_id=<?= $a['id'] ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Delete this appointment permanently?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- View Modal -->
                        <div class="modal fade" id="viewModal<?= $a['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Appointment Details</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Patient:</strong> <?= htmlspecialchars($a['patient_name']) ?></p>
                                        <p><strong>Doctor:</strong> Dr. <?= htmlspecialchars($a['doctor_name']) ?></p>
                                        <p><strong>Date:</strong> <?= date('l, F j, Y', strtotime($apptDate)) ?></p>
                                        <p><strong>Time:</strong> <?= date('g:i A', strtotime($a['appointment_time'])) ?></p>
                                        <p><strong>Reason:</strong></p>
                                        <div class="bg-light p-3 rounded">
                                            <?= nl2br(htmlspecialchars($a['reason'])) ?>
                                        </div>
                                        <hr>
                                        <small class="text-muted">
                                            Booked on: <?= date('F j, Y \a\t g:i A', strtotime($a['created_at'])) ?>
                                        </small>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $a['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-dark">
                                        <h5 class="modal-title">Edit Appointment</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="appointment_id" value="<?= $a['id'] ?>">
                                            <div class="mb-3">
                                                <label class="form-label">Doctor</label>
                                                <select name="doctor_id" class="form-select" required>
                                                    <?php foreach ($doctors as $doc): ?>
                                                        <option value="<?= $doc['id'] ?>" <?= $a['doctor_id'] == $doc['id'] ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($doc['name']) ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Patient Name</label>
                                                <input type="text" name="patient_name" class="form-control" value="<?= htmlspecialchars($a['patient_name']) ?>" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Date</label>
                                                    <input type="date" name="appointment_date" class="form-control" value="<?= $a['appointment_date'] ?>" min="<?= date('Y-m-d') ?>" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Time</label>
                                                    <input type="time" name="appointment_time" class="form-control" value="<?= $a['appointment_time'] ?>" min="09:00" max="18:00" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Reason</label>
                                                <textarea name="reason" class="form-control" rows="4" required><?= htmlspecialchars($a['reason']) ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" name="update_appointment" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-times fa-5x text-muted mb-4"></i>
                            <h4 class="text-muted">No appointments found</h4>
                            <p class="text-muted">Try adjusting your filters or wait for new bookings.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Live Search
    document.getElementById('searchInput')?.addEventListener('keyup', function() {
        const term = this.value.toLowerCase();
        document.querySelectorAll('.appt-item').forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(term) ? '' : 'none';
        });
    });
</script>
</body>
</html>