<?php
// Start a secure user session layout
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 86400,
        'cookie_secure'   => isset($_SERVER['HTTPS']),
        'cookie_httponly' => true,
        'use_strict_mode' => true
    ]);
}

// 1. Language Controller Logic
if (isset($_GET['lang'])) {
    $allowed_langs = ['en', 'sw'];
    if (in_array($_GET['lang'], $allowed_langs)) {
        $_SESSION['lang'] = $_GET['lang'];
    }
    // Redirect cleanly to drop the query parameter from URL string
    header("Location: login.php");
    exit;
}

// Default to English if no preference is saved in session
$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// 2. Bilingual Dictionaries Translation Matrix
$lang_dict = [
    'en' => [
        'title' => 'Welcome Back',
        'subtitle' => 'Connect to your account securely',
        'email' => 'Email Address',
        'password' => 'Password',
        'btn_login' => 'Log In',
        'or' => 'OR',
        'btn_google' => 'Continue with Google',
        'toggle_btn' => 'Badilisha Kuja Kiswahili 🇰🇪',
        'toggle_code' => 'sw',
        'placeholder_email' => 'Enter your email',
        'placeholder_pass' => 'Enter your password'
    ],
    'sw' => [
        'title' => 'Karibu Tena',
        'subtitle' => 'Ingia kwenye akaunti yako kwa usalama',
        'email' => 'Anwani ya Barua Pepe',
        'password' => 'Neno siri',
        'btn_login' => 'Ingia Lango',
        'or' => 'AU',
        'btn_google' => 'Endelea na Google',
        'toggle_btn' => 'Switch to English ',
        'toggle_code' => 'en',
        'placeholder_email' => 'Weka barua pepe yako',
        'placeholder_pass' => 'Weka neno siri lako'
    ]
];

$text = $lang_dict[$current_lang];
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $text['title']; ?> - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">
    <div class="back-home-container">
        <a href="index.php" class="back-btn" id="btnBack">← Home</a>
    </div>

    <div class="lang-switcher-container">
        <a href="login.php?lang=<?php echo $text['toggle_code']; ?>" class="btn-lang-toggle">
            <?php echo $text['toggle_btn']; ?>
        </a>
    </div>

    <main class="login-hero-wrapper">
        
        <div class="glass-login-card">
            
            <div class="card-header">
                <h2><?php echo htmlspecialchars($text['title']); ?></h2>
                <p><?php echo htmlspecialchars($text['subtitle']); ?></p>
            </div>

           <form action="auth_process.php" method="POST" class="login-form">
    
    <div class="input-group">
        <label for="email"><?php echo $text['email']; ?></label>
        <input type="email" id="email" name="email" placeholder="<?php echo $text['placeholder_email']; ?>" required>
    </div>

    <div class="input-group">
        <label for="password"><?php echo $text['password'] ?? 'Password'; ?></label>
        <div class="password-field-wrapper">
            <input type="password" id="password" name="password" placeholder="••••••••" required>
            
            <button type="button" id="passwordToggle" class="password-toggle-btn" aria-label="Toggle password visibility">
                <span class="eye-icon">👁️</span>
            </button>
        </div>
    </div>

    <button type="submit" class="btn-submit-auth"><?php echo $text['btn_login']; ?></button>
</form>

            <div class="auth-divider">
                <span><?php echo $text['or']; ?></span>
            </div>

            <div class="oauth-container">
                <a href="google_oauth_redirect.php" class="btn-google-oauth">
                    <svg class="google-icon" viewBox="0 0 24 24" width="20" height="20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                    </svg>
                    <span><?php echo $text['btn_google']; ?></span>
                </a>
            </div>

        </div>
    </main>

    <script src="assets/scripts.js"></script>
</body>
</html>