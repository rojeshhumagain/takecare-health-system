<?php include('header1.php'); ?>

<!DOCTYPE html>
<html lang="ne">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>मानसिक स्वास्थ्य - ग्रामीण नेपालका लागि</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --mental-blue: #3498db;
            --mental-green: #27ae60;
            --mental-orange: #f39c12;
            --mental-purple: #9b59b6;
            --mental-red: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            line-height: 1.7;
        }
        
        .header-banner {
            background: linear-gradient(135deg, #5d6d7e, #3498db);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .mental-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 25px;
            border: none;
        }
        
        .mental-card:hover {
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
        
        .common {
            background-color: rgba(52, 152, 219, 0.1);
            color: var(--mental-blue);
            border: 1px solid rgba(52, 152, 219, 0.3);
        }
        
        .severe {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--mental-red);
            border: 1px solid rgba(231, 76, 60, 0.3);
        }
        
        .mood {
            background-color: rgba(155, 89, 182, 0.1);
            color: var(--mental-purple);
            border: 1px solid rgba(155, 89, 182, 0.3);
        }
        
        .anxiety {
            background-color: rgba(243, 156, 18, 0.1);
            color: var(--mental-orange);
            border: 1px solid rgba(243, 156, 18, 0.3);
        }
        
        .symptoms-box {
            background-color: #fef9e7;
            border-left: 4px solid var(--mental-orange);
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
        }
        
        .treatment-box {
            background-color: #eafaf1;
            border-left: 4px solid var(--mental-green);
            padding: 15px;
            border-radius: 4px;
            margin-top: 15px;
        }
        
        .self-help-box {
            background-color: #e8f4fc;
            border-left: 4px solid var(--mental-blue);
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
            background: var(--mental-purple);
            border-radius: 3px;
        }
        
        .rural-specific {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 4px;
            margin-top: 10px;
            font-size: 0.9rem;
        }
        
        .myth-fact {
            border-left: 4px solid #9b59b6;
            padding: 10px;
            margin: 10px 0;
            background-color: #f5eef8;
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
</head>
<body>
    <!-- Header Banner -->
    <div class="header-banner">
        <div class="container">
            <h1 class="display-4"><i class="fas fa-brain"></i> मानसिक स्वास्थ्य</h1>
            <p class="lead">मनको स्वास्थ्य, सबैको लागि जरुरी</p>
        </div>
    </div>
    
    <div class="container mb-5">
        <!-- Introduction -->
        <div class="alert alert-primary mb-4">
            <h4 class="alert-heading"><i class="fas fa-info-circle"></i> मानसिक स्वास्थ्यको महत्व:</h4>
            <p>मानसिक स्वास्थ्य भनेको केवल मानसिक रोग नभएको अवस्था मात्र होइन, तर यो भनेको हाम्रो भावनात्मक, मनोवैज्ञानिक र सामाजिक कल्याणको अवस्था हो। ग्रामीण नेपालमा मानसिक स्वास्थ्यको बारेमा जानकारीको अभाव छ र यसलाई सामाजिक कलंकको रूपमा हेरिन्छ।</p>
        </div>
        
        <!-- Mental Health Disorders Section -->
        <h2 class="section-title mt-5">सामान्य मानसिक स्वास्थ्य समस्याहरू</h2>
        
        <div class="row">
            <!-- Depression -->
            <div class="col-lg-6">
                <div class="card mental-card">
                    <div class="card-header bg-purple text-white" style="background-color: #9b59b6;">
                        <i class="fas fa-cloud"></i> निराशा (डिप्रेसन)
                        <span class="badge mood float-end">मुड डिसअर्डर</span>
                        <span class="badge common float-end mx-1">सामान्य</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">लामो समयसम्म उदास मनको अवस्था जसले दैनिक जीवनमा असर गर्छ। ग्रामीण क्षेत्रमा यसलाई "मन दुख्ने" भनेर चिनिन्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>लामो समयसम्म उदासी वा खालीपन महसुस गर्ने</li>
                                <li>रुचि र आनन्द हराउने</li>
                                <li>निद्रामा समस्या (धेरै सुत्ने वा नसुत्ने)</li>
                                <li>थकान र ऊर्जाको कमी</li>
                                <li>आत्महत्या सम्बन्धी विचार (गम्भीर अवस्थामा)</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>मनोचिकित्सकको परामर्श</li>
                                <li>एन्टिडिप्रेसन्ट औषधि (डाक्टरको सल्लाहमा)</li>
                                <li>कग्निटिभ बिहेभियर थेरापी (CBT)</li>
                                <li>नियमित व्यायाम र ध्यान</li>
                                <li>सामाजिक समर्थन</li>
                            </ul>
                        </div>
                        
                        <div class="self-help-box">
                            <h5><i class="fas fa-hands-helping text-primary"></i> स्वयं सहयोग:</h5>
                            <ul>
                                <li>नियमित दिनचर्या बनाउने</li>
                                <li>साना लक्ष्यहरू सेट गर्ने</li>
                                <li>विश्वसनीय व्यक्तिहरूसँग कुरा गर्ने</li>
                                <li>प्रकृतिमा समय बिताउने</li>
                                <li>राम्रो खानेकुरा खाने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा यसलाई "आलस्य" भनेर गलत बुझिन्छ। यो रोग हो, व्यक्तिको कमजोरी होइन। सामुदायिक सहयोग र जागरूकता जरुरी छ।
                        </div>
                        
                        <div class="myth-fact mt-3">
                            <h6><i class="fas fa-lightbulb"></i> भ्रम vs तथ्य:</h6>
                            <p><strong>भ्रम:</strong> निराशा भनेको आलस्य मात्र हो।<br>
                            <strong>तथ्य:</strong> निराशा एउटा गम्भीर मानसिक रोग हो जसले मस्तिष्कको रसायनिक सन्तुलनलाई प्रभावित गर्छ।</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Anxiety -->
            <div class="col-lg-6">
                <div class="card mental-card">
                    <div class="card-header bg-warning text-dark" style="background-color: #f39c12;">
                        <i class="fas fa-heartbeat"></i> चिन्ता (एन्जाइटी)
                        <span class="badge anxiety float-end">चिन्ता विकार</span>
                        <span class="badge common float-end mx-1">सामान्य</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">अत्यधिक चिन्ता र डरले गर्दा दैनिक जीवन प्रभावित हुने अवस्था। ग्रामीण क्षेत्रमा यसलाई "हृदय घट्ने" भनेर चिनिन्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>अत्यधिक चिन्ता र डर</li>
                                <li>हृदयको धड्कन बढ्ने</li>
                                <li>पसिना आउने</li>
                                <li>हातखुट्टा काँप्ने</li>
                                <li>सास फेर्न गाह्रो हुने</li>
                                <li>निद्रामा समस्या</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>मनोचिकित्सकको परामर्श</li>
                                <li>एन्जाइटी औषधि (डाक्टरको सल्लाहमा)</li>
                                <li>एक्सपोजर थेरापी</li>
                                <li>रिलेक्सेसन तकनीक (श्वास व्यायाम, ध्यान)</li>
                                <li>नियमित व्यायाम</li>
                            </ul>
                        </div>
                        
                        <div class="self-help-box">
                            <h5><i class="fas fa-hands-helping text-primary"></i> स्वयं सहयोग:</h5>
                            <ul>
                                <li>गहिरो श्वास व्यायाम गर्ने (4-7-8 तकनीक)</li>
                                <li>कफी र चिया कम पिउने</li>
                                <li>नियमित समयमा सुत्ने</li>
                                <li>योग र ध्यान गर्ने</li>
                                <li>चिन्ताको कारणहरू लेख्ने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा यसलाई "भूतप्रेत" लागेको भन्ने गरिन्छ। यो एउटा मानसिक समस्या हो, अलौकिक कुरा होइन। स्थानीय स्वास्थ्य कर्मीहरूसँग कुरा गर्नुपर्छ।
                        </div>
                        
                        <div class="myth-fact mt-3">
                            <h6><i class="fas fa-lightbulb"></i> भ्रम vs तथ्य:</h6>
                            <p><strong>भ्रम:</strong> चिन्ता भनेको कमजोर व्यक्तिहरूमा मात्र हुने समस्या हो।<br>
                            <strong>तथ्य:</strong> कुनै पनि व्यक्तिलाई चिन्ता विकार हुन सक्छ, यो व्यक्तिको कमजोरी होइन।</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- PTSD -->
            <div class="col-lg-6">
                <div class="card mental-card">
                    <div class="card-header bg-danger text-white">
                        <i class="fas fa-trauma"></i> आघातपछिको तनाव (PTSD)
                        <span class="badge severe float-end">गम्भीर</span>
                        <span class="badge anxiety float-end mx-1">चिन्ता विकार</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">गम्भीर आघातपछि (जस्तै भूकम्प, हिंसा, दुर्घटना) हुने मानसिक समस्या। नेपालमा भूकम्प र युद्धपीडितहरूमा यो समस्या धेरै छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>आघात सम्बन्धी फ्ल्याशब्याक आउने</li>
                                <li>स्वप्नमा आघात फेरि अनुभव गर्ने</li>
                                <li>आघात सम्बन्धी कुराहरूबाट टाढा रहने</li>
                                <li>नकारात्मक विचारहरू</li>
                                <li>चिढचिढाउने स्वभाव</li>
                                <li>निद्रामा समस्या</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>ट्रामा-फोकस थेरापी</li>
                                <li>EMDR थेरापी</li>
                                <li>मनोचिकित्सकको परामर्श</li>
                                <li>सामुदायिक समर्थन समूह</li>
                                <li>औषधि (डाक्टरको सल्लाहमा)</li>
                            </ul>
                        </div>
                        
                        <div class="self-help-box">
                            <h5><i class="fas fa-hands-helping text-primary"></i> स्वयं सहयोग:</h5>
                            <ul>
                                <li>नियमित दिनचर्या बनाउने</li>
                                <li>विश्वसनीय व्यक्तिहरूसँग आफ्नो अनुभव साट्ने</li>
                                <li>आराम गर्ने तकनीक सिक्ने</li>
                                <li>सकारात्मक गतिविधिहरूमा संलग्न हुने</li>
                                <li>प्रकृतिमा समय बिताउने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा प्राकृतिक प्रकोप धेरै हुन्छ। सामुदायिक स्तरमा मानसिक स्वास्थ्य प्राथमिक उपचार (Psychological First Aid) को जानकारी आवश्यक छ।
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Psychosis -->
            <div class="col-lg-6">
                <div class="card mental-card">
                    <div class="card-header bg-dark text-white">
                        <i class="fas fa-brain"></i> मनोविकार (Psychosis)
                        <span class="badge severe float-end">गम्भीर</span>
                    </div>
                    <div class="card-body">
                        <p class="card-text">वास्तविकता सम्झन नसक्ने गरी मस्तिष्कको कार्यप्रणाली बिग्रिएको अवस्था। ग्रामीण क्षेत्रमा यसलाई "भूत लागेको" भनेर गलत बुझिन्छ।</p>
                        
                        <div class="symptoms-box">
                            <h5><i class="fas fa-exclamation-circle text-warning"></i> लक्षणहरू:</h5>
                            <ul>
                                <li>मिथ्या विश्वास (Delusions)</li>
                                <li>मिथ्या अनुभूति (Hallucinations)</li>
                                <li>अव्यवस्थित विचार र बोली</li>
                                <li>भावनाहरू प्रकट गर्न नसक्ने</li>
                                <li>सामाजिक सम्पर्क टुट्ने</li>
                            </ul>
                        </div>
                        
                        <div class="treatment-box">
                            <h5><i class="fas fa-medkit text-success"></i> उपचार:</h5>
                            <ul>
                                <li>एन्टीसाइकोटिक औषधि</li>
                                <li>मनोचिकित्सकको नियमित परामर्श</li>
                                <li>परिवार थेरापी</li>
                                <li>सामाजिक कौशल्य प्रशिक्षण</li>
                                <li>व्यावसायिक पुनर्वास</li>
                            </ul>
                        </div>
                        
                        <div class="self-help-box">
                            <h5><i class="fas fa-hands-helping text-primary"></i> परिवारले गर्न सक्ने:</h5>
                            <ul>
                                <li>रोगीलाई निन्द्राको लागि प्रोत्साहित गर्ने</li>
                                <li>नियमित खाना र औषधि दिने</li>
                                <li>धैर्य राख्ने</li>
                                <li>रोगीलाई सानो-सानो काम दिने</li>
                                <li>डाक्टरको सम्पर्कमा रहने</li>
                            </ul>
                        </div>
                        
                        <div class="rural-specific">
                            <i class="fas fa-tractor"></i> <strong>ग्रामीण सन्दर्भ:</strong> गाउँहरूमा यस्ता रोगीलाई झारफुक वा धामी-झाँक्रीको चौतारीमा लगिन्छ। यो एउटा मानसिक रोग हो जसको उपचार सम्भव छ। नजिकको अस्पतालमा मनोचिकित्सक वा स्वास्थ्यकर्मीसँग सम्पर्क गर्नुपर्छ।
                        </div>
                        
                        <div class="myth-fact mt-3">
                            <h6><i class="fas fa-lightbulb"></i> भ्रम vs तथ्य:</h6>
                            <p><strong>भ्रम:</strong> मनोविकार भएका व्यक्तिहरू खतरनाक हुन्छन्।<br>
                            <strong>तथ्य:</strong> धेरैजसो मनोविकार भएका व्यक्तिहरू हिंसात्मक हुँदैनन् र उपचार गर्न सकिन्छ।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mental Health Promotion Section -->
        <h2 class="section-title mt-5">मानसिक स्वास्थ्य संवर्धन</h2>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4 border-success">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-heart"></i> सकारात्मक मानसिक स्वास्थ्यका लागि टिप्स
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h6><i class="fas fa-users text-primary"></i> सामाजिक सम्बन्ध:</h6>
                                <p>परिवार र साथीहरूसँग नियमित सम्पर्क राख्नुहोस्। गाउँमा चिया पार्टी वा सामूहिक कार्य गर्ने बानी बनाउनुहोस्।</p>
                            </li>
                            <li class="list-group-item">
                                <h6><i class="fas fa-walking text-info"></i> शारीरिक गतिविधि:</h6>
                                <p>दैनिक 30 मिनेट हिँड्ने, खेतबारी गर्ने वा योग गर्ने। गाउँमा सामूहिक नाचगान पनि मानसिक स्वास्थ्यका लागि राम्रो हो।</p>
                            </li>
                            <li class="list-group-item">
                                <h6><i class="fas fa-utensils text-warning"></i> पौष्टिक आहार:</h6>
                                <p>स्थानीय फलफूल, हरिय सागसब्जी, अन्न र दालहरू समावेश गर्ने। गाउँमा उपलब्ध स्थानीय खाद्यपदार्थहरू पनि पौष्टिक हुन्छन्।</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4 border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-moon"></i> तनाव व्यवस्थापन
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h6><i class="fas fa-bed text-purple"></i> निद्रा स्वच्छता:</h6>
                                <p>दिनको 7-8 घण्टा सुत्ने, नियमित समयमा सुत्ने र उठ्ने। गाउँमा बत्ती नबलेपछि सुत्ने बानी पनि राम्रो हो।</p>
                            </li>
                            <li class="list-group-item">
                                <h6><i class="fas fa-meditation text-success"></i> विश्राम तकनीक:</h6>
                                <p>गहिरो श्वास व्यायाम, ध्यान, वा प्रार्थना गर्ने। गाउँमा प्रकृतिको शान्त वातावरणमा बस्ने।</p>
                            </li>
                            <li class="list-group-item">
                                <h6><i class="fas fa-calendar-check text-danger"></i> समय प्रबन्धन:</h6>
                                <p>दैनिक कार्यहरूको सूची बनाउने, आवश्यक कामहरूलाई प्राथमिकता दिने। गाउँमा पनि दिनचर्या बनाउनु फाइदाजनक हुन्छ।</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mental Health Resources -->
        <h2 class="section-title mt-5">मानसिक स्वास्थ्य सेवाहरू</h2>
        
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-phone-alt"></i> हेल्पलाइन नम्बरहरू
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>राष्ट्रिय मानसिक स्वास्थ्य हेल्पलाइन:</strong> 1660-01-2005</li>
                            <li class="list-group-item"><strong>तनाव व्यवस्थापन हेल्पलाइन:</strong> 1145</li>
                            <li class="list-group-item"><strong>बाल हेल्पलाइन:</strong> 1098</li>
                            <li class="list-group-item"><strong>महिला हेल्पलाइन:</strong> 1145</li>
                            <li class="list-group-item"><strong>सुसाइड प्रिवेन्सन हेल्पलाइन:</strong> 1166</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-warning">
                    <div class="card-header bg-warning text-dark">
                        <i class="fas fa-hospital"></i> मानसिक स्वास्थ्य सेवा केन्द्रहरू
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>त्रिवि शिक्षण अस्पताल (मानसिक स्वास्थ्य विभाग):</strong> काठमाडौं</li>
                            <li class="list-group-item"><strong>पाटन अस्पताल (मनोचिकित्सा विभाग):</strong> ललितपुर</li>
                            <li class="list-group-item"><strong>बीर अस्पताल (मानसिक स्वास्थ्य क्लिनिक):</strong> काठमाडौं</li>
                            <li class="list-group-item"><strong>जिल्ला अस्पतालहरूमा मानसिक स्वास्थ्य सेवा</strong></li>
                            <li class="list-group-item"><strong>सामुदायिक स्वास्थ्य इकाईहरू</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stigma Reduction -->
        <div class="card mt-4 border-danger">
            <div class="card-header bg-danger text-white">
                <i class="fas fa-ban"></i> मानसिक स्वास्थ्य सम्बन्धी कलंक हटाउने उपाय
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5><i class="fas fa-comment"></i> कुरा गर्न सिक्नुहोस्:</h5>
                        <ul>
                            <li>मानसिक स्वास्थ्यको बारेमा खुला रूपमा कुरा गर्ने</li>
                            <li>मानसिक रोग भएका व्यक्तिहरूसँग सहानुभूति राख्ने</li>
                            <li>गलत धारणाहरू सुधार्ने</li>
                            <li>आफ्नो अनुभव साट्ने</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5><i class="fas fa-hands-helping"></i> समर्थन गर्ने तरिका:</h5>
                        <ul>
                            <li>रोगीलाई सुन्ने र बुझ्ने</li>
                            <li>उपचारका लागि प्रोत्साहित गर्ने</li>
                            <li>नजिकको स्वास्थ्य केन्द्रसम्म साथ दिने</li>
                            <li>परिवार र समुदायलाई जागरूक गर्ने</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

   <?php
   include 'footer.php';
   ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>