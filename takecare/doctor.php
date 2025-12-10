<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Define uploads directory
$uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/takecare/uploads/';

// Initialize variables
$doctor = null;
$doctors = [];
$error = '';
$showSingleDoctor = false;

// Fetch single doctor if doctor_id is provided
if (isset($_GET['doctor_id'])) {
    $doctor_id = filter_input(INPUT_GET, 'doctor_id', FILTER_VALIDATE_INT);
    if ($doctor_id) {
        try {
            $stmt = $conn->prepare("SELECT * FROM doctors WHERE id = :id");
            $stmt->execute(['id' => $doctor_id]);
            $doctor = $stmt->fetch();
            if ($doctor) {
                $doctor['education'] = json_decode($doctor['education'], true) ?? [];
                $doctor['specializations'] = json_decode($doctor['specializations'], true) ?? [];
                $showSingleDoctor = true;
            } else {
                $error = "Doctor not found.";
            }
        } catch (PDOException $e) {
            $error = "Failed to fetch doctor: " . $e->getMessage();
        }
    } else {
        $error = "Invalid doctor ID.";
    }
}

// Fetch all doctors if no doctor_id is provided
if (!$showSingleDoctor) {
    try {
        $stmt = $conn->query("SELECT * FROM doctors ORDER BY created_at DESC");
        $doctors = $stmt->fetchAll();
        foreach ($doctors as &$doc) {
            $doc['education'] = json_decode($doc['education'], true) ?? [];
            $doc['specializations'] = json_decode($doc['specializations'], true) ?? [];
        }
    } catch (PDOException $e) {
        $error = "Failed to fetch doctors: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $showSingleDoctor ? 'Doctor Profile' : 'Find a Doctor'; ?> | Takecare.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --dark-blue: #1A2B40;
            --purple: #8A2BE2;
            --white: #FFFFFF;
            --light-gray: #F0F0F0;
            --text-color: #333333;
        }

        body {
            background: linear-gradient(135deg, #f0f7ff, #e1ecfe);
            color: var(--text-color);
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

        .subtitle {
            color: #555;
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto 30px;
        }

        .doctor-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            transition: all 0.3s;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .doctor-img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px 10px 0 0;
        }

        .doctor-info {
            padding: 30px;
        }

        .doctor-name {
            font-size: 2rem;
            color: #0d47a1;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .doctor-specialty {
            color: #1a73e8;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .doctor-location {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            color: #666;
            font-size: 0.9rem;
        }

        .doctor-location i {
            margin-right: 8px;
            color: #1a73e8;
        }

        .contact-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: #555;
        }

        .contact-item i {
            width: 20px;
            color: #1a73e8;
            margin-right: 10px;
        }

        .rating-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stars {
            color: #ffc107;
            font-size: 1.2rem;
        }

        .rating-text {
            color: #666;
            font-size: 0.9rem;
        }

        .profile-section {
            margin-bottom: 25px;
        }

        .profile-section h4 {
            color: #0d47a1;
            font-size: 1.1rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-section p, .profile-section ul {
            color: #555;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .profile-section ul {
            padding-left: 20px;
        }

        .profile-section li {
            margin-bottom: 5px;
        }

        .btn-primary, .btn-outline-primary {
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            border: none;
            font-weight: 600;
            padding: 12px 20px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-primary:hover, .btn-outline-primary:hover {
            background: linear-gradient(to right, #0d47a1, #1a73e8);
            box-shadow: 0 5px 15px rgba(26, 115, 232, 0.3);
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid #1a73e8;
            color: #1a73e8;
        }

        .btn-outline-primary:hover {
            color: white;
        }

        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .availability {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .available {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 20px;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(to right, #1a73e8, #0d47a1);
            color: white;
            border-radius: 10px 10px 0 0;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: none;
            padding: 15px 20px;
        }

        .form-control:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 5px rgba(26, 115, 232, 0.3);
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }

            .doctor-name {
                font-size: 1.6rem;
            }

            .doctor-specialty {
                font-size: 1rem;
            }

            .doctor-img {
                height: 200px;
            }

            .doctor-info {
                padding: 20px;
            }

            .doctors-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title"><?php echo $showSingleDoctor ? 'Doctor Profile' : 'Find a Doctor'; ?></h1>
            <?php if (!$showSingleDoctor): ?>
                <p class="subtitle">Browse all available doctors</p>
            <?php endif; ?>
        </div>

        <!-- Error Message -->
        <?php if ($error && $showSingleDoctor): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Single Doctor Profile -->
        <?php if ($showSingleDoctor && $doctor): ?>
            <div class="doctor-card">
                <?php if (!empty($doctor['image']) && file_exists($uploadDir . $doctor['image'])): ?>
                    <img src="/takecare/uploads/<?php echo htmlspecialchars($doctor['image']); ?>" alt="<?php echo htmlspecialchars($doctor['name']); ?>" class="doctor-img">
                <?php else: ?>
                    <img src="https://via.placeholder.com/300" alt="Default Doctor Image" class="doctor-img">
                <?php endif; ?>
                <div class="doctor-info">
                    <h2 class="doctor-name"><?php echo htmlspecialchars($doctor['name']); ?></h2>
                    <p class="doctor-specialty"><?php echo htmlspecialchars($doctor['specialty']); ?></p>
                    <div class="rating-section">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <span class="rating-text">4.9/5 (127 reviews)</span>
                    </div>
                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo htmlspecialchars($doctor['location']); ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span><?php echo htmlspecialchars($doctor['phone']); ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo htmlspecialchars($doctor['email']); ?></span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>Mon-Fri: 9:00 AM - 6:00 PM</span>
                        </div>
                    </div>
                    <div class="profile-section">
                        <h4><i class="fas fa-user-md"></i> About</h4>
                        <p><?php echo nl2br(htmlspecialchars($doctor['about'])); ?></p>
                    </div>
                    <div class="profile-section">
                        <h4><i class="fas fa-graduation-cap"></i> Education & Certifications</h4>
                        <ul>
                            <?php foreach ($doctor['education'] as $edu): ?>
                                <li><?php echo htmlspecialchars($edu); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="profile-section">
                        <h4><i class="fas fa-award"></i> Specializations</h4>
                        <ul>
                            <?php foreach ($doctor['specializations'] as $spec): ?>
                                <li><?php echo htmlspecialchars($spec); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="profile-section">
                        <h4><i class="fas fa-language"></i> Languages</h4>
                        <p><?php echo htmlspecialchars($doctor['languages']); ?></p>
                    </div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookModal<?php echo $doctor['id']; ?>">
                        <i class="far fa-calendar"></i> Book Appointment
                    </button>
                </div>
            </div>
            <!-- Book Modal for Single Doctor -->
            <div class="modal fade" id="bookModal<?php echo $doctor['id']; ?>" tabindex="-1" aria-labelledby="bookModalLabel<?php echo $doctor['id']; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="bookModalLabel<?php echo $doctor['id']; ?>">Book Appointment with <?php echo htmlspecialchars($doctor['name']); ?></h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="appointment.php" method="POST">
                                <input type="hidden" name="doctor_id" value="<?php echo $doctor['id']; ?>">
                                <div class="mb-3">
                                    <label for="patient_name<?php echo $doctor['id']; ?>" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="patient_name<?php echo $doctor['id']; ?>" name="patient_name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="appointment_date<?php echo $doctor['id']; ?>" class="form-label">Appointment Date</label>
                                    <input type="date" class="form-control" id="appointment_date<?php echo $doctor['id']; ?>" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="appointment_time<?php echo $doctor['id']; ?>" class="form-label">Appointment Time</label>
                                    <input type="time" class="form-control" id="appointment_time<?php echo $doctor['id']; ?>" name="appointment_time" required>
                                </div>
                                <div class="mb-3">
                                    <label for="reason<?php echo $doctor['id']; ?>" class="form-label">Reason for Visit</label>
                                    <textarea class="form-control" id="reason<?php echo $doctor['id']; ?>" name="reason" rows="4" required></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit Appointment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Doctors Grid -->
            <div class="doctors-grid">
                <?php if (!empty($doctors)): ?>
                    <?php foreach ($doctors as $doc): ?>
                        <div class="doctor-card">
                            <?php if (!empty($doc['image']) && file_exists($uploadDir . $doc['image'])): ?>
                                <img src="/takecare/uploads/<?php echo htmlspecialchars($doc['image']); ?>" alt="<?php echo htmlspecialchars($doc['name']); ?>" class="doctor-img" style="height: 180px;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/180" alt="Default Doctor Image" class="doctor-img" style="height: 180px;">
                            <?php endif; ?>
                            <div class="doctor-info">
                                <h3 class="doctor-name"><?php echo htmlspecialchars($doc['name']); ?></h3>
                                <p class="doctor-specialty"><?php echo htmlspecialchars($doc['specialty']); ?></p>
                                <div class="doctor-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo htmlspecialchars($doc['location']); ?></span>
                                </div>
                                <div class="availability available">
                                    <i class="fas fa-check-circle"></i> Available Today
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookModal<?php echo $doc['id']; ?>">
                                        <i class="far fa-calendar"></i> Book
                                    </button>
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#profileModal<?php echo $doc['id']; ?>">
                                        <i class="far fa-user"></i> Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Book Modal -->
                        <div class="modal fade" id="bookModal<?php echo $doc['id']; ?>" tabindex="-1" aria-labelledby="bookModalLabel<?php echo $doc['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="bookModalLabel<?php echo $doc['id']; ?>">Book Appointment with <?php echo htmlspecialchars($doc['name']); ?></h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="appointment.php" method="POST">
                                            <input type="hidden" name="doctor_id" value="<?php echo $doc['id']; ?>">
                                            <div class="mb-3">
                                                <label for="patient_name<?php echo $doc['id']; ?>" class="form-label">Your Name</label>
                                                <input type="text" class="form-control" id="patient_name<?php echo $doc['id']; ?>" name="patient_name" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="appointment_date<?php echo $doc['id']; ?>" class="form-label">Appointment Date</label>
                                                <input type="date" class="form-control" id="appointment_date<?php echo $doc['id']; ?>" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="appointment_time<?php echo $doc['id']; ?>" class="form-label">Appointment Time</label>
                                                <input type="time" class="form-control" id="appointment_time<?php echo $doc['id']; ?>" name="appointment_time" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="reason<?php echo $doc['id']; ?>" class="form-label">Reason for Visit</label>
                                                <textarea class="form-control" id="reason<?php echo $doc['id']; ?>" name="reason" rows="4" required></textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Submit Appointment</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Profile Modal -->
                        <div class="modal fade" id="profileModal<?php echo $doc['id']; ?>" tabindex="-1" aria-labelledby="profileModalLabel<?php echo $doc['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="profileModalLabel<?php echo $doc['id']; ?>"><?php echo htmlspecialchars($doc['name']); ?>'s Profile</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if (!empty($doc['image']) && file_exists($uploadDir . $doc['image'])): ?>
                                            <img src="/takecare/uploads/<?php echo htmlspecialchars($doc['image']); ?>" alt="<?php echo htmlspecialchars($doc['name']); ?>" class="doctor-img mb-3">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/300" alt="Default Doctor Image" class="doctor-img mb-3">
                                        <?php endif; ?>
                                        <h2 class="doctor-name"><?php echo htmlspecialchars($doc['name']); ?></h2>
                                        <p class="doctor-specialty"><?php echo htmlspecialchars($doc['specialty']); ?></p>
                                        <div class="rating-section">
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <span class="rating-text">4.9/5 (127 reviews)</span>
                                        </div>
                                        <div class="contact-info">
                                            <div class="contact-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span><?php echo htmlspecialchars($doc['location']); ?></span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-phone"></i>
                                                <span><?php echo htmlspecialchars($doc['phone']); ?></span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <span><?php echo htmlspecialchars($doc['email']); ?></span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-clock"></i>
                                                <span>Mon-Fri: 9:00 AM - 6:00 PM</span>
                                            </div>
                                        </div>
                                        <div class="profile-section">
                                            <h4><i class="fas fa-user-md"></i> About</h4>
                                            <p><?php echo nl2br(htmlspecialchars($doc['about'])); ?></p>
                                        </div>
                                        <div class="profile-section">
                                            <h4><i class="fas fa-graduation-cap"></i> Education & Certifications</h4>
                                            <ul>
                                                <?php foreach ($doc['education'] as $edu): ?>
                                                    <li><?php echo htmlspecialchars($edu); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="profile-section">
                                            <h4><i class="fas fa-award"></i> Specializations</h4>
                                            <ul>
                                                <?php foreach ($doc['specializations'] as $spec): ?>
                                                    <li><?php echo htmlspecialchars($spec); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                        <div class="profile-section">
                                            <h4><i class="fas fa-language"></i> Languages</h4>
                                            <p><?php echo htmlspecialchars($doc['languages']); ?></p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookModal<?php echo $doc['id']; ?>" onclick="document.getElementById('profileModal<?php echo $doc['id']; ?>').classList.remove('show');">Book Appointment</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="error-message">No doctors found. Please try again later or contact support.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Language functionality from header.php
        document.addEventListener("DOMContentLoaded", () => {
            const languageSelect = document.getElementById("language-select");
            if (languageSelect) {
                const savedLang = localStorage.getItem('language') || 'en';
                languageSelect.value = savedLang;

                const updateLanguage = (lang) => {
                    const mapping = {
                        en: {
                            'nav-home': 'Home',
                            'nav-emergency': 'Emergency',
                            'nav-services': 'Services',
                            'nav-health': 'Health',
                            'nav-doctors': 'Doctors',
                            'nav-hospitals': 'Hospitals',
                            'nav-about': 'About',
                            'nav-login': 'Login'
                        },
                        np: {
                            'nav-home': 'गृह',
                            'nav-emergency': 'आपतकालीन',
                            'nav-services': 'सेवाहरू',
                            'nav-health': 'स्वास्थ्य',
                            'nav-doctors': 'डाक्टरहरू',
                            'nav-hospitals': 'अस्पतालहरू',
                            'nav-about': 'हाम्रो बारे',
                            'nav-login': 'लगइन'
                        }
                    };

                    document.querySelectorAll('[data-translate]').forEach(el => {
                        const key = el.getAttribute('data-translate');
                        if (mapping[lang] && mapping[lang][key]) {
                            el.textContent = mapping[lang][key];
                        }
                    });

                    localStorage.setItem('language', lang);
                };

                updateLanguage(savedLang);

                languageSelect.addEventListener("change", function () {
                    updateLanguage(this.value);
                });
            }

            // Navigation active state
            document.querySelectorAll('.nav-item').forEach(item => {
                item.addEventListener('click', e => {
                    document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                    item.classList.add('active');
                });
            });
        });
    </script>
</body>
</html>