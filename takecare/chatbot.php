<?php
// Groq API configuration
define('GROQ_API_KEY', '');
define('GROQ_API_URL', 'https://api.groq.com/openai/v1/chat/completions');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Custom Levenshtein function for fuzzy matching
if (!function_exists('levenshtein')) {
    function levenshtein($str1, $str2) {
        $len1 = strlen($str1);
        $len2 = strlen($str2);
        $matrix = array();

        for ($i = 0; $i <= $len1; $i++) {
            $matrix[$i] = array_fill(0, $len2 + 1, 0);
            $matrix[$i][0] = $i;
        }
        for ($j = 0; $j <= $len2; $j++) {
            $matrix[0][$j] = $j;
        }

        for ($i = 1; $i <= $len1; $i++) {
            for ($j = 1; $j <= $len2; $j++) {
                $cost = ($str1[$i - 1] == $str2[$j - 1]) ? 0 : 1;
                $matrix[$i][$j] = min(
                    $matrix[$i - 1][$j] + 1,
                    $matrix[$i][$j - 1] + 1,
                    $matrix[$i - 1][$j - 1] + $cost
                );
            }
        }
        return $matrix[$len1][$len2];
    }
}

// TakeCare Medical Chatbot Class
class TakeCareChatbot {
    private $userQuestion;
    private $emergencyLink = 'http://localhost/takecare/emergency.php';

    public function __construct($question) {
        $this->userQuestion = trim($question);
    }

    public function processQuestion() {
        // Handle greetings first
        $greetingResponse = $this->checkForGreetings($this->userQuestion);
        if ($greetingResponse) {
            return $this->formatResponse($greetingResponse);
        }

        // Handle emergency queries
        $emergencyResponse = $this->checkForEmergency($this->userQuestion);
        if ($emergencyResponse) {
            return $this->formatResponse($emergencyResponse);
        }

        // Handle specific medical queries
        $specificResponse = $this->handleSpecificQueries();
        if ($specificResponse) {
            return $this->formatResponse($specificResponse);
        }

        // Use Groq API for health-related answers
        try {
            $answer = $this->callGroqAPI();
            if (!$answer) {
                $answer = $this->generateFallbackResponse();
            }
        } catch (Exception $e) {
            error_log("Groq API error: " . $e->getMessage());
            $answer = $this->generateFallbackResponse();
        }

        return $this->formatResponse($answer);
    }

    private function formatResponse($answer) {
        $contactInfo = $this->getContactInfo();
        $socialMedia = $this->getSocialMedia();

        $response = $answer;
        
        // Add disclaimer
        $response .= '<div class="medical-disclaimer">';
        $response .= '<p><strong>⚠️ Medical Disclaimer:</strong> This information is for educational purposes only and not a substitute for professional medical advice. Always consult a healthcare provider for medical conditions.</p>';
        $response .= '</div>';
        
        $response .= '<h3>Contact TakeCare</h3>';
        $response .= '<p>For appointments and consultations:</p>';
        $response .= '<ul>';
        $response .= '<li><strong>Address</strong>: ' . htmlspecialchars($contactInfo['address'] ?? 'Medical Complex, Kathmandu') . '</li>';
        $response .= '<li><strong>Email</strong>: <a href="mailto:' . htmlspecialchars($contactInfo['email'] ?? 'info@takecare.com') . '" target="_blank">' . htmlspecialchars($contactInfo['email'] ?? 'info@takecare.com') . '</a></li>';
        $response .= '<li><strong>Emergency Hotline</strong>: <a href="tel:' . htmlspecialchars($contactInfo['emergency'] ?? '+977 9876543210') . '" target="_blank">' . htmlspecialchars($contactInfo['emergency'] ?? '+977 9876543210') . '</a></li>';
        $response .= '<li><strong>Appointment</strong>: <a href="tel:' . htmlspecialchars($contactInfo['phone'] ?? '+977 014567890') . '" target="_blank">' . htmlspecialchars($contactInfo['phone'] ?? '+977 014567890') . '</a></li>';
        $response .= '<li><strong>24/7 Helpline</strong>: <a href="tel:' . htmlspecialchars($contactInfo['helpline'] ?? '+977 9801234567') . '" target="_blank">' . htmlspecialchars($contactInfo['helpline'] ?? '+977 9801234567') . '</a></li>';
        
        if (!empty($contactInfo['whatsapp'])) {
            $response .= '<li><strong>WhatsApp Consultation</strong>: <a href="' . htmlspecialchars($contactInfo['whatsapp']) . '" target="_blank">' . htmlspecialchars($contactInfo['whatsapp']) . '</a></li>';
        }
        
        $response .= '</ul>';
        
        $response .= '<h3>Emergency Services</h3>';
        $response .= '<p>For immediate medical emergencies:</p>';
        $response .= '<ul>';
        $response .= '<li><strong>Emergency Portal</strong>: <a href="' . $this->emergencyLink . '" target="_blank" class="emergency-link">🚨 Click here for Emergency Assistance</a></li>';
        $response .= '<li><strong>Ambulance</strong>: 102</li>';
        $response .= '<li><strong>Police</strong>: 100</li>';
        $response .= '<li><strong>Fire</strong>: 101</li>';
        $response .= '</ul>';
        
        $response .= '<h3>Follow Us</h3>';
        $response .= '<p>Stay updated with health tips:</p>';
        $response .= '<ul>';
        foreach ($socialMedia as $sm) {
            $icon = $this->getSocialMediaIcon($sm['platform']);
            $response .= '<li><a href="' . htmlspecialchars($sm['url']) . '" target="_blank" class="social-link">' . $icon . ' ' . htmlspecialchars($sm['platform']) . '</a></li>';
        }
        $response .= '</ul>';
        $response .= '<p>Powered by <strong>TakeCare Medical Assistance</strong></p>';

        return json_encode([
            'answer' => $response,
            'sources' => ['TakeCare Medical Knowledge Base']
        ]);
    }

    private function getSocialMediaIcon($platform) {
        $icons = [
            'facebook' => '<i class="fab fa-facebook-f"></i>',
            'instagram' => '<i class="fab fa-instagram"></i>',
            'youtube' => '<i class="fab fa-youtube"></i>',
            'linkedin' => '<i class="fab fa-linkedin-in"></i>',
            'whatsapp' => '<i class="fab fa-whatsapp"></i>',
            'twitter' => '<i class="fab fa-twitter"></i>',
            'telegram' => '<i class="fab fa-telegram"></i>'
        ];
        return $icons[strtolower($platform)] ?? '<i class="fas fa-link"></i>';
    }

