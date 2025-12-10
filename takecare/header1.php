<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Takecare.com Navbar</title>
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

    .top-bar {
      background-color: var(--dark-blue);
      color: var(--white);
      padding: 1rem 10rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 1.5rem;
      flex-wrap: nowrap;
    }

    .logo {
      font-family: serif;
      font-size: 1.8rem;
      font-weight: bold;
      color: var(--white);
      text-decoration: none;
      flex-shrink: 0;
    }

    .search-container {
      flex-grow: 1;
      display: flex;
      justify-content: center;
      max-width: 500px;
    }

    .search-form {
      display: flex;
      width: 100%;
      border-radius: 25px;
      overflow: hidden;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .search-form input[type="search"] {
      flex-grow: 1;
      padding: 0.75rem 1.25rem;
      border: none;
      font-size: 1rem;
      outline: none;
    }

    .search-form button {
      background: linear-gradient(45deg, var(--purple), #A020F0);
      color: var(--white);
      border: none;
      padding: 0.75rem 1.25rem;
      cursor: pointer;
      font-size: 1rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s ease;
    }

    .search-form button:hover {
      background: linear-gradient(45deg, #A020F0, var(--purple));
    }

    .right-controls {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      flex-shrink: 0;
    }

    .social-icons {
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }

    .social-icons a {
      color: var(--white);
      font-size: 1.2rem;
      transition: color 0.3s ease;
    }

    .social-icons a:hover {
      color: var(--purple);
    }

    .language-selector select {
      padding: 0.4rem 0.7rem;
      border-radius: 20px;
      border: none;
      font-size: 0.9rem;
      cursor: pointer;
    }

    .login-btn {
      background: var(--white);
      color: var(--text-color);
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 25px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .logout-btn {
      background: linear-gradient(45deg, var(--purple), #A020F0);
      color: var(--white);
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 25px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .logout-btn:hover {
      background: linear-gradient(45deg, #A020F0, var(--purple));
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      color: var(--white);
      font-weight: 500;
    }

    .bottom-nav {
      background-color: var(--white);
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: 2rem;
      padding: 1rem 2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.6rem 1.2rem;
      border-radius: 25px;
      background-color: var(--light-gray);
      color: var(--text-color);
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .nav-item:hover {
      background-color: var(--purple);
      color: var(--white);
    }

    

    .nav-item i {
      font-size: 1.1rem;
    }

    @media (max-width: 768px) {
      .top-bar {
        padding: 0.8rem 1rem;
        display: grid;
        grid-template-columns: auto 1fr auto;
        grid-template-rows: auto auto;
        gap: 0.4rem 0.6rem;
        align-items: center;
      }

      .logo {
        grid-column: 1 / 2;
        grid-row: 1 / 2;
        font-size: 1.4rem;
      }

      .login-btn, .logout-btn {
        grid-column: 3 / 4;
        grid-row: 1 / 2;
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
      }

      .user-info {
        grid-column: 1 / 3;
        grid-row: 2 / 3;
        justify-content: flex-end;
      }

      .search-container {
        grid-column: 1 / 3;
        grid-row: 2 / 3;
        max-width: 100%;
      }

      .search-form input[type="search"] {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
      }

      .search-form button {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
      }

      .language-selector {
        grid-column: 3 / 4;
        grid-row: 2 / 3;
        margin-left: 0.4rem;
      }

      .social-icons {
        display: none;
      }

      .right-controls {
        display: contents;
      }

      .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        justify-content: space-around;
        gap: 0;
        padding: 0.4rem 0;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        z-index: 1000;
      }

      .nav-item {
        flex-direction: column;
        gap: 0.2rem;
        padding: 0.4rem 0.3rem;
        font-size: 0.7rem;
        flex: 1;
        text-align: center;
      }

      .nav-item[data-page="about"] {
        display: none;
      }
    }
  </style>
</head>
<body>
  <header>
    <div class="top-bar">
      <a href="#" class="logo">Takecare.com</a>
      <div class="search-container">
        <form class="search-form">
          <input type="search" placeholder="Search health topics, services..." aria-label="Search health topics" />
          <button type="submit" aria-label="Search"><i class="fas fa-search"></i></button>
        </form>
      </div>
      <div class="right-controls">
        <div class="social-icons">
          <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
        </div>
        <div class="language-selector">
          <label for="language-select" class="sr-only">Select Language</label>
          <select id="language-select">
            <option value="en">Eng</option>
            <option value="np">नेपाली</option>
          </select>
        </div>
        <?php if (isset($_SESSION['user'])): ?>
          <div class="user-info">
            <span><?= htmlspecialchars($_SESSION['user']['name']) ?></span>
            <a href="logout.php">
            <button type="button" class="logout-btn" data-translate="nav-logout">Logout</button>
           </a>
          </div>
        <?php else: ?>
          <button class="login-btn">
            <a href="login.php" data-translate="nav-login">Login</a>
          </button>
        <?php endif; ?>
      </div>
    </div>

    <nav class="bottom-nav" aria-label="Main Navigation">
      <a href="index.php" class="nav-item active" data-page="home">
        <i class="fas fa-home"></i>
        <span class="nav-text" data-translate="nav-home">Home</span>
      </a>
      <a href="emergency.php" class="nav-item" data-page="emergency">
        <i class="fas fa-exclamation-triangle"></i>
        <span class="nav-text" data-translate="nav-emergency">Emergency</span>
      </a>
      <a href="services.php" class="nav-item" data-page="services">
        <i class="fas fa-cog"></i>
        <span class="nav-text" data-translate="nav-services">Services</span>
      </a>
      <a href="education.php" class="nav-item" data-page="health">
        <i class="fas fa-heartbeat"></i>
        <span class="nav-text" data-translate="nav-health">Health</span>
      </a>
      <a href="hospitals.php" class="nav-item" data-page="hospitals">
        <i class="fas fa-hospital"></i>
        <span class="nav-text" data-translate="nav-hospitals">Hospitals</span>
      </a>
      <a href="about.php" class="nav-item" data-page="about">
        <i class="fas fa-info-circle"></i>
        <span class="nav-text" data-translate="nav-about">About</span>
      </a>
    </nav>
  </header>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const languageSelect = document.getElementById("language-select");
      if (languageSelect) {
        const savedLang = localStorage.getItem('language') || 'en';
        languageSelect.value = savedLang;

        const updateLanguage = (lang) => {
          const mapping = {
            en: {
              'nav-home': 'Home',
              'nav-emergency': 'Emergency',
              'nav-services': 'Services',
              'nav-health': 'Health',
              'nav-hospitals': 'Hospitals',
              'nav-about': 'About',
              'nav-login': 'Login',
              'nav-logout': 'Logout'
            },
            np: {
              'nav-home': 'गृह',
              'nav-emergency': 'आपतकालीन',
              'nav-services': 'सेवाहरू',
              'nav-health': 'स्वास्थ्य',
              'nav-hospitals': 'अस्पतालहरू',
              'nav-about': 'हाम्रो बारे',
              'nav-login': 'लगइन',
              'nav-logout': 'लगआउट'
            }
          };

          document.querySelectorAll('[data-translate]').forEach(el => {
            const key = el.getAttribute('data-translate');
            if (mapping[lang] && mapping[lang][key]) {
              el.textContent = mapping[lang][key];
            }
          });

          localStorage.setItem('language', lang);

          const languageChangedEvent = new CustomEvent('languageChanged', {
            detail: { language: lang }
          });
          document.dispatchEvent(languageChangedEvent);
        };

        updateLanguage(savedLang);

        languageSelect.addEventListener("change", function () {
          updateLanguage(this.value);
        });
      }

      document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', e => {
          document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
          item.classList.add('active');
        });
      });
    });
  </script>
</body>
</html>