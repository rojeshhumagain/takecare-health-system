<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>नेपाल प्रशासनिक फिल्टर</title>
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

    @media (max-width: 768px) {
      body {
        padding-top: 100px; 
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
    }
  </style>
</head>
<body>
  <?php include('header.php'); ?>
  <div class="filter-container">
    <div class="filter-row">
      <div class="form-group">
        <label for="province">प्रदेश</label>
        <select name="province" id="province">
          <option value="0">सबै</option>
          <option value="1">कोशी प्रदेश</option>
          <option value="2">मधेश प्रदेश</option>
          <option value="3">बागमती प्रदेश</option>
          <option value="4">गण्डकी प्रदेश</option>
          <option value="5">लुम्बिनी प्रदेश</option>
          <option value="6">कर्णाली प्रदेश</option>
          <option value="7">सुदूरपश्चिम प्रदेश</option>
        </select>
      </div>
      <div class="form-group">
        <label for="district">जिल्ला</label>
        <select name="district" id="district">
          <option value="0">सबै</option>
        </select>
      </div>
      <div class="form-group">
        <label for="local-level">स्थानीय तह</label>
        <select name="local-level" id="local-level">
          <option value="0">सबै</option>
        </select>
      </div>
    </div>
  </div>

  <script>
   
    const nepalData = {
      1: { 
        name: "कोशी प्रदेश",
        districts: {
          "भोजपुर": [
            "भोजपुर नगरपालिका", // Municipality
            "षडानन्द नगरपालिका", // Municipality
            "ट्याम्केमैयुम गाउँपालिका", // Rural Municipality
            "रामप्रसाद राई गाउँपालिका", // Rural Municipality
            "अरुण गाउँपालिका", // Rural Municipality
            "पौवादुङमा गाउँपालिका", // Rural Municipality
            "साल्पासिलिछो गाउँपालिका", // Rural Municipality
            "आमचोक गाउँपालिका", // Rural Municipality
            "हतुवागढी गाउँपालिका" // Rural Municipality
          ],
          "धनकुटा": [
            "धनकुटा नगरपालिका", // Municipality
            "पाख्रिबास नगरपालिका", // Municipality
            "महालक्ष्मी नगरपालिका", // Municipality
            "साँगुरीगढी गाउँपालिका", // Rural Municipality
            "खाल्सा छिन्ताङ सहीदभूमि गाउँपालिका", // Rural Municipality
            "छथर जोरपाटी गाउँपालिका", // Rural Municipality
            "चौबिसे गाउँपालिका" // Rural Municipality
          ],
          "इलाम": [
            "इलाम नगरपालिका", // Municipality
            "देउमाई नगरपालिका", // Municipality
            "माई नगरपालिका", // Municipality
            "सूर्योदय नगरपालिका", // Municipality
            "फाकफोकथुम गाउँपालिका", // Rural Municipality
            "चुलाचुली गाउँपालिका", // Rural Municipality
            "माईजोगमाई गाउँपालिका", // Rural Municipality
            "माङसेबुङ गाउँपालिका", // Rural Municipality
            "रोङ गाउँपालिका", // Rural Municipality
            "सन्दकपुर गाउँपालिका" // Rural Municipality
          ],
          "झापा": [
            "भद्रपुर नगरपालिका", // Municipality
            "मेचीनगर नगरपालिका", // Municipality
            "दमक नगरपालिका", // Municipality
            "कन्काई नगरपालिका", // Municipality
            "बिर्तामोड नगरपालिका", // Municipality
            "अर्जुनधारा नगरपालिका", // Municipality
            "शिवसताक्षी नगरपालिका", // Municipality
            "गौरादह नगरपालिका", // Municipality
            "झापा गाउँपालिका", // Rural Municipality
            "कमल गाउँपालिका", // Rural Municipality
            "गौरीगञ्ज गाउँपालिका", // Rural Municipality
            "बाह्रदशी गाउँपालिका", // Rural Municipality
            "हल्दिबारी गाउँपालिका", // Rural Municipality
            "बुद्धशान्ति गाउँपालिका", // Rural Municipality
            "कचनकवल गाउँपालिका" // Rural Municipality
          ],
          "खोटाङ": [
            "हलेसी तुवाचुङ नगरपालिका", // Municipality
            "रुपाकोट मझुवागढी नगरपालिका", // Municipality
            "खोटेहाङ गाउँपालिका", // Rural Municipality
            "दिक्तेल गाउँपालिका", // Rural Municipality
            "साकेला गाउँपालिका", // Rural Municipality
            "दिप्रुङ चुइचुम्मा गाउँपालिका", // Rural Municipality
            "ऐंसेलुखर्क गाउँपालिका", // Rural Municipality
            "लामिडाँडा गाउँपालिका", // Rural Municipality
            "जन्तेढुंगा गाउँपालिका", // Rural Municipality
            "बराहपोखरी गाउँपालिका" // Rural Municipality
          ],
          "मोरङ": [
            "विराटनगर महानगरपालिका", // Metropolitan City
            "बेलबारी नगरपालिका", // Municipality
            "लेटाङ नगरपालिका", // Municipality
            "पथरी शनिश्चरे नगरपालिका", // Municipality
            "रंगेली नगरपालिका", // Municipality
            "रतुवामाई नगरपालिका", // Municipality
            "सुनवर्षी नगरपालिका", // Municipality
            "उर्लाबारी नगरपालिका", // Municipality
            "सुन्दरहरैंचा नगरपालिका", // Municipality
            "बुढीगंगा गाउँपालिका", // Rural Municipality
            "धनपालथान गाउँपालिका", // Rural Municipality
            "ग्रामथान गाउँपालिका", // Rural Municipality
            "जाहदा गाउँपालिका", // Rural Municipality
            "कानेपोखरी गाउँपालिका", // Rural Municipality
            "कटहरी गाउँपालिका", // Rural Municipality
            "केरावारी गाउँपालिका", // Rural Municipality
            "मिक्लाजुङ गाउँपालिका" // Rural Municipality
          ],
          "ओखलढुंगा": [
            "सिद्धिचरण नगरपालिका", // Municipality
            "चिशंखुगढी गाउँपालिका", // Rural Municipality
            "खिजिदेम्बा गाउँपालिका", // Rural Municipality
            "चम्पादेवी गाउँपालिका", // Rural Municipality
            "सुनकोशी गाउँपालिका", // Rural Municipality
            "मानेभञ्ज्याङ गाउँपालिका", // Rural Municipality
            "मोलुङ गाउँपालिका", // Rural Municipality
            "लिखु गाउँपालिका" // Rural Municipality
          ],
          "पाँचथर": [
            "फिदिम नगरपालिका", // Municipality
            "फालेलुंग गाउँपालिका", // Rural Municipality
            "फाल्गुनन्द गाउँपालिका", // Rural Municipality
            "हिलिहाङ गाउँपालिका", // Rural Municipality
            "कुम्मायक गाउँपालिका", // Rural Municipality
            "मिक्लाजुङ गाउँपालिका", // Rural Municipality
            "तुम्बेवा गाउँपालिका", // Rural Municipality
            "याङवरक गाउँपालिका" // Rural Municipality
          ],
          "संखुवासभा": [
            "खाँदबारी नगरपालिका", // Municipality
            "चैनपुर नगरपालिका", // Municipality
            "धर्मदेवी नगरपालिका", // Municipality
            "पाँचखपन नगरपालिका", // Municipality
            "मादी नगरपालिका", // Municipality
            "भोटखोला गाउँपालिका", // Rural Municipality
            "चिचिला गाउँपालिका", // Rural Municipality
            "सभापोखरी गाउँपालिका", // Rural Municipality
            "सिलीचोङ गाउँपालिका", // Rural Municipality
            "मकालु गाउँपालिका" // Rural Municipality
          ],
          "सोलुखुम्बु": [
            "सोलुदुधकुण्ड नगरपालिका", // Municipality
            "दुधकोशी गाउँपालिका", // Rural Municipality
            "खुम्बु पासाङल्हामु गाउँपालिका", // Rural Municipality
            "दुधकौशिका गाउँपालिका", // Rural Municipality
            "नेचासल्यान गाउँपालिका", // Rural Municipality
            "महाकुलुङ गाउँपालिका", // Rural Municipality
            "लिखुपिके गाउँपालिका", // Rural Municipality
            "सोताङ गाउँपालिका" // Rural Municipality
          ],
          "सुनसरी": [
            "इटहरी उपमहानगरपालिका", // Sub-Metropolitan City
            "धरान उपमहानगरपालिका", // Sub-Metropolitan City
            "इनरुवा नगरपालिका", // Municipality
            "दुहवी नगरपालिका", // Municipality
            "रामधुनी नगरपालिका", // Municipality
            "बराहक्षेत्र नगरपालिका", // Municipality
            "कोशी गाउँपालिका", // Rural Municipality
            "गढी गाउँपालिका", // Rural Municipality
            "बरजु गाउँपालिका", // Rural Municipality
            "हरिनगर गाउँपालिका", // Rural Municipality
            "देवानगञ्ज गाउँपालिका", // Rural Municipality
            "भोक्राहा नरसिंह गाउँपालिका" // Rural Municipality
          ],
          "ताप्लेजुङ": [
            "फुङलिङ नगरपालिका", // Municipality
            "आठराई त्रिवेणी गाउँपालिका", // Rural Municipality
            "सिरीजङ्घा गाउँपालिका", // Rural Municipality
            "फक्ताङलुङ गाउँपालिका", // Rural Municipality
            "मिक्वाखोला गाउँपालिका", // Rural Municipality
            "मेरिङदेन गाउँपालिका", // Rural Municipality
            "पाथीभरा याङवरक गाउँपालिका", // Rural Municipality
            "सिदिङ्वा गाउँपालिका", // Rural Municipality
            "मैवाखोला गाउँपालिका" // Rural Municipality
          ],
          "तेह्रथुम": [
            "म्याङलुङ नगरपालिका", // Municipality
            "लालिगुराँस नगरपालिका", // Municipality
            "आठराई गाउँपालिका", // Rural Municipality
            "फेदाप गाउँपालिका", // Rural Municipality
            "छथर गाउँपालिका", // Rural Municipality
            "मेन्छयायेम गाउँपालिका" // Rural Municipality
          ],
          "उदयपुर": [
            "त्रियुगा नगरपालिका", // Municipality
            "कटारी नगरपालिका", // Municipality
            "चौदण्डीगढी नगरपालिका", // Municipality
            "बेलका नगरपालिका", // Municipality
            "उदयपुरगढी गाउँपालिका", // Rural Municipality
            "रौतामाई गाउँपालिका", // Rural Municipality
            "लिम्चुङबुङ गाउँपालिका", // Rural Municipality
            "ताप्लि गाउँपालिका" // Rural Municipality
          ]
        }
      },
      2: { // Madhesh Province
        name: "मधेश प्रदेश",
        districts: {
          "बारा": [
            "कलैया उपमहानगरपालिका", // Sub-Metropolitan City
            "जीतपुर सिमरा उपमहानगरपालिका", // Sub-Metropolitan City
            "कोल्हवी नगरपालिका", // Municipality
            "महागढीमाई नगरपालिका", // Municipality
            "सिम्रौनगढ नगरपालिका", // Municipality
            "पचरौता नगरपालिका", // Municipality
            "विश्रामपुर गाउँपालिका", // Rural Municipality
            "प्रसौनी गाउँपालिका", // Rural Municipality
            "आदर्श कोतवाल गाउँपालिका", // Rural Municipality
            "करैयामाई गाउँपालिका", // Rural Municipality
            "परवानीपुर गाउँपालिका", // Rural Municipality
            "फेटा गाउँपालिका", // Rural Municipality
            "बैरिया गाउँपालिका", // Rural Municipality
            "देवताल गाउँपालिका", // Rural Municipality
            "सुवर्ण गाउँपालिका", // Rural Municipality
            "बरागढी गाउँपालिका" // Rural Municipality
          ],
          "धनुषा": [
            "जनकपुरधाम उपमहानगरपालिका", // Sub-Metropolitan City
            "क्षिरेश्वरनाथ नगरपालिका", // Municipality
            "चौरजहारी नगरपालिका", // Municipality
            "गणेशमान चारनाथ नगरपालिका", // Municipality
            "धनुषाधाम नगरपालिका", // Municipality
            "नगराइन नगरपालिका", // Municipality
            "मिथिला नगरपालिका", // Municipality
            "शहीदनगर नगरपालिका", // Municipality
            "सबैला नगरपालिका", // Municipality
            "कमला नगरपालिका", // Municipality
            "मिथिला बिहारी नगरपालिका", // Municipality
            "हंसपुर नगरपालिका", // Municipality
            "जनकनन्दिनी गाउँपालिका", // Rural Municipality
            "बटेश्वर गाउँपालिका", // Rural Municipality
            "मुखियापट्टी मुसहरनिया गाउँपालिका", // Rural Municipality
            "लक्ष्मीनिया गाउँपालिका", // Rural Municipality
            "औरही गाउँपालिका", // Rural Municipality
            "विदेह गाउँपालिका" // Rural Municipality
          ],
          "महोत्तरी": [
            "जलेश्वर नगरपालिका", // Municipality
            "बर्दिबास नगरपालिका", // Municipality
            "गौशाला नगरपालिका", // Municipality
            "लोहरपट्टी नगरपालिका", // Municipality
            "रामगोपालपुर नगरपालिका", // Municipality
            "मनरा सिसवा नगरपालिका", // Municipality
            "मटिहानी नगरपालिका", // Municipality
            "भङ्गहा नगरपालिका", // Municipality
            "बलवा नगरपालिका", // Municipality
            "औरही नगरपालिका", // Municipality
            "पिपरा गाउँपालिका", // Rural Municipality
            "सोनमा गाउँपालिका", // Rural Municipality
            "साम्सी गाउँपालिका", // Rural Municipality
            "एकडारा गाउँपालिका", // Rural Municipality
            "महोत्तरी गाउँपालिका" // Rural Municipality
          ],
          "पर्सा": [
            "बीरगञ्ज महानगरपालिका", // Metropolitan City
            "पोखरिया नगरपालिका", // Municipality
            "बहुदरमाई नगरपालिका", // Municipality
            "पर्सागढी नगरपालिका", // Municipality
            "जगरनाथपुर गाउँपालिका", // Rural Municipality
            "पटेर्वा सुगौली गाउँपालिका", // Rural Municipality
            "सखुवा प्रसौनी गाउँपालिका", // Rural Municipality
            "छिपहरमाई गाउँपालिका", // Rural Municipality
            "बिन्दबासिनी गाउँपालिका", // Rural Municipality
            "धोबीनी गाउँपालिका", // Rural Municipality
            "कालिकामाई गाउँपालिका", // Rural Municipality
            "ठोरी गाउँपालिका", // Rural Municipality
            "जिराभवानी गाउँपालिका", // Rural Municipality
            "पकाहा मैनपुर गाउँपालिका" // Rural Municipality
          ],
          "रौतहट": [
            "चन्द्रपुर नगरपालिका", // Municipality
            "गौर नगरपालिका", // Municipality
            "बृन्दावन नगरपालिका", // Municipality
            "गढीमाई नगरपालिका", // Municipality
            "कटहरिया नगरपालिका", // Municipality
            "माधव नारायण नगरपालिका", // Municipality
            "मौलापुर नगरपालिका", // Municipality
            "परोहा नगरपालिका", // Municipality
            "फतुवा विजयपुर नगरपालिका", // Municipality
            "बौधीमाई नगरपालिका", // Municipality
            "ईशनाथ नगरपालिका", // Municipality
            "राजपुर नगरपालिका", // Municipality
            "देवाही गोनाही नगरपालिका", // Municipality
            "गुजरा नगरपालिका", // Municipality
            "राजदेवी नगरपालिका", // Municipality
            "दुर्गा भगवती गाउँपालिका", // Rural Municipality
            "यमुनामाई गाउँपालिका", // Rural Municipality
            "वृजपुर गाउँपालिका" // Rural Municipality
          ],
          "सप्तरी": [
            "राजविराज नगरपालिका", // Municipality
            "हनुमाननगर कङ्कालिनी नगरपालिका", // Municipality
            "सप्तकोशी नगरपालिका", // Municipality
            "कञ्चनरुप नगरपालिका", // Municipality
            "अग्निसाइर कृष्णसवरन नगरपालिका", // Municipality
            "शम्भुनाथ नगरपालिका", // Municipality
            "खडक नगरपालिका", // Municipality
            "दक्षिणवारी तोलिया नगरपालिका", // Municipality
            "सुरुङ्गा नगरपालिका", // Municipality
            "बेल्ही चपेना गाउँपालिका", // Rural Municipality
            "बिष्णुपुर गाउँपालिका", // Rural Municipality
            "राजगढ गाउँपालिका", // Rural Municipality
            "छिन्नमस्ता गाउँपालिका", // Rural Municipality
            "महादेवा गाउँपालिका", // Rural Municipality
            "तिलाठी कोईलाडी गाउँपालिका", // Rural Municipality
            "रुपनी गाउँपालिका", // Rural Municipality
            "तिरहुत गाउँपालिका", // Rural Municipality
            "बलान बिहुल गाउँपालिका" // Rural Municipality
          ],
          "सर्लाही": [
            "मलङ्गवा नगरपालिका", // Municipality
            "लालबन्दी नगरपालिका", // Municipality
            "हरिवन नगरपालिका", // Municipality
            "बरहथवा नगरपालिका", // Municipality
            "ईश्वरपुर नगरपालिका", // Municipality
            "गोडैटा नगरपालिका", // Municipality
            "ब्रह्मपुरी नगरपालिका", // Municipality
            "कविलासी नगरपालिका", // Municipality
            "चक्रघट्टा नगरपालिका", // Municipality
            "चन्द्रनगर गाउँपालिका", // Rural Municipality
            "धनकौल गाउँपालिका", // Rural Municipality
            "रामनगर गाउँपालिका", // Rural Municipality
            "बलरा गाउँपालिका", // Rural Municipality
            "बसबरिया गाउँपालिका", // Rural Municipality
            "पर्सा गाउँपालिका", // Rural Municipality
            "कौडेना गाउँपालिका", // Rural Municipality
            "बागमती गाउँपालिका", // Rural Municipality
            "बिष्णु गाउँपालिका", // Rural Municipality
            "रामनगर बहुअर्वा गाउँपालिका", // Rural Municipality
            "हरिपुर गाउँपालिका" // Rural Municipality
          ],
          "सिरहा": [
            "लहान नगरपालिका", // Municipality
            "सिरहा नगरपालिका", // Municipality
            "धनगढीमाई नगरपालिका", // Municipality
            "गोलबजार नगरपालिका", // Municipality
            "मिर्चैया नगरपालिका", // Municipality
            "कल्याणपुर नगरपालिका", // Municipality
            "कर्जन्हा नगरपालिका", // Municipality
            "सुखीपुर नगरपालिका", // Municipality
            "सखुवानान्कारकट्टी गाउँपालिका", // Rural Municipality
            "नरहा गाउँपालिका", // Rural Municipality
            "अर्नमा गाउँपालिका", // Rural Municipality
            "नवराजपुर गाउँपालिका", // Rural Municipality
            "लक्ष्मीपुर पतारी गाउँपालिका", // Rural Municipality
            "औरही गाउँपालिका", // Rural Municipality
            "विष्णुपुर गाउँपालिका", // Rural Municipality
            "बरियारपट्टी गाउँपालिका", // Rural Municipality
            "भागलपुर गाउँपालिका" // Rural Municipality
          ]
        }
      },
      3: { // Bagmati Province
        name: "बागमती प्रदेश",
        districts: {
          "भक्तपुर": [
            "भक्तपुर महानगरपालिका", // Metropolitan City
            "चाँगुनारायण नगरपालिका", // Municipality
            "मध्यपुर थिमी नगरपालिका", // Municipality
            "सूर्यविनायक नगरपालिका" // Municipality
          ],
          "चितवन": [
            "भरतपुर महानगरपालिका", // Metropolitan City
            "कालिका नगरपालिका", // Municipality
            "खैरहनी नगरपालिका", // Municipality
            "माडी नगरपालिका", // Municipality
            "रत्ननगर नगरपालिका", // Municipality
            "राप्ती नगरपालिका", // Municipality
            "इच्छाकामना गाउँपालिका" // Rural Municipality
          ],
          "धादिङ": [
            "धादिङबेसी नगरपालिका", // Municipality
            "नीलकण्ठ नगरपालिका", // Municipality
            "खनियाबास गाउँपालिका", // Rural Municipality
            "गजुरी गाउँपालिका", // Rural Municipality
            "गल्छी गाउँपालिका", // Rural Municipality
            "गङ्गाजमुना गाउँपालिका", // Rural Municipality
            "ज्वालामुखी गाउँपालिका", // Rural Municipality
            "थाक्रे गाउँपालिका", // Rural Municipality
            "नेत्रावती डबजोङ गाउँपालिका", // Rural Municipality
            "बेनीघाट रोराङ गाउँपालिका", // Rural Municipality
            "रुबी भ्याली गाउँपालिका", // Rural Municipality
            "सिद्धलेक गाउँपालिका", // Rural Municipality
            "त्रिपुरासुन्दरी गाउँपालिका" // Rural Municipality
          ],
          "दोलखा": [
            "भिमेश्वर नगरपालिका", // Municipality
            "जिरी नगरपालिका", // Municipality
            "कालिन्चोक गाउँपालिका", // Rural Municipality
            "गौरीशङ्कर गाउँपालिका", // Rural Municipality
            "तामाकोशी गाउँपालिका", // Rural Municipality
            "मेलुङ गाउँपालिका", // Rural Municipality
            "वैत्येश्वर गाउँपालिका", // Rural Municipality
            "शैलुङ गाउँपालिका", // Rural Municipality
            "विगु गाउँपालिका" // Rural Municipality
          ],
          "काठमाडौँ": [
            "काठमाडौँ महानगरपालिका", // Metropolitan City
            "बुढानिलकण्ठ नगरपालिका", // Municipality
            "चन्द्रागिरी नगरपालिका", // Municipality
            "गोकर्णेश्वर नगरपालिका", // Municipality
            "कागेश्वरी मनोहरा नगरपालिका", // Municipality
            "कीर्तिपुर नगरपालिका", // Municipality
            "नागार्जुन नगरपालिका", // Municipality
            "शङ्खरापुर नगरपालिका", // Municipality
            "तारकेश्वर नगरपालिका", // Municipality
            "टोखा नगरपालिका", // Municipality
            "दक्षिणकाली नगरपालिका" // Municipality
          ],
          "काभ्रेपलान्चोक": [
            "बनेपा नगरपालिका", // Municipality
            "धुलिखेल नगरपालिका", // Municipality
            "मण्डन देउपुर नगरपालिका", // Municipality
            "नमोबुद्ध नगरपालिका", // Municipality
            "पनौती नगरपालिका", // Municipality
            "पाँचखाल नगरपालिका", // Municipality
            "खानीखोला गाउँपालिका", // Rural Municipality
            "चौरीदेउराली गाउँपालिका", // Rural Municipality
            "तेमाल गाउँपालिका", // Rural Municipality
            "बेथानचोक गाउँपालिका", // Rural Municipality
            "भुम्लु गाउँपालिका", // Rural Municipality
            "महाभारत गाउँपालिका", // Rural Municipality
            "रोशी गाउँपालिका" // Rural Municipality
          ],
          "ललितपुर": [
            "ललितपुर महानगरपालिका", // Metropolitan City
            "गोदावरी नगरपालिका", // Municipality
            "महालक्ष्मी नगरपालिका", // Municipality
            "कोन्ज्योसोम गाउँपालिका", // Rural Municipality
            "बागमती गाउँपालिका", // Rural Municipality
            "महाङ्काल गाउँपालिका" // Rural Municipality
          ],
          "मकवानपुर": [
            "हेटौँडा उपमहानगरपालिका", // Sub-Metropolitan City
            "थाहा नगरपालिका", // Municipality
            "इन्द्रसरोवर गाउँपालिका", // Rural Municipality
            "कैलाश गाउँपालिका", // Rural Municipality
            "बकैया गाउँपालिका", // Rural Municipality
            "बागमती गाउँपालिका", // Rural Municipality
            "भिमफेदी गाउँपालिका", // Rural Municipality
            "मकवानपुरगढी गाउँपालिका", // Rural Municipality
            "मनहरी गाउँपालिका", // Rural Municipality
            "राक्सिराङ गाउँपालिका" // Rural Municipality
          ],
          "नुवाकोट": [
            "बिदुर नगरपालिका", // Municipality
            "बेलकोटगढी नगरपालिका", // Municipality
            "ककनी गाउँपालिका", // Rural Municipality
            "किस्पाङ गाउँपालिका", // Rural Municipality
            "दुप्चेश्वर गाउँपालिका", // Rural Municipality
            "तादी गाउँपालिका", // Rural Municipality
            "पञ्चकन्या गाउँपालिका", // Rural Municipality
            "लिखु गाउँपालिका", // Rural Municipality
            "म्यागङ गाउँपालिका", // Rural Municipality
            "शिवपुरी गाउँपालिका", // Rural Municipality
            "सुर्यगढी गाउँपालिका", // Rural Municipality
            "तारकेश्वर गाउँपालिका" // Rural Municipality
          ],
          "रामेछाप": [
            "मन्थली नगरपालिका", // Municipality
            "रामेछाप नगरपालिका", // Municipality
            "उमाकुण्ड गाउँपालिका", // Rural Municipality
            "खाँडादेवी गाउँपालिका", // Rural Municipality
            "गोकुलगङ्गा गाउँपालिका", // Rural Municipality
            "दोरम्वा शैलुङ गाउँपालिका", // Rural Municipality
            "लिखु तामाकोशी गाउँपालिका" // Rural Municipality
          ],
          "रसुवा": [
            "उत्तरगया गाउँपालिका", // Rural Municipality
            "कालिका गाउँपालिका", // Rural Municipality
            "गोसाइँकुण्ड गाउँपालिका", // Rural Municipality
            "नौकुण्ड गाउँपालिका", // Rural Municipality
            "पार्वतीकुण्ड गाउँपालिका" // Rural Municipality
          ],
          "सिन्धुली": [
            "कमलामाई नगरपालिका", // Municipality
            "दुधौली नगरपालिका", // Municipality
            "गोलन्जोर गाउँपालिका", // Rural Municipality
            "घ्याङलेख गाउँपालिका", // Rural Municipality
            "तीनपाटन गाउँपालिका", // Rural Municipality
            "फिक्कल गाउँपालिका", // Rural Municipality
            "मरिण गाउँपालिका", // Rural Municipality
            "सुनकोशी गाउँपालिका", // Rural Municipality
            "हरिहरपुरगढी गाउँपालिका" // Rural Municipality
          ],
          "सिन्धुपाल्चोक": [
            "चौतारा साँगाचोकगढी नगरपालिका", // Municipality
            "बाह्रबिसे नगरपालिका", // Municipality
            "मेलम्ची नगरपालिका", // Municipality
            "बलेफी गाउँपालिका", // Rural Municipality
            "भोटेकोशी गाउँपालिका", // Rural Municipality
            "हेलम्वु गाउँपालिका", // Rural Municipality
            "इन्द्रावती गाउँपालिका", // Rural Municipality
            "जुगल गाउँपालिका", // Rural Municipality
            "लिसङ्खु पाखर गाउँपालिका", // Rural Municipality
            "पाँचपोखरी थाङपाल गाउँपालिका", // Rural Municipality
            "सुनकोशी गाउँपालिका", // Rural Municipality
            "त्रिपुरासुन्दरी गाउँपालिका" // Rural Municipality
          ]
        }
      },
      4: { // Gandaki Province
        name: "गण्डकी प्रदेश",
        districts: {
          "बागलुङ": [
            "बागलुङ नगरपालिका", // Municipality
            "गल्कोट नगरपालिका", // Municipality
            "जैमिनी नगरपालिका", // Municipality
            "ढोरपाटन नगरपालिका", // Municipality
            "काठेखोला गाउँपालिका", // Rural Municipality
            "तमानखोला गाउँपालिका", // Rural Municipality
            "ताराखोला गाउँपालिका", // Rural Municipality
            "बडिगाड गाउँपालिका", // Rural Municipality
            "निसीखोला गाउँपालिका", // Rural Municipality
            "बरेङ गाउँपालिका" // Rural Municipality
          ],
          "गोरखा": [
            "गोरखा नगरपालिका", // Municipality
            "पालुङटार नगरपालिका", // Municipality
            "सुलीकोट गाउँपालिका", // Rural Municipality
            "सिरानचोक गाउँपालिका", // Rural Municipality
            "आजिरकोट गाउँपालिका", // Rural Municipality
            "चुमनुब्री गाउँपालिका", // Rural Municipality
            "धर्चे गाउँपालिका", // Rural Municipality
            "गण्डकी गाउँपालिका", // Rural Municipality
            "भिमसेनथापा गाउँपालिका", // Rural Municipality
            "शहीद लखन गाउँपालिका", // Rural Municipality
            "आरुघाट गाउँपालिका" // Rural Municipality
          ],
          "कास्की": [
            "पोखरा लेखनाथ महानगरपालिका", // Metropolitan City
            "अन्नपूर्ण गाउँपालिका", // Rural Municipality
            "माछापुच्छ्रे गाउँपालिका", // Rural Municipality
            "मादी गाउँपालिका", // Rural Municipality
            "रुपा गाउँपालिका" // Rural Municipality
          ],
          "लमजुङ": [
            "बेसीशहर नगरपालिका", // Municipality
            "मध्यनेपाल नगरपालिका", // Municipality
            "राइनास नगरपालिका", // Municipality
            "सुन्दरबजार नगरपालिका", // Municipality
            "दोर्दी गाउँपालिका", // Rural Municipality
            "दूधपोखरी गाउँपालिका", // Rural Municipality
            "क्व्होलासोथार गाउँपालिका", // Rural Municipality
            "मर्स्याङ्दी गाउँपालिका" // Rural Municipality
          ],
          "मनाङ": [
            "चामे गाउँपालिका", // Rural Municipality
            "नार्पा भूमि गाउँपालिका", // Rural Municipality
            "नासोङ गाउँपालिका", // Rural Municipality
            "मनाङ डिस्याङ गाउँपालिका" // Rural Municipality
          ],
          "मुस्ताङ": [
            "घरपझोङ गाउँपालिका", // Rural Municipality
            "थासाङ गाउँपालिका", // Rural Municipality
            "लो-घेकर दामोदरकुण्ड गाउँपालिका", // Rural Municipality
            "बारागुङ मुक्तिक्षेत्र गाउँपालिका", // Rural Municipality
            "लोमन्थाङ गाउँपालिका" // Rural Municipality
          ],
          "म्याग्दी": [
            "बेनी नगरपालिका", // Municipality
            "अन्नपूर्ण गाउँपालिका", // Rural Municipality
            "धौलागिरी गाउँपालिका", // Rural Municipality
            "मालिका गाउँपालिका", // Rural Municipality
            "मङ्गला गाउँपालिका", // Rural Municipality
            "रघुगंगा गाउँपालिका" // Rural Municipality
          ],
          "नवलपरासी (बर्दघाट सुस्ता पूर्व)": [
            "कावासोती नगरपालिका", // Municipality
            "गैँडाकोट नगरपालिका", // Municipality
            "मध्यविन्दु नगरपालिका", // Municipality
            "देवचुली नगरपालिका", // Municipality
            "हुप्सेकोट गाउँपालिका", // Rural Municipality
            "विनयी त्रिवेणी गाउँपालिका", // Rural Municipality
            "बुलिङटार गाउँपालिका", // Rural Municipality
            "बौदीकाली गाउँपालिका" // Rural Municipality
          ],
          "पर्वत": [
            "कुश्मा नगरपालिका", // Municipality
            "फलेवास नगरपालिका", // Municipality
            "जलजला गाउँपालिका", // Rural Municipality
            "पैयुँ गाउँपालिका", // Rural Municipality
            "महाशिला गाउँपालिका", // Rural Municipality
            "मोदी गाउँपालिका", // Rural Municipality
            "विहादी गाउँपालिका" // Rural Municipality
          ],
          "स्याङ्जा": [
            "पुतलीबजार नगरपालिका", // Municipality
            "वालिङ नगरपालिका", // Municipality
            "चापाकोट नगरपालिका", // Municipality
            "भैरहवा नगरपालिका", // Municipality
            "भीरकोट नगरपालिका", // Municipality
            "आँधीखोला गाउँपालिका", // Rural Municipality
            "अर्जुन चौपारी गाउँपालिका", // Rural Municipality
            "पहेलो गाउँपालिका", // Rural Municipality
            "बिरुवा गाउँपालिका", // Rural Municipality
            "हरिनास गाउँपालिका", // Rural Municipality
            "कालीगण्डकी गाउँपालिका" // Rural Municipality
          ],
          "तनहुँ": [
            "व्यास नगरपालिका", // Municipality
            "शुक्लागण्डकी नगरपालिका", // Municipality
            "भानु नगरपालिका", // Municipality
            "भिमाद नगरपालिका", // Municipality
            "ऋषिङ गाउँपालिका", // Rural Municipality
            "घिरिङ गाउँपालिका", // Rural Municipality
            "म्याग्दे गाउँपालिका", // Rural Municipality
            "बन्दीपुर गाउँपालिका", // Rural Municipality
            "आँबुखैरेनी गाउँपालिका", // Rural Municipality
            "देवघाट गाउँपालिका" // Rural Municipality
          ]
        }
      },
      5: { // Lumbini Province
        name: "लुम्बिनी प्रदेश",
        districts: {
          "अर्घाखाँची": [
            "सन्धिखर्क नगरपालिका", // Municipality
            "शितगंगा नगरपालिका", // Municipality
            "भूमिकास्थान नगरपालिका", // Municipality
            "छत्रदेव गाउँपालिका", // Rural Municipality
            "पाणिनी गाउँपालिका", // Rural Municipality
            "मालारानी गाउँपालिका" // Rural Municipality
          ],
          "बाँके": [
            "नेपालगञ्ज उपमहानगरपालिका", // Sub-Metropolitan City
            "कोहलपुर नगरपालिका", // Municipality
            "नरैनापुर गाउँपालिका", // Rural Municipality
            "राप्ती सोनारी गाउँपालिका", // Rural Municipality
            "बैजनाथ गाउँपालिका", // Rural Municipality
            "खजुरा गाउँपालिका", // Rural Municipality
            "डुडुवा गाउँपालिका", // Rural Municipality
            "जानकी गाउँपालिका" // Rural Municipality
          ],
          "बर्दिया": [
            "गुलरिया नगरपालिका", // Municipality
            "मधुवन नगरपालिका", // Municipality
            "राजापुर नगरपालिका", // Municipality
            "ठाकुरबाबा नगरपालिका", // Municipality
            "बाँसगढी नगरपालिका", // Municipality
            "बरबर्दिया नगरपालिका", // Municipality
            "बढैयाताल गाउँपालिका", // Rural Municipality
            "गेरुवा गाउँपालिका" // Rural Municipality
          ],
          "दाङ": [
            "घोराही उपमहानगरपालिका", // Sub-Metropolitan City
            "तुलसीपुर उपमहानगरपालिका", // Sub-Metropolitan City
            "लमही नगरपालिका", // Municipality
            "बंगलाचुली गाउँपालिका", // Rural Municipality
            "दंगीशरण गाउँपालिका", // Rural Municipality
            "गढवा गाउँपालिका", // Rural Municipality
            "राजपुर गाउँपालिका", // Rural Municipality
            "राप्ती गाउँपालिका", // Rural Municipality
            "शान्तिनगर गाउँपालिका", // Rural Municipality
            "बबई गाउँपालिका" // Rural Municipality
          ],
          "गुल्मी": [
            "मुसिकोट नगरपालिका", // Municipality
            "रेसुङ्गा नगरपालिका", // Municipality
            "रुरुक्षेत्र गाउँपालिका", // Rural Municipality
            "इस्मा गाउँपालिका", // Rural Municipality
            "कालीगण्डकी गाउँपालिका", // Rural Municipality
            "गुल्मी दरबार गाउँपालिका", // Rural Municipality
            "मदाने गाउँपालिका", // Rural Municipality
            "मालिका गाउँपालिका", // Rural Municipality
            "छत्रकोट गाउँपालिका", // Rural Municipality
            "धुर्कोट गाउँपालिका", // Rural Municipality
            "सत्यवती गाउँपालिका", // Rural Municipality
            "चन्द्रकोट गाउँपालिका" // Rural Municipality
          ],
          "कपिलवस्तु": [
            "कपिलवस्तु नगरपालिका", // Municipality
            "बुद्धभूमि नगरपालिका", // Municipality
            "शिवराज नगरपालिका", // Municipality
            "महाराजगञ्ज नगरपालिका", // Municipality
            "कृष्णनगर नगरपालिका", // Municipality
            "बाणगंगा नगरपालिका", // Municipality
            "मायादेवी गाउँपालिका", // Rural Municipality
            "यसोधरा गाउँपालिका", // Rural Municipality
            "सुद्धोधन गाउँपालिका", // Rural Municipality
            "विजयनगर गाउँपालिका" // Rural Municipality
          ],
          "नवलपरासी (बर्दघाट सुस्ता पश्चिम)": [
            "रामग्राम नगरपालिका", // Municipality
            "सुनवल नगरपालिका", // Municipality
            "बर्दघाट नगरपालिका", // Municipality
            "सुस्ता गाउँपालिका", // Rural Municipality
            "पाल्हीनन्दन गाउँपालिका", // Rural Municipality
            "प्रतापपुर गाउँपालिका", // Rural Municipality
            "सरावल गाउँपालिका" // Rural Municipality
          ],
          "पाल्पा": [
            "तानसेन नगरपालिका", // Municipality
            "रामपुर नगरपालिका", // Municipality
            "रैनादेवी छहरा गाउँपालिका", // Rural Municipality
            "रिब्दिकोट गाउँपालिका", // Rural Municipality
            "पूर्वखोला गाउँपालिका", // Rural Municipality
            "तिनाउ गाउँपालिका", // Rural Municipality
            "निस्दी गाउँपालिका", // Rural Municipality
            "बगनासकाली गाउँपालिका", // Rural Municipality
            "माथागढी गाउँपालिका", // Rural Municipality
            "रम्भा गाउँपालिका" // Rural Municipality
          ],
          "प्युठान": [
            "स्वर्गद्वारी नगरपालिका", // Municipality
            "प्यूठान नगरपालिका", // Municipality
            "गौमुखी गाउँपालिका", // Rural Municipality
            "झिमरुक गाउँपालिका", // Rural Municipality
            "नौवहिनी गाउँपालिका", // Rural Municipality
            "माण्डवी गाउँपालिका", // Rural Municipality
            "मल्लरानी गाउँपालिका", // Rural Municipality
            "ऐरावती गाउँपालिका", // Rural Municipality
            "सरोमार गाउँपालिका" // Rural Municipality
          ],
          "रोल्पा": [
            "रोल्पा नगरपालिका", // Municipality
            "रुन्टीगढी गाउँपालिका", // Rural Municipality
            "त्रिवेणी गाउँपालिका", // Rural Municipality
            "दुबिडाँडा गाउँपालिका", // Rural Municipality
            "माडी गाउँपालिका", // Rural Municipality
            "लुङ्ग्री गाउँपालिका", // Rural Municipality
            "सुकीदह गाउँपालिका", // Rural Municipality
            "सुनिलस्मृति गाउँपालिका", // Rural Municipality
            "थवाङ गाउँपालिका", // Rural Municipality
            "गंगादेव गाउँपालिका" // Rural Municipality
          ],
          "रुपन्देही": [
            "बुटवल उपमहानगरपालिका", // Sub-Metropolitan City
            "सिद्धार्थनगर नगरपालिका", // Municipality
            "तिलोत्तमा नगरपालिका", // Municipality
            "लुम्बिनी सांस्कृतिक नगरपालिका", // Municipality
            "देवदह नगरपालिका", // Municipality
            "शुद्धोधन नगरपालिका", // Municipality
            "गैडहवा गाउँपालिका", // Rural Municipality
            "मायादेवी गाउँपालिका", // Rural Municipality
            "कोटहीमाई गाउँपालिका", // Rural Municipality
            "सियारी गाउँपालिका", // Rural Municipality
            "सम्मरीमाई गाउँपालिका", // Rural Municipality
            "रोहिणी गाउँपालिका", // Rural Municipality
            "मर्चवारी गाउँपालिका", // Rural Municipality
            "सुद्धोधन गाउँपालिका", // Rural Municipality
            "ओमसतिया गाउँपालिका", // Rural Municipality
            "कंचन गाउँपालिका" // Rural Municipality
          ],
          "रुकुम (पूर्व)": [
            "भूमे गाउँपालिका", // Rural Municipality
            "पुथा उत्तरगंगा गाउँपालिका", // Rural Municipality
            "सिस्ने गाउँपालिका" // Rural Municipality
          ]
        }
      },
      6: { // Karnali Province
        name: "कर्णाली प्रदेश",
        districts: {
          "दैलेख": [
            "नारायण नगरपालिका", // Municipality
            "दुल्लु नगरपालिका", // Municipality
            "चामुण्डा बिन्द्रासैनी नगरपालिका", // Municipality
            "आठबीस नगरपालिका", // Municipality
            "भैरवी गाउँपालिका", // Rural Municipality
            "महाबु गाउँपालिका", // Rural Municipality
            "गुराँस गाउँपालिका", // Rural Municipality
            "दुंगेश्वर गाउँपालिका", // Rural Municipality
            "नौमुले गाउँपालिका", // Rural Municipality
            "भगवतीमाई गाउँपालिका", // Rural Municipality
            "ठाँटीकाँध गाउँपालिका" // Rural Municipality
          ],
          "डोल्पा": [
            "ठूली भेरी नगरपालिका", // Municipality
            "त्रिपुरासुन्दरी नगरपालिका", // Municipality
            "डोल्पो बुद्ध गाउँपालिका", // Rural Municipality
            "शे फोक्सुण्डो गाउँपालिका", // Rural Municipality
            "जगदुल्ला गाउँपालिका", // Rural Municipality
            "मुड्केचुला गाउँपालिका", // Rural Municipality
            "काइके गाउँपालिका", // Rural Municipality
            "छार्का ताङसोङ गाउँपालिका" // Rural Municipality
          ],
          "हुम्ला": [
            "सिमकोट गाउँपालिका", // Rural Municipality
            "नाम्खा गाउँपालिका", // Rural Municipality
            "खार्पुनाथ गाउँपालिका", // Rural Municipality
            "सर्केगाड गाउँपालिका", // Rural Municipality
            "चंखेली गाउँपालिका", // Rural Municipality
            "अदानचुली गाउँपालिका", // Rural Municipality
            "ताँजाकोट गाउँपालिका" // Rural Municipality
          ],
          "जाजरकोट": [
            "छेडागाड नगरपालिका", // Municipality
            "भेरी नगरपालिका", // Municipality
            "नलगाड नगरपालिका", // Municipality
            "बारेकोट गाउँपालिका", // Rural Municipality
            "कुसे गाउँपालिका", // Rural Municipality
            "जुनिचाँदे गाउँपालिका", // Rural Municipality
            "शिवालय गाउँपालिका" // Rural Municipality
          ],
          "जुम्ला": [
            "चन्दननाथ नगरपालिका", // Municipality
            "कनकासुन्दरी गाउँपालिका", // Rural Municipality
            "सिंजा गाउँपालिका", // Rural Municipality
            "हिमा गाउँपालिका", // Rural Municipality
            "तिला गाउँपालिका", // Rural Municipality
            "गुठीचौर गाउँपालिका", // Rural Municipality
            "तातोपानी गाउँपालिका", // Rural Municipality
            "पातारासी गाउँपालिका" // Rural Municipality
          ],
          "कालिकोट": [
            "खाँडाचक्र नगरपालिका", // Municipality
            "रास्कोट नगरपालिका", // Municipality
            "तिलागुफा नगरपालिका", // Municipality
            "पचालझरना गाउँपालिका", // Rural Municipality
            "पालता गाउँपालिका", // Rural Municipality
            "नरहरिनाथ गाउँपालिका", // Rural Municipality
            "सान्नी त्रिवेणी गाउँपालिका", // Rural Municipality
            "शुभकालिका गाउँपालिका", // Rural Municipality
            "महावै गाउँपालिका" // Rural Municipality
          ],
          "मुगु": [
            "छायाँनाथ रारा नगरपालिका", // Municipality
            "मुगुम कार्मारोङ गाउँपालिका", // Rural Municipality
            "सोरु गाउँपालिका", // Rural Municipality
            "खत्याड गाउँपालिका" // Rural Municipality
          ],
          "रुकुम (पश्चिम)": [
            "मुसिकोट नगरपालिका", // Municipality
            "चौरजहारी नगरपालिका", // Municipality
            "आठबिसकोट नगरपालिका", // Municipality
            "बाँफिकोट गाउँपालिका", // Rural Municipality
            "त्रिवेणी गाउँपालिका", // Rural Municipality
            "सानी भेरी गाउँपालिका" // Rural Municipality
          ],
          "सल्यान": [
            "शारदा नगरपालिका", // Municipality
            "बागचौर नगरपालिका", // Municipality
            "बनगाड कुपिण्डे नगरपालिका", // Municipality
            "कालीमाटी गाउँपालिका", // Rural Municipality
            "त्रिवेणी गाउँपालिका", // Rural Municipality
            "कपुरकोट गाउँपालिका", // Rural Municipality
            "छत्रेश्वरी गाउँपालिका", // Rural Municipality
            "ढोरचौर गाउँपालिका", // Rural Municipality
            "कुमाख गाउँपालिका", // Rural Municipality
            "दर्मा गाउँपालिका" // Rural Municipality
          ],
          "सुर्खेत": [
            "वीरेन्द्रनगर नगरपालिका", // Municipality
            "गुर्भाकोट नगरपालिका", // Municipality
            "पञ्चपुरी नगरपालिका", // Municipality
            "भेरीगंगा नगरपालिका", // Municipality
            "लेकबेसी नगरपालिका", // Municipality
            "चौकुने गाउँपालिका", // Rural Municipality
            "बराहताल गाउँपालिका", // Rural Municipality
            "चिङ्गाड गाउँपालिका", // Rural Municipality
            "सिम्ता गाउँपालिका" // Rural Municipality
          ]
        }
      },
      7: { // Sudurpashchim Province
        name: "सुदूरपश्चिम प्रदेश",
        districts: {
          "अछाम": [
            "मंगलसेन नगरपालिका", // Municipality
            "कमलबजार नगरपालिका", // Municipality
            "साँफेबगर नगरपालिका", // Municipality
            "पञ्चदेवल विनायक नगरपालिका", // Municipality
            "चौरपाटी गाउँपालिका", // Rural Municipality
            "रामारोशन गाउँपालिका", // Rural Municipality
            "ढकारी गाउँपालिका", // Rural Municipality
            "मेल्लेख गाउँपालिका", // Rural Municipality
            "बान्नीगढी जयगढ गाउँपालिका", // Rural Municipality
            "तुरमाखाँद गाउँपालिका" // Rural Municipality
          ],
          "बैतडी": [
            "दशरथचन्द नगरपालिका", // Municipality
            "पाटन नगरपालिका", // Municipality
            "मेलौली नगरपालिका", // Municipality
            "पुर्चौडी नगरपालिका", // Municipality
            "सुर्नया गाउँपालिका", // Rural Municipality
            "डिलासैनी गाउँपालिका", // Rural Municipality
            "सिगास गाउँपालिका", // Rural Municipality
            "शिवनाथ गाउँपालिका", // Rural Municipality
            "पञ्चेश्वर गाउँपालिका", // Rural Municipality
            "दोगडाकेदार गाउँपालिका" // Rural Municipality
          ],
          "बझाङ": [
            "जयपृथ्वी नगरपालिका", // Municipality
            "बुंगल नगरपालिका", // Municipality
            "तलकोट गाउँपालिका", // Rural Municipality
            "मष्टा गाउँपालिका", // Rural Municipality
            "खप्तडछान्ना गाउँपालिका", // Rural Municipality
            "थलारा गाउँपालिका", // Rural Municipality
            "बित्थडचिर गाउँपालिका", // Rural Municipality
            "छबिसपाथिभेरा गाउँपालिका", // Rural Municipality
            "दुर्गाथली गाउँपालिका", // Rural Municipality
            "केदारस्यु गाउँपालिका", // Rural Municipality
            "सुर्मा गाउँपालिका", // Rural Municipality
            "साइपाल गाउँपालिका" // Rural Municipality
          ],
          "बाजुरा": [
            "बडीमालिका नगरपालिका", // Municipality
            "त्रिवेणी नगरपालिका", // Municipality
            "बुढीगंगा नगरपालिका", // Municipality
            "बुढीनन्दा नगरपालिका", // Municipality
            "गौमुल गाउँपालिका", // Rural Municipality
            "जगन्नाथ गाउँपालिका", // Rural Municipality
            "स्वामीकार्तिक खापर गाउँपालिका", // Rural Municipality
            "खप्तड छेडेदह गाउँपालिका", // Rural Municipality
            "हिमाली गाउँपालिका" // Rural Municipality
          ],
          "डडेलधुरा": [
            "अमरगढी नगरपालिका", // Municipality
            "परशुराम नगरपालिका", // Municipality
            "आलिताल गाउँपालिका", // Rural Municipality
            "भागेश्वर गाउँपालिका", // Rural Municipality
            "नवदुर्गा गाउँपालिका", // Rural Municipality
            "अजयमेरु गाउँपालिका", // Rural Municipality
            "गन्यापधुरा गाउँपालिका" // Rural Municipality
          ],
          "दार्चुला": [
            "महाकाली नगरपालिका", // Municipality
            "शैल्यशिखर नगरपालिका", // Municipality
            "मालिकार्जुन गाउँपालिका", // Rural Municipality
            "अपिहिमाल गाउँपालिका", // Rural Municipality
            "दुहुँ गाउँपालिका", // Rural Municipality
            "नौगाड गाउँपालिका", // Rural Municipality
            "मार्मा गाउँपालिका", // Rural Municipality
            "लेखम गाउँपालिका", // Rural Municipality
            "व्यास गाउँपालिका" // Rural Municipality
          ],
          "डोटी": [
            "दिपायल सिलगढी नगरपालिका", // Municipality
            "शिखर नगरपालिका", // Municipality
            "पुर्वीचौकी गाउँपालिका", // Rural Municipality
            "बडीकेदार गाउँपालिका", // Rural Municipality
            "जोरायल गाउँपालिका", // Rural Municipality
            "सायल गाउँपालिका", // Rural Municipality
            "आदर्श गाउँपालिका", // Rural Municipality
            "के.आई.सिंह गाउँपालिका", // Rural Municipality
            "बोगटान फुड्सिल गाउँपालिका" // Rural Municipality
          ],
          "कैलाली": [
            "धनगढी उपमहानगरपालिका", // Sub-Metropolitan City
            "टिकापुर नगरपालिका", // Municipality
            "घोडाघोडी नगरपालिका", // Municipality
            "लम्कीचुहा नगरपालिका", // Municipality
            "भजनी नगरपालिका", // Municipality
            "गोदावरी नगरपालिका", // Municipality
            "गौरीगंगा नगरपालिका", // Municipality
            "जानकी गाउँपालिका", // Rural Municipality
            "बर्दगोरिया गाउँपालिका", // Rural Municipality
            "मोहन्याल गाउँपालिका", // Rural Municipality
            "कैलारी गाउँपालिका", // Rural Municipality
            "जोशीपुर गाउँपालिका", // Rural Municipality
            "चुरे गाउँपालिका" // Rural Municipality
          ],
          "कञ्चनपुर": [
            "भीमदत्त नगरपालिका", // Municipality
            "पुर्नवास नगरपालिका", // Municipality
            "बेदकोट नगरपालिका", // Municipality
            "महाकाली नगरपालिका", // Municipality
            "शुक्लाफाँटा नगरपालिका", // Municipality
            "बेलौरी नगरपालिका", // Municipality
            "कृष्णपुर नगरपालिका", // Municipality
            "बेलडाँडी गाउँपालिका", // Rural Municipality
            "लालझाडी गाउँपालिका" // Rural Municipality
          ]
        }
      }
    };

    document.addEventListener("DOMContentLoaded", () => {
      const provinceSelect = document.getElementById("province");
      const districtSelect = document.getElementById("district");
      const localLevelSelect = document.getElementById("local-level");

      // Update districts when province changes
      provinceSelect.addEventListener("change", () => {
        const provinceId = provinceSelect.value;
        districtSelect.innerHTML = '<option value="0">सबै</option>';
        localLevelSelect.innerHTML = '<option value="0">सबै</option>';

        if (provinceId !== "0" && nepalData[provinceId]) {
          Object.keys(nepalData[provinceId].districts).forEach(district => {
            const option = document.createElement("option");
            option.value = district;
            option.textContent = district;
            districtSelect.appendChild(option);
          });
        }
      });

      // Update local levels when district changes
      districtSelect.addEventListener("change", () => {
        const provinceId = provinceSelect.value;
        const districtName = districtSelect.value;
        localLevelSelect.innerHTML = '<option value="0">सबै</option>';

        if (provinceId !== "0" && districtName !== "0" && nepalData[provinceId].districts[districtName]) {
          nepalData[provinceId].districts[districtName].forEach(localLevel => {
            const option = document.createElement("option");
            option.value = localLevel;
            option.textContent = localLevel;
            localLevelSelect.appendChild(option);
          });
        }
      });

      // Log selected values for filtering
      localLevelSelect.addEventListener("change", () => {
        const province = provinceSelect.value === "0" ? "सबै" : nepalData[provinceSelect.value].name;
        const district = districtSelect.value === "0" ? "सबै" : districtSelect.value;
        const localLevel = localLevelSelect.value === "0" ? "सबै" : localLevelSelect.value;
        console.log(`चयन गरिएको: प्रदेश=${province}, जिल्ला=${district}, स्थानीय तह=${localLevel}`);
        // Add filtering logic here (e.g., filter a table or map)
      });
    });
  </script>
</body>
</html>