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
        'lbl_role'         => 'Sajili Kama',
        'opt_select'       => '-- Chagua aina ya akaunti --',
        'opt_client'       => 'Mteja (Natafuta Fundi)',
        'opt_fundi'        => 'Fundi (Natoa Huduma)',
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
        'lbl_role'         => 'Register As',
        'opt_select'       => '-- Select account type --',
        'opt_client'       => 'Client (I want to hire a Fundi)',
        'opt_fundi'        => 'Fundi (I want to offer services)',
        'lbl_pass'         => 'Password',
        'lbl_confirm_pass' => 'Confirm Password',
        'btn_submit'       => 'Register',
        'footer_text'      => 'Already have an account? ',
        'footer_link'      => 'Login'
    ];
}

// 4. Database Registration Logic with INSTANT REDIRECT
$registration_status = "";

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $registration_status = "mismatch";
        echo "<script>alert('Passwords do not match! / Nenosiri hazilingani!');</script>";
    } else {
        if ($role === 'client' || $role === 'fundi') {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashed_password', '$role')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // SUCCESS: Clear session data if needed and redirect cleanly
                header("Location: login.php?status=registered");
                exit(); // Stop script execution right here so the redirect happens cleanly
            } else {
                $registration_status = "failed";
                // If it fails, let's output the direct database error so we can fix it instantly
                die("Database Error: " . mysqli_error($conn));
            }
        } else {
            die("Invalid role configuration.");
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
    <style>
        .password-field-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .password-field-wrapper input {
            width: 100%;
            padding-right: 45px;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: rgba(255, 255, 255, 0.7);
            user-select: none;
            font-size: 0.9rem;
        }
    </style>
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
                    <label id="lblRole" for="role"><?php echo $text['lbl_role']; ?></label>
                    <select id="role" name="role" required style="width: 100%; padding: 12px; border-radius: 8px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; font-size: 1rem; outline: none; transition: 0.3s; margin-top: 5px;">
                        <option value="" disabled selected style="background: #2a2e3d; color: #fff;"><?php echo $text['opt_select']; ?></option>
                        <option value="client" style="background: #2a2e3d; color: #fff;"><?php echo $text['opt_client']; ?></option>
                        <option value="fundi" style="background: #2a2e3d; color: #fff;"><?php echo $text['opt_fundi']; ?></option>
                    </select>
                </div>

                <div class="input-group">
                    <label id="lblPassword" for="password"><?php echo $text['lbl_pass']; ?></label>
                    <div class="password-field-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <span class="toggle-password" onclick="togglePassVisibility('password', this)">👁️</span>
                    </div>
                </div>

                <div class="input-group">
                    <label id="lblConfirmPassword" for="confirm_password"><?php echo $text['lbl_confirm_pass']; ?></label>
                    <div class="password-field-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="••••••••" required>
                        <span class="toggle-password" onclick="togglePassVisibility('confirm_password', this)">👁️</span>
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

        function togglePassVisibility(inputId, toggleIcon) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.textContent = "🙈";
            } else {
                passwordInput.type = "password";
                toggleIcon.textContent = "👁️";
            }
        }
    </script>
    <script src="assets/scripts.js"></script>
</body>
</html>