    private function checkForGreetings($question) {
        $greetings =[
    'namaste' => 'Namaste! Welcome to <strong>TakeCare Medical Assistance</strong>. I’m here to help you understand your symptoms, guide you with safe health information, and assist you on your wellness journey. How can I support you today?',

    'hello' => 'Hello! You’re connected with <strong>TakeCare</strong>—your smart medical companion. Whether you have symptoms, health questions, or need reliable medical guidance, I’m here to assist you step by step. How may I help?',

    'hi' => 'Hi there! <strong>TakeCare</strong> is ready to support your health needs with clear explanations, symptom guidance, and trusted medical information. Tell me what you’re experiencing today.',

    'good morning' => 'Good morning! Wishing you a healthy and energetic start to your day. <strong>TakeCare</strong> is here to provide medical guidance, symptom analysis, and wellness advice whenever you need it. How can I assist this morning?',

    'good afternoon' => 'Good afternoon! Hope your day is going well. <strong>TakeCare</strong> is available to help you understand symptoms, medicines, or any health-related concerns. What would you like to ask?',

    'good evening' => 'Good evening! Your health is important, and <strong>TakeCare</strong> is here to support you with medical answers and safe guidance. Feel free to share any symptoms or questions you have.',

    'bye' => 'Thank you for using <strong>TakeCare Medical Assistance</strong>! Stay healthy, take care of yourself, and feel free to return anytime you need medical guidance or support. Have a great day ahead!',

    'thank you' => 'You’re most welcome! <strong>TakeCare</strong> is always here to help you understand your health better. Let me know if you ever need more assistance.',

    'thanks' => 'Happy to help! Remember, <strong>TakeCare</strong> is available anytime you need medical explanations, symptom support, or wellness tips.',

    'doctor' => 'Hello! You’re connected with <strong>TakeCare Medical Assistant</strong>. I can help answer your health questions, guide you based on your symptoms, and provide safe medical suggestions. What would you like to discuss with the doctor today?'
];


        $questionLower = strtolower($question);
        foreach ($greetings as $keyword => $response) {
            if (strpos($questionLower, $keyword) !== false) {
                return $response;
            }
        }
        return false;
    }

    private function checkForEmergency($question) {
        $emergencyKeywords = ['emergency', 'urgent', 'critical', 'heart attack', 'stroke', 'bleeding', 'unconscious', 'accident', 'severe pain', 'can\'t breathe', 'choking'];
        
        $questionLower = strtolower($question);
        foreach ($emergencyKeywords as $keyword) {
            if (strpos($questionLower, $keyword) !== false) {
                return '<h3>🚨 EMERGENCY ALERT - TakeCare Response</h3>
                        <p><strong>This appears to be a medical emergency!</strong> Please take immediate action:</p>
                        <ol>
                            <li><u>Call Emergency Services</u>: <strong>Dial 102 for ambulance or 100 for police immediately</strong></li>
                            <li><u>Stay Calm</u>: <strong>Keep the patient calm and in a safe position</strong></li>
                            <li><u>Do Not Move</u>: <strong>Do not move the patient if there\'s suspected spinal injury</strong></li>
                            <li><u>Check Breathing</u>: <strong>Ensure the airway is clear and person is breathing</strong></li>
                            <li><u>CPR if needed</u>: <strong>If not breathing, begin CPR (30 chest compressions, 2 breaths)</strong></li>
                        </ol>
                        <p><strong>🚑 Go to Emergency Portal:</strong> <a href="' . $this->emergencyLink . '" target="_blank" class="emergency-link">Click here for immediate emergency assistance</a></p>
                        <p><em>TakeCare recommends seeking professional medical help immediately!</em></p>';
            }
        }
        return false;
    }

    private function extractKeywords($question) {
        $medicalKeywords = [
            'fever', 'headache', 'cold', 'cough', 'pain', 'medicine', 'doctor', 'hospital',
            'symptom', 'treatment', 'diagnosis', 'health', 'medical', 'emergency', 'clinic',
            'pharmacy', 'drug', 'pill', 'tablet', 'injection', 'vaccine', 'covid', 'flu',
            'stomach', 'heart', 'lung', 'liver', 'kidney', 'blood', 'pressure', 'sugar',
            'diabetes', 'asthma', 'arthritis', 'cancer', 'allergy', 'infection', 'virus',
            'bacteria', 'antibiotic', 'paracetamol', 'ibuprofen', 'aspirin', 'vitamin',
            'nutrition', 'diet', 'exercise', 'yoga', 'meditation', 'mental', 'stress',
            'anxiety', 'depression', 'sleep', 'insomnia', 'pregnancy', 'child', 'baby',
            'elderly', 'first aid', 'wound', 'burn', 'fracture', 'sprain', 'dizziness',
            'nausea', 'vomit', 'diarrhea', 'constipation', 'rash', 'itch', 'swelling',
            'temperature', 'chills', 'fatigue', 'weakness', 'weight', 'loss', 'gain',
            'breathing', 'chest', 'back', 'neck', 'shoulder', 'arm', 'leg', 'joint',
            'muscle', 'bone', 'skin', 'eye', 'ear', 'nose', 'throat', 'mouth', 'tooth',
            'dental', 'vision', 'hearing', 'appetite', 'urine', 'stool', 'menstrual',
            'period', 'contraceptive', 'sexual', 'std', 'hiv', 'aids', 'tuberculosis',
            'malaria', 'dengue', 'typhoid', 'cholera', 'hepatitis', 'thyroid', 'pcos',
            'migraine', 'epilepsy', 'parkinson', 'alzheimer', 'autism', 'adhd'
        ];

        $questionLower = strtolower($question);
        $questionWords = preg_split('/\s+/', $questionLower);
        $foundKeywords = [];

        foreach ($questionWords as $word) {
            foreach ($medicalKeywords as $keyword) {
                if (levenshtein($word, $keyword) <= 2 || strpos($keyword, $word) !== false) {
                    $foundKeywords[] = $keyword;
                }
            }
        }

        return array_unique($foundKeywords) ?: [$questionLower];
    }

    private function handleSpecificQueries() {
        $questionLower = strtolower($this->userQuestion);

        // Check for TakeCare related queries
        if (preg_match('/takecare|about takecare|who are you|company info|medical center/i', $questionLower)) {
            return $this->getAboutTakeCare();
        }

        // Medicine queries
        if (preg_match('/medicine|medication|drug|pill|tablet|capsule|syrup|injection/i', $questionLower)) {
            return $this->getMedicineInfo();
        }

        // Symptoms
        if (preg_match('/symptom|sign|feeling|hurts|pain|ache|discomfort/i', $questionLower)) {
            return $this->getSymptomInfo();
        }

        // First Aid
        if (preg_match('/first aid|emergency care|immediate help|accident|injury/i', $questionLower)) {
            return $this->getFirstAidInfo();
        }

        // Health tips
        if (preg_match('/tip|tips|health tip|prevention|prevent|healthy lifestyle/i', $questionLower)) {
            return $this->getHealthTips();
        }

        // Doctor consultation
        if (preg_match('/doctor|consult|appointment|see doctor|when to see doctor/i', $questionLower)) {
            return $this->getDoctorInfo();
        }

        // COVID-19
        if (preg_match('/covid|corona|pandemic|vaccine|quarantine/i', $questionLower)) {
            return $this->getCovidInfo();
        }

        // Mental health
        if (preg_match('/mental|stress|anxiety|depression|therapy|counseling|psychologist/i', $questionLower)) {
            return $this->getMentalHealthInfo();
        }

        // Diet and nutrition
        if (preg_match('/diet|nutrition|food|eat|healthy food|vitamin|mineral/i', $questionLower)) {
            return $this->getDietInfo();
        }

        // Exercise
        if (preg_match('/exercise|workout|yoga|gym|physical activity|fitness/i', $questionLower)) {
            return $this->getExerciseInfo();
        }

        // Common diseases
        if (preg_match('/diabetes|blood pressure|heart disease|asthma|arthritis|cancer/i', $questionLower)) {
            return $this->getDiseaseInfo();
        }

        return false;
    }

