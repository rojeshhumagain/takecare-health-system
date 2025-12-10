<?php
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title data-translate="page-title">Government Hospitals in Nepal</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --dark-blue: #1A2B40;
            --purple: #8A2BE2;
            --white: #FFFFFF;
            --light-gray: #F0F0F0;
            --text-color: #333333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: var(--light-gray);
            
        }

        .hospital-section {
            margin: 40px 20px;
        }

        .hospital-section h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            color: #764ba2;
            margin-bottom: 40px;
            text-align: center;
        }

        .filter-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 2rem;
        }

        .filter-row {
            display: flex;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 1;
            min-width: 250px;
            margin-bottom: 1rem;
        }

        .form-group label {
            font-weight: 500;
            font-size: 1rem;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-group select {
            width: 100%;
            padding: 0.75rem 1.25rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            background-color: var(--white);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            outline: none;
            cursor: pointer;
            transition: box-shadow 0.3s ease;
        }

        .form-group select:focus {
            box-shadow: 0 2px 8px rgba(138, 43, 226, 0.5);
        }

        .hospital-container {
            max-width: 1400px;
            margin: auto;
            position: relative;
        }

        .hospital-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
            padding: 0 20px;
        }

        .hospital-slider {
            display: flex;
            gap: 25px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            padding-bottom: 30px;
            display: none;
        }

        .hospital-slider::-webkit-scrollbar {
            display: none;
        }

        .hospital-card {
            scroll-snap-align: start;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            height: 380px;
            padding: 15px;
            position: relative;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .hospital-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .hospital-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            transition: transform 0.8s ease;
        }

        .hospital-card:hover img {
            transform: scale(1.05);
        }

        .hospital-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 700;
            color: #2b2d42;
            text-align: center;
            margin: 10px 0;
        }

        .hospital-location {
            font-size: 0.9rem;
            color: #5c5d75;
            text-align: center;
            margin: 0 0 10px;
            flex-grow: 1;
        }

        .hospital-view-btn {
            background: linear-gradient(45deg, #8A2BE2, #A020F0);
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .hospital-view-btn:hover {
            background: linear-gradient(45deg, #A020F0, #8A2BE2);
            transform: scale(1.05);
        }

        .hospital-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.3);
            color: white;
            font-size: 2rem;
            border: none;
            cursor: pointer;
            padding: 10px 15px;
            z-index: 10;
            display: none;
        }

        .hospital-nav.left {
            left: 0;
        }

        .hospital-nav.right {
            right: 0;
        }

        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            transition: opacity 0.3s ease;
        }

        .popup.show {
            display: flex;
            opacity: 1;
        }

        .popup-content {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 700px;
            max-height: 85vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-y: auto;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .popup-img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .popup-title {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: #2b2d42;
            text-align: center;
            margin: 0 0 15px;
        }

        .popup-location, .popup-contact, .popup-services, .popup-ambulance, .popup-description {
            font-size: 1.1rem;
            color: #5c5d75;
            text-align: center;
            margin: 0 0 10px;
            line-height: 1.8;
            width: 100%;
        }

        .popup-services {
            text-align: left;
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
        }

        .popup-description {
            background: #f9fafb;
            padding: 15px;
            border-radius: 12px;
            text-align: left;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8e1c1c;
            font-size: 1.2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            background: #8e1c1c;
            color: white;
            transform: rotate(90deg) scale(1.1);
        }

        @media (max-width: 1024px) {
            .hospital-grid {
                display: none;
            }
            .hospital-slider {
                display: flex;
            }
            -card {
                min-width: 300px;
            }
        }

        @media (max-width: 768px) {

            .hospital-section h2 {
                font-size: 2rem;
            }
            .filter-row {
                flex-direction: column;
                gap: 0.5rem;
            }
            .form-group {
                min-width: 100%;
            }
            .form-group select {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
            .form-group label {
                font-size: 0.9rem;
            }
            .hospital-card {
                min-width: 280px;
                height: 350px;
            }
            .hospital-card img {
                height: 150px;
            }
            .popup-content {
                width: 90%;
                padding: 15px;
            }
            .popup-img {
                height: 180px;
            }
            .popup-title {
                font-size: 1.5rem;
            }
            .popup-location, .popup-contact, .popup-services, .popup-ambulance, .popup-description {
                font-size: 1rem;
            }
        }

        @media (min-width: 1025px) {
            .hospital-slider {
                display: none;
            }
            .hospital-nav {
                display: none;
            }
            .hospital-grid {
                display: grid;
            }
        }

        /* Animation for cards */
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

        .hospital-card {
            opacity: 0;
            animation: hp-unique-fadeInUp 0.8s ease forwards;
        }

        .hospital-card:nth-child(1) { animation-delay: 0.1s; }
        .hospital-card:nth-child(2) { animation-delay: 0.2s; }
        .hospital-card:nth-child(3) { animation-delay: 0.3s; }
        .hospital-card:nth-child(4) { animation-delay: 0.4s; }
        .hospital-card:nth-child(5) { animation-delay: 0.5s; }
        .hospital-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <section class="hospital-section">
        <h2 data-translate="hospitals-title">Government Hospitals in Nepal</h2>
        <div class="filter-container">
            <div class="filter-row">
                <div class="form-group">
                    <label for="province" data-translate="filter-province">Province</label>
                    <select name="province" id="province">
                        <option value="0" data-translate="filter-all">All</option>
                        <option value="1" data-translate="filter-province1">Koshi Province</option>
                        <option value="2" data-translate="filter-province2">Madhesh Province</option>
                        <option value="3" data-translate="filter-bagmati">Bagmati Province</option>
                        <option value="4" data-translate="filter-gandaki">Gandaki Province</option>
                        <option value="5" data-translate="filter-lumbini">Lumbini Province</option>
                        <option value="6" data-translate="filter-karnali">Karnali Province</option>
                        <option value="7" data-translate="filter-sudurpaschim">Sudurpaschim Province</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="district" data-translate="filter-district">District</label>
                    <select name="district" id="district">
                        <option value="0" data-translate="filter-all">All</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="local-level" data-translate="filter-local-level">Local Level</label>
                    <select name="local-level" id="local-level">
                        <option value="0" data-translate="filter-all">All</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="hospital-container">
            <div class="hospital-grid" id="hospitalGrid">
                <?php
                $hospitals = [
                    [
                        'name_en' => 'Bir Hospital',
                        'name_np' => 'बीर अस्पताल',
                        'location_en' => 'Kathmandu, Bagmati',
                        'location_np' => 'काठमाडौं, बागमती',
                        'province' => '3',
                        'district' => 'काठमाडौँ',
                        'local_level' => 'काठमाडौँ महानगरपालिका',
                        'image' => 'assets/birhospital.jpeg.jpg',
                        'contact_en' => 'Phone: +977-1-4221119',
                        'contact_np' => 'फोन: +९७७-१-४२२१११९',
                        'services_en' => 'General Surgery, Cardiology, Emergency Services',
                        'services_np' => 'सामान्य शल्यक्रिया, कार्डियोलोजी, आपतकालीन सेवाहरू',
                        'ambulance_en' => 'Ambulance: +977-1-4221988',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-१-४२२१९८८',
                        'description_en' => 'Bir Hospital, established in 1889, is Nepal\'s oldest and most prestigious government hospital, located in the heart of Kathmandu. It serves as a critical healthcare hub, offering specialized services such as general surgery, cardiology, and emergency care.',
                        'description_np' => 'बीर अस्पताल, सन् १८८९ मा स्थापित, नेपालको सबैभन्दा पुरानो र प्रतिष्ठित सरकारी अस्पताल हो, जुन काठमाडौंको मुटुमा अवस्थित छ। यो एक महत्वपूर्ण स्वास्थ्य सेवा केन्द्रको रूपमा कार्य गर्छ, जसले सामान्य शल्यक्रिया, कार्डियोलोजी, र आपतकालीन हेरचाह जस्ता विशेष सेवाहरू प्रदान गर्छ।'
                    ],
                    [
                        'name_en' => 'B.P. Koirala Memorial Hospital',
                        'name_np' => 'बी.पी. कोइराला स्मृति अस्पताल',
                        'location_en' => 'Dharan, Koshi Province',
                        'location_np' => 'धरान, कोशी प्रदेश',
                        'province' => '1',
                        'district' => 'सुनसरी',
                        'local_level' => 'धरान उपमहानगरपालिका',
                        'image' => 'assets/bpkoirala.jpeg.jpg',
                        'contact_en' => 'Phone: +977-25-525555',
                        'contact_np' => 'फोन: +९७७-२५-५२५५५५',
                        'services_en' => 'Oncology, Cardiology, General Surgery',
                        'services_np' => 'क्यान्सर उपचार, कार्डियोलोजी, सामान्य शल्यक्रिया',
                        'ambulance_en' => 'Ambulance: +977-25-525556',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-२५-५२५५५६',
                        'description_en' => 'B.P. Koirala Memorial Hospital in Dharan is a renowned government hospital specializing in oncology, cardiology, and general surgery. Established to honor Nepal\'s first elected Prime Minister.',
                        'description_np' => 'धरानमा अवस्थित बी.पी. कोइराला स्मृति अस्पताल एक प्रख्यात सरकारी अस्पताल हो, जसले क्यान्सर उपचार, कार्डियोलोजी, र सामान्य शल्यक्रियामा विशेषज्ञता प्राप्त गरेको छ। नेपालका पहिलो निर्वाचित प्रधानमन्त्रीको सम्मानमा स्थापित।'
                    ],
                    [
                        'name_en' => 'Bharatpur Hospital',
                        'name_np' => 'भरतपुर अस्पताल',
                        'location_en' => 'Chitwan, Bagmati',
                        'location_np' => 'चितवन, बागमती',
                        'province' => '3',
                        'district' => 'चितवन',
                        'local_level' => 'भरतपुर महानगरपालिका',
                        'image' => 'assets/bharatpur.jpg',
                        'contact_en' => 'Phone: +977-56-520111',
                        'contact_np' => 'फोन: +९७७-५६-५२०१११',
                        'services_en' => 'Pediatrics, Orthopedics, Maternity Care',
                        'services_np' => 'बाल रोग, हाडजोर्नी, प्रसूति सेवा',
                        'ambulance_en' => 'Ambulance: +977-56-520222',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-५६-५२०२२२',
                        'description_en' => 'Bharatpur Hospital is a leading government hospital in Bagmati Province, known for its comprehensive healthcare services in pediatrics, orthopedics, and maternity services.',
                        'description_np' => 'भरतपुर अस्पताल बागमती प्रदेशको एक अग्रणी सरकारी अस्पताल हो, जुन बाल रोग, हाडजोर्नी, र प्रसूति सेवाहरूका लागि परिचित छ।'
                    ],
                    [
                        'name_en' => 'Lumbini Provincial Hospital',
                        'name_np' => 'लुम्बिनी प्रादेशिक अस्पताल',
                        'location_en' => 'Butwal, Lumbini',
                        'location_np' => 'बुटवल, लुम्बिनी',
                        'province' => '5',
                        'district' => 'रुपन्देही',
                        'local_level' => 'बुटवल उपमहानगरपालिका',
                        'image' => 'assets/lumbini provisional.jpg',
                        'contact_en' => 'Phone: +977-71-540200',
                        'contact_np' => 'फोन: +९७७-७१-५४०२००',
                        'services_en' => 'General Medicine, Surgery, Gynecology',
                        'services_np' => 'सामान्य चिकित्सा, शल्यक्रिया, स्त्री रोग',
                        'ambulance_en' => 'Ambulance: +977-71-540201',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-७१-५४०२०१',
                        'description_en' => 'Lumbini Provincial Hospital in Butwal is a key healthcare facility in Lumbini Province, offering a wide range of medical services including general medicine, surgery, and gynecology.',
                        'description_np' => 'बुटवलमा अवस्थित लुम्बिनी प्रादेशिक अस्पताल लुम्बिनी प्रदेशको एक प्रमुख स्वास्थ्य सुविधा हो, जसले सामान्य चिकित्सा, शल्यक्रिया, र स्त्री रोग सहित विभिन्न चिकित्सा सेवाहरू प्रदान गर्छ।'
                    ],
                    [
                        'name_en' => 'Western Regional Hospital',
                        'name_np' => 'पश्चिम क्षेत्रीय अस्पताल',
                        'location_en' => 'Pokhara, Gandaki',
                        'location_np' => 'पोखरा, गण्डकी',
                        'province' => '4',
                        'district' => 'कास्की',
                        'local_level' => 'पोखरा लेखनाथ महानगरपालिका',
                        'image' => 'assets/Western-Regional-Hospital.jpg',
                        'contact_en' => 'Phone: +977-61-520461',
                        'contact_np' => 'फोन: +९७७-६१-५२०४६१',
                        'services_en' => 'Emergency Care, Neurology, ENT',
                        'services_np' => 'आपतकालीन हेरचाह, न्यूरोलोजी, नाक-कान-घाँटी',
                        'ambulance_en' => 'Ambulance: +977-61-520462',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-६१-५२०४६२',
                        'description_en' => 'Western Regional Hospital in Pokhara is a major government healthcare facility serving the western region of Nepal, specializing in emergency care, neurology, and ENT services.',
                        'description_np' => 'पोखरामा अवस्थित पश्चिम क्षेत्रीय अस्पताल नेपालको पश्चिमी क्षेत्रलाई सेवा प्रदान गर्ने एक प्रमुख सरकारी स्वास्थ्य सुविधा हो, जसले आपतकालीन हेरचाह, न्यूरोलोजी, र नाक-कान-घाँटी सेवाहरूमा विशेषज्ञता प्राप्त गरेको छ।'
                    ],
                    [
                        'name_en' => 'Narayani Hospital',
                        'name_np' => 'नारायणी अस्पताल',
                        'location_en' => 'Birgunj, Madhesh',
                        'location_np' => 'बिरगञ्ज, मधेश',
                        'province' => '2',
                        'district' => 'पर्सा',
                        'local_level' => 'बिरगञ्ज महानगरपालिका',
                        'image' => 'assets/narayani.jpeg.jpg',
                        'contact_en' => 'Phone: +977-51-523000',
                        'contact_np' => 'फोन: +९७७-५१-५२३०००',
                        'services_en' => 'General Medicine, Surgery, Pediatrics',
                        'services_np' => 'सामान्य चिकित्सा, शल्यक्रिया, बाल रोग',
                        'ambulance_en' => 'Ambulance: +977-51-523111',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-५१-५२३१११',
                        'description_en' => 'Narayani Hospital in Birgunj is a key healthcare provider in Madhesh Province, offering services in general medicine, surgery, and pediatrics.',
                        'description_np' => 'बिरगञ्जमा अवस्थित नारायणी अस्पताल मधेश प्रदेशको एक प्रमुख स्वास्थ्य सेवा प्रदायक हो, जसले सामान्य चिकित्सा, शल्यक्रिया, र बाल रोग सेवाहरू प्रदान गर्छ।'
                    ],
                    [
                        'name_en' => 'Surkhet Hospital',
                        'name_np' => 'सुर्खेत अस्पताल',
                        'location_en' => 'Birendranagar, Karnali',
                        'location_np' => 'वीरेन्द्रनगर, कर्णाली',
                        'province' => '6',
                        'district' => 'सुर्खेत',
                        'local_level' => 'वीरेन्द्रनगर नगरपालिका',
                        'image' => 'assets/surkhet.jpeg.jpg',
                        'contact_en' => 'Phone: +977-83-520300',
                        'contact_np' => 'फोन: +९७७-८३-५२०३००',
                        'services_en' => 'General Medicine, Surgery, Emergency Care',
                        'services_np' => 'सामान्य चिकित्सा, शल्यक्रिया, आपतकालीन हेरचाह',
                        'ambulance_en' => 'Ambulance: +977-83-520301',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-८३-५२०३०१',
                        'description_en' => 'Surkhet Hospital is the main government hospital in Karnali Province, providing essential medical services including general medicine, surgery, and emergency care.',
                        'description_np' => 'सुर्खेत अस्पताल कर्णाली प्रदेशको मुख्य सरकारी अस्पताल हो, जसले सामान्य चिकित्सा, शल्यक्रिया, र आपतकालीन हेरचाह सहित आवश्यक चिकित्सा सेवाहरू प्रदान गर्छ।'
                    ],
                    [
                        'name_en' => 'Dhangadhi Hospital',
                        'name_np' => 'धनगढी अस्पताल',
                        'location_en' => 'Dhangadhi, Sudurpaschim',
                        'location_np' => 'धनगढी, सुदूरपश्चिम',
                        'province' => '7',
                        'district' => 'कैलाली',
                        'local_level' => 'धनगढी उपमहानगरपालिका',
                        'image' => 'assets/dhangadhi.jpg',
                        'contact_en' => 'Phone: +977-91-521100',
                        'contact_np' => 'फोन: +९७७-९१-५२११००',
                        'services_en' => 'General Medicine, Pediatrics, Emergency Services',
                        'services_np' => 'सामान्य चिकित्सा, बाल रोग, आपतकालीन सेवाहरू',
                        'ambulance_en' => 'Ambulance: +977-91-521101',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-९१-५२११०१',
                        'description_en' => 'Dhangadhi Hospital serves as a key healthcare facility in Sudurpaschim Province, offering general medicine, pediatrics, and emergency services to the local population.',
                        'description_np' => 'धनगढी अस्पताल सुदूरपश्चिम प्रदेशको एक प्रमुख स्वास्थ्य सुविधा हो, जसले स्थानीय जनतालाई सामान्य चिकित्सा, बाल रोग, र आपतकालीन सेवाहरू प्रदान गर्छ।'
                    ],
                    [
                        'name_en' => 'Patan Hospital',
                        'name_np' => 'पाटन अस्पताल',
                        'location_en' => 'Lalitpur, Bagmati',
                        'location_np' => 'ललितपुर, बागमती',
                        'province' => '3',
                        'district' => 'ललितपुर',
                        'local_level' => 'ललितपुर महानगरपालिका',
                        'image' => 'assets/patan.jpeg.jpg',
                        'contact_en' => 'Phone: +977-1-5522295',
                        'contact_np' => 'फोन: +९७७-१-५५२२२९५',
                        'services_en' => 'General Medicine, Surgery, Gynecology',
                        'services_np' => 'सामान्य चिकित्सा, शल्यक्रिया, स्त्री रोग',
                        'ambulance_en' => 'Ambulance: +977-1-5522296',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-१-५५२२२९६',
                        'description_en' => 'Patan Hospital is a major government hospital in Lalitpur, providing comprehensive healthcare services including general medicine, surgery, and gynecology.',
                        'description_np' => 'पाटन अस्पताल ललितपुरको एक प्रमुख सरकारी अस्पताल हो, जसले सामान्य चिकित्सा, शल्यक्रिया, र स्त्री रोग सहित व्यापक स्वास्थ्य सेवाहरू प्रदान गर्छ।'
                    ],
                    [
                        'name_en' => 'Janakpur Hospital',
                        'name_np' => 'जनकपुर अस्पताल',
                        'location_en' => 'Janakpur, Madhesh',
                        'location_np' => 'जनकपुर, मधेश',
                        'province' => '2',
                        'district' => 'धनुषा',
                        'local_level' => 'जनकपुर उपमहानगरपालिका',
                        'image' => 'assets/janakpur.jpeg.jpg',
                        'contact_en' => 'Phone: +977-41-520500',
                        'contact_np' => 'फोन: +९७७-४१-५२०५००',
                        'services_en' => 'General Medicine, Pediatrics, Maternity Care',
                        'services_np' => 'सामान्य चिकित्सा, बाल रोग, प्रसूति सेवा',
                        'ambulance_en' => 'Ambulance: +977-41-520501',
                        'ambulance_np' => 'एम्बुलेन्स: +९७७-४१-५२०५०१',
                        'description_en' => 'Janakpur Hospital is a key healthcare provider in Madhesh Province, offering services in general medicine, pediatrics, and maternity care to the local community.',
                        'description_np' => 'जनकपुर अस्पताल मधेश प्रदेशको एक प्रमुख स्वास्थ्य सेवा प्रदायक हो, जसले स्थानीय समुदायलाई सामान्य चिकित्सा, बाल रोग, र प्रसूति सेवा प्रदान गर्छ।'
                    ]
                ];

                foreach ($hospitals as $hospital) {
                    echo "
                    <div class='hospital-card' data-province='{$hospital['province']}' data-district='{$hospital['district']}' data-local-level='{$hospital['local_level']}'>
                        <img src='{$hospital['image']}' alt='{$hospital['name_en']}' loading='lazy'>
                        <h3 class='hospital-title' data-translate-name='{$hospital['name_en']}'>{$hospital['name_en']}</h3>
                        <p class='hospital-location' data-translate-location='{$hospital['location_en']}'>{$hospital['location_en']}</p>
                        <button class='hospital-view-btn' data-translate='view-details'>View Details</button>
                    </div>";
                }
                ?>
            </div>
            <div class="hospital-slider" id="hospitalSlider">
                <?php
                foreach ($hospitals as $hospital) {
                    echo "
                    <div class='hospital-card' data-province='{$hospital['province']}' data-district='{$hospital['district']}' data-local-level='{$hospital['local_level']}'>
                        <img src='{$hospital['image']}' alt='{$hospital['name_en']}' loading='lazy'>
                        <h3 class='hospital-title' data-translate-name='{$hospital['name_en']}'>{$hospital['name_en']}</h3>
                        <p class='hospital-location' data-translate-location='{$hospital['location_en']}'>{$hospital['location_en']}</p>
                        <button class='hospital-view-btn' data-translate='view-details'>View Details</button>
                    </div>";
                }
                ?>
            </div>
            <button class="hospital-nav left" onclick="scrollByHospitalCard(-1)"><i class="fas fa-chevron-left"></i></button>
            <button class="hospital-nav right" onclick="scrollByHospitalCard(1)"><i class="fas fa-chevron-right"></i></button>
        </div>
    </section>

    <!-- Popup -->
    <div class="popup" id="popup">
        <div class="popup-content">
            <button class="close-btn" id="closePopup"><i class="fas fa-times"></i></button>
            <img class="popup-img" id="popupImg" src="" alt="Hospital Image">
            <h3 class="popup-title" id="popupTitle"></h3>
            <p class="popup-location" id="popupLocation"></p>
            <p class="popup-contact" id="popupContact"></p>
            <p class="popup-services" id="popupServices"></p>
            <p class="popup-ambulance" id="popupAmbulance"></p>
            <p class="popup-description" id="popupDescription"></p>
        </div>
    </div>
<?php
    include 'footer.php';
?>
    <script>
        const nepalData = {
            1: {
                name_en: "Koshi Province",
                name_np: "कोशी प्रदेश",
                districts: {
                    "सुनसरी": ["धरान उपमहानगरपालिका", "इटहरी उपमहानगरपालिका", "इनरुवा नगरपालिका", "दुहवी नगरपालिका", "रामधुनी नगरपालिका", "बराहक्षेत्र नगरपालिका", "कोशी गाउँपालिका", "गढी गाउँपालिका", "बरजु गाउँपालिका", "हरिनगर गाउँपालिका", "देवानगञ्ज गाउँपालिका", "भोक्राहा नरसिंह गाउँपालिका"]
                }
            },
            2: {
                name_en: "Madhesh Province",
                name_np: "मधेश प्रदेश",
                districts: {
                    "पर्सा": ["बिरगञ्ज महानगरपालिका", "पोखरिया नगरपालिका", "बहुदरामाई नगरपालिका", "पर्सागढी नगरपालिका", "जिराभवानी नगरपालिका", "सखुवाप्रसौनी नगरपालिका"],
                    "धनुषा": ["जनकपुर उपमहानगरपालिका", "चिरांगदेव नगरपालिका", "गणेशमान चारनाथ नगरपालिका", "धनुषाधाम नगरपालिका", "नगराईन नगरपालिका", "विदेह नगरपालिका"]
                }
            },
            3: {
                name_en: "Bagmati Province",
                name_np: "बागमती प्रदेश",
                districts: {
                    "काठमाडौँ": ["काठमाडौँ महानगरपालिका", "बुढानिलकण्ठ नगरपालिका", "चन्द्रागिरी नगरपालिका", "गोकर्णेश्वर नगरपालिका", "कागेश्वरी मनोहरा नगरपालिका", "कीर्तिपुर नगरपालिका", "नागार्जुन नगरपालिका", "शङ्खरापुर नगरपालिका", "तारकेश्वर नगरपालिका", "टोखा नगरपालिका", "दक्षिणकाली नगरपालिका"],
                    "चितवन": ["भरतपुर महानगरपालिका", "कालिका नगरपालिका", "खैरहनी नगरपालिका", "माडी नगरपालिका", "रत्ननगर नगरपालिका", "राप्ती नगरपालिका", "इच्छाकामना गाउँपालिका"],
                    "ललितपुर": ["ललितपुर महानगरपालिका", "गोदावरी नगरपालिका", "महालक्ष्मी नगरपालिका", "कोन्ज्योसोम गाउँपालिका", "बाग्मती गाउँपालिका"]
                }
            },
            4: {
                name_en: "Gandaki Province",
                name_np: "गण्डकी प्रदेश",
                districts: {
                    "कास्की": ["पोखरा लेखनाथ महानगरपालिका", "अन्नपूर्ण गाउँपालिका", "माछापुच्छ्रे गाउँपालिका", "मादी गाउँपालिका", "रुपा गाउँपालिका"]
                }
            },
            5: {
                name_en: "Lumbini Province",
                name_np: "लुम्बिनी प्रदेश",
                districts: {
                    "रुपन्देही": ["बुटवल उपमहानगरपालिका", "सिद्धार्थनगर नगरपालिका", "तिलोत्तमा नगरपालिका", "लुम्बिनी सांस्कृतिक नगरपालिका", "देवदह नगरपालिका", "शुद्धोधन नगरपालिका", "गैडहवा गाउँपालिका", "मायादेवी गाउँपालिका", "कोटहीमाई गाउँपालिका", "सियारी गाउँपालिका", "सम्मरीमाई गाउँपालिका", "रोहिणी गाउँपालिका", "मर्चवारी गाउँपालिका", "सुद्धोधन गाउँपालिका", "ओमसतिया गाउँपालिका", "कंचन गाउँपालिका"]
                }
            },
            6: {
                name_en: "Karnali Province",
                name_np: "कर्णाली प्रदेश",
                districts: {
                    "सुर्खेत": ["वीरेन्द्रनगर नगरपालिका", "बराहताल नगरपालिका", "गुर्भाकोट नगरपालिका", "लेकबेशी नगरपालिका", "पञ्चपुरी नगरपालिका", "चौकुने गाउँपालिका", "चिङ्गाड गाउँपालिका"]
                }
            },
            7: {
                name_en: "Sudurpaschim Province",
                name_np: "सुदूरपश्चिम प्रदेश",
                districts: {
                    "कैलाली": ["धनगढी उपमहानगरपालिका", "टीकापुर नगरपालिका", "गोदावरी नगरपालिका", "लम्की चुहा नगरपालिका", "भजनी नगरपालिका", "गौरीगंगा नगरपालिका", "जानकी नगरपालिका"]
                }
            }
        };

        document.addEventListener("DOMContentLoaded", () => {
            const languageSelect = document.getElementById("language-select");
            const hospitalsData = <?php echo json_encode($hospitals); ?>;
            const provinceSelect = document.getElementById("province");
            const districtSelect = document.getElementById("district");
            const localLevelSelect = document.getElementById("local-level");

            const translations = {
                en: {
                    'page-title': 'Government Hospitals in Nepal',
                    'hospitals-title': 'Government Hospitals in Nepal',
                    'filter-all': 'All',
                    'filter-province': 'Province',
                    'filter-district': 'District',
                    'filter-local-level': 'Local Level',
                    'filter-province1': 'Koshi Province',
                    'filter-province2': 'Madhesh Province',
                    'filter-bagmati': 'Bagmati Province',
                    'filter-gandaki': 'Gandaki Province',
                    'filter-lumbini': 'Lumbini Province',
                    'filter-karnali': 'Karnali Province',
                    'filter-sudurpaschim': 'Sudurpaschim Province',
                    'view-details': 'View Details',
                    ...hospitalsData.reduce((acc, hospital) => ({
                        ...acc,
                        [hospital.name_en]: hospital.name_en,
                        [hospital.location_en]: hospital.location_en,
                        [`contact-${hospital.name_en}`]: hospital.contact_en,
                        [`services-${hospital.name_en}`]: hospital.services_en,
                        [`ambulance-${hospital.name_en}`]: hospital.ambulance_en,
                        [`description-${hospital.name_en}`]: hospital.description_en
                    }), {})
                },
                np: {
                    'page-title': 'नेपालका सरकारी अस्पतालहरू',
                    'hospitals-title': 'नेपालका सरकारी अस्पतालहरू',
                    'filter-all': 'सबै',
                    'filter-province': 'प्रदेश',
                    'filter-district': 'जिल्ला',
                    'filter-local-level': 'स्थानीय तह',
                    'filter-province1': 'कोशी प्रदेश',
                    'filter-province2': 'मधेश प्रदेश',
                    'filter-bagmati': 'बागमती प्रदेश',
                    'filter-gandaki': 'गण्डकी प्रदेश',
                    'filter-lumbini': 'लुम्बिनी प्रदेश',
                    'filter-karnali': 'कर्णाली प्रदेश',
                    'filter-sudurpaschim': 'सुदूरपश्चिम प्रदेश',
                    'view-details': 'विवरण हेर्नुहोस्',
                    ...hospitalsData.reduce((acc, hospital) => ({
                        ...acc,
                        [hospital.name_en]: hospital.name_np,
                        [hospital.location_en]: hospital.location_np,
                        [`contact-${hospital.name_en}`]: hospital.contact_np,
                        [`services-${hospital.name_en}`]: hospital.services_np,
                        [`ambulance-${hospital.name_en}`]: hospital.ambulance_np,
                        [`description-${hospital.name_en}`]: hospital.description_np
                    }), {})
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

                document.querySelectorAll('[data-translate-location]').forEach(el => {
                    const key = el.getAttribute('data-translate-location');
                    el.textContent = translations[lang][key];
                });

                provinceSelect.querySelectorAll('option').forEach(option => {
                    const key = option.getAttribute('data-translate');
                    if (key && translations[lang][key]) {
                        option.textContent = translations[lang][key];
                    }
                });
            };

            const savedLang = localStorage.getItem('language') || 'en';
            languageSelect.value = savedLang;
            updateLanguage(savedLang);

            languageSelect.addEventListener("change", function () {
                updateLanguage(this.value);
            });

            const hospitalCards = document.querySelectorAll('.hospital-card');

            function applyFilters() {
                const province = provinceSelect.value;
                const district = districtSelect.value;
                const localLevel = localLevelSelect.value;

                hospitalCards.forEach(card => {
                    const cardProvince = card.getAttribute('data-province');
                    const cardDistrict = card.getAttribute('data-district');
                    const cardLocalLevel = card.getAttribute('data-local-level');

                    const provinceMatch = province === '0' || province === cardProvince;
                    const districtMatch = district === '0' || district === cardDistrict;
                    const localLevelMatch = localLevel === '0' || localLevel === cardLocalLevel;

                    if (provinceMatch && districtMatch && localLevelMatch) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            provinceSelect.addEventListener("change", () => {
                const provinceId = provinceSelect.value;
                districtSelect.innerHTML = '<option value="0" data-translate="filter-all">All</option>';
                localLevelSelect.innerHTML = '<option value="0" data-translate="filter-all">All</option>';

                if (provinceId !== "0" && nepalData[provinceId]) {
                    Object.keys(nepalData[provinceId].districts).forEach(district => {
                        const option = document.createElement("option");
                        option.value = district;
                        option.textContent = district;
                        districtSelect.appendChild(option);
                    });
                }
                applyFilters();
                updateLanguage(languageSelect.value);
            });

            districtSelect.addEventListener("change", () => {
                const provinceId = provinceSelect.value;
                const districtName = districtSelect.value;
                localLevelSelect.innerHTML = '<option value="0" data-translate="filter-all">All</option>';

                if (provinceId !== "0" && districtName !== "0" && nepalData[provinceId].districts[districtName]) {
                    nepalData[provinceId].districts[districtName].forEach(localLevel => {
                        const option = document.createElement("option");
                        option.value = localLevel;
                        option.textContent = localLevel;
                        localLevelSelect.appendChild(option);
                    });
                }
                applyFilters();
                updateLanguage(languageSelect.value);
            });

            localLevelSelect.addEventListener("change", () => {
                applyFilters();
            });

            function scrollByHospitalCard(direction) {
                const slider = document.getElementById('hospitalSlider');
                const card = slider.querySelector('.hospital-card');
                if (!card) return;
                const cardWidth = card.offsetWidth + 25;
                slider.scrollBy({ left: direction * cardWidth, behavior: 'smooth' });
            }

            const popup = document.getElementById('popup');
            const closePopup = document.getElementById('closePopup');
            const popupImg = document.getElementById('popupImg');
            const popupTitle = document.getElementById('popupTitle');
            const popupLocation = document.getElementById('popupLocation');
            const popupContact = document.getElementById('popupContact');
            const popupServices = document.getElementById('popupServices');
            const popupAmbulance = document.getElementById('popupAmbulance');
            const popupDescription = document.getElementById('popupDescription');

            document.querySelectorAll('.hospital-view-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const card = this.closest('.hospital-card');
                    const index = Array.from(document.querySelectorAll('.hospital-card')).indexOf(card) % hospitalsData.length;
                    const hospital = hospitalsData[index];
                    const lang = languageSelect.value;

                    popupImg.src = hospital.image;
                    popupTitle.textContent = translations[lang][hospital.name_en];
                    popupLocation.textContent = translations[lang][hospital.location_en];
                    popupContact.textContent = translations[lang][`contact-${hospital.name_en}`];
                    popupServices.textContent = translations[lang][`services-${hospital.name_en}`];
                    popupAmbulance.textContent = translations[lang][`ambulance-${hospital.name_en}`];
                    popupDescription.textContent = translations[lang][`description-${hospital.name_en}`];

                    popup.classList.add('show');
                    document.body.style.overflow = 'hidden';
                });
            });

            closePopup.addEventListener('click', function() {
                popup.classList.remove('show');
                document.body.style.overflow = 'auto';
            });

            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    popup.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });

            // Initialize filters
            applyFilters();
        });
    </script>
</body>
</html>