<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Healthcare Fundraising - Takecare.com</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
  <style>
    :root {
      --dark-blue: #1A2B40;
      --purple: #8A2BE2;
      --white: #FFFFFF;
      --light-gray: #F0F0F0;
      --text-color: #333333;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--light-gray);
      color: var(--text-color);
    }

    /* Fundraising Page Styles */
    .fundraising-container {
      max-width: 1200px;
      margin: 2rem auto;
      padding: 0 1rem;
    }

    .page-header {
      text-align: center;
      margin-bottom: 2rem;
    }

    .page-header h1 {
      color: var(--dark-blue);
      font-size: 2.2rem;
      margin-bottom: 0.5rem;
    }

    .page-header p {
      color: var(--text-color);
      font-size: 1.1rem;
      max-width: 800px;
      margin: 0 auto;
    }

    /* Campaign Cards */
    .campaigns-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.5rem;
      margin-bottom: 3rem;
    }

    .campaign-card {
      background-color: var(--white);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      display: flex;
      flex-direction: column;
    }

    .campaign-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .campaign-image {
      width: 100%;
      height: 160px;
      object-fit: cover;
    }

    .campaign-content {
      padding: 1.2rem;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .campaign-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 0.5rem;
    }

    .campaign-title {
      font-size: 1.2rem;
      margin: 0;
      color: var(--dark-blue);
      font-weight: 600;
    }

    .campaign-urgent {
      background-color: #F44336;
      color: var(--white);
      padding: 0.2rem 0.6rem;
      border-radius: 12px;
      font-size: 0.7rem;
      font-weight: 500;
    }

    .campaign-description {
      color: var(--text-color);
      font-size: 0.9rem;
      margin-bottom: 1rem;
      line-height: 1.4;
      flex-grow: 1;
    }

    .patient-info {
      margin-bottom: 1rem;
    }

    .patient-info p {
      margin: 0.3rem 0;
      font-size: 0.9rem;
      color: var(--text-color);
    }

    .patient-info .amount-required {
      font-weight: 600;
      color: var(--purple);
    }

    .qr-code {
      width: 100px;
      height: 100px;
      margin: 0.5rem auto;
      display: block;
    }

    /* Transparency Section */
    .transparency-section {
      background-color: var(--white);
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      margin: 3rem auto;
      max-width: 1000px;
    }

    .transparency-section h2 {
      text-align: center;
      color: var(--dark-blue);
      margin-bottom: 1.5rem;
      font-size: 1.6rem;
    }

    .transparency-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
    }

    .transparency-item {
      text-align: center;
      padding: 1rem;
    }

    .transparency-icon {
      font-size: 2rem;
      color: var(--purple);
      margin-bottom: 0.8rem;
    }

    .transparency-item h3 {
      color: var(--dark-blue);
      margin-bottom: 0.5rem;
      font-size: 1.1rem;
    }

    .transparency-item p {
      color: var(--text-color);
      line-height: 1.5;
      font-size: 0.9rem;
      margin: 0;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .campaigns-grid {
        grid-template-columns: 1fr;
      }

      .page-header h1 {
        font-size: 1.8rem;
      }

      .transparency-grid {
        grid-template-columns: 1fr;
        gap: 1.5rem;
      }

      .qr-code {
        width: 80px;
        height: 80px;
      }
    }

    @media (max-width: 480px) {
      .campaign-image {
        height: 140px;
      }

      .campaign-title {
        font-size: 1.1rem;
      }

      .campaign-description {
        font-size: 0.85rem;
      }

      .patient-info p {
        font-size: 0.85rem;
      }

      .qr-code {
        width: 70px;
        height: 70px;
      }
    }
  </style>