    // Get about TakeCare
    private function getAboutTakeCare() {
        return '<p><strong>TakeCare Medical Assistance</strong> is your trusted digital health companion, dedicated to providing reliable medical information and guidance.</p>
                <ol>
                    <li><u>Our Mission</u>: <strong>To make healthcare information accessible and understandable for everyone</strong></li>
                    <li><u>Services</u>: <strong>Medical advice, symptom checking, medicine information, and health tips</strong></li>
                    <li><u>Expertise</u>: <strong>Information curated from reliable medical sources and guidelines</strong></li>
                    <li><u>24/7 Availability</u>: <strong>Always here to answer your health questions</strong></li>
                    <li><u>Privacy</u>: <strong>Your health queries are confidential and secure</strong></li>
                </ol>
                <p><em>Your health is our priority at TakeCare!</em></p>';
    }

    // Get medicine information
    private function getMedicineInfo() {
        $medicines = [
            'Paracetamol' => ['use' => 'Fever and pain relief', 'dose' => '500mg every 4-6 hours', 'caution' => 'Avoid alcohol, max 4g/day'],
            'Ibuprofen' => ['use' => 'Pain, inflammation, fever', 'dose' => '200-400mg every 6-8 hours', 'caution' => 'Take with food, avoid in stomach ulcers'],
            'Amoxicillin' => ['use' => 'Bacterial infections', 'dose' => 'As prescribed by doctor', 'caution' => 'Complete full course, may cause diarrhea'],
            'Cetirizine' => ['use' => 'Allergies, itching', 'dose' => '10mg once daily', 'caution' => 'May cause drowsiness'],
            'Omeprazole' => ['use' => 'Acid reflux, ulcers', 'dose' => '20-40mg daily', 'caution' => 'Take before meals'],
            'Metformin' => ['use' => 'Type 2 diabetes', 'dose' => 'As prescribed', 'caution' => 'Take with meals to reduce GI upset'],
            'Aspirin' => ['use' => 'Pain, fever, blood thinner', 'dose' => '75-325mg as directed', 'caution' => 'Avoid in children, may cause bleeding'],
            'Losartan' => ['use' => 'High blood pressure', 'dose' => '25-100mg daily', 'caution' => 'Monitor blood pressure regularly']
        ];

        $response = '<h3>Your TakeCare Medical Answer</h3>';
        $response .= '<p><strong>Common Medicines Information:</strong></p>';
        $response .= '<ol>';
        
        foreach ($medicines as $name => $details) {
            $response .= "<li><u>{$name}</u>: <strong>Use:</strong> {$details['use']} | <strong>Dose:</strong> {$details['dose']} | <strong>Caution:</strong> {$details['caution']}</li>";
        }
        
        $response .= '</ol>';
        $response .= '<p><strong>⚠️ Important:</strong> Always consult a doctor before taking any medication. Dosage may vary based on age, weight, and medical condition.</p>';
        $response .= '<p><em>TakeCare recommends proper medical consultation for prescriptions!</em></p>';
        
        return $response;
    }

    // Get symptom information
    private function getSymptomInfo() {
        $commonSymptoms = [
            'Fever with chills' => ['possible' => 'Viral infection, Malaria, UTI', 'action' => 'Rest, hydrate, consult if >3 days'],
            'Cough with phlegm' => ['possible' => 'Bronchitis, Pneumonia, COVID', 'action' => 'Steam inhalation, see doctor if breathing difficulty'],
            'Headache with vomiting' => ['possible' => 'Migraine, High BP, Meningitis', 'action' => 'Rest in dark room, emergency if severe'],
            'Chest pain' => ['possible' => 'Heart issue, Acid reflux, Anxiety', 'action' => 'EMERGENCY - seek immediate medical help'],
            'Abdominal pain' => ['possible' => 'Gastritis, Appendicitis, Stones', 'action' => 'Avoid food, consult doctor for persistent pain'],
            'Shortness of breath' => ['possible' => 'Asthma, Heart problem, Anxiety', 'action' => 'Use inhaler if asthmatic, emergency if severe']
        ];

        $response = '<h3>Your TakeCare Medical Answer</h3>';
        $response .= '<p><strong>Common Symptoms Analysis:</strong></p>';
        $response .= '<ol>';
        
        foreach ($commonSymptoms as $symptom => $info) {
            $response .= "<li><u>{$symptom}</u>: <strong>Possible Causes:</strong> {$info['possible']} | <strong>Action:</strong> {$info['action']}</li>";
        }
        
        $response .= '</ol>';
        $response .= '<p><strong>📋 When to See a Doctor:</strong></p>';
        $response .= '<ol>';
        $response .= '<li><u>Emergency symptoms</u>: <strong>Chest pain, difficulty breathing, severe bleeding, unconsciousness</strong></li>';
        $response .= '<li><u>Within 24 hours</u>: <strong>High fever, severe pain, persistent vomiting</strong></li>';
        $response .= '<li><u>Within 3 days</u>: <strong>Mild symptoms not improving, rash, joint pain</strong></li>';
        $response .= '</ol>';
        $response .= '<p><em>TakeCare advises: Never ignore persistent symptoms!</em></p>';
        
        return $response;
    }

