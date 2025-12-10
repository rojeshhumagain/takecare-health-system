<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Footer Styles */
        .site-footer {
            background: linear-gradient(135deg, #2b2d42 0%, #1a1b2e 100%);
            color: #ffffff;
            padding: 60px 0 20px;
            margin-top: 50px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, 'Noto Sans Devanagari';
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 40px;
        }

        .footer-section h3 {
            color: #ffffff;
            font-size: 1.4rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #8e1c1c, #ff6b6b);
            border-radius: 2px;
        }

        .footer-section.about p {
            line-height: 1.6;
            color: #b8b9c7;
            font-size: 1rem;
        }

        .footer-section.quick-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section.quick-links li {
            margin-bottom: 12px;
        }

        .footer-section.quick-links a {
            color: #b8b9c7;
            text-decoration: none;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            padding-left: 15px;
        }

        .footer-section.quick-links a::before {
            content: '▶';
            position: absolute;
            left: 0;
            color: #8e1c1c;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .footer-section.quick-links a:hover {
            color: #ffffff;
            padding-left: 20px;
        }

        .footer-section.quick-links a:hover::before {
            color: #ff6b6b;
        }

        .footer-section.contact-info p {
            color: #b8b9c7;
            margin-bottom: 15px;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .footer-section.contact-info i {
            color: #8e1c1c;
            margin-right: 12px;
            width: 20px;
            font-size: 1.1rem;
        }

        .footer-section.social .social-links {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer-section.social .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.05);
            color: #ffffff;
            text-decoration: none;
            border-radius: 50%;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-section.social .social-links a:hover {
            background: #8e1c1c;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(142, 28, 28, 0.3);
        }

        .footer-section.social .social-links a i {
            font-size: 1.2rem;
        }

        .footer-bottom {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .footer-bottom p {
            color: #b8b9c7;
            margin: 0;
            font-size: 0.95rem;
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            .footer-container {
                grid-template-columns: 1fr;
                gap: 30px;
                padding: 0 15px;
                text-align: center;
            }

            .site-footer {
                padding: 50px 0;
            }

            .footer-section h3 {
                font-size: 1.2rem;
                margin-bottom: 15px;
            }

            .footer-section.about p,
            .footer-section.quick-links a,
            .footer-section.contact-info p {
                font-size: 1rem;
                text-align: center; /* Centering contact info text */
            }

            .footer-section.social .social-links {
                justify-content: center;
            }

            .footer-section.social .social-links a {
                width: 40px;
                height: 40px;
            }

            .footer-section.social .social-links a i {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .site-footer {
                padding: 30px 0;
            }

            .footer-container {
                padding: 0 10px;
                gap: 20px;
            }

            .footer-section h3 {
                font-size: 1.1rem;
                margin-bottom: 12px;
            }

            .footer-section.about p,
            .footer-section.quick-links a,
            .footer-section.contact-info p {
                font-size: 0.95rem;
                text-align: center; /* Ensure content is centered */
            }

            .footer-bottom {
                margin-top: 30px;
                padding-top: 20px;
            }

            .footer-bottom p {
                font-size: 0.85rem;
            }

            .footer-section.quick-links a {
                font-size: 0.9rem;
            }

            .footer-section.social .social-links {
                justify-content: center;
            }

            .footer-section.social .social-links a {
                width: 35px;
                height: 35px;
            }

            .footer-section.social .social-links a i {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-section about">
                <h3>About takecare.com</h3>
                <p>Your trusted partner for health and wellness. We provide comprehensive care solutions tailored to your needs.</p>
            </div>
            <div class="footer-section quick-links">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section contact-info">
                <h3>Contact Info</h3>
                <p><i class="fas fa-map-marker-alt"></i> 123 Health St, Wellness City</p>
                <p><i class="fas fa-phone"></i> +1 234 567 8900</p>
                <p><i class="fas fa-envelope"></i> info@takecare.com</p>
            </div>
            <div class="footer-section social">
                <h3>Follow Us</h3>
                <div class="social-links">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> takecare.com. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>