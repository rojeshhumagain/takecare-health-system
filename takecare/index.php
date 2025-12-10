<?php
include 'header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Banner</title>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <style>
      
        :root {
            --mb-bg-color: #f9fafb;
            --mb-text-color: #2b2d42;
            --mb-card-bg: #ffffff;
            --mb-card-text: #5c5d75;
            --mb-accent-color: #8e1c1c;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif, 'Noto Sans Devanagari';
            margin: 0;
            padding: 0;
        }

        .mb-container {
            max-width: 1200px;
            margin: 30px auto;
            position: relative;
        }

        
        .mb-slider {
            display: flex;
            overflow-x: hidden; 
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            padding-bottom: 20px;
        }

        .mb-slider::-webkit-scrollbar {
            display: none;
        }

        .mb-slide {
            flex: 0 0 100%;
            height: 600px;
            scroll-snap-align: start;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mb-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .mb-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 2rem;
            border: none;
            cursor: pointer;
            padding: 10px;
            z-index: 10;
        }

        .mb-nav.left {
            left: 10px;
        }

        .mb-nav.right {
            right: 10px;
        }

     
        @keyframes hp-unique-fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .mb-slide:nth-child(1) { animation: hp-unique-fadeInUp 0.5s ease-out forwards; animation-delay: 0.1s; }
        .mb-slide:nth-child(2) { animation: hp-unique-fadeInUp 0.5s ease-out forwards; animation-delay: 0.2s; }
        .mb-slide:nth-child(3) { animation: hp-unique-fadeInUp 0.5s ease-out forwards; animation-delay: 0.3s; }
        .mb-slide:nth-child(4) { animation: hp-unique-fadeInUp 0.5s ease-out forwards; animation-delay: 0.4s; }
        .mb-slide:nth-child(5) { animation: hp-unique-fadeInUp 0.5s ease-out forwards; animation-delay: 0.5s; }
        .mb-slide:nth-child(6) { animation: hp-unique-fadeInUp 0.5s ease-out forwards; animation-delay: 0.6s; }

       
        @media (max-width: 1024px) {
            .mb-slide {
                height: 480px;
            }
        }

        @media (max-width: 767px) {
            .mb-slide {
                height: 360px;
            }
        }
    </style>
</head>
<body>
    <?php
   
    $banner_id = 'main-banner-' . uniqid();
    ?>

    <div class="mb-banner" id="<?php echo $banner_id; ?>">
        <div class="mb-container">
            <div class="mb-slider" id="<?php echo $banner_id; ?>-slider">
                <div class="mb-slide mb-slide-1">
                    <img src="assets/banner1.png"  alt=" Banner1">
                </div>
                <div class="mb-slide mb-slide-2">
                    <img src="assets/healthmedical.png"  alt=" Banner2">
                </div>
                <div class="mb-slide mb-slide-3">
                    <img src="assets/medical.png" alt=" Banner3">
                </div>
                <div class="mb-slide mb-slide-4">
                    <img src="assets/service.png" alt="Banner4">
                </div>
                
            </div>
            <button class="mb-nav left" onclick="scrollByBannerSlide(-1, '<?php echo $banner_id; ?>')"><i class="fas fa-chevron-left"></i></button>
            <button class="mb-nav right" onclick="scrollByBannerSlide(1, '<?php echo $banner_id; ?>')"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
     
<?php
include 'service1.php';
?>

<?php
include './pages/blog1.php ';
?>

<?php
include './pages/fund.php';
?>


    <?php
include 'footer.php';
?>
    <script>
       
        function scrollByBannerSlide(direction, bannerId) {
            const slider = document.getElementById(bannerId + '-slider');
            const slides = slider.querySelectorAll('.mb-slide');
            if (!slides.length) return;
            const slideWidth = slides[0].offsetWidth;
            const maxScrollLeft = slider.scrollWidth - slider.clientWidth;

            let newScrollLeft = slider.scrollLeft + direction * slideWidth;

            if (newScrollLeft >= maxScrollLeft) {
               
                slider.scrollTo({ left: 0, behavior: 'smooth' });
            } else if (newScrollLeft <= 0 && direction < 0) {
              
                slider.scrollTo({ left: maxScrollLeft, behavior: 'smooth' });
            } else {
               
                slider.scrollBy({ left: direction * slideWidth, behavior: 'smooth' });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
       
            let autoScrollInterval = setInterval(() => {
                const slider = document.getElementById('<?php echo $banner_id; ?>-slider');
                const slides = slider.querySelectorAll('.mb-slide');
                if (!slides.length) return;
                const slideWidth = slides[0].offsetWidth;
                const maxScrollLeft = slider.scrollWidth - slider.clientWidth;

                if (slider.scrollLeft >= maxScrollLeft) {
                  
                    slider.scrollTo({ left: 0, behavior: 'smooth' });
                } else {
                 
                    slider.scrollBy({ left: slideWidth, behavior: 'smooth' });
                }
            }, 9000);


            const slider = document.getElementById('<?php echo $banner_id; ?>-slider');
            slider.addEventListener('mouseenter', () => clearInterval(autoScrollInterval));
            slider.addEventListener('mouseleave', () => {
                autoScrollInterval = setInterval(() => {
                    const slides = slider.querySelectorAll('.mb-slide');
                    if (!slides.length) return;
                    const slideWidth = slides[0].offsetWidth;
                    const maxScrollLeft = slider.scrollWidth - slider.clientWidth;

                    if (slider.scrollLeft >= maxScrollLeft) {
                      
                        slider.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                       
                        slider.scrollBy({ left: slideWidth, behavior: 'smooth' });
                    }
                }, 5000);
            });
        });
    </script>
</body>
</html>