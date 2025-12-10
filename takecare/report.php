<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Generate CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
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
    die("Error: Database connection failed: " . $e->getMessage());
}

// Handle form submission
$message = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_report'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "अमान्य CSRF टोकन।";
    } else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING) ?: NULL;
        $issue_type = filter_input(INPUT_POST, 'issue_type', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $pdf_file = NULL;
        $video_file = NULL;

        // Validation
        if (!$name || !$email || !$issue_type || !$description) {
            $error = "सबै आवश्यक क्षेत्रहरू भर्नुहोस्।";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "अमान्य इमेल ढाँचा।";
        } else {
            // Handle PDF/image upload
            if (isset($_FILES['pdf_upload']) && $_FILES['pdf_upload']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
                $max_size = 5 * 1024 * 1024; // 5MB
                $file_type = mime_content_type($_FILES['pdf_upload']['tmp_name']);
                $file_size = $_FILES['pdf_upload']['size'];
                $file_ext = strtolower(pathinfo($_FILES['pdf_upload']['name'], PATHINFO_EXTENSION));
                $file_name = 'pdf_' . uniqid() . '.' . $file_ext;
                $upload_dir = 'C:/xampp/htdocs/takecare/uploads/';
                $upload_path = $upload_dir . $file_name;

                if (!in_array($file_type, $allowed_types)) {
                    $error = "PDF वा JPEG/PNG छवि मात्र अपलोड गर्न सकिन्छ।";
                } elseif ($file_size > $max_size) {
                    $error = "फाइलको आकार 5MB भन्दा कम हुनुपर्छ।";
                } elseif (!move_uploaded_file($_FILES['pdf_upload']['tmp_name'], $upload_path)) {
                    $error = "फाइल अपलोड गर्न असफल।";
                } else {
                    $pdf_file = $file_name;
                }
            }

            // Handle video upload
            if (!$error && isset($_FILES['video_upload']) && $_FILES['video_upload']['error'] === UPLOAD_ERR_OK) {
                $allowed_types = ['video/mp4', 'video/mov', 'video/avi'];
                $max_size = 5 * 1024 * 1024; // 5MB
                $file_type = mime_content_type($_FILES['video_upload']['tmp_name']);
                $file_size = $_FILES['video_upload']['size'];
                $file_ext = strtolower(pathinfo($_FILES['video_upload']['name'], PATHINFO_EXTENSION));
                $file_name = 'video_' . uniqid() . '.' . $file_ext;
                $upload_path = $upload_dir . $file_name;

                if (!in_array($file_type, $allowed_types)) {
                    $error = "MP4, MOV, वा AVI भिडियो मात्र अपलोड गर्न सकिन्छ।";
                } elseif ($file_size > $max_size) {
                    $error = "भिडियोको आकार 5MB भन्दा कम हुनुपर्छ।";
                } elseif (!move_uploaded_file($_FILES['video_upload']['tmp_name'], $upload_path)) {
                    $error = "भिडियो अपलोड गर्न असफल।";
                } else {
                    $video_file = $file_name;
                }
            }

            // Save to database
            if (!$error) {
                try {
                    $stmt = $conn->prepare("INSERT INTO reports (name, email, address, issue_type, description, pdf_file, video_file, status) VALUES (:name, :email, :address, :issue_type, :description, :pdf_file, :video_file, 'pending')");
                    $stmt->execute([
                        'name' => $name,
                        'email' => $email,
                        'address' => $address,
                        'issue_type' => $issue_type,
                        'description' => $description,
                        'pdf_file' => $pdf_file,
                        'video_file' => $video_file
                    ]);
                    $message = "तपाईंको रिपोर्ट सफलतापूर्वक पेश गरियो! हामी चाँडै सम्पर्क गर्नेछौं।";
                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                } catch (PDOException $e) {
                    $error = "रिपोर्ट पेश गर्न असफल: " . $e->getMessage();
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>रिपोर्ट गर्नुहोस् - Takecare.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --dark-blue: #1A2B40;
            --purple: #8A2BE2;
            --light-purple: #9c4dff;
            --white: #FFFFFF;
            --light-gray: #F5F7FA;
            --medium-gray: #e0e0e0;
            --text-color: #333333;
            --success: #28a745;
            --accent: #e24e1b;
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            min-height: 100vh;
        }

        .container {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }

        .report-card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 30px;
            width: 100%;
        }

        .card-title {
            color: var(--dark-blue);
            font-size: 1.5rem;
            margin-bottom: 20px;
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--medium-gray);
        }

        .card-title i {
            color: var(--purple);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-blue);
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: " *";
            color: #dc3545;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: var(--light-gray);
        }

        .form-control:focus {
            border-color: var(--purple);
            box-shadow: 0 0 0 3px rgba(138, 43, 226, 0.15);
            outline: none;
            background: var(--white);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .attachments-header {
            margin: 25px 0 15px;
            font-size: 1.1rem;
            color: var(--dark-blue);
            text-align: center;
        }

        .attachments-subheader {
            color: #666;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: center;
        }

        .upload-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .upload-column {
            flex: 1;
        }

        .upload-box {
            border: 2px dashed var(--medium-gray);
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s;
            background: var(--light-gray);
            height: 100%;
            text-align: center;
        }

        .upload-box:hover {
            border-color: var(--purple);
            background: rgba(138, 43, 226, 0.03);
        }

        .upload-title {
            font-size: 1rem;
            color: var(--dark-blue);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .upload-title i {
            color: var(--purple);
        }

        .upload-info {
            color: #666;
            font-size: 0.8rem;
            margin-bottom: 15px;
        }

        .file-input {
            display: none;
        }

        .upload-btn {
            background: linear-gradient(45deg, var(--purple), var(--light-purple));
            color: var(--white);
            border: none;
            padding: 8px 15px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.85rem;
            margin: 5px;
        }

        .upload-btn:hover {
            background: linear-gradient(45deg, var(--light-purple), var(--purple));
            box-shadow: 0 3px 8px rgba(138, 43, 226, 0.2);
        }

        .file-preview {
            margin-top: 10px;
            font-size: 0.8rem;
            color: #666;
        }

        .submit-btn {
            background: linear-gradient(45deg, var(--purple), var(--light-purple));
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            display: block;
            margin: 25px auto 0;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(138, 43, 226, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
        }

        .submit-btn:hover {
            background: linear-gradient(45deg, var(--light-purple), var(--purple));
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(138, 43, 226, 0.3);
        }

        .success-message, .error-message {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .success-message {
            background-color: var(--success);
            color: var(--white);
            display: none;
        }

        .error-message {
            background-color: #dc3545;
            color: var(--white);
            display: none;
        }

        .success-message i, .error-message i {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .success-message h2, .error-message h2 {
            margin-bottom: 8px;
            font-size: 1.3rem;
        }

        @media (max-width: 600px) {
            .report-card {
                padding: 25px 20px;
            }

            .card-title {
                font-size: 1.3rem;
            }

            .upload-row {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>
    <div class="container my-4">
        <div class="report-card">
            <h2 class="card-title"><i class="fas fa-flag"></i> समस्या रिपोर्ट गर्नुहोस्</h2>
            <?php if ($message): ?>
                <div class="success-message" id="successMessage" style="display: block;">
                    <i class="fas fa-check-circle"></i>
                    <h2>रिपोर्ट पेश गरियो!</h2>
                    <p><?php echo htmlspecialchars($message); ?></p>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="error-message" id="errorMessage" style="display: block;">
                    <i class="fas fa-exclamation-circle"></i>
                    <h2>त्रुटि!</h2>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            <form id="reportForm" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <div class="form-group">
                    <label class="form-label required" for="name">पूरा नाम</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="तपाईंको पूरा नाम" required>
                </div>
                <div class="form-group">
                    <label class="form-label required" for="email">इमेल ठेगाना</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="तपाईंको इमेल ठेगाना" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="address">ठेगाना</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="तपाईंको ठेगाना (वैकल्पिक)">
                </div>
                <div class="form-group">
                    <label class="form-label required" for="issue_type">समस्याको प्रकार</label>
                    <select id="issue_type" name="issue_type" class="form-control" required>
                        <option value="">समस्याको प्रकार छान्नुहोस्</option>
                        <option value="technical">प्राविधिक समस्या</option>
                        <option value="service">सेवा सम्बन्धी चासो</option>
                        <option value="feedback">प्रतिक्रिया/सुझाव</option>
                        <option value="safety">सुरक्षा चासो</option>
                        <option value="other">अन्य</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label required" for="description">विवरण</label>
                    <textarea id="description" name="description" class="form-control" placeholder="समस्याको विस्तृत विवरण..." required></textarea>
                </div>
                <h3 class="attachments-header">संलग्नकहरू (वैकल्पिक)</h3>
                <p class="attachments-subheader">तपाईंको समस्यालाई राम्रोसँग बुझ्न मद्दत गर्न समर्थन कागजात वा मिडिया संलग्न गर्न सक्नुहुन्छ।</p>
                <div class="upload-row">
                    <div class="upload-column">
                        <div class="upload-box">
                            <h4 class="upload-title"><i class="fas fa-file-pdf"></i> कागजातहरू अपलोड गर्नुहोस्</h4>
                            <p class="upload-info">PDF वा छवि ढाँचामा समर्थन कागजातहरू</p>
                            <div>
                                <input type="file" id="pdf_upload" name="pdf_upload" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                                <label for="pdf_upload" class="upload-btn">
                                    <i class="fas fa-upload"></i> PDF/छवि
                                </label>
                            </div>
                            <div class="file-preview" id="pdfPreview">कुनै फाइल चयन गरिएको छैन</div>
                        </div>
                    </div>
                    <div class="upload-column">
                        <div class="upload-box">
                            <h4 class="upload-title"><i class="fas fa-video"></i> भिडियो अपलोड गर्नुहोस्</h4>
                            <p class="upload-info">समस्यालाई प्रदर्शन गर्ने छोटो भिडियो</p>
                            <input type="file" id="video_upload" name="video_upload" class="file-input" accept="video/*">
                            <label for="video_upload" class="upload-btn">
                                <i class="fas fa-upload"></i> भिडियो
                            </label>
                            <div class="file-preview" id="videoPreview">कुनै फाइल चयन गरिएको छैन</div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit_report" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> रिपोर्ट पेश गर्नुहोस्
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // File upload preview
            document.getElementById('pdf_upload').addEventListener('change', function(e) {
                document.getElementById('pdfPreview').textContent = 
                    this.files.length ? this.files[0].name : 'कुनै फाइल चयन गरिएको छैन';
            });
            document.getElementById('video_upload').addEventListener('change', function(e) {
                document.getElementById('videoPreview').textContent = 
                    this.files.length ? this.files[0].name : 'कुनै फाइल चयन गरिएको छैन';
            });
            // Form submission
            document.getElementById('reportForm').addEventListener('submit', function(e) {
                // Prevent default form submission (handled by PHP)
                const successMessage = document.getElementById('successMessage');
                const errorMessage = document.getElementById('errorMessage');
                <?php if ($message): ?>
                    this.style.display = 'none';
                    successMessage.style.display = 'block';
                    setTimeout(() => {
                        this.reset();
                        document.getElementById('pdfPreview').textContent = 'कुनै फाइल चयन गरिएको छैन';
                        document.getElementById('videoPreview').textContent = 'कुनै फाइल चयन गरिएको छैन';
                        this.style.display = 'block';
                        successMessage.style.display = 'none';
                    }, 4000);
                <?php endif; ?>
                <?php if ($error): ?>
                    this.style.display = 'none';
                    errorMessage.style.display = 'block';
                    setTimeout(() => {
                        this.style.display = 'block';
                        errorMessage.style.display = 'none';
                    }, 4000);
                <?php endif; ?>
            });
        });
    </script>
</body>
</html>