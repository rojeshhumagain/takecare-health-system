<?php
header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title data-translate="about-title">About Us - Takecare.com</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
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
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light-gray);
      color: var(--text-color);
      padding-bottom: 70px; 
    }

    .main-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 1.5rem;
    }

    .about-hero {
      background: linear-gradient(135deg, var(--purple), var(--dark-blue));
      color: var(--white);
      padding: 2rem 1.5rem;
      border-radius: 10px;
      margin-bottom: 2rem;
      text-align: center;
    }

    .about-hero h1 {
      font-size: 2.2rem;
      margin-bottom: 1rem;
    }

    .about-hero p {
      font-size: 1.1rem;
      max-width: 800px;
      margin: 0 auto 1.5rem;
      line-height: 1.6;
    }

    .card-container {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
      margin-bottom: 2rem;
    }

    .card {
      background: var(--white);
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h2 {
      color: var(--purple);
      margin-top: 0;
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }

    .card h2 i {
      color: var(--accent);
    }

    .team-section {
      margin-bottom: 2rem;
    }

    .team-section h2 {
      text-align: center;
      color: var(--purple);
      margin-bottom: 1.5rem;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 1.5rem;
    }

    .team-member {
      background: var(--white);
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .team-member img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .team-member-info {
      padding: 1.2rem;
    }

    .team-member h3 {
      margin: 0.5rem 0;
      color: var(--purple);
    }

    .team-member p {
      color: var(--text-color);
      margin: 0.3rem 0;
      font-size: 0.9rem;
    }

    .stats-section {
      background: linear-gradient(135deg, var(--purple), var(--dark-blue));
      color: var(--white);
      padding: 2rem;
      border-radius: 10px;
      margin-bottom: 2rem;
      text-align: center;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1.5rem;
    }

    .stat-item {
      padding: 1rem;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: bold;
      margin-bottom: 0.5rem;
      color: var(--accent);
    }

    .stat-label {
      font-size: 1rem;
    }

    .contact-section {
      background: var(--white);
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .contact-section h2 {
      color: var(--purple);
      margin-top: 0;
    }

    .contact-info {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1rem;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
    }

    .contact-item i {
      font-size: 1.5rem;
      color: var(--accent);
      width: 40px;
      text-align: center;
    }

    .contact-item a {
      color: var(--text-color);
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .contact-item a:hover {
      color: var(--purple);
    }

    .sr-only {
      position: absolute;
      width: 1px;
      height: 1px;
      padding: 0;
      margin: -1px;
      overflow: hidden;
      clip: rect(0, 0, 0, 0);
      white-space: nowrap;
      border-width: 0;
    }

    @media (min-width: 600px) {
      .stats-grid {
        grid-template-columns: repeat(4, 1fr);
      }

      .contact-info {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media (min-width: 768px) {
      .card-container {
        grid-template-columns: 1fr 1fr;
      }

      .main-content {
        padding: 2rem;
      }

      .about-hero h1 {
        font-size: 2.5rem;
      }

      .about-hero p {
        font-size: 1.2rem;
      }
    }

    @media (max-width: 768px) {
      .about-hero h1 {
        font-size: 1.8rem;
      }

      .about-hero p {
        font-size: 1rem;
      }

      .card {
        padding: 1.2rem;
      }

      .team-grid {
        grid-template-columns: 1fr;
      }

      .stats-section {
        padding: 1.5rem 1rem;
      }

      .stat-number {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <?php include 'header1.php'; ?>

  <main class="main-content">
    <section class="about-hero">
      <h1 data-translate="about-title">About Takecare.com</h1>
      <p data-translate="about-hero-text">Connecting rural Nepal with quality healthcare through innovative technology and compassionate service.</p>
    </section>

    <div class="card-container">
      <div class="card">
        <h2><i class="fas fa-bullseye"></i> <span data-translate="mission-title">Our Mission</span></h2>
        <p data-translate="mission-text">To bridge the healthcare gap in rural Nepal by providing accessible, affordable, and quality medical services through digital innovation and community partnerships.</p>
      </div>
      <div class="card">
        <h2><i class="fas fa-eye"></i> <span data-translate="vision-title">Our Vision</span></h2>
        <p data-translate="vision-text">A Nepal where every individual, regardless of location or economic status, has access to timely healthcare services and health education.</p>
      </div>
    </div>

    <section class="team-section">
      <h2 data-translate="team-title">Meet Our Team</h2>
      <div class="team-grid">
        <div class="team-member">
          <img src="assets/arjun 3.jpg" alt="Dr. Arjun Thapa">
          <div class="team-member-info">
            <h3 data-translate-name="team-name1">Dr. Arjun Thapa</h3>
            <p data-translate="team-role1">Medical Director</p>
            <p data-translate="team-bio1">5 years experience in rural healthcare</p>
          </div>
        </div>
        <div class="team-member">
          <img src="assets/rojesh.jpg" alt="Rojesh Humagain">
          <div class="team-member-info">
            <h3 data-translate-name="team-name2">Rojesh Humagain</h3>
            <p data-translate="team-role2">Developer</p>
            <p data-translate="team-bio2"></p>
          </div>
        </div>
        <div class="team-member">
          <img src="assets/sujan.jpg" alt="Sujan Basnet">
          <div class="team-member-info">
            <h3 data-translate-name="team-name3">Sujan Basnet</h3>
            <p data-translate="team-role3">Developer</p>
            <p data-translate="team-bio3">Connecting with rural communities</p>
          </div>
        </div>
        <div class="team-member">
          <img src="assets/utsab.jpg" alt="Utsab Chaudhary">
          <div class="team-member-info">
            <h3 data-translate-name="team-name4">Utsab Chaudhary</h3>
            <p data-translate="team-role4">Developer</p>
            <p data-translate="team-bio4"></p>
          </div>
        </div>
      </div>
    </section>

    <section class="contact-section">
      <h2 data-translate="contact-title">Contact Us</h2>
      <div class="contact-info">
        <div class="contact-item">
          <i class="fas fa-map-marker-alt"></i>
          <div>
            <h3 data-translate="contact-address">Address</h3>
            <p data-translate="contact-address-text">Kathmandu, Nepal</p>
          </div>
        </div>
        <div class="contact-item">
          <i class="fas fa-phone-alt"></i>
          <div>
            <h3 data-translate="contact-phone">Phone</h3>
            <p><a href="tel:+97714456789">+977-1-4456789</a></p>
          </div>
        </div>
        <div class="contact-item">
          <i class="fas fa-envelope"></i>
          <div>
            <h3 data-translate="contact-email">Email</h3>
            <p><a href="mailto:info@takecare.com">info@takecare.com</a></p>
          </div>
        </div>
        <div class="contact-item">
          <i class="fas fa-clock"></i>
          <div>
            <h3 data-translate="contact-hours">Hours</h3>
            <p data-translate="hours-text">24/7 Emergency Support</p>
          </div>
        </div>
      </div>
    </section>
  </main>
<?php include 'footer.php'; ?>
  <script >
document.addEventListener("DOMContentLoaded", () => {
  const languageSelect = document.getElementById("language-select") || { value: 'en' };

  const translations = {
    en: {
      'about-title': 'About Us - Takecare.com',
      'about-hero-text': 'Connecting rural Nepal with quality healthcare through innovative technology and compassionate service.',
      'mission-title': 'Our Mission',
      'mission-text': 'To bridge the healthcare gap in rural Nepal by providing accessible, affordable, and quality medical services through digital innovation and community partnerships.',
      'vision-title': 'Our Vision',
      'vision-text': 'A Nepal where every individual, regardless of location or economic status, has access to timely healthcare services and health education.',
      'team-title': 'Meet Our Team',
      'team-name1': 'Dr. Arjun Thapa',
      'team-role1': 'Medical Director',
      'team-bio1': '5 years experience in rural healthcare',
      'team-name2': 'Rojesh Humagain',
      'team-role2': 'Technology Lead',
      'team-bio2': 'Building solutions for remote areas',
      'team-name3': 'Sujan Basnet',
      'team-role3': 'Community Coordinator',
      'team-bio3': 'Connecting with rural communities',
      'team-name4': 'Utsab Chaudhary',
      'team-role4': 'Field Operations',
      'team-bio4': 'Organizing health camps and transport',
      'stats-title': 'Our Impact',
      'stat-patients': 'Patients Served',
      'stat-camps': 'Health Camps',
      'stat-districts': 'Districts Covered',
      'stat-partners': 'Healthcare Partners',
      'contact-title': 'Contact Us',
      'contact-address': 'Address',
      'contact-address-text': 'Kathmandu, Nepal',
      'contact-phone': 'Phone',
      'contact-email': 'Email',
      'contact-hours': 'Hours',
      'hours-text': '24/7 Emergency Support'
    },
    np: {
      'about-title': 'हाम्रो बारेमा - Takecare.com',
      'about-hero-text': 'नवीन प्रविधि र दयालु सेवामार्फत ग्रामीण नेपाललाई गुणस्तरीय स्वास्थ्य सेवासँग जोड्दै।',
      'mission-title': 'हाम्रो मिशन',
      'mission-text': 'डिजिटल नवाचार र सामुदायिक साझेदारीमार्फत ग्रामीण नेपालमा स्वास्थ्य सेवा अन्तरलाई कम गर्न, सुलभ, किफायती र गुणस्तरीय चिकित्सा सेवाहरू प्रदान गर्ने।',
      'vision-title': 'हाम्रो दृष्टिकोण',
      'vision-text': 'नेपाल जहाँ प्रत्येक व्यक्तिलाई, स्थान वा आर्थिक अवस्थाको बावजुद, समयमै स्वास्थ्य सेवा र स्वास्थ्य शिक्षाको पहुँच होस्।',
      'team-title': 'हाम्रो टोलीसँग भेट्नुहोस्',
      'team-name1': 'डा. अर्जुन थापा',
      'team-role1': 'मेडिकल डाइरेक्टर',
      'team-bio1': 'ग्रामीण स्वास्थ्य सेवामा ५ वर्षको अनुभव',
      'team-name2': 'रोजेश हुमागाईं',
      'team-role2': 'प्रविधि नेतृत्व',
      'team-bio2': 'दूरदराजका क्षेत्रहरूका लागि समाधानहरू निर्माण गर्दै',
      'team-name3': 'सुजन बस्नेत',
      'team-role3': 'सामुदायिक संयोजक',
      'team-bio3': 'ग्रामीण समुदायहरूसँग जोड्दै',
      'team-name4': 'उत्सव चौधरी',
      'team-role4': 'फिल्ड अपरेशन्स',
      'team-bio4': 'स्वास्थ्य शिविर र यातायातको आयोजन',
      'stats-title': 'हाम्रो प्रभाव',
      'stat-patients': 'बिरामीहरूलाई सेवा प्रदान',
      'stat-camps': 'स्वास्थ्य शिविरहरू',
      'stat-districts': 'कभर गरिएका जिल्लाहरू',
      'stat-partners': 'स्वास्थ्य साझेदारहरू',
      'contact-title': 'हामीलाई सम्पर्क गर्नुहोस्',
      'contact-address': 'ठेगाना',
      'contact-address-text': 'काठमाडौं, नेपाल',
      'contact-phone': 'फोन',
      'contact-email': 'इमेल',
      'contact-hours': 'समय',
      'hours-text': '२४/७ आपतकालीन समर्थन'
    }
  };

  const updateLanguage = (lang) => {
    document.querySelectorAll('[data-translate]').forEach(el => {
      const key = el.getAttribute('data-translate');
      if (translations[lang][key]) {
        el.textContent = translations[lang][key];
      }
    });

    document.querySelectorAll('[data-translate-name]').forEach(el => {
      const key = el.getAttribute('data-translate-name');
      el.textContent = translations[lang][key];
    });

    document.title = translations[lang]['about-title'];
  };

  const savedLang = localStorage.getItem('language') || 'en';
  languageSelect.value = savedLang;
  updateLanguage(savedLang);

  languageSelect.addEventListener("change", function () {
    localStorage.setItem('language', this.value);
    updateLanguage(this.value);
  });
});


  </script>
</body>
</html>