    // Get first aid information
    private function getFirstAidInfo() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>Basic First Aid Procedures:</strong></p>
                <ol>
                    <li><u>CPR (Cardiopulmonary Resuscitation)</u>: <strong>30 chest compressions, 2 breaths. Repeat until help arrives</strong></li>
                    <li><u>Bleeding Control</u>: <strong>Apply direct pressure with clean cloth, elevate wound</strong></li>
                    <li><u>Burns</u>: <strong>Cool with running water for 20 mins, cover with sterile dressing</strong></li>
                    <li><u>Fracture</u>: <strong>Immobilize the area, apply ice pack, seek medical help</strong></li>
                    <li><u>Choking</u>: <strong>5 back blows, 5 abdominal thrusts (Heimlich maneuver)</strong></li>
                    <li><u>Sprain</u>: <strong>Rest, Ice, Compression, Elevation (RICE method)</strong></li>
                    <li><u>Fainting</u>: <strong>Lay person flat, elevate legs, loosen tight clothing</strong></li>
                </ol>
                <p><strong>🚨 Emergency Numbers:</strong></p>
                <ol>
                    <li><u>Ambulance</u>: <strong>102</strong></li>
                    <li><u>Police</u>: <strong>100</strong></li>
                    <li><u>Fire</u>: <strong>101</strong></li>
                    <li><u>TakeCare Emergency</u>: <strong><a href="' . $this->emergencyLink . '" target="_blank">Emergency Portal</a></strong></li>
                </ol>
                <p><em>TakeCare recommends first aid training for everyone!</em></p>';
    }

    // Get health tips
    private function getHealthTips() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>Daily Health Tips for Better Living:</strong></p>
                <ol>
                    <li><u>Morning Routine</u>: <strong>Drink 2 glasses of water, 15-min morning walk, healthy breakfast</strong></li>
                    <li><u>Hydration</u>: <strong>Drink 8-10 glasses of water daily, more during exercise</strong></li>
                    <li><u>Sleep</u>: <strong>7-8 hours quality sleep, consistent bedtime</strong></li>
                    <li><u>Nutrition</u>: <strong>Eat colorful vegetables, lean proteins, whole grains</strong></li>
                    <li><u>Exercise</u>: <strong>30 minutes moderate activity, 5 days a week</strong></li>
                    <li><u>Mental Health</u>: <strong>10-min meditation daily, digital detox weekly</strong></li>
                    <li><u>Prevention</u>: <strong>Regular check-ups, vaccinations, sunscreen use</strong></li>
                    <li><u>Hygiene</u>: <strong>Hand washing, dental care twice daily</strong></li>
                </ol>
                <p><strong>🧠 Mental Wellness Tips:</strong></p>
                <ol>
                    <li><u>Stress Management</u>: <strong>Deep breathing exercises, regular breaks</strong></li>
                    <li><u>Social Connection</u>: <strong>Regular contact with friends and family</strong></li>
                    <li><u>Mindfulness</u>: <strong>Practice gratitude journaling daily</strong></li>
                    <li><u>Professional Help</u>: <strong>Seek counseling when needed - it\'s okay!</strong></li>
                </ol>
                <p><em>TakeCare believes: Prevention is better than cure!</em></p>';
    }

    // Get doctor consultation info
    private function getDoctorInfo() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>When to Consult a Doctor:</strong></p>
                <ol>
                    <li><u>Immediate (Go to Emergency)</u>: 
                        <strong>Chest pain, difficulty breathing, severe bleeding, sudden weakness, severe headache, high fever with rash</strong>
                    </li>
                    <li><u>Within 24 Hours</u>: 
                        <strong>High fever (>103°F), persistent vomiting/diarrhea, severe pain, injury with swelling</strong>
                    </li>
                    <li><u>Within 3 Days</u>: 
                        <strong>Cold/cough not improving, mild fever, minor injuries, routine check-ups</strong>
                    </li>
                    <li><u>Regular Check-ups</u>: 
                        <strong>Annual physical, chronic condition monitoring, preventive screenings</strong>
                    </li>
                </ol>
                
                <p><strong>📞 How to Prepare for Doctor Visit:</strong></p>
                <ol>
                    <li><u>Before Visit</u>: <strong>List symptoms, duration, medications, allergies</strong></li>
                    <li><u>During Visit</u>: <strong>Be honest, ask questions, take notes</strong></li>
                    <li><u>After Visit</u>: <strong>Follow instructions, take medications as prescribed</strong></li>
                </ol>
                
                <p><strong>👨‍⚕️ Types of Specialists:</strong></p>
                <ol>
                    <li><u>General Physician</u>: <strong>Primary care, common illnesses</strong></li>
                    <li><u>Cardiologist</u>: <strong>Heart and blood vessels</strong></li>
                    <li><u>Dermatologist</u>: <strong>Skin, hair, nails</strong></li>
                    <li><u>Gynecologist</u>: <strong>Women\'s health</strong></li>
                    <li><u>Pediatrician</u>: <strong>Children\'s health</strong></li>
                    <li><u>Psychiatrist</u>: <strong>Mental health</strong></li>
                </ol>
                
                <p><em>TakeCare reminds: Regular check-ups save lives!</em></p>';
    }

    // Get COVID-19 information
    private function getCovidInfo() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>COVID-19 Prevention and Management:</strong></p>
                <ol>
                    <li><u>Prevention</u>: 
                        <strong>Vaccination, mask in crowded places, hand hygiene, social distancing</strong>
                    </li>
                    <li><u>Symptoms</u>: 
                        <strong>Fever, cough, fatigue, loss of taste/smell, difficulty breathing</strong>
                    </li>
                    <li><u>Home Care (Mild Cases)</u>: 
                        <strong>Isolate, rest, hydrate, monitor oxygen levels, paracetamol for fever</strong>
                    </li>
                    <li><u>Emergency Signs</u>: 
                        <strong>Oxygen saturation <94%, difficulty breathing, chest pain, confusion</strong>
                    </li>
                    <li><u>Vaccination</u>: 
                        <strong>Complete primary series, booster doses as recommended</strong>
                    </li>
                </ol>
                
                <p><strong>🏠 Home Isolation Guidelines:</strong></p>
                <ol>
                    <li><u>Isolation Period</u>: <strong>Minimum 5 days from symptom onset or positive test</strong></li>
                    <li><u>Room</u>: <strong>Separate room, well-ventilated, own bathroom if possible</strong></li>
                    <li><u>Monitoring</u>: <strong>Check temperature, oxygen saturation twice daily</strong></li>
                    <li><u>Hydration</u>: <strong>Drink plenty of fluids - water, soups, juices</strong></li>
                    <li><u>Nutrition</u>: <strong>Balanced diet with proteins and vitamins</strong></li>
                </ol>
                
                <p><em>TakeCare advises: Stay updated with latest health guidelines!</em></p>';
    }

    // Get mental health information
    private function getMentalHealthInfo() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>Mental Health and Well-being:</strong></p>
                <ol>
                    <li><u>Common Conditions</u>: 
                        <strong>Anxiety, Depression, Stress, PTSD, Bipolar disorder, OCD</strong>
                    </li>
                    <li><u>Signs to Watch</u>: 
                        <strong>Persistent sadness, loss of interest, sleep/appetite changes, fatigue, difficulty concentrating</strong>
                    </li>
                    <li><u>Self-Care Strategies</u>: 
                        <strong>Regular exercise, balanced diet, adequate sleep, mindfulness practice</strong>
                    </li>
                    <li><u>Professional Help</u>: 
                        <strong>Therapy, counseling, medication (if prescribed), support groups</strong>
                    </li>
                    <li><u>Crisis Support</u>: 
                        <strong>National helplines, emergency services, trusted friends/family</strong>
                    </li>
                </ol>
                
                <p><strong>🧘‍♀️ Daily Mental Wellness Practices:</strong></p>
                <ol>
                    <li><u>Morning</u>: <strong>5-min gratitude journaling, sunlight exposure</strong></li>
                    <li><u>Afternoon</u>: <strong>Short walk, deep breathing exercises</strong></li>
                    <li><u>Evening</u>: <strong>Digital detox 1 hour before bed, relaxation techniques</strong></li>
                    <li><u>Weekly</u>: <strong>Social activity, hobby time, nature exposure</strong></li>
                </ol>
                
                <p><strong>📞 Mental Health Resources:</strong></p>
                <ol>
                    <li><u>TakeCare Counseling</u>: <strong>Available through our portal</strong></li>
                    <li><u>Emergency</u>: <strong>Suicide prevention hotlines</strong></li>
                    <li><u>Therapy</u>: <strong>Clinical psychologists, psychiatrists</strong></li>
                </ol>
                
                <p><em>TakeCare believes: Mental health is as important as physical health!</em></p>';
    }

    // Get diet information
    private function getDietInfo() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>Healthy Diet and Nutrition Guide:</strong></p>
                <ol>
                    <li><u>Balanced Plate</u>: 
                        <strong>50% vegetables, 25% protein, 25% whole grains</strong>
                    </li>
                    <li><u>Essential Nutrients</u>: 
                        <strong>Proteins, Carbohydrates, Fats, Vitamins, Minerals, Water</strong>
                    </li>
                    <li><u>Portion Control</u>: 
                        <strong>Use smaller plates, listen to hunger cues, avoid second servings</strong>
                    </li>
                    <li><u>Meal Timing</u>: 
                        <strong>Regular intervals, no skipping breakfast, light dinner</strong>
                    </li>
                    <li><u>Hydration</u>: 
                        <strong>8-10 glasses water daily, limit sugary drinks</strong>
                    </li>
                </ol>
                
                <p><strong>🥦 Food Groups Recommendations:</strong></p>
                <ol>
                    <li><u>Fruits & Vegetables</u>: <strong>5 servings daily, variety of colors</strong></li>
                    <li><u>Proteins</u>: <strong>Lean meats, fish, eggs, legumes, nuts</strong></li>
                    <li><u>Grains</u>: <strong>Whole grains over refined, brown rice, whole wheat</strong></li>
                    <li><u>Dairy</u>: <strong>Low-fat options, yogurt, cheese in moderation</strong></li>
                    <li><u>Fats</u>: <strong>Healthy oils (olive, canola), limit saturated fats</strong></li>
                </ol>
                
                <p><strong>⚠️ Foods to Limit:</strong></p>
                <ol>
                    <li><u>Sugar</u>: <strong>Limit added sugars, sweets, sugary drinks</strong></li>
                    <li><u>Salt</u>: <strong>Less than 5g daily, avoid processed foods</strong></li>
                    <li><u>Trans Fats</u>: <strong>Avoid fried foods, baked goods</strong></li>
                    <li><u>Alcohol</u>: <strong>Moderate consumption, if at all</strong></li>
                </ol>
                
                <p><em>TakeCare recommends: Eat well, live well!</em></p>';
    }

    // Get exercise information
    private function getExerciseInfo() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>Physical Activity and Exercise Guide:</strong></p>
                <ol>
                    <li><u>Weekly Recommendation</u>: 
                        <strong>150 minutes moderate or 75 minutes vigorous activity</strong>
                    </li>
                    <li><u>Types of Exercise</u>: 
                        <strong>Aerobic, Strength training, Flexibility, Balance</strong>
                    </li>
                    <li><u>Benefits</u>: 
                        <strong>Weight control, heart health, mood improvement, better sleep</strong>
                    </li>
                    <li><u>Starting Safely</u>: 
                        <strong>Consult doctor if new, start slow, warm-up/cool-down</strong>
                    </li>
                    <li><u>Consistency</u>: 
                        <strong>Regular schedule, find activities you enjoy</strong>
                    </li>
                </ol>
                
                <p><strong>🏃‍♂️ Sample Weekly Exercise Plan:</strong></p>
                <ol>
                    <li><u>Monday</u>: <strong>30 min brisk walking or jogging</strong></li>
                    <li><u>Tuesday</u>: <strong>Strength training (weights/resistance bands)</strong></li>
                    <li><u>Wednesday</u>: <strong>Yoga or stretching exercises</strong></li>
                    <li><u>Thursday</u>: <strong>Cycling or swimming</strong></li>
                    <li><u>Friday</u>: <strong>Strength training</strong></li>
                    <li><u>Saturday</u>: <strong>Active recreation (sports, hiking)</strong></li>
                    <li><u>Sunday</u>: <strong>Rest or gentle walking</strong></li>
                </ol>
                
                <p><strong>⚠️ Exercise Precautions:</strong></p>
                <ol>
                    <li><u>Medical Conditions</u>: <strong>Consult doctor for heart conditions, diabetes, arthritis</strong></li>
                    <li><u>Injury Prevention</u>: <strong>Proper form, appropriate footwear, listen to your body</strong></li>
                    <li><u>Hydration</u>: <strong>Drink water before, during, after exercise</strong></li>
                    <li><u>Weather</u>: <strong>Adjust for heat, cold, pollution</strong></li>
                </ol>
                
                <p><em>TakeCare believes: Movement is medicine!</em></p>';
    }

    // Get disease information
    private function getDiseaseInfo() {
        $diseases = [
            'Diabetes' => [
                'symptoms' => 'Increased thirst, frequent urination, fatigue, blurred vision',
                'management' => 'Blood sugar monitoring, medication, diet control, exercise',
                'prevention' => 'Healthy weight, balanced diet, regular exercise'
            ],
            'Hypertension' => [
                'symptoms' => 'Often none, sometimes headache, dizziness, nosebleeds',
                'management' => 'Regular monitoring, medication, low-salt diet, stress management',
                'prevention' => 'Healthy diet, exercise, weight management, limit alcohol'
            ],
            'Asthma' => [
                'symptoms' => 'Wheezing, shortness of breath, chest tightness, coughing',
                'management' => 'Inhalers, avoid triggers, action plan, regular check-ups',
                'prevention' => 'Identify triggers, flu vaccine, clean environment'
            ],
            'Arthritis' => [
                'symptoms' => 'Joint pain, stiffness, swelling, decreased range of motion',
                'management' => 'Pain relief, physical therapy, joint protection, assistive devices',
                'prevention' => 'Maintain healthy weight, exercise, protect joints'
            ]
        ];

        $response = '<h3>Your TakeCare Medical Answer</h3>';
        $response .= '<p><strong>Common Chronic Diseases Management:</strong></p>';
        
        foreach ($diseases as $name => $info) {
            $response .= "<h4><u>{$name}</u></h4>";
            $response .= '<ol>';
            $response .= "<li><u>Symptoms</u>: <strong>{$info['symptoms']}</strong></li>";
            $response .= "<li><u>Management</u>: <strong>{$info['management']}</strong></li>";
            $response .= "<li><u>Prevention</u>: <strong>{$info['prevention']}</strong></li>";
            $response .= '</ol>';
        }
        
        $response .= '<p><strong>🏥 Regular Monitoring for Chronic Conditions:</strong></p>';
        $response .= '<ol>';
        $response .= '<li><u>Diabetes</u>: <strong>HbA1c every 3-6 months, daily glucose monitoring</strong></li>';
        $response .= '<li><u>Hypertension</u>: <strong>Regular BP checks, annual kidney function tests</strong></li>';
        $response .= '<li><u>Asthma</u>: <strong>Peak flow monitoring, regular lung function tests</strong></li>';
        $response .= '<li><u>Arthritis</u>: <strong>Regular joint assessments, bone density tests</strong></li>';
        $response .= '</ol>';
        
        $response .= '<p><em>TakeCare advises: Regular monitoring and doctor follow-ups are crucial for chronic conditions!</em></p>';
        
        return $response;
    }

    private function getContactInfo() {
        return [
            'address' => 'TakeCare Medical Center, Kathmandu, Nepal',
            'email' => 'info@takecare.com',
            'phone' => '+977 014567890',
            'emergency' => '+977 9876543210',
            'helpline' => '+977 9801234567',
            'whatsapp' => 'https://wa.me/+9779801234567'
        ];
    }

    private function getSocialMedia() {
        return [
            ['platform' => 'Facebook', 'url' => 'https://facebook.com/takecaremedical'],
            ['platform' => 'Instagram', 'url' => 'https://instagram.com/takecare_health'],
            ['platform' => 'YouTube', 'url' => 'https://youtube.com/takecaremedical'],
            ['platform' => 'WhatsApp', 'url' => 'https://wa.me/+9779801234567'],
            ['platform' => 'Telegram', 'url' => 'https://t.me/takecarehealth'],
        ];
    }

    // Call Groq API for AI-generated medical responses
    private function callGroqAPI() {
        $keywords = $this->extractKeywords($this->userQuestion);
        $keywordText = implode(', ', $keywords);

        $prompt = "You are TakeCare Medical Assistance, a professional healthcare AI assistant. Start your response with '<h3>Your TakeCare Medical Answer</h3>'. Then, answer the medical question: '{$this->userQuestion}'

Important Formatting Rules:
- Use ordered lists (1, 2, 3) or lettered lists (a, b, c) for the content
- Use <u> for underline and <strong> for bold for section titles
- Structure your answer based on the type of medical question
- Include relevant keywords: {$keywordText}

Medical Guidelines:
1. For medicine questions: Include medicine name, use, dosage, precautions
2. For symptom questions: Include possible causes, when to see doctor, home care
3. For health tips: Provide practical, evidence-based advice
4. Always include safety warnings and when to seek professional help
5. Mention emergency situations clearly
6. Include preventive measures where applicable

Examples:

Example A (Medicine question):
<h3>Your TakeCare Medical Answer</h3>
<ol>
  <li><u>Medicine Name</u>: <strong>Paracetamol (Acetaminophen)</strong></li>
  <li><u>Primary Use</u>: <strong>Fever and mild to moderate pain relief</strong></li>
  <li><u>Standard Dosage</u>: <strong>500mg every 4-6 hours (max 4g/day)</strong></li>
  <li><u>Precautions</u>: <strong>Avoid alcohol, not for liver patients, consult for children</strong></li>
  <li><u>When to See Doctor</u>: <strong>If fever persists >3 days or pain worsens</strong></li>
</ol>

Example B (Symptom question):
<h3>Your TakeCare Medical Answer</h3>
<ol>
  <li><u>Symptom Analysis</u>: <strong>Possible causes include viral infection, allergy, or bacterial infection</strong></li>
  <li><u>Home Care</u>: <strong>Rest, hydrate, steam inhalation, honey for cough</strong></li>
  <li><u>Medical Attention Needed</u>: <strong>If breathing difficulty, high fever, or symptoms persist >1 week</strong></li>
  <li><u>Prevention</u>: <strong>Hand hygiene, avoid sick contacts, maintain immunity</strong></li>
</ol>

Example C (Health tip question):
<h3>Your TakeCare Medical Answer</h3>
<ol>
  <li><u>Nutrition</u>: <strong>Eat colorful vegetables, lean proteins, whole grains</strong></li>
  <li><u>Exercise</u>: <strong>30 minutes daily, mix cardio and strength training</strong></li>
  <li><u>Sleep</u>: <strong>7-8 hours quality sleep, consistent schedule</strong></li>
  <li><u>Mental Health</u>: <strong>Daily meditation, social connections, stress management</strong></li>
</ol>

EMERGENCY WARNING: If the question involves chest pain, difficulty breathing, severe bleeding, or loss of consciousness, emphasize EMERGENCY and direct to emergency services.

Always include: '⚠️ Important: This is general information. Consult a healthcare professional for personal medical advice.'

Do NOT include contact information in your answer - it will be added separately.
Brand as TakeCare Medical Assistance.";

        $data = [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => 'You are TakeCare Medical Assistance, providing accurate medical information only. You must:
1. Start with: <h3>Your TakeCare Medical Answer</h3>
2. Use ordered lists for content
3. Use <u> for underline and <strong> for bold
4. Include medical safety warnings
5. Specify when to seek professional help
6. Only provide medically accurate information
7. Do not make diagnoses - suggest possible causes
8. Emphasize emergency situations
9. Include preventive measures
10. Remind users this is not a substitute for professional medical advice'],
                ['role' => 'user', 'content' => $prompt]
            ],
            'temperature' => 0.1,
            'max_tokens' => 2048
        ];

        $ch = curl_init(GROQ_API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . GROQ_API_KEY
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($httpCode === 200) {
            $responseData = json_decode($response, true);
            if (isset($responseData['choices'][0]['message']['content'])) {
                return $responseData['choices'][0]['message']['content'];
            }
        }
        error_log("Groq API error: HTTP $httpCode - $error");
        return false;
    }

    // Generate fallback response
    private function generateFallbackResponse() {
        return '<h3>Your TakeCare Medical Answer</h3>
                <p><strong>TakeCare Medical Assistance</strong> is here to help with your health concerns. Based on your question, here\'s general medical advice:</p>
                <ol>
                    <li><u>Consult Professional</u>: <strong>Always consult a healthcare provider for accurate diagnosis</strong></li>
                    <li><u>Medication Safety</u>: <strong>Never self-medicate without professional advice</strong></li>
                    <li><u>Symptom Monitoring</u>: <strong>Keep track of symptoms, duration, and severity</strong></li>
                    <li><u>Emergency Signs</u>: <strong>Seek immediate help for chest pain, breathing difficulty, or severe bleeding</strong></li>
                </ol>
                <p><em>For more specific information, please rephrase your question or contact our medical team!</em></p>';
    }
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $question = $_POST['question'] ?? '';
    if (!empty($question)) {
        $chatbot = new TakeCareChatbot($question);
        echo $chatbot->processQuestion();
    } else {
        echo json_encode([
            'answer' => '<h3>Your TakeCare Medical Answer</h3><p>Please ask a health-related question to get started!</p>',
            'sources' => []
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="TakeCare Medical Chatbot - Your health assistant for medical advice, symptoms, and health tips">
    <meta name="keywords" content="medical, health, doctor, medicine, symptoms, TakeCare, healthcare">
    <meta name="author" content="TakeCare Medical Assistance">
    <title>TakeCare Medical Chatbot - Health Assistant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #FF6B35; /* Orange */
            --secondary-color: #8B4513; /* Onion/Saddle Brown */
            --accent-color: #FFA500; /* Light Orange */
            --light-color: #FFF8F0; /* Cream */
            --dark-color: #5D4037; /* Dark Brown */
            --success-color: #4CAF50; /* Green */
            --danger-color: #F44336; /* Red */
            --warning-color: #FFC107; /* Amber */
            --info-color: #2196F3; /* Blue */
            --gradient-start: #FF6B35;
            --gradient-middle: #FFA500;
            --gradient-end: #8B4513;
            --medical-light: #E8F5E9; /* Light medical green */
            --medical-dark: #2E7D32; /* Dark medical green */
        }

        /* Animated Medical Background */
        body {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-middle), var(--gradient-end));
            background-size: 400% 400%;
            animation: gradientBG 18s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-y: hidden;
            overflow-x: hidden;
            position: relative;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Medical particles animation */
        .medical-particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float linear infinite;
        }

        .particle.plus {
            background: rgba(76, 175, 80, 0.3);
            font-weight: bold;
        }

        .particle.cross {
            background: rgba(244, 67, 54, 0.3);
            transform: rotate(45deg);
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes float {
            to {
                transform: translateY(100vh) rotate(360deg);
            }
        }

        /* Medical Pattern Background */
        .medical-pattern {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 150px;
            z-index: 2;
            opacity: 0.1;
            background-image: 
                repeating-linear-gradient(45deg, var(--medical-dark) 0px, var(--medical-dark) 10px, transparent 10px, transparent 20px),
                repeating-linear-gradient(-45deg, var(--medical-dark) 0px, var(--medical-dark) 10px, transparent 10px, transparent 20px);
        }

        /* Main Chatbot Container */
        .chatbot-container {
            width: 100%;
            max-width: 900px;
            background: rgba(255, 248, 240, 0.95); /* Cream with transparency */
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(139, 69, 19, 0.2);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 85vh;
            position: relative;
            z-index: 10;
            backdrop-filter: blur(5px);
            border: 2px solid var(--primary-color);
        }

        /* Chat Header - Medical Theme */
        .chat-header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px 20px;
            border-bottom: 4px solid var(--accent-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            min-height: 70px;
            box-sizing: border-box;
            position: relative;
        }

        .chat-header::before {
            content: '⚕️';
            position: absolute;
            left: 20px;
            font-size: 1.5rem;
        }

        .header-content {
            flex: 1;
            text-align: center;
            min-width: 0;
        }

        .header-buttons {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        .header-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .chat-header h1 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        /* Chat Messages Area */
        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background: var(--light-color);
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) #e0e0e0;
        }

        .chat-messages::-webkit-scrollbar {
            width: 8px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #e0e0e0;
            border-radius: 4px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        /* Message Styles */
        .message {
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 18px;
            max-width: 85%;
            line-height: 1.5;
            font-size: 1.1rem;
            position: relative;
            animation: fadeIn 0.3s ease-out;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .user-message {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            margin-left: auto;
            border-bottom-right-radius: 5px;
            box-shadow: 0 4px 8px rgba(255, 107, 53, 0.2);
        }

        .bot-message {
            background: linear-gradient(135deg, #E8F5E9, #F1F8E9);
            color: var(--dark-color);
            margin-right: auto;
            border-bottom-left-radius: 5px;
            box-shadow: 0 4px 8px rgba(46, 125, 50, 0.1);
            border-left: 4px solid var(--medical-dark);
        }

        .bot-message h3 {
            font-size: 1.4rem;
            margin-bottom: 10px;
            color: var(--medical-dark);
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bot-message h3::before {
            content: '⚕️';
        }

        .bot-message u {
            text-decoration: underline;
            color: var(--secondary-color);
        }

        .bot-message strong {
            color: var(--primary-color);
            font-weight: 600;
        }

        .bot-message em {
            font-style: italic;
            color: #666;
        }

        .bot-message ol, .bot-message ul {
            margin: 10px 0 10px 20px;
        }

        .bot-message li {
            margin-bottom: 8px;
            padding-left: 5px;
        }

        .bot-message a {
            color: var(--medical-dark);
            text-decoration: none;
            transition: color 0.2s;
            font-weight: 500;
        }

        .bot-message a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        .social-link i {
            margin-right: 5px;
            font-size: 1.1rem;
        }

        .emergency-link {
            color: var(--danger-color) !important;
            font-weight: bold !important;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        .medical-disclaimer {
            background: #FFF3E0;
            border-left: 4px solid var(--warning-color);
            padding: 10px 15px;
            margin: 15px 0;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        /* Suggestions - Medical Theme */
        .suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding: 15px;
            background: #F5F5F5;
            border-top: 1px solid #ddd;
        }

        .suggestion {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 10px 15px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(139, 69, 19, 0.2);
            border: none;
        }

        .suggestion:hover {
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(139, 69, 19, 0.3);
        }

        /* Chat Input */
        .chat-input {
            display: flex;
            padding: 15px;
            background: white;
            border-top: 1px solid #ddd;
            gap: 10px;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 12px 18px;
            border: 2px solid var(--primary-color);
            border-radius: 25px;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .chat-input input:focus {
            border-color: var(--secondary-color);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2), 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .chat-input button {
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #sendButton {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        }

        #sendButton:hover {
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(139, 69, 19, 0.3);
        }

        #sendButton:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        #stopButton {
            background: var(--danger-color);
            display: none;
        }

        #stopButton:hover {
            background: #d32f2f;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(211, 47, 47, 0.3);
        }

        /* Typing Indicator - Medical Theme */
        .typing-indicator {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #E8F5E9;
            border-radius: 18px;
            max-width: 120px;
            margin-right: auto;
            border-bottom-left-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid var(--medical-dark);
        }

        .typing-dot {
            width: 8px;
            height: 8px;
            background: var(--medical-dark);
            border-radius: 50%;
            margin-right: 5px;
            animation: blink 1.4s infinite both;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes blink {
            0%, 20%, 100% { opacity: 0.2; }
            40% { opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Medical Icons */
        .medical-icon {
            display: inline-block;
            width: 24px;
            height: 24px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            margin-right: 8px;
            font-size: 0.8rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .chatbot-container {
                height: 90vh;
                max-width: 100%;
                margin: 0;
                border-radius: 15px;
            }

            .chat-header {
                padding: 12px 15px;
                min-height: 60px;
            }

            .chat-header h1 {
                font-size: 1.2rem;
            }

            .header-btn {
                padding: 6px 10px;
                font-size: 0.8rem;
            }

            .header-btn i {
                margin-right: 0;
            }

            .header-btn span {
                display: none;
            }

            .chat-messages {
                padding: 15px;
            }

            .message {
                max-width: 90%;
                font-size: 1rem;
                padding: 12px;
            }

            .suggestions {
                gap: 8px;
                padding: 12px;
            }

            .suggestion {
                font-size: 0.9rem;
                padding: 8px 12px;
            }

            .chat-input {
                padding: 12px;
            }

            .chat-input input {
                font-size: 0.95rem;
                padding: 10px 15px;
            }

            .chat-input button {
                padding: 10px 16px;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .chatbot-container {
                height: 95vh;
                border-radius: 12px;
            }

            .chat-header {
                padding: 10px;
            }

            .chat-header h1 {
                font-size: 1.1rem;
            }

            .header-btn {
                padding: 5px 8px;
            }

            .message {
                font-size: 0.95rem;
                padding: 10px;
                max-width: 95%;
            }

            .suggestion {
                font-size: 0.85rem;
                padding: 6px 10px;
            }

            .chat-input input {
                font-size: 0.9rem;
                padding: 8px 12px;
            }

            .chat-input button {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Medical Particles Background Animation -->
    <div class="medical-particles" id="medicalParticles"></div>
    
    <!-- Medical Pattern Background -->
    <div class="medical-pattern"></div>

    <div class="chatbot-container">
        <div class="chat-header">
            <div class="header-buttons">
                <button class="header-btn" id="homeButton">
                    <i class="fas fa-home"></i>
                    <span>Home</span>
                </button>
            </div>
            <div class="header-content">
                <h1>⚕️ TakeCare Medical Assistance</h1>
            </div>
            <div class="header-buttons">
                <button class="header-btn" id="clearButton">
                    <i class="fas fa-trash"></i>
                    <span>Clear</span>
                </button>
                <button class="header-btn" id="emergencyButton">
                    <i class="fas fa-ambulance"></i>
                    <span>Emergency</span>
                </button>
            </div>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                <h3>Hello! 👨‍⚕️</h3>
                <p>I'm <strong>TakeCare Medical Assistance</strong>, your digital health companion. I can help with:</p>
                <ol>
                    <li><u>Medical Information</u>: <strong>Medicine details, usage, precautions</strong></li>
                    <li><u>Symptom Analysis</u>: <strong>Possible causes and when to see a doctor</strong></li>
                    <li><u>Health Tips</u>: <strong>Prevention, nutrition, exercise, mental wellness</strong></li>
                    <li><u>First Aid</u>: <strong>Emergency care instructions</strong></li>
                    <li><u>Doctor Consultation</u>: <strong>When and how to seek professional help</strong></li>
                </ol>
                <div class="medical-disclaimer">
                    <p><strong>⚠️ Important:</strong> This is for informational purposes only. Always consult a healthcare professional for medical advice.</p>
                </div>
                <p><em>Ask me anything about health and medicine!</em></p>
            </div>
        </div>
        <div class="suggestions">
            <div class="suggestion" data-question="Tell me about common medicines">Common Medicines</div>
            <div class="suggestion" data-question="headache symptoms and treatment">Headache</div>
            <div class="suggestion" data-question="daily health tips">Health Tips</div>
            <div class="suggestion" data-question="when to see a doctor">Doctor Consultation</div>
        </div>
        <div class="chat-input">
            <input type="text" id="userInput" placeholder="Ask about health, symptoms, or medicines..." autocomplete="off" aria-label="Ask a health-related question">
            <button id="sendButton" aria-label="Send message">
                <i class="fas fa-paper-plane"></i>
                <span>Send</span>
            </button>
            <button id="stopButton" aria-label="Stop response">
                <i class="fas fa-stop-circle"></i>
                <span>Stop</span>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM elements
            const chatMessages = document.getElementById('chatMessages');
            const userInput = document.getElementById('userInput');
            const sendButton = document.getElementById('sendButton');
            const stopButton = document.getElementById('stopButton');
            const suggestions = document.querySelectorAll('.suggestion');
            const homeButton = document.getElementById('homeButton');
            const clearButton = document.getElementById('clearButton');
            const emergencyButton = document.getElementById('emergencyButton');

            // State variables
            let typingInterval = null;
            let currentTypingMessage = null;
            let isGenerating = false;
            let currentResponseText = '';
            let currentResponsePosition = 0;
            let abortController = null;

            // Focus input on load
            userInput.focus();

            // Event listeners
            sendButton.addEventListener('click', sendMessage);
            stopButton.addEventListener('click', stopGenerating);
            homeButton.addEventListener('click', goToHome);
            clearButton.addEventListener('click', clearChat);
            emergencyButton.addEventListener('click', goToEmergency);

            userInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && !isGenerating) {
                    sendMessage();
                }
            });

            suggestions.forEach(suggestion => {
                suggestion.addEventListener('click', function() {
                    if (!isGenerating) {
                        userInput.value = this.getAttribute('data-question');
                        sendMessage();
                    }
                });
            });

            // Create medical particles for background
            function createMedicalParticles() {
                const particlesContainer = document.getElementById('medicalParticles');
                const particleCount = 40;
                
                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    
                    // Random type of particle
                    const types = ['normal', 'plus', 'cross'];
                    const type = types[Math.floor(Math.random() * types.length)];
                    particle.className = `particle ${type}`;
                    
                    // Random size between 3px and 8px
                    const size = Math.random() * 5 + 3;
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    
                    // Random position
                    particle.style.left = `${Math.random() * 100}%`;
                    particle.style.top = `${Math.random() * 100}%`;
                    
                    // Random animation duration between 15s and 25s
                    const duration = Math.random() * 10 + 15;
                    particle.style.animationDuration = `${duration}s`;
                    
                    // Add content for special particles
                    if (type === 'plus') {
                        particle.textContent = '+';
                        particle.style.fontSize = `${size}px`;
                        particle.style.lineHeight = `${size}px`;
                        particle.style.textAlign = 'center';
                    } else if (type === 'cross') {
                        particle.style.background = 'transparent';
                        particle.style.border = `1px solid rgba(244, 67, 54, 0.3)`;
                    }
                    
                    particlesContainer.appendChild(particle);
                }
            }

            // Send message to server
            function sendMessage() {
                const message = userInput.value.trim();
                if (message === '' || isGenerating) return;

                isGenerating = true;
                userInput.disabled = true;
                sendButton.disabled = true;
                stopButton.style.display = 'flex';

                addMessage(message, 'user');
                userInput.value = '';

                // Show typing indicator
                const typingIndicator = document.createElement('div');
                typingIndicator.className = 'typing-indicator';
                typingIndicator.innerHTML = `
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                    <div class="typing-dot"></div>
                `;
                chatMessages.appendChild(typingIndicator);
                scrollToBottom();

                // Create new AbortController for this request
                abortController = new AbortController();

                // Fetch response from server
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'question=' + encodeURIComponent(message),
                    signal: abortController.signal
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (typingIndicator.parentNode) {
                        chatMessages.removeChild(typingIndicator);
                    }
                    currentResponseText = data.answer;
                    currentResponsePosition = 0;
                    typewriterEffect();
                })
                .catch(error => {
                    if (error.name === 'AbortError') {
                        console.log('Fetch aborted');
                        if (typingIndicator.parentNode) {
                            chatMessages.removeChild(typingIndicator);
                        }
                        addMessage('<h3>Your TakeCare Medical Answer</h3><p>Response stopped. You can ask another question.</p>', 'bot');
                    } else {
                        if (typingIndicator.parentNode) {
                            chatMessages.removeChild(typingIndicator);
                        }
                        addMessage('<h3>Your TakeCare Medical Answer</h3><p>Sorry, I encountered an error. Please try again.</p>', 'bot');
                        console.error('Error:', error);
                    }
                    resetInputState();
                });
            }

            // Typewriter effect for bot responses
            function typewriterEffect() {
                if (currentResponsePosition === 0) {
                    // Create new message element
                    const messageElement = document.createElement('div');
                    messageElement.className = 'message bot-message';
                    chatMessages.appendChild(messageElement);
                    currentTypingMessage = messageElement;
                }

                // Add more text to the message
                if (currentResponsePosition < currentResponseText.length) {
                    const chunkSize = 20;
                    const nextPosition = Math.min(currentResponsePosition + chunkSize, currentResponseText.length);
                    
                    const partialText = currentResponseText.substring(0, nextPosition);
                    currentTypingMessage.innerHTML = partialText;
                    
                    currentResponsePosition = nextPosition;
                    
                    const isNearBottom = chatMessages.scrollHeight - chatMessages.scrollTop - chatMessages.clientHeight < 100;
                    if (isNearBottom) {
                        scrollToBottom();
                    }
                    
                    typingInterval = setTimeout(typewriterEffect, 30);
                } else {
                    clearTimeout(typingInterval);
                    typingInterval = null;
                    currentTypingMessage = null;
                    resetInputState();
                }
            }

            // Stop generating response
            function stopGenerating() {
                if (abortController) {
                    abortController.abort();
                }
                
                if (typingInterval) {
                    clearTimeout(typingInterval);
                    typingInterval = null;
                }
                
                if (currentTypingMessage && currentResponseText && currentResponsePosition > 0) {
                    currentTypingMessage.innerHTML = currentResponseText.substring(0, currentResponsePosition);
                }
                
                currentTypingMessage = null;
                resetInputState();
                
                if (currentResponsePosition > 0 && currentResponsePosition < currentResponseText.length) {
                    addMessage('<p><em>Response stopped. You can ask another question.</em></p>', 'bot');
                }
            }

            // Reset input state
            function resetInputState() {
                isGenerating = false;
                userInput.disabled = false;
                sendButton.disabled = false;
                stopButton.style.display = 'none';
                userInput.focus();
                
                currentResponseText = '';
                currentResponsePosition = 0;
                abortController = null;
            }

            // Add message to chat
            function addMessage(text, sender) {
                const messageElement = document.createElement('div');
                messageElement.className = `message ${sender}-message`;
                if (sender === 'user') {
                    messageElement.textContent = text;
                } else {
                    messageElement.innerHTML = text;
                }
                chatMessages.appendChild(messageElement);
                scrollToBottom();
                return messageElement;
            }

            // Scroll to bottom of chat
            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Go to home page
            function goToHome() {
                window.location.href = '../index.php';
            }

            // Go to emergency page
            function goToEmergency() {
                window.open('http://localhost/takecare/emergency.php', '_blank');
            }

            // Clear chat
            function clearChat() {
                if (confirm('Are you sure you want to clear the chat?')) {
                    const welcomeMessage = chatMessages.firstElementChild;
                    chatMessages.innerHTML = '';
                    chatMessages.appendChild(welcomeMessage);
                    scrollToBottom();
                }
            }

            // Initialize medical particles
            createMedicalParticles();

            // Handle window resize for responsiveness
            window.addEventListener('resize', scrollToBottom);

            // Clear input on escape key
            userInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    userInput.value = '';
                    userInput.focus();
                }
            });

            // Auto-suggest based on input
            userInput.addEventListener('input', function() {
                const value = this.value.toLowerCase();
                if (value.includes('emergency') || value.includes('urgent') || value.includes('911')) {
                    emergencyButton.style.animation = 'pulse 1s infinite';
                } else {
                    emergencyButton.style.animation = '';
                }
            });
        });
    </script>
</body>
</html>