</head>
<body>
  <!-- Header will be included via PHP -->
  <?php include 'header1.php'; ?>

  <div class="fundraising-container">
    <div class="page-header">
      <h1>Support Healthcare Causes</h1>
      <p>Your support can transform lives by helping individuals access critical medical care. Connect directly with patients to make a meaningful impact.</p>
    </div>

    <div class="campaigns-grid">
      <!-- Campaign 1 -->
      <div class="campaign-card">
        <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Cancer Treatment" class="campaign-image">
        <div class="campaign-content">
          <div class="campaign-header">
            <h3 class="campaign-title">Cancer Treatment Fund</h3>
            <span class="campaign-urgent">Urgent</span>
          </div>
          <p class="campaign-description">Ramesh Shrestha is battling cancer and requires urgent chemotherapy. Your support can help him access life-saving treatment.</p>
          <div class="patient-info">
            <p><strong>Patient:</strong> Ramesh Shrestha</p>
            <p><strong>Contact:</strong> +977-9841234567</p>
            <p class="amount-required">Amount Required: Rs. 500,000</p>
          </div>
          <img src="assets/qr.jpeg" alt="QR Code for Donation" class="qr-code">
        </div>
      </div>

      <!-- Campaign 2 -->
      <div class="campaign-card">
        <img src="https://images.unsplash.com/photo-1581056771107-24ca5f033842?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Community Ambulance" class="campaign-image">
        <div class="campaign-content">
          <div class="campaign-header">
            <h3 class="campaign-title">Community Ambulance Service</h3>
          </div>
          <p class="campaign-description">Sita Tamang needs funds to maintain an ambulance service for her rural community, ensuring timely emergency care.</p>
          <div class="patient-info">
            <p><strong>Patient:</strong> Sita Tamang</p>
            <p><strong>Contact:</strong> +977-9851234567</p>
            <p class="amount-required">Amount Required: Rs. 500,000</p>
          </div>
          <img src="https://via.placeholder.com/100?text=QR+Code" alt="QR Code for Donation" class="qr-code">
        </div>
      </div>

      <!-- Campaign 3 -->
      <div class="campaign-card">
        <img src="https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Mental Health" class="campaign-image">
        <div class="campaign-content">
          <div class="campaign-header">
            <h3 class="campaign-title">Mental Health Awareness</h3>
          </div>
          <p class="campaign-description">Hari Bahadur struggles with mental health issues and needs counseling support. Your help can provide him with essential care.</p>
          <div class="patient-info">
            <p><strong>Patient:</strong> Hari Bahadur</p>
            <p><strong>Contact:</strong> +977-9861234567</p>
            <p class="amount-required">Amount Required: Rs. 200,000</p>
          </div>
          <img src="https://via.placeholder.com/100?text=QR+Code" alt="QR Code for Donation" class="qr-code">
        </div>
      </div>

      <!-- Campaign 4 -->
      <div class="campaign-card">
        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Kidney Treatment" class="campaign-image">
        <div class="campaign-content">
          <div class="campaign-header">
            <h3 class="campaign-title">Kidney Treatment Fund</h3>
            <span class="campaign-urgent">Urgent</span>
          </div>
          <p class="campaign-description">Laxmi Gurung requires dialysis for kidney failure. Your contribution can help her afford this critical treatment.</p>
          <div class="patient-info">
            <p><strong>Patient:</strong> Laxmi Gurung</p>
            <p><strong>Contact:</strong> +977-9871234567</p>
            <p class="amount-required">Amount Required: Rs. 500,000</p>
          </div>
          <img src="https://via.placeholder.com/100?text=QR+Code" alt="QR Code for Donation" class="qr-code">
        </div>
      </div>

      <!-- Campaign 5 -->
      <div class="campaign-card">
        <img src="https://images.unsplash.com/photo-1530026186672-2cd00ffc50fe?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Disaster Relief" class="campaign-image">
        <div class="campaign-content">
          <div class="campaign-header">
            <h3 class="campaign-title">Disaster Medical Relief</h3>
            <span class="campaign-urgent">Urgent</span>
          </div>
          <p class="campaign-description">Bimala Nepal needs urgent medical supplies after a natural disaster. Your support can provide her with essential care.</p>
          <div class="patient-info">
            <p><strong>Patient:</strong> Bimala Nepal</p>
            <p><strong>Contact:</strong> +977-9881234567</p>
            <p class="amount-required">Amount Required: Rs. 500,000</p>
          </div>
          <img src="https://via.placeholder.com/100?text=QR+Code" alt="QR Code for Donation" class="qr-code">
        </div>
      </div>

      <!-- Campaign 6 -->
      <div class="campaign-card">
        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Rural Hospital" class="campaign-image">
        <div class="campaign-content">
          <div class="campaign-header">
            <h3 class="campaign-title">Rural Hospital Development</h3>
          </div>
          <p class="campaign-description">Gopal Thapa is leading efforts to build a hospital in his remote village. Your support can improve healthcare access for many.</p>
          <div class="patient-info">
            <p><strong>Patient:</strong> Gopal Thapa</p>
            <p><strong>Contact:</strong> +977-9891234567</p>
            <p class="amount-required">Amount Required: Rs. 5,000,000</p>
          </div>
          <img src="https://via.placeholder.com/100?text=QR+Code" alt="QR Code for Donation" class="qr-code">
        </div>
      </div>
    </div>

    <!-- Transparency Section -->
    <div class="transparency-section">
      <h2>Our Commitment to Transparency</h2>
      <div class="transparency-grid">
        <div class="transparency-item">
          <div class="transparency-icon"><i class="fas fa-hand-holding-heart"></i></div>
          <h3>Direct Support</h3>
          <p>Your contributions go directly to patients through verified channels, ensuring maximum impact.</p>
        </div>
        <div class="transparency-item">
          <div class="transparency-icon"><i class="fas fa-file-invoice"></i></div>
          <h3>Patient Stories</h3>
          <p>We share detailed stories and updates about the individuals you help, fostering trust and connection.</p>
        </div>
        <div class="transparency-item">
          <div class="transparency-icon"><i class="fas fa-shield-alt"></i></div>
          <h3>Verified Cases</h3>
          <p>Each patient's case is thoroughly vetted to ensure authenticity and need.</p>
        </div>
        <div class="transparency-item">
          <div class="transparency-icon"><i class="fas fa-certificate"></i></div>
          <h3>Transparent Process</h3>
          <p>We provide clear information on how to support patients directly, with no intermediaries.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>