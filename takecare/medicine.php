<?php include('header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>सामान्य रोगका लागि सामान्य औषधिहरू - Health Education Nepal</title>
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
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
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
        }
        
        .medicine-item {
            border-left: 4px solid var(--health-blue);
            padding: 10px 15px;
            margin-bottom: 10px;
            background-color: rgba(52, 152, 219, 0.05);
            border-radius: 4px;
        }
        
        .medicine-name {
            font-weight: 600;
            color: var(--health-blue);
        }
        
        .medicine-dosage {
            font-size: 0.85rem;
            color: #6c757d;
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
        
        .warning-note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
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
        
        @media (max-width: 768px) {
            .header-banner {
                padding: 2rem 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header Banner -->
    <div class="header-banner">
        <div class="container">
            <h1 class="display-4"><i class="fas fa-pills"></i> सामान्य रोगका लागि सामान्य औषधिहरू</h1>
            <p class="lead">सामान्य स्वास्थ्य समस्याको उपचारका लागि प्रयोग हुने औषधिहरूको जानकारी</p>
        </div>
    </div>
    
    <div class="container mb-5">
        <!-- Important Note -->
        <div class="alert alert-warning mb-4">
            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> महत्वपूर्ण नोट:</h4>
            <p>यी औषधिहरू सामान्य जानकारीका लागि मात्र हुन्। कुनै पनि औषधि प्रयोग गर्नु अघि आफ्नो डाक्टर वा फार्मासिस्टको सल्लाह लिनुहोस्। आफैंले औषधि प्रयोग गर्नु खतरनाक हुन सक्छ।</p>
        </div>
        
        <!-- Common Diseases Section -->
        <h2 class="section-title mt-5">सामान्य रोगहरू र औषधिहरू</h2>
        
        <div class="row">
            <!-- Fever -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-temperature-high"></i> ज्वरो (Fever)
                        <span class="badge communicable float-end">संक्रामक</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">ज्वरो भाइरल संक्रमण, ब्याक्टेरियल संक्रमण वा अन्य कारणले हुन सक्छ।</p>
                        
                        <h5 class="mt-4 mb-3">सामान्य औषधिहरू:</h5>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">प्यारासिटामोल (Paracetamol)</div>
                            <div class="medicine-dosage">डोज: 500mg प्रति 4-6 घण्टामा (वयस्क)</div>
                            <small class="text-muted">ब्रान्ड नाम: Crocin, Calpol, Metacin</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">आइबुप्रोफेन (Ibuprofen)</div>
                            <div class="medicine-dosage">डोज: 200-400mg प्रति 6-8 घण्टामा (वयस्क)</div>
                            <small class="text-muted">ब्रान्ड नाम: Brufen, Ibugesic</small>
                        </div>
                        
                        <div class="warning-note mt-3">
                            <i class="fas fa-info-circle"></i> <strong>सावधानी:</strong> ज्वरो 3 दिनभन्दा बढी रह्यो भने वा 103°F भन्दा माथि पुग्यो भने डाक्टरको सल्लाह लिनुहोस्।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cold & Cough -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-head-side-cough"></i> रूखो खोकी र चिसो (Cold & Cough)
                        <span class="badge communicable float-end">संक्रामक</span>
                        <span class="badge seasonal float-end mx-1">मौसमी</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">भाइरल संक्रमणले गर्दा हुने सामान्य स्वास्थ्य समस्या।</p>
                        
                        <h5 class="mt-4 mb-3">सामान्य औषधिहरू:</h5>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">सेट्रिजिन (Cetirizine)</div>
                            <div class="medicine-dosage">डोज: 10mg दिनको एक पटक (वयस्क)</div>
                            <small class="text-muted">ब्रान्ड नाम: Cetzine, Alerid</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">एम्ब्रोक्सोल (Ambroxol)</div>
                            <div class="medicine-dosage">डोज: 30mg दिनको 2-3 पटक (वयस्क)</div>
                            <small class="text-muted">ब्रान्ड नाम: Mucolite, Ambrohexal</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">फिनाइलफ्रिन + क्लोरफेनिरामिन (Phenylephrine + Chlorpheniramine)</div>
                            <div class="medicine-dosage">डोज: दिनको 3-4 पटक (नाक बन्द भएमा)</div>
                            <small class="text-muted">ब्रान्ड नाम: Sinarest, Nasoclear</small>
                        </div>
                        
                        <div class="warning-note mt-3">
                            <i class="fas fa-info-circle"></i> <strong>सावधानी:</strong> खोकी 2 हप्ताभन्दा बढी रह्यो भने वा पहेँलो कफ आयो भने डाक्टर देखाउनुहोस्।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Diarrhea -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-toilet"></i> पखाला (Diarrhea)
                        <span class="badge communicable float-end">संक्रामक</span>
                        <span class="badge waterborne float-end mx-1">पानीजन्य</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">असफा खानापानी वा संक्रमणले गर्दा हुने समस्या।</p>
                        
                        <h5 class="mt-4 mb-3">सामान्य औषधिहरू:</h5>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">ओआरएस (Oral Rehydration Solution)</div>
                            <div class="medicine-dosage">डोज: हरेक पखाला पछि 1-2 गिलास</div>
                            <small class="text-muted">तयार पैकेट: Electral, ORS-L</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">जिङ्क (Zinc Sulfate)</div>
                            <div class="medicine-dosage">डोज: 20mg दिनको एक पटक (10-14 दिनसम्म)</div>
                            <small class="text-muted">ब्रान्ड नाम: Zinconia, Zincofast</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">मेट्रोनिडाजोल (Metronidazole)</div>
                            <div class="medicine-dosage">डोज: 400mg दिनको 3 पटक (5-7 दिनसम्म)</div>
                            <small class="text-muted">ब्रान्ड नाम: Flagyl, Metrogyl</small>
                        </div>
                        
                        <div class="warning-note mt-3">
                            <i class="fas fa-info-circle"></i> <strong>सावधानी:</strong> रगत मिसिएको पखाला वा 3 दिनभन्दा बढी रह्यो भने डाक्टर देखाउनुहोस्।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Headache -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-secondary text-white">
                        <i class="fas fa-head-side-virus"></i> टाउको दुख्ने (Headache)
                    </div>
                    <div class="card-body">
                        <p class="card-text">तनाव, निद्राको अभाव वा अन्य कारणले हुने समस्या।</p>
                        
                        <h5 class="mt-4 mb-3">सामान्य औषधिहरू:</h5>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">प्यारासिटामोल (Paracetamol)</div>
                            <div class="medicine-dosage">डोज: 500-1000mg प्रति 4-6 घण्टामा</div>
                            <small class="text-muted">ब्रान्ड नाम: Crocin, Calpol</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">आइबुप्रोफेन (Ibuprofen)</div>
                            <div class="medicine-dosage">डोज: 200-400mg प्रति 6-8 घण्टामा</div>
                            <small class="text-muted">ब्रान्ड नाम: Brufen, Ibugesic</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">डोम्पेरीडोन (Domperidone)</div>
                            <div class="medicine-dosage">डोज: 10mg प्रति 8 घण्टामा (उल्टी साथ भएमा)</div>
                            <small class="text-muted">ब्रान्ड नाम: Domstal, Dompan</small>
                        </div>
                        
                        <div class="warning-note mt-3">
                            <i class="fas fa-info-circle"></i> <strong>सावधानी:</strong> टाउको दुखाइ बारम्बार हुन्छ वा धेरै गम्भीर छ भने डाक्टर देखाउनुहोस्।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gastric Problem -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-warning text-dark">
                        <i class="fas fa-stomach"></i> ग्यास्ट्रिक समस्या (Acidity)
                    </div>
                    <div class="card-body">
                        <p class="card-text">अम्लपित्त, पेट फुल्ने, डकार आउने समस्या।</p>
                        
                        <h5 class="mt-4 mb-3">सामान्य औषधिहरू:</h5>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">रेनिटिडिन (Ranitidine)</div>
                            <div class="medicine-dosage">डोज: 150mg दिनको 1-2 पटक</div>
                            <small class="text-muted">ब्रान्ड नाम: Zinetac, Rantac</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">प्यान्टोप्राजोल (Pantoprazole)</div>
                            <div class="medicine-dosage">डोज: 40mg दिनको एक पटक (बिहान खाली पेट)</div>
                            <small class="text-muted">ब्रान्ड नाम: Pantocid, Pantop</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">डोम्पेरीडोन (Domperidone)</div>
                            <div class="medicine-dosage">डोज: 10mg दिनको 3 पटक</div>
                            <small class="text-muted">ब्रान्ड नाम: Domstal, Dompan</small>
                        </div>
                        
                        <div class="warning-note mt-3">
                            <i class="fas fa-info-circle"></i> <strong>सावधानी:</strong> 2 हप्ताभन्दा बढी लगातार यी औषधिहरू प्रयोग गर्नु हुँदैन।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pain & Inflammation -->
            <div class="col-lg-6">
                <div class="card disease-card">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-bone"></i> दुखाइ र सुन्निने (Pain & Inflammation)
                    </div>
                    <div class="card-body">
                        <p class="card-text">जोर्नी, मांसपेशी वा अन्य शरीरका भागमा हुने दुखाइ।</p>
                        
                        <h5 class="mt-4 mb-3">सामान्य औषधिहरू:</h5>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">आइबुप्रोफेन (Ibuprofen)</div>
                            <div class="medicine-dosage">डोज: 400mg प्रति 8 घण्टामा</div>
                            <small class="text-muted">ब्रान्ड नाम: Brufen, Ibugesic</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">डाइक्लोफेनाक (Diclofenac)</div>
                            <div class="medicine-dosage">डोज: 50mg दिनको 2-3 पटक</div>
                            <small class="text-muted">ब्रान्ड नाम: Voveran, Dicloran</small>
                        </div>
                        
                        <div class="medicine-item">
                            <div class="medicine-name">प्यारासिटामोल (Paracetamol)</div>
                            <div class="medicine-dosage">डोज: 500-1000mg प्रति 6 घण्टामा</div>
                            <small class="text-muted">ब्रान्ड नाम: Crocin, Calpol</small>
                        </div>
                        
                        <div class="warning-note mt-3">
                            <i class="fas fa-info-circle"></i> <strong>सावधानी:</strong> यी औषधिहरू लामो समयसम्म लिनु हुँदैन। दुखाइ बढ्दै गयो भने डाक्टर देखाउनुहोस्।
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- General Medicine Guidelines -->
        <div class="card mt-5 border-primary">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-book-medical"></i> औषधि प्रयोगका सामान्य निर्देशनहरू
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-check-circle text-success"></i> गर्नुपर्ने कामहरू:</h5>
                        <ul>
                            <li>औषधि डाक्टरको सल्लाह अनुसार मात्र प्रयोग गर्नुहोस्</li>
                            <li>औषधिको पूर्ण कोर्स सक्नुहोस् (एन्टिबायोटिक विशेष गरी)</li>
                            <li>औषधि नियमित समयमा लिनुहोस्</li>
                            <li>औषधि सुचारु रूपमा भण्डारण गर्नुहोस्</li>
                            <li>औषधिको एक्सपाइरी मिति जाँच गर्नुहोस्</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-times-circle text-danger"></i> नगर्नुपर्ने कामहरू:</h5>
                        <ul>
                            <li>आफैंले औषधिको डोज बढाउनु वा घटाउनु हुँदैन</li>
                            <li>अरूलाई सिफारिस गरिएको औषधि आफैंले प्रयोग गर्नु हुँदैन</li>
                            <li>औषधि शराबसँग मिसाउनु हुँदैन</li>
                            <li>एकै समयमा धेरै प्रकारका औषधिहरू मिसाउनु हुँदैन</li>
                            <li>औषधिको कोर्स बीचमै छोड्नु हुँदैन</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Emergency Section -->
        <h2 class="section-title mt-5">आपतकालीन सम्पर्क</h2>
        
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-ambulance"></i> आपतकालीन नम्बरहरू
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>एम्बुलेन्स:</strong> 102</li>
                            <li class="list-group-item"><strong>पुलिस:</strong> 100</li>
                            <li class="list-group-item"><strong>आगो नियन्त्रण:</strong> 101</li>
                            <li class="list-group-item"><strong>COVID-19 हेल्पलाइन:</strong> 1115</li>
                            <li class="list-group-item"><strong>महिला हेल्पलाइन:</strong> 1145</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-hospital"></i> प्रमुख अस्पतालहरू
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>त्रिवि शिक्षण अस्पताल:</strong> 01-4412303</li>
                            <li class="list-group-item"><strong>पाटन अस्पताल:</strong> 01-5522295</li>
                            <li class="list-group-item"><strong>भक्तपुर क्यान्सर अस्पताल:</strong> 01-6610666</li>
                            <li class="list-group-item"><strong>बीर अस्पताल:</strong> 01-4435353</li>
                            <li class="list-group-item"><strong>सिविक अस्पताल:</strong> 01-4256090</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('footer.php'); ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>