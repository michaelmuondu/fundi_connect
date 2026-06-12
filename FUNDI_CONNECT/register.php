<?php
session_start();
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'sw' ? 'sw' : 'en';
}
$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// Define translations directly based on the current language
if ($current_lang === 'sw') {
    $text = [
        'back_home'    => '← Nyumbani',
        'lang_toggle'  => 'English',
        'next_lang'    => 'en',
        'title'        => 'Fungua Akaunti',
        'subtitle'     => 'Unganishwa na wataalamu wa ndani haraka na salama.',
        'lbl_name'     => 'Majina Kamili',
        'lbl_email'    => 'Anwani ya Barua Pepe',
        'lbl_pass'     => 'Nenosiri',
        'btn_submit'   => 'Sajili',
        'footer_text'  => 'Tayari una akaunti? ',
        'footer_link'  => 'Ingia hapa'
    ];
} else {
    $text = [
        'back_home'    => '← Home',
        'lang_toggle'  => 'Kiswahili',
        'next_lang'    => 'sw',
        'title'        => 'Create Account',
        'subtitle'     => 'Connect with local experts quickly and securely.',
        'lbl_name'     => 'Full Name',
        'lbl_email'    => 'Email Address',
        'lbl_pass'     => 'Password',
        'btn_submit'   => 'Register',
        'footer_text'  => 'Already have an account? ',
        'footer_link'  => 'Login'
    ];
}
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundi Connect - <?php echo $text['title']; ?></title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>

    <div class="back-home-container">
        <a href="index.php" class="back-btn" id="btnBack"><?php echo $text['back_home']; ?></a>
    </div>

    <!-- FIXED: Button changed to a dynamic link that reloads the page with the target language -->
    <div class="lang-switcher-container">
        <a href="register.php?lang=<?php echo $text['next_lang']; ?>" class="btn-lang-toggle" id="langBtn" style="text-decoration: none; display: inline-block; text-align: center;">
            🌐 <?php echo $text['lang_toggle']; ?>
        </a>
    </div>

    <div class="login-hero-wrapper">
        
        <div class="glass-login-card">
            
            <div class="card-header">
                <h2 id="formTitle"><?php echo $text['title']; ?></h2>
                <p id="heroSubtitle"><?php echo $text['subtitle']; ?></p>
            </div>
            
            <form action="register.php" method="POST" class="login-form">
                                
                <div class="input-group">
                    <label id="lblFullName" for="fullname"><?php echo $text['lbl_name']; ?></label>
                    <input type="text" id="fullname" name="fullname" placeholder="John Doe" required>
                </div>

                <div class="input-group">
                    <label id="lblEmail" for="email"><?php echo $text['lbl_email']; ?></label>
                    <input type="email" id="email" name="email" placeholder="john@example.com" required>
                </div>

                <div class="input-group">
                    <label id="lblPassword" for="password"><?php echo $text['lbl_pass']; ?></label>
                    <div class="password-field-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit-auth" id="btnSubmit"><?php echo $text['btn_submit']; ?></button>
            </form>

            <div class="form-footer" style="margin-top: 25px;">
                <span id="footerText"><?php echo $text['footer_text']; ?></span><a href="login.php" id="footerLink"><?php echo $text['footer_link']; ?></a>
            </div>

        </div>
    </div>

    <script src="assets/scripts.js"></script>
</body>
</html>