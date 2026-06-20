<?php
include 'connect.php';
session_start();

// Security Guard: Restrict access to logged-in Fundis only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'fundi') {
    header("Location: login.php");
    exit;
}

$fundi_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

// Handle Form Update Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $specialty    = mysqli_real_escape_string($conn, $_POST['specialty']);
    $bio          = mysqli_real_escape_string($conn, $_POST['bio']);

    $update_sql = "UPDATE users 
                   SET phone_number = '$phone_number', specialty = '$specialty', bio = '$bio' 
                   WHERE id = '$fundi_id'";

    if (mysqli_query($conn, $update_sql)) {
        $success_msg = "⚙️ Storefront updated successfully! Changes are live on your public profile.";
    } else {
        $error_msg = "⚠️ Systems Error: Failed to save your profile configurations.";
    }
}

// Fetch current user database values to pre-populate form inputs
$fetch_sql = "SELECT username, email, phone_number, specialty, bio FROM users WHERE id = '$fundi_id'";
$result = mysqli_query($conn, $fetch_sql);
$profile = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configure Storefront - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="form-container-card">
            
            <!-- Navigation Back Button -->
            <div class="back-home-container" style="position: static; margin-bottom: 20px; text-align: left;">
                <a href="fundi_dashboard.php" class="back-btn">← Back to Workspace</a>
            </div>

            <!-- Profile Configuration Card -->
            <div class="glass-login-card" style="width: 100%; box-sizing: border-box;">
                <div class="card-header">
                    <h2>⚙️ Edit Professional Profile</h2>
                    <p class="subtext-muted">Customize the information clients see when booking your services in the local directory.</p>
                </div>

                <!-- Alert Feedback Components -->
                <?php if(!empty($success_msg)): ?>
                    <div class="alert-msg alert-success"><?php echo $success_msg; ?></div>
                <?php endif; ?>
                <?php if(!empty($error_msg)): ?>
                    <div class="alert-msg alert-error"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <form action="edit_profile.php" method="POST" class="login-form">
                    
                    <!-- Read-only Username Insight (Locked) -->
                    <div class="form-group">
                        <label style="color: rgba(255,255,255,0.4);">Account Username (Locked)</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($profile['username']); ?>" style="opacity: 0.5; cursor: not-allowed;" readonly>
                    </div>

                    <!-- Read-only Email Insight (Locked) -->
                    <div class="form-group">
                        <label style="color: rgba(255,255,255,0.4);">Account Email Address (Locked)</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($profile['email']); ?>" style="opacity: 0.5; cursor: not-allowed;" readonly>
                    </div>

                    <!-- Active Operational Specialty Dropdown Picker -->
                    <div class="form-group">
                        <label for="specialty">Primary Trade Specialty *</label>
                        <select name="specialty" id="specialty" class="form-control" required>
                            <option value="" disabled>-- Select Your Main Trade Category --</option>
                            <option value="Plumbing" <?php if($profile['specialty'] === 'Plumbing') echo 'selected'; ?>>Plumbing (Bomba)</option>
                            <option value="Electrical" <?php if($profile['specialty'] === 'Electrical') echo 'selected'; ?>>Electrical (Stima)</option>
                            <option value="Masonry" <?php if($profile['specialty'] === 'Masonry') echo 'selected'; ?>>Masonry / Mason (Ujenzi)</option>
                            <option value="Carpentry" <?php if($profile['specialty'] === 'Carpentry') echo 'selected'; ?>>Carpentry (Useremala)</option>
                            <option value="Painting" <?php if($profile['specialty'] === 'Painting') echo 'selected'; ?>>Painting (Rangi)</option>
                        </select>
                    </div>

                    <!-- Public Telephone Line Input Contact Field -->
                    <div class="form-group">
                        <label for="phone_number">Public Phone Number *</label>
                        <input type="tel" id="phone_number" name="phone_number" class="form-control" 
                               value="<?php echo htmlspecialchars($profile['phone_number'] ?? ''); ?>" 
                               placeholder="e.g., +254700111222" required>
                    </div>

                    <!-- Professional Bio Biography Textbox Section -->
                    <div class="form-group">
                        <label for="bio">Professional Bio & Experience Summary *</label>
                        <textarea id="bio" name="bio" class="form-control" style="min-height: 110px;" 
                                  placeholder="Introduce yourself to prospective clients. Mention certifications, years of experience, or specialized equipment tools you operate..." required><?php echo htmlspecialchars($profile['bio'] ?? ''); ?></textarea>
                    </div>

                    <!-- Submission Action Button execution node -->
                    <button type="submit" class="btn-submit-job" style="background:#4285F4;">Save Profile Modifications</button>
                </form>

            </div>
        </div>
    </main>

    <script src="assets/scripts.js"></script>
</body>
</html>