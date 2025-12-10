<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

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

$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/takecare/uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

$editMode = false;
$doctor = [
    'id' => '', 'name' => '', 'specialty' => '', 'location' => '', 'phone' => '', 'email' => '',
    'about' => '', 'education' => [], 'specializations' => [], 'languages' => '', 'image' => ''
];
$error = $success = '';

// Edit Mode
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
    $stmt->execute([$edit_id]);
    if ($row = $stmt->fetch()) {
        $doctor = $row;
        $editMode = true;
        $doctor['education'] = json_decode($doctor['education'] ?? '[]', true);
        $doctor['specializations'] = json_decode($doctor['specializations'] ?? '[]', true);
    }
}

// Delete Doctor
if (isset($_GET['delete_id'])) {
    $id = (int)$_GET['delete_id'];
    $stmt = $conn->prepare("SELECT image FROM doctors WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetchColumn();
    if ($img && file_exists($uploadDir . $img)) unlink($uploadDir . $img);
    $conn->prepare("DELETE FROM doctors WHERE id = ?")->execute([$id]);
    header("Location: manage_doctor.php?msg=deleted");
    exit();
}

// Form Submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $specialty = $_POST['specialty'] ?? '';
    $location = trim($_POST['location'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $about = trim($_POST['about'] ?? '');
    $languages = trim($_POST['languages'] ?? '');
    $education = array_filter(array_map('trim', $_POST['education'] ?? []));
    $specializations = array_filter(array_map('trim', $_POST['specializations'] ?? []));
    $imageName = $editMode ? $doctor['image'] : '';

    if (empty($name) || empty($specialty) || empty($location) || empty($phone) || empty($email)) {
        $error = "Please fill all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        // Handle image upload
        if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === 0) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($_FILES['image']['type'], $allowed) && $_FILES['image']['size'] <= 5*1024*1024 && in_array($ext, ['jpg','jpeg','png','webp'])) {
                $imageName = 'doc_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName);
                if ($editMode && $doctor['image'] && file_exists($uploadDir . $doctor['image'])) {
                    unlink($uploadDir . $doctor['image']);
                }
            } else {
                $error = "Invalid image. Use JPEG/PNG/WebP, max 5MB.";
            }
        }

        if (!$error) {
            $eduJson = json_encode($education);
            $specJson = json_encode($specializations);
            try {
                if ($editMode) {
                    $sql = "UPDATE doctors SET name=?, specialty=?, location=?, phone=?, email=?, about=?, education=?, specializations=?, languages=?, image=? WHERE id=?";
                    $conn->prepare($sql)->execute([$name, $specialty, $location, $phone, $email, $about, $eduJson, $specJson, $languages, $imageName, $edit_id]);
                    $success = "Doctor updated successfully!";
                } else {
                    $sql = "INSERT INTO doctors (name,specialty,location,phone,email,about,education,specializations,languages,image,created_at) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,NOW())";
                    $conn->prepare($sql)->execute([$name, $specialty, $location, $phone, $email, $about, $eduJson, $specJson, $languages, $imageName]);
                    $success = "Doctor added successfully!";
                }
            } catch (Exception $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}

// Fetch all doctors
$doctors = $conn->query("SELECT * FROM doctors ORDER BY created_at DESC")->fetchAll();
foreach ($doctors as &$d) {
    $d['education'] = json_decode($d['education'] ?? '[]', true);
    $d['specializations'] = json_decode($d['specializations'] ?? '[]', true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors - TakeCare Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card-header { background: #0d6efd; color: white; border-radius: 12px 12px 0 0 !important; }
        .btn-primary { background-color: #0d6efd; border: none; }
        .doctor-card { transition: 0.3s; border-radius: 12px; overflow: hidden; }
        .doctor-card:hover { box-shadow: 0 8px 25px rgba(13,110,253,0.15); transform: translateY(-5px); }
        .doctor-img { height: 200px; overflow: hidden; background: #e9ecef; }
        .doctor-img img { width: 100%; height: 100%; object-fit: cover; }
        .form-control, .form-select { border-radius: 8px; }
        .input-group button { border-radius: 0 8px 8px 0; }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <?php include 'sidebar.php'; ?>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 text-primary"><i class="fas fa-user-md"></i> Manage Doctors</h2>
            </div>

            <!-- Success / Error Messages -->
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
            <?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    Doctor deleted successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Add/Edit Form -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas <?= $editMode ? 'fa-edit' : 'fa-plus' ?>"></i> <?= $editMode ? 'Edit Doctor' : 'Add New Doctor' ?></h5>
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Doctor Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($doctor['name']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Specialty <span class="text-danger">*</span></label>
                                <select name="specialty" class="form-select" required>
                                    <option value="">Select Specialty</option>
                                    <option <?= $doctor['specialty']=='Cardiologist' ? 'selected' : '' ?>>Cardiologist</option>
                                    <option <?= $doctor['specialty']=='Neurologist' ? 'selected' : '' ?>>Neurologist</option>
                                    <option <?= $doctor['specialty']=='Pediatrician' ? 'selected' : '' ?>>Pediatrician</option>
                                    <option <?= $doctor['specialty']=='Dermatologist' ? 'selected' : '' ?>>Dermatologist</option>
                                    <option <?= $doctor['specialty']=='Orthopedic Surgeon' ? 'selected' : '' ?>>Orthopedic Surgeon</option>
                                    <option <?= $doctor['specialty']=='Ophthalmologist' ? 'selected' : '' ?>>Ophthalmologist</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($doctor['location']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($doctor['phone']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($doctor['email']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Photo (Optional)</label>
                                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImg(this)">
                                <?php if ($editMode && $doctor['image']): ?>
                                    <img src="/takecare/uploads/<?= $doctor['image'] ?>" class="mt-2 rounded" style="height:70px;">
                                <?php endif; ?>
                                <img id="imgPreview" class="mt-2 rounded" style="height:80px; display:none;">
                            </div>
                            <div class="col-12">
                                <label class="form-label">About</label>
                                <textarea name="about" class="form-control" rows="3"><?= htmlspecialchars($doctor['about']) ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Education</label>
                                <div id="educationFields">
                                    <?php foreach ($doctor['education'] as $edu): ?>
                                        <div class="input-group mb-2">
                                            <input type="text" name="education[]" class="form-control" value="<?= htmlspecialchars($edu) ?>">
                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Remove</button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addField('educationFields')">+ Add Education</button>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Specializations</label>
                                <div id="specFields">
                                    <?php foreach ($doctor['specializations'] as $spec): ?>
                                        <div class="input-group mb-2">
                                            <input type="text" name="specializations[]" class="form-control" value="<?= htmlspecialchars($spec) ?>">
                                            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Remove</button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addField('specFields')">+ Add Specialization</button>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Languages</label>
                                <input type="text" name="languages" class="form-control" value="<?= htmlspecialchars($doctor['languages']) ?>" placeholder="e.g. English, Spanish, French">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save"></i> <?= $editMode ? 'Update' : 'Add' ?> Doctor
                            </button>
                            <?php if ($editMode): ?>
                                <a href="manage_doctor.php" class="btn btn-secondary btn-lg px-4 ms-2">Cancel</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <input type="text" id="searchInput" class="form-control form-control-lg" placeholder="Search doctors by name, specialty or location...">
                </div>
            </div>

            <!-- Doctors List -->
            <div class="row g-4" id="doctorsList">
                <?php foreach ($doctors as $d): ?>
                    <div class="col-md-6 col-lg-4 doctor-item">
                        <div class="card doctor-card h-100">
                            <div class="doctor-img">
                                <?php if ($d['image'] && file_exists($uploadDir . $d['image'])): ?>
                                    <img src="/takecare/uploads/<?= htmlspecialchars($d['image']) ?>" alt="<?= htmlspecialchars($d['name']) ?>">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                        <i class="fas fa-user-md fa-4x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($d['name']) ?></h5>
                                <p class="text-info fw-bold mb-1"><?= htmlspecialchars($d['specialty']) ?></p>
                                <p class="text-muted small"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($d['location']) ?></p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <small class="text-muted">Added <?= date('M j, Y', strtotime($d['created_at'])) ?></small>
                                    <div>
                                        <a href="?edit_id=<?= $d['id'] ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="?delete_id=<?= $d['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this doctor permanently?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const prev = document.getElementById('imgPreview');
            prev.src = e.target.result;
            prev.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function addField(containerId) {
    const container = document.getElementById(containerId);
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" name="${containerId === 'educationFields' ? 'education' : 'specializations'}[]" class="form-control">
        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">Remove</button>
    `;
    container.appendChild(div);
}

// Live Search
document.getElementById('searchInput').addEventListener('keyup', function() {
    const term = this.value.toLowerCase();
    document.querySelectorAll('.doctor-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(term) ? '' : 'none';
    });
});
</script>
</body>
</html>