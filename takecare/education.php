<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>स्वास्थ्य शिक्षा - Health Education Nepal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #1a5276;
            --health-red: #e74c3c;
            --health-green: #27ae60;
            --health-blue: #3498db;
            --health-orange: #f39c12;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --white: #fff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f9fafb;
            color: var(--text-color);
        }

        .header-banner {
            background: linear-gradient(135deg, var(--health-blue), var(--health-green));
            color: white;
            padding: 30px 0;
            text-align: center;
            margin-bottom: 30px;
        }

        .header-banner h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
        }

        .header-banner p {
            margin: 10px 0 0;
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .health-section {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section-title {
            font-size: 2rem;
            color: var(--primary-color);
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
            text-align: center;
        }

        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--health-red);
            border-radius: 2px;
        }

        .health-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .health-card {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .health-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .health-card-header {
            padding: 20px;
            background: var(--health-blue);
            color: white;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .health-card-header i {
            font-size: 1.8rem;
        }

        .health-card-header h3 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 600;
        }

        .health-card-body {
            padding: 20px;
        }

        .health-card-body p {
            margin: 0 0 15px;
            line-height: 1.7;
        }

        .health-card-body ul {
            margin: 0 0 15px;
            padding-left: 20px;
        }

        .health-card-body li {
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .precaution-list {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
        }

        .precaution-list h4 {
            margin: 0 0 10px;
            color: var(--health-red);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .precaution-list h4 i {
            font-size: 1.1rem;
        }

        .disease-type {
            display: inline-block;
            padding: 3px 10px;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 20px;
            margin-right: 8px;
            margin-bottom: 8px;
            color: white;
        }

        .type-communicable {
            background: var(--health-red);
        }

        .type-noncommunicable {
            background: var(--health-blue);
        }

        .type-seasonal {
            background: var(--health-orange);
        }

        .type-waterborne {
            background: var(--health-green);
        }

        .emergency-contacts {
            background: #fff8f8;
            border-left: 4px solid var(--health-red);
            padding: 15px;
            margin-top: 20px;
            border-radius: 0 6px 6px 0;
        }

        .emergency-contacts h4 {
            margin: 0 0 10px;
            color: var(--health-red);
        }

        .emergency-contacts p {
            margin: 0;
            font-size: 0.9rem;
        }

        .health-tips-section {
            background: #f0f7ff;
            padding: 30px;
            border-radius: var(--border-radius);
            margin: 40px 0;
        }

        .health-tips-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }

        .health-tip {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            gap: 15px;
        }

        .health-tip i {
            font-size: 1.5rem;
            color: var(--health-blue);
            margin-top: 3px;
        }

        .health-tip-content h4 {
            margin: 0 0 8px;
            color: var(--primary-color);
        }

        .health-tip-content p {
            margin: 0;
            font-size: 0.9rem;
            color: #555;
        }

        @media (max-width: 768px) {
            .health-grid {
                grid-template-columns: 1fr;
            }
            
            .header-banner h1 {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.8rem;
            }
        }

        /* Animation for cards */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .health-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .health-card:nth-child(1) { animation-delay: 0.1s; }
        .health-card:nth-child(2) { animation-delay: 0.2s; }
        .health-card:nth-child(3) { animation-delay: 0.3s; }
        .health-card:nth-child(4) { animation-delay: 0.4s; }
        .health-card:nth-child(5) { animation-delay: 0.5s; }
        .health-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
</head>
<body>
    <?php include('header1.php'); ?>
    
    <div class="header-banner">
        <h1><i class="fas fa-heartbeat"></i> स्वास्थ्य शिक्षा</h1>
        <p>स्वस्थ जीवनशैली, रोग नियन्त्रण र सावधानीका उपायहरू</p>
    </div>

    <div class="health-section">
        <h2 class="section-title">सामान्य रोगहरू र उपचार</h2>
        
        <div class="health-grid">
            <!-- Dengue Fever -->
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-red);">
                    <i class="fas fa-bug"></i>
                    <h3>डेंगु ज्वरो</h3>
                </div>
                <div class="health-card-body">
                    <span class="disease-type type-communicable">संक्रामक</span>
                    <span class="disease-type type-seasonal">मौसमी</span>
                    
                    <p>डेंगु एडिस मच्छरले फैलाउने भाइरल रोग हो। यसको प्रमुख लक्षणहरू:</p>
                    <ul>
                        <li>अचानक उच्च ज्वरो (१०४°F सम्म)</li>
                        <li>घाँटी दुख्ने, टाउको दुख्ने</li>
                        <li>आँखा पछाडि दुख्ने</li>
                        <li>मांसपेशी र जोर्नी दुख्ने</li>
                        <li>रक्तस्रावी लक्षण (गम्भीर अवस्थामा)</li>
                    </ul>
                    
                    <div class="precaution-list">
                        <h4><i class="fas fa-shield-alt"></i> सावधानीहरू:</h4>
                        <ul>
                            <li>मच्छरदानी प्रयोग गर्ने</li>
                            <li>घर वरिपरि पानी जम्न नदिने</li>
                            <li>मच्छर भगाउने क्रीम प्रयोग गर्ने</li>
                            <li>फुल आस्तीन लुगा लगाउने</li>
                        </ul>
                    </div>
                    
                    <div class="emergency-contacts">
                        <h4><i class="fas fa-phone-alt"></i> आपतकालीन सम्पर्क:</h4>
                        <p>स्वास्थ्य सेवा विभाग: ९८५१०८५३४७</p>
                        <p>नजिकको स्वास्थ्य चौकीमा सम्पर्क गर्नुहोस्</p>
                    </div>
                </div>
            </div>
            
            <!-- Typhoid -->
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-orange);">
                    <i class="fas fa-bacteria"></i>
                    <h3>टाइफाइड</h3>
                </div>
                <div class="health-card-body">
                    <span class="disease-type type-communicable">संक्रामक</span>
                    <span class="disease-type type-waterborne">पानीजन्य</span>
                    
                    <p>साल्मोनेला टाइफी जीवाणुले फैलाउने रोग हो। लक्षणहरू:</p>
                    <ul>
                        <li>लामो समयसम्म ज्वरो (१०३-१०४°F)</li>
                        <li>कब्जियत वा पखाला</li>
                        <li>पेट दुख्ने</li>
                        <li>टाउको दुख्ने र कमजोरी</li>
                        <li>रक्तस्राव (गम्भीर अवस्थामा)</li>
                    </ul>
                    
                    <div class="precaution-list">
                        <h4><i class="fas fa-shield-alt"></i> सावधानीहरू:</h4>
                        <ul>
                            <li>सफा पानी मात्र पिउने</li>
                            <li>हात धुने (खाना खानु अगाडि र शौच पछि)</li>
                            <li>खाना राम्ररी पकाएर खाने</li>
                            <li>टाइफाइड टीका लगाउने</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Diarrhea -->
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-green);">
                    <i class="fas fa-toilet"></i>
                    <h3>पखाला (डायरिया)</h3>
                </div>
                <div class="health-card-body">
                    <span class="disease-type type-communicable">संक्रामक</span>
                    <span class="disease-type type-waterborne">पानीजन्य</span>
                    
                    <p>पखाला विभिन्न कारणले हुन सक्छ, विशेष गरी असफा पानी र खानाले। लक्षणहरू:</p>
                    <ul>
                        <li>पातलो दिसा बारम्बार हुने</li>
                        <li>पेट दुख्ने वा मरोड हुने</li>
                        <li>उल्टी हुने</li>
                        <li>शरीरबाट पानी निकालिने (डिहाइड्रेसन)</li>
                    </ul>
                    
                    <div class="precaution-list">
                        <h4><i class="fas fa-shield-alt"></i> सावधानीहरू:</h4>
                        <ul>
                            <li>ओआरएस घोल प्रयोग गर्ने</li>
                            <li>सफा पानी मात्र पिउने</li>
                            <li>हात धुने (खाना खानु अगाडि र शौच पछि)</li>
                            <li>खाना राम्ररी पकाएर खाने</li>
                        </ul>
                    </div>
                    
                    <div class="emergency-contacts">
                        <h4><i class="fas fa-notes-medical"></i> उपचार:</h4>
                        <p>ओआरएस घोल: १ लिटर सफा पानीमा ६ चिम्टी चिनी र १ चिम्टी नुन घोलेर हरेक पखाला पछि पिउने</p>
                    </div>
                </div>
            </div>
            
            <!-- Hypertension -->
            <div class="health-card">
                <div class="health-card-header" style="background: var(--primary-color);">
                    <i class="fas fa-heart"></i>
                    <h3>उच्च रक्तचाप</h3>
                </div>
                <div class="health-card-body">
                    <span class="disease-type type-noncommunicable">गैर-संक्रामक</span>
                    
                    <p>रक्तचाप १४०/९० mmHg भन्दा बढी हुँदा उच्च रक्तचाप भनिन्छ। यसका प्रमुख कारणहरू:</p>
                    <ul>
                        <li>धेरै नुन खाने बानी</li>
                        <li>मोटोपना</li>
                        <li>तनाव</li>
                        <li>शारीरिक श्रम नगर्ने</li>
                        <li>धूम्रपान र मदिरा सेवन</li>
                    </ul>
                    
                    <div class="precaution-list">
                        <h4><i class="fas fa-shield-alt"></i> नियन्त्रणका उपाय:</h4>
                        <ul>
                            <li>नुन कम खाने</li>
                            <li>नियमित व्यायाम गर्ने</li>
                            <li>ताजा फलफूल र सागसब्जी धेरै खाने</li>
                            <li>तनाव कम गर्ने</li>
                            <li>धूम्रपान र मदिरा त्याग्ने</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Diabetes -->
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-blue);">
                    <i class="fas fa-vial"></i>
                    <h3>मधुमेह (डायबिटिज)</h3>
                </div>
                <div class="health-card-body">
                    <span class="disease-type type-noncommunicable">गैर-संक्रामक</span>
                    
                    <p>मधुमेह भनेको इन्सुलिन हर्मोनको असक्षमताको कारण रगतमा चिनीको मात्रा बढी हुने रोग हो। लक्षणहरू:</p>
                    <ul>
                        <li>धेरै प्यास लाग्ने</li>
                        <li>बारम्बार पिसाब आउने</li>
                        <li>अचानक वजन घट्ने</li>
                        <li>घाऊ निको हुन गाह्रो हुने</li>
                        <li>आँखाको दृष्टि धुंधलाउने</li>
                    </ul>
                    
                    <div class="precaution-list">
                        <h4><i class="fas fa-shield-alt"></i> नियन्त्रणका उपाय:</h4>
                        <ul>
                            <li>नियमित रक्त परीक्षण गर्ने</li>
                            <li>चिनीयुक्त खाद्यपदार्थ कम खाने</li>
                            <li>नियमित व्यायाम गर्ने</li>
                            <li>डाक्टरको सल्लाह अनुसार औषधि लिने</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- COVID-19 -->
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-red);">
                    <i class="fas fa-virus"></i>
                    <h3>COVID-19</h3>
                </div>
                <div class="health-card-body">
                    <span class="disease-type type-communicable">संक्रामक</span>
                    <span class="disease-type type-seasonal">मौसमी</span>
                    
                    <p>कोरोना भाइरसले फैलाउने संक्रामक रोग। प्रमुख लक्षणहरू:</p>
                    <ul>
                        <li>ज्वरो</li>
                        <li>खोकी (सुख्खा खोकी)</li>
                        <li>सास फेर्न गाह्रो हुने</li>
                        <li>स्वाद र गन्ध नआउने</li>
                        <li>शरीर दुख्ने</li>
                    </ul>
                    
                    <div class="precaution-list">
                        <h4><i class="fas fa-shield-alt"></i> सावधानीहरू:</h4>
                        <ul>
                            <li>मास्क लगाउने</li>
                            <li>हात धुने वा सेनिटाइज गर्ने</li>
                            <li>सामाजिक दूरी (२ मिटर) पालना गर्ने</li>
                            <li>टीका लगाउने</li>
                            <li>भीडभाडबाट टाढा रहने</li>
                        </ul>
                    </div>
                    
                    <div class="emergency-contacts">
                        <h4><i class="fas fa-phone-alt"></i> आपतकालीन सम्पर्क:</h4>
                        <p>COVID-19 हेल्पलाइन: १११५</p>
                        <p>स्वास्थ्य सेवा विभाग: ९८५१०८५३४७</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="health-tips-section">
            <h2 class="section-title">स्वस्थ जीवनशैलीका टिप्सहरू</h2>
            
            <div class="health-tips-grid">
                <div class="health-tip">
                    <i class="fas fa-utensils"></i>
                    <div class="health-tip-content">
                        <h4>सन्तुलित आहार</h4>
                        <p>दैनिक आहारमा फलफूल, सागसब्जी, अन्न, दुध र दालहरू समावेश गर्नुहोस्। चिनी, नुन र घिउ कम मात्रामा प्रयोग गर्नुहोस्।</p>
                    </div>
                </div>
                
                <div class="health-tip">
                    <i class="fas fa-running"></i>
                    <div class="health-tip-content">
                        <h4>नियमित व्यायाम</h4>
                        <p>दिनको कम्तिमा ३० मिनेट व्यायाम गर्नुहोस्। हिँड्ने, दौड्ने, योग गर्ने वा अन्य शारीरिक गतिविधि गर्नुहोस्।</p>
                    </div>
                </div>
                
                <div class="health-tip">
                    <i class="fas fa-bed"></i>
                    <div class="health-tip-content">
                        <h4>पर्याप्त निद्रा</h4>
                        <p>दिनको ७-८ घण्टा निद्रा लिनुहोस्। नियमित समयमा सुत्ने र उठ्ने बानी बनाउनुहोस्।</p>
                    </div>
                </div>
                
                <div class="health-tip">
                    <i class="fas fa-hand-holding-water"></i>
                    <div class="health-tip-content">
                        <h4>धेरै पानी पिउने</h4>
                        <p>दिनभरीमा कम्तिमा २-३ लिटर पानी पिउनुहोस्। सफा र उबालिएको पानी मात्र पिउनुहोस्।</p>
                    </div>
                </div>
                
                <div class="health-tip">
                    <i class="fas fa-smoking-ban"></i>
                    <div class="health-tip-content">
                        <h4>धूम्रपान नगर्ने</h4>
                        <p>धूम्रपान र मदिरा सेवनबाट टाढा रहनुहोस्। यसले फोक्सो, मुटु र क्यान्सर जस्ता रोगहरू बढाउँछ।</p>
                    </div>
                </div>
                
                <div class="health-tip">
                    <i class="fas fa-hand-wash"></i>
                    <div class="health-tip-content">
                        <h4>हात धुने बानी</h4>
                        <p>खाना खानु अगाडि, शौच पछि र बाहिरबाट आएपछि साबुनले हात धुनुहोस्। यसले रोगाणु फैलिनबाट रोक्छ।</p>
                    </div>
                </div>
                
                <div class="health-tip">
                    <i class="fas fa-syringe"></i>
                    <div class="health-tip-content">
                        <h4>टीकाकरण</h4>
                        <p>सबै आवश्यक टीकाहरू समयमै लगाउनुहोस्। विशेष गरी बच्चाहरूलाई नियमित टीकाकरण गराउनुहोस्।</p>
                    </div>
                </div>
                
                <div class="health-tip">
                    <i class="fas fa-heartbeat"></i>
                    <div class="health-tip-content">
                        <h4>नियमित स्वास्थ्य जाँच</h4>
                        <p>वर्षमा कम्तिमा एक पटक पूर्ण स्वास्थ्य जाँच गराउनुहोस्। रक्तचाप, मधुमेह र कोलेस्ट्रोल जाँच गर्नुहोस्।</p>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="section-title">आपतकालीन स्वास्थ्य सेवा</h2>
        
        <div class="health-grid">
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-red);">
                    <i class="fas fa-ambulance"></i>
                    <h3>आपतकालीन सम्पर्क नम्बरहरू</h3>
                </div>
                <div class="health-card-body">
                    <ul>
                        <li><strong>एम्बुलेन्स:</strong> १०२</li>
                        <li><strong>पुलिस:</strong> १००</li>
                        <li><strong>आगो नियन्त्रण:</strong> १०१</li>
                        <li><strong>COVID-19 हेल्पलाइन:</strong> १११५</li>
                        <li><strong>महिला हेल्पलाइन:</strong> ११४५</li>
                        <li><strong>बाल हेल्पलाइन:</strong> १०९८</li>
                    </ul>
                    
                    <div class="emergency-contacts" style="margin-top: 15px;">
                        <h4><i class="fas fa-hospital"></i> प्रमुख अस्पतालहरू:</h4>
                        <p><strong>त्रिवि शिक्षण अस्पताल:</strong> ९८५१०८५३४७</p>
                        <p><strong>पाटन अस्पताल:</strong> ९८५१०८५३४८</p>
                        <p><strong>भक्तपुर क्यान्सर अस्पताल:</strong> ९८५१०८५३४९</p>
                    </div>
                </div>
            </div>
            
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-orange);">
                    <i class="fas fa-first-aid"></i>
                    <h3>प्राथमिक उपचार</h3>
                </div>
                <div class="health-card-body">
                    <h4>घाउ-चोटको उपचार:</h4>
                    <ul>
                        <li>सफा पानीले घाउ धुनुहोस्</li>
                        <li>एन्टिसेप्टिक क्रीम लगाउनुहोस्</li>
                        <li>सफा पट्टी बाँध्नुहोस्</li>
                    </ul>
                    
                    <h4>ज्वरोको उपचार:</h4>
                    <ul>
                        <li>पानी वा ओआरएस पिउन दिनुहोस्</li>
                        <li>पर्याप्त आराम गर्न दिनुहोस्</li>
                        <li>प्यारासिटामोल (डाक्टरको सल्लाह अनुसार)</li>
                    </ul>
                    
                    <h4>उल्टी/पखालाको उपचार:</h4>
                    <ul>
                        <li>ओआरएस घोल पिउन दिनुहोस्</li>
                        <li>सजिलै पच्ने खाना दिनुहोस्</li>
                        <li>डाक्टरको सल्लाह लिनुहोस्</li>
                    </ul>
                </div>
            </div>
            
            <div class="health-card">
                <div class="health-card-header" style="background: var(--health-green);">
                    <i class="fas fa-heartbeat"></i>
                    <h3>मुटुको आक्रमणको लक्षण</h3>
                </div>
                <div class="health-card-body">
                    <p>मुटुको आक्रमणको प्रमुख लक्षणहरू:</p>
                    <ul>
                        <li>छातीमा गहिरो दुखाइ (१५ मिनेटभन्दा बढी)</li>
                        <li>बायाँ हात, जबडा वा घाँटीमा दुखाइ</li>
                        <li>सास फेर्न गाह्रो हुने</li>
                        <li>घाम लाग्ने र उल्टी लाग्ने</li>
                    </ul>
                    
                    <div class="precaution-list">
                        <h4><i class="fas fa-exclamation-triangle"></i> के गर्ने?</h4>
                        <ul>
                            <li>तुरुन्त एम्बुलेन्स बोलाउनुहोस् (१०२)</li>
                            <li>रोगीलाई आरामदायी अवस्थामा राख्नुहोस्</li>
                            <li>एस्प्रिन ट्याब्लेट चपाउन दिनुहोस् (यदि उपलब्ध छ भने)</li>
                            <li>रोगीलाई शान्त गराउनुहोस्</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include('footer.php'); ?>

    <script>
        // Simple animation trigger
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.health-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = ${index * 0.1}s;
            });
        });
    </script>
</body>
</html>