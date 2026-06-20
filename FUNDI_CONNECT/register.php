<?php
// 1. Include Database Connection
include 'connect.php';

session_start();

// 2. Language Toggle Logic
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'] === 'sw' ? 'sw' : 'en';
}
$current_lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';

// 3. Translations Array
if ($current_lang === 'sw') {
    $text = [
        'back_home'        => '← Nyumbani',
        'lang_toggle'      => 'English',
        'next_lang'        => 'en',
        'title'            => 'Fungua Akaunti',
        'subtitle'         => 'Unganishwa na wataalamu wa ndani haraka na salama.',
        'lbl_name'         => 'Majina Kamili',
        'lbl_email'        => 'Anwani ya Barua Pepe',
        'lbl_pass'         => 'Nenosiri',
        'lbl_confirm_pass' => 'Thibitisha Nenosiri',
        'btn_submit'       => 'Sajili',
        'footer_text'      => 'Tayari una akaunti? ',
        'footer_link'      => 'Ingia hapa'
    ];
} else {
    $text = [
        'back_home'        => '← Home',
        'lang_toggle'      => 'Kiswahili',
        'next_lang'        => 'sw',
        'title'            => 'Create Account',
        'subtitle'         => 'Connect with local experts quickly and securely.',
        'lbl_name'         => 'Full Name',
        'lbl_email'        => 'Email Address',
        'lbl_pass'         => 'Password',
        'lbl_confirm_pass' => 'Confirm Password',
        'btn_submit'       => 'Register',
        'footer_text'      => 'Already have an account? ',
        'footer_link'      => 'Login'
    ];
}

// 4. Real Database Registration Logic
$registration_status = "";

if (isset($_POST['register'])) {
    // Note: 'username' maps to the 'fullname' field in your HTML form input
    $username = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Double check passwords match on backend side
    if ($password !== $confirm_password) {
        $registration_status = "mismatch";
    } else {
        // Hash the password securely using bcrypt
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // FIXED: Changed '$password' to '$hashed_password' so your database is secure
        $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $registration_status = "success";
        } else {
            $registration_status = "failed";
        }
    }
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
            
            <form action="register.php" method="POST" class="login-form" id="registerForm">
                                
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

                <div class="input-group">
                    <label id="lblConfirmPassword" for="confirm_password"><?php echo $text['lbl_confirm_pass']; ?></label>
                    <div class="password-field-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
                    </div>
                    <span id="passwordError" class="error-text"></span>
                </div>

                <button type="submit" name="register" class="btn-submit-auth" id="btnSubmit"><?php echo $text['btn_submit']; ?></button>
            </form>

            <div class="form-footer" style="margin-top: 25px;">
                <span id="footerText"><?php echo $text['footer_text']; ?></span><a href="login.php" id="footerLink"><?php echo $text['footer_link']; ?></a>
            </div>

        </div>
    </div>

    <script>
        window.currentLang = "<?php echo $current_lang; ?>";
        window.registrationStatus = "<?php echo $registration_status; ?>";
    </script>
    
    <script src="assets/scripts.js"></script>
</body>
</html>