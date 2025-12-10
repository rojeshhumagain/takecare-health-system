<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ग्रामीण नेपालका सामान्य संक्रामक र गैर-संक्रामक रोगहरू</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --health-red: #e74c3c;
            --health-green: #27ae60;
            --health-blue: #3498db;
            --health-orange: #f39c12;
            --health-purple: #9b59b6;
            --health-brown: #8e44ad;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            line-height: 1.7;
        }
        
        .header-banner {
            background: linear-gradient(135deg, #1a5276, #3498db);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .disease-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 25px;
            border: none;
        }
        
        .disease-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            font-weight: 600;
            border-bottom: none;
            font-size: 1.2rem;
        }
        
        .type-badge {
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 50px;
            margin-right: 5px;
        }
        
        .communicable {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--health-red);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .non-communicable {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--health-blue);
            border: 1px solid rgba(52, 152, 219, 0.3);
        }
        
        .seasonal {
            background-color: rgba(243, 156, 18, 0.1);
            color: var(--health-orange);
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .waterborne {
            background-color: rgba(39, 174, 96, 0.1);
            color: var(--health-green);
            border: 1px solid rgba(39, 174, 96, 0.3);
        }
        
        .vector-borne {
            background-color: rgba(142, 68, 173, 0.1);
            color: var(--health-brown);
            border: 1px solid rgba(142, 68, 173, 0.3);
        }
        
        .prevention-box {
            background-color: #e8f4fc;
            border-left: 4px solid var(--health-blue);
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
        }
        
        .symptoms-box {
            background-color: #fef9e7;
            border-left: 4px solid var(--health-orange);
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
        }
        
        .treatment-box {
            background-color: #eafaf1;
            border-left: 4px solid var(--health-green);
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 2rem;
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
            height: 3px;
            background: var(--health-red);
            border-radius: 3px;
        }
        
        .rural-specific {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .header-banner {
                padding: 2rem 0;
            }
            
            .card-header {
                font-size: 1rem;
            }
        }
    </style>
    <?php include 'header1.php'; ?>
</head>
<body>
    <!-- Header Banner -->
    <div class="header-banner">
        <div class="container">
            <h1 class="display-4"><i class="fas fa-heartbeat"></i> ग्रामीण नेपालका सामान्य रोगहरू</h1>
            <p class="lead">संक्रामक र गैर-संक्रामक रोगहरूको जानकारी, लक्षण र बचावका उपाय</p>
        </div>
    </div>
    
    <div class="container mb-5">
        <!-- Introduction -->
        <div class="alert alert-info mb-4">
            <h4 class="alert-heading"><i class="fas fa-info-circle"></i> महत्वपूर्ण जानकारी:</h4>
            <p>नेपालका ग्रामीण क्षेत्रहरूमा स्वास्थ्य सेवाको पहुँच सीमित छ। यसले गर्दा सामान्य रोगहरू पनि गम्भीर रूप लिन सक्छन्। यस पृष्ठमा ग्रामीण नेपालमा धेरै हुने सामान्य रोगहरूको बारेमा जानकारी दिइएको छ।</p>
        </div>
        
        <!-- Communicable Diseases Section -->
        <h2 class="section-title mt-5">संक्रामक रोगहरू</h2>
        <p class="text-center mb-4">एक व्यक्तिबाट अर्को व्यक्तिमा सर्न सक्ने रोगहरू</p>
        
        <div class="row">
            <!-- Diarrhea -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-toilet"></i> पखाला (डायरिया)
                        <span class="badge communicable float-end">संक्रामक</span>
                        <span class="badge waterborne float-end mx-1">पानीजन्य</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">असफा पानी र खानाको सेवनले गर्दा हुने सामान्य रोग। ग्रामीण क्षेत्रमा बच्चाहरूमा यो रोगले गर्दा मृत्यु हुन सक्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>पातलो दिसा बारम्बार हुने</li>
                                <li>पेट दुख्ने वा मरोड हुने</li>
                                <li>उल्टी हुने</li>
                                <li>शरीरबाट पानी निकालिने (डिहाइड्रेसन)</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>ओआरएस घोल: १ लिटर सफा पानीमा ६ चिम्टी चिनी र १ चिम्टी नुन घोलेर हरेक पखाला पछि पिउने</li>
                                <li>जिङ्क ट्याब्लेट: १४ दिनसम्म</li>
                                <li>न्यानो खाना (भात, दाइ, साबुजी)</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>सफा पानी पिउने (उबालिएको वा फिल्टर गरिएको)</li>
                                <li>हात धुने (खाना खानु अगाडि र शौच पछि)</li>
                                <li>खाना राम्ररी पकाएर खाने</li>
                                <li>शौचालयको प्रयोग गर्ने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> धेरै गाउँहरूमा सफा पानीको अभाव छ। पानी उबाल्ने वा फिल्टर गर्ने बानी बनाउनु जरुरी छ।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Typhoid -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-bacterium"></i> टाइफाइड
                        <span class="badge communicable float-end">संक्रामक</span>
                        <span class="badge waterborne float-end mx-1">पानीजन्य</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">साल्मोनेला टाइफी जीवाणुले गर्दा हुने गम्भीर रोग। ग्रामीण क्षेत्रमा सफाइको अभावले यो रोग फैलिने जोखिम धेरै हुन्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>लामो समयसम्म ज्वरो (१०३-१०४°F)</li>
                                <li>कब्जियत वा पखाला</li>
                                <li>पेट दुख्ने</li>
                                <li>टाउको दुख्ने र कमजोरी</li>
                                <li>रक्तस्राव (गम्भीर अवस्थामा)</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>एन्टिबायोटिक (सिप्रोफ्लोक्सासिन, अजिथ्रोमाइसिन)</li>
                                <li>पर्याप्त तरल पदार्थ</li>
                                <li>पौष्टिक खाना</li>
                                <li>पूर्ण आराम</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>टाइफाइड टीका लगाउने</li>
                                <li>सफा पानी मात्र पिउने</li>
                                <li>हात धुने (खाना खानु अगाडि र शौच पछि)</li>
                                <li>खाना राम्ररी पकाएर खाने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा खुलेआम शौच गर्ने बानी छ। शौचालय निर्माण र प्रयोगलाई प्रोत्साहन गर्नुपर्छ।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kala-azar -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-warning text-dark">
                        <i class="fas fa-bug"></i> कालाजार (Leishmaniasis)
                        <span class="badge communicable float-end">संक्रामक</span>
                        <span class="badge vector-borne float-end mx-1">भेक्टरजन्य</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">सानो किराले सुताएर फैलाउने गम्भीर रोग। नेपालको तराई क्षेत्रमा धेरै पाइन्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>लामो समयसम्म ज्वरो</li>
                                <li>शरीरको वजन घट्ने</li>
                                <li>प्लीहा र लिम्फ नोडहरू बढ्ने</li>
                                <li>रक्तमा कमी (एनिमिया)</li>
                                <li>छालाको रङ्ग कालो पर्ने</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>एन्टिमोनियल यौगिक (Sodium Stibogluconate)</li>
                                <li>Amphotericin B</li>
                                <li>Miltefosine</li>
                                <li>पौष्टिक आहार</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>मच्छरदानी प्रयोग गर्ने</li>
                                <li>किरा भगाउने क्रीम प्रयोग गर्ने</li>
                                <li>घर वरिपरि सफाइ गर्ने</li>
                                <li>रोग पत्ता लाग्नासाथ उपचार गर्ने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> तराईका गाउँहरूमा यो रोगको प्रकोप धेरै हुन्छ। सरकारले निशुल्क उपचार उपलब्ध गराउँछ।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pneumonia -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-lungs"></i> निमोनिया
                        <span class="badge communicable float-end">संक्रामक</span>
                        <span class="badge seasonal float-end mx-1">मौसमी</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">फोक्सोमा संक्रमण हुँदा हुने रोग। बच्चा र बुढापाकाहरूमा यो रोग खतरनाक हुन सक्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>ज्वरो</li>
                                <li>खोकी (कहिलेकाहीँ कफ आउने)</li>
                                <li>सास फेर्न गाह्रो हुने</li>
                                <li>छाती दुख्ने</li>
                                <li>शरीर दुख्ने र कमजोरी</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>एन्टिबायोटिक (Amoxicillin, Azithromycin)</li>
                                <li>ज्वरो घटाउने औषधि (Paracetamol)</li>
                                <li>धेरै तरल पदार्थ</li>
                                <li>आराम</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>निमोनियाको टीका लगाउने</li>
                                <li>धुलो-धुवाँबाट टाढा रहने</li>
                                <li>ताजा हावामा बस्ने</li>
                                <li>धूम्रपान नगर्ने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा चुलोको धुवाँले गर्दा महिलाहरूमा निमोनिया हुने जोखिम धेरै हुन्छ। चुलो सुधार गर्नुपर्छ।
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Non-Communicable Diseases Section -->
        <h2 class="section-title mt-5">गैर-संक्रामक रोगहरू</h2>
        <p class="text-center mb-4">एक व्यक्तिबाट अर्को व्यक्तिमा नसर्ने तर दीर्घकालीन स्वास्थ्य समस्या बन्न सक्ने रोगहरू</p>
        
        <div class="row">
            <!-- Hypertension -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-heartbeat"></i> उच्च रक्तचाप
                        <span class="badge non-communicable float-end">गैर-संक्रामक</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">रक्तचाप १४०/९० mmHg भन्दा बढी हुँदा उच्च रक्तचाप भनिन्छ। ग्रामीण क्षेत्रमा यसको बारेमा जानकारीको अभाव छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>धेरै समयसम्म कुनै लक्षण नदेखिने</li>
                                <li>टाउको दुख्ने</li>
                                <li>चक्कर आउने</li>
                                <li>नाकबाट रक्तस्राव हुने</li>
                                <li>सास फेर्न गाह्रो हुने</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>डाक्टरको सल्लाह अनुसार औषधि (Amlodipine, Losartan)</li>
                                <li>नियमित व्यायाम</li>
                                <li>आहारमा परिवर्तन</li>
                                <li>तनाव व्यवस्थापन</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>नुन कम खाने</li>
                                <li>नियमित व्यायाम गर्ने</li>
                                <li>ताजा फलफूल र सागसब्जी धेरै खाने</li>
                                <li>धूम्रपान र मदिरा त्याग्ने</li>
                                <li>नियमित रक्तचाप जाँच गर्ने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा धेरै नुन खाने बानी छ। घिउ, तेल र नुन कम प्रयोग गर्ने बानी बनाउनुपर्छ।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Diabetes -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-vial"></i> मधुमेह (डायबिटिज)
                        <span class="badge non-communicable float-end">गैर-संक्रामक</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">इन्सुलिन हर्मोनको असक्षमताको कारण रगतमा चिनीको मात्रा बढी हुने रोग। ग्रामीण क्षेत्रमा पनि यो रोग बढ्दै गइरहेको छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>धेरै प्यास लाग्ने</li>
                                <li>बारम्बार पिसाब आउने</li>
                                <li>अचानक वजन घट्ने</li>
                                <li>घाऊ निको हुन गाह्रो हुने</li>
                                <li>आँखाको दृष्टि धुंधलाउने</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>डाक्टरको सल्लाह अनुसार औषधि (Metformin, Glibenclamide)</li>
                                <li>इन्सुलिन (टाइप 1 डायबिटिजमा)</li>
                                <li>नियमित रक्त शर्करा जाँच</li>
                                <li>आहार नियन्त्रण</li>
                                <li>नियमित व्यायाम</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>स्वस्थ वजन कायम राख्ने</li>
                                <li>नियमित शारीरिक गतिविधि</li>
                                <li>चिनीयुक्त खाद्यपदार्थ कम खाने</li>
                                <li>धेरै फाइबरयुक्त आहार लिने</li>
                                <li>नियमित स्वास्थ्य जाँच</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा मिठाई र चिनी धेरै प्रयोग गरिन्छ। यसलाई सीमित गर्नुपर्छ।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- COPD -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-secondary text-white">
                        <i class="fas fa-lungs-virus"></i> क्रनिक फोक्सो रोग (COPD)
                        <span class="badge non-communicable float-end">गैर-संक्रामक</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">धुवाँ, धूलो र प्रदूषणले गर्दा फोक्सोमा हुने दीर्घकालीन समस्या। ग्रामीण महिलाहरूमा चुलोको धुवाँले गर्दा यो रोग धेरै हुन्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>लामो समयसम्म खोकी</li>
                                <li>कफ (पहेँलो वा सेतो)</li>
                                <li>सास फेर्न गाह्रो हुने</li>
                                <li>छाती कसेको जस्तो महसुस हुने</li>
                                <li>शरीर कमजोर हुने</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>ब्रोन्कोडाइलेटर (Salbutamol inhaler)</li>
                                <li>स्टेरोइड (कहिलेकाहीँ)</li>
                                <li>अक्सिजन थेरापी (गम्भीर अवस्थामा)</li>
                                <li>फोक्सोको व्यायाम</li>
                                <li>धुवाँ र धूलोबाट टाढा रहने</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>धूम्रपान नगर्ने</li>
                                <li>चुलोको धुवाँबाट बच्ने</li>
                                <li>धूलो भएको ठाउँमा मास्क लगाउने</li>
                                <li>नियमित व्यायाम</li>
                                <li>स्वच्छ हावामा बस्ने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा चुलो सुधार (धुवाँ कम हुने चुलो) प्रयोग गर्नुपर्छ। बायोग्यास चुलो र इन्डक्सन स्टोभ उपयुक्त हुन्।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Arthritis -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-warning text-dark">
                        <i class="fas fa-bone"></i> गाँठेदार दुखाइ (Arthritis)
                        <span class="badge non-communicable float-end">गैर-संक्रामक</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">जोर्नीहरूमा हुने दुखाइ र सुनिने समस्या। ग्रामीण क्षेत्रमा भारी श्रम गर्ने व्यक्तिहरूमा यो समस्या धेरै हुन्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>जोर्नीहरूमा दुखाइ</li>
                                <li>सुनिने वा अकडन</li>
                                <li>चल्न फर्न गाह्रो हुने</li>
                                <li>जोर्नीहरू सुनिने</li>
                                <li>जोर्नीहरू फुल्ने</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>दुखाइ निवारक (Paracetamol, Ibuprofen)</li>
                                <li>जोर्नीको व्यायाम</li>
                                <li>गरम पानीले सेक्ने</li>
                                <li>वजन नियन्त्रण</li>
                                <li>भौतिक चिकित्सा</li>
                            </ul>
                        </div>
                        
                        <div class="prevention-box">
                            <h5><i class="fas fa-shield-alt text-primary"></i> बचावका उपाय:</h5>
                            <ul>
                                <li>नियमित व्यायाम</li>
                                <li>स्वस्थ वजन कायम राख्ने</li>
                                <li>भारी वस्तु उचाल्दा सावधानी अपनाउने</li>
                                <li>क्याल्सियमयुक्त खाना खाने</li>
                                <li>जोर्नीमा चोट नलाग्ने गरी काम गर्ने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा भारी श्रम गर्नुपर्छ। उचित तरिकाले श्रम गर्ने तरिका सिकाउनुपर्छ।
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Rural Health Tips -->
        <div class="card mt-5 border-success">
            <div class="card-header bg-success text-white">
                <i class="fas fa-lightbulb"></i> ग्रामीण स्वास्थ्य सुझावहरू
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3 border-0">
                            <div class="card-body">
                                <h5><i class="fas fa-hand-holding-water text-primary"></i> स्वच्छ पानी:</h5>
                                <ul>
                                    <li>पानी उबालेर वा फिल्टर गरेर पिउने</li>
                                    <li>पानी भण्डारण गर्दा ढक्कन लगाउने</li>
                                    <li>नदीको पानी प्रयोग गर्दा राम्रोसँग उपचार गर्ने</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card mb-3 border-0">
                            <div class="card-body">
                                <h5><i class="fas fa-utensils text-info"></i> स्वच्छ खाना:</h5>
                                <ul>
                                    <li>खाना पकाउनु अगाडि हात धुने</li>
                                    <li>कच्चा र पकाएका खाना छुट्याउने</li>
                                    <li>खाना ढाकेर राख्ने</li>
                                    <li>फलफूल र सब्जी धुने</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-3 border-0">
                            <div class="card-body">
                                <h5><i class="fas fa-home text-warning"></i> स्वच्छ वातावरण:</h5>
                                <ul>
                                    <li>घर वरिपरि सफाइ गर्ने</li>
                                    <li>फोहोर उचित ठाउँमा फाल्ने</li>
                                    <li>शौचालय प्रयोग गर्ने</li>
                                    <li>मच्छर नपलाउने गरी पानी जम्न नदिने</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="card mb-3 border-0">
                            <div class="card-body">
                                <h5><i class="fas fa-heartbeat text-danger"></i> स्वस्थ जीवनशैली:</h5>
                                <ul>
                                    <li>नियमित व्यायाम गर्ने</li>
                                    <li>धूम्रपान र मदिरा त्याग्ने</li>
                                    <li>पौष्टिक आहार लिने</li>
                                    <li>नियमित स्वास्थ्य जाँच गर्ने</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Emergency Section -->
        <h2 class="section-title mt-5">ग्रामीण आपतकालीन स्वास्थ्य सेवा</h2>
        
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-ambulance"></i> आपतकालीन नम्बरहरू
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>एम्बुलेन्स:</strong> 102</li>
                            <li class="list-group-item"><strong>नजिकको स्वास्थ्य चौकी:</strong> स्थानीय नम्बर</li>
                            <li class="list-group-item"><strong>महिला हेल्पलाइन:</strong> 1145</li>
                            <li class="list-group-item"><strong>बाल हेल्पलाइन:</strong> 1098</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-first-aid"></i> प्राथमिक उपचार
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>घाउ-चोट:</strong> सफा पानीले धुने, एन्टिसेप्टिक लगाउने</li>
                            <li class="list-group-item"><strong>ज्वरो:</strong> प्यारासिटामोल, ओआरएस</li>
                            <li class="list-group-item"><strong>पखाला:</strong> ओआरएस, जिङ्क ट्याब्लेट</li>
                            <li class="list-group-item"><strong>सास फेर्न गाह्रो:</strong> ताजा हावामा राख्ने</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-heartbeat"></i> ग्रामीण स्वास्थ्य शिक्षा</h5>
                    <p>स्वस्थ गाउँ, सबल नेपालको निम्ति</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">© 2023 ग्रामीण स्वास्थ्य शिक्षा. सर्वाधिकार सुरक्षित.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>