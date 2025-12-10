<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Initialize CSRF token if not set
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "अमान्य CSRF टोकन।";
    } else {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message_text = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

        if (!$name || !$email || !$message_text) {
            $error = "सबै क्षेत्रहरू आवश्यक छन्।";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "अमान्य इमेल ढाँचा।";
        } else {
            try {
                $stmt = $conn->prepare("INSERT INTO contacts (name, email, message, status) VALUES (:name, :email, :message, 'pending')");
                $stmt->execute([
                    'name' => $name,
                    'email' => $email,
                    'message' => $message_text
                ]);
                $message = "तपाईंको सन्देशको लागि धन्यवाद! हामी चाँडै तपाईंसँग सम्पर्क गर्नेछौं।";
                // Regenerate CSRF token after successful submission
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            } catch (PDOException $e) {
                $error = "सन्देश पठाउन असफल: " . $e->getMessage();
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
    <title>सम्पर्क गर्नुहोस् - Takecare.com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
        :root {
            --dark-blue: #1A2B40;
            --purple: #8A2BE2;
            --accent: #e24e1b;
            --white: #FFFFFF;
            --light-gray: #F0F0F0;
            --text-color: #333333;
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .contact-hero {
            background: linear-gradient(135deg, var(--purple), var(--dark-blue));
            color: var(--white);
            border-radius: 10px;
            text-align: center;
        }

        .contact-form-section, .contact-info-section, .map-section {
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .submit-btn {
            background: linear-gradient(45deg, var(--purple), #A020F0);
            border: none;
            border-radius: 25px;
            transition: background 0.3s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(45deg, #A020F0, var(--purple));
        }

        .contact-item i {
            color: var(--accent);
        }

        .contact-item a {
            color: var(--text-color);
            text-decoration: none;
        }

        .contact-item a:hover {
            color: var(--purple);
        }

        .map-container {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: 10px;
        }

        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include 'header1.php'; ?>

    <main class="container my-4">
        <section class="contact-hero p-4 mb-4">
            <h1 class="display-4">हामीलाई सम्पर्क गर्नुहोस्</h1>
            <p class="lead">हामी तपाईंलाई गुणस्तरीय स्वास्थ्य सेवामा पहुँच दिलाउन सघाउ गर्न तयार छौं। कुनै पनि जिज्ञासा वा प्रतिक्रिया छ भने सम्पर्क गर्नुहोस्।</p>
        </section>

        <section class="contact-form-section p-4 mb-4">
            <h2 class="h3 mb-4 text-purple">हामीलाई सन्देश पठाउनुहोस्</h2>
            <?php if ($message): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <form class="row g-3" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                <div class="col-md-6">
                    <label for="name" class="form-label">नाम</label>
                    <input type="text" class="form-control" id="name" name="name" required aria-label="तपाईंको नाम">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">इमेल</label>
                    <input type="email" class="form-control" id="email" name="email" required aria-label="तपाईंको इमेल">
                </div>
                <div class="col-12">
                    <label for="message" class="form-label">सन्देश</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required aria-label="तपाईंको सन्देश"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn submit-btn">पठाउनुहोस्</button>
                </div>
            </form>
        </section>

        <section class="contact-info-section p-4 mb-4">
            <h2 class="h3 mb-4 text-purple">हाम्रो सम्पर्क जानकारी</h2>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-map-marker-alt fa-2x me-3"></i>
                        <div>
                            <h3 class="h5">ठेगाना</h3>
                            <p>काठमाडौं, नेपाल</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-phone-alt fa-2x me-3"></i>
                        <div>
                            <h3 class="h5">फोन</h3>
                            <p><a href="tel:+97714456789">+९७७-१-४४५६७८९</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-envelope fa-2x me-3"></i>
                        <div>
                            <h3 class="h5">इमेल</h3>
                            <p><a href="mailto:info@takecare.com">info@takecare.com</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock fa-2x me-3"></i>
                        <div>
                            <h3 class="h5">समय</h3>
                            <p>२४/७ आपतकालीन सेवा</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="map-section p-4">
            <h2 class="h3 mb-4 text-purple">हामीलाई खोज्नुहोस्</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.418445839273!2d85.31914731506247!3d27.71724598278114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb190a64d1b08f%3A0x7a5b0b6a60a4867f!2sKathmandu%2C%20Nepal!5e0!3m2!1sen!2snp!4v1698765432109!5m2!1sen!2snp" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>