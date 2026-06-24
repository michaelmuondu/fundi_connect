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
    // Clean and sanitize phone numbers (keeping digits only)
    $phone_number = preg_replace('/[^0-9]/', '', $_POST['phone_number']);
    
    // Process specialty selection
    $chosen_specialty = $_POST['specialty'];
    if ($chosen_specialty === 'Other' && !empty($_POST['other_specialty'])) {
        $specialty = mysqli_real_escape_string($conn, $_POST['other_specialty']);
    } else {
        $specialty = mysqli_real_escape_string($conn, $chosen_specialty);
    }
    
    $bio = mysqli_real_escape_string($conn, $_POST['bio']);
    
    // Default to existing profile picture path from current database state
    $fetch_current = mysqli_query($conn, "SELECT profile_pic FROM users WHERE id = '$fundi_id'");
    $current_pic_row = mysqli_fetch_assoc($fetch_current);
    $profile_pic_name = $current_pic_row['profile_pic'] ?? 'default.png';

    // Image Upload Logic Handling
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['profile_pic']['tmp_name'];
        $file_original_name = $_FILES['profile_pic']['name'];
        
        $file_extension = strtolower(pathinfo($file_original_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (in_array($file_extension, $allowed_extensions)) {
            $new_file_name = "fundi_" . $fundi_id . "_" . time() . "." . $file_extension;
            $upload_target_path = "uploads/" . $new_file_name;

            if (move_uploaded_file($file_tmp_path, $upload_target_path)) {
                $profile_pic_name = $new_file_name;
            } else {
                $error_msg = "⚠️ Upload directory error. Failed to move file destination.";
            }
        } else {
            $error_msg = "⚠️ Invalid format! Please upload an image file ending in .jpg, .jpeg, or .png.";
        }
    }

    // Process DB changes if no errors occurred
    if (empty($error_msg)) {
        if (empty($phone_number)) {
            $error_msg = "⚠️ Please enter a valid telephone number containing digits only.";
        } else {
            $update_sql = "UPDATE users 
                           SET phone_number = '$phone_number', specialty = '$specialty', bio = '$bio', profile_pic = '$profile_pic_name' 
                           WHERE id = '$fundi_id'";

            if (mysqli_query($conn, $update_sql)) {
                $success_msg = "⚙️ Storefront updated successfully! Changes are live on your public profile.";
            } else {
                $error_msg = "⚠️ Systems Error: Failed to save your profile configurations.";
            }
        }
    }
}

// Fetch current user database values to pre-populate form inputs
$fetch_sql = "SELECT username, email, phone_number, specialty, bio, profile_pic FROM users WHERE id = '$fundi_id'";
$result = mysqli_query($conn, $fetch_sql);
$profile = mysqli_fetch_assoc($result);

// Pre-defined standard list items to track if database entry belongs to "Other" option group
$standard_specialties = ['Plumbing', 'Electrical', 'Masonry', 'Carpentry', 'Painting'];
$is_custom_specialty = !in_array($profile['specialty'], $standard_specialties) && !empty($profile['specialty']);
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
            
            <div class="back-home-container" style="position: static; margin-bottom: 20px; text-align: left;">
                <a href="fundi_dashboard.php" class="back-btn">← Back to Workspace</a>
            </div>

            <div class="glass-login-card" style="width: 100%; box-sizing: border-box;">
                <div class="card-header">
                    <h2>⚙️ Edit Professional Profile</h2>
                    <p class="subtext-muted">Customize the information clients see when booking your services in the local directory.</p>
                </div>

                <?php if(!empty($success_msg)): ?>
                    <div class="alert-msg alert-success"><?php echo $success_msg; ?></div>
                <?php endif; ?>
                <?php if(!empty($error_msg)): ?>
                    <div class="alert-msg alert-error"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div style="text-align: center; margin-bottom: 25px;">
                    <img src="uploads/<?php echo htmlspecialchars($profile['profile_pic'] ?? 'default.png'); ?>" 
                         alt="Avatar" 
                         style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3px solid #4285F4; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                    <p style="color: rgba(255,255,255,0.6); font-size: 0.85rem; margin-top: 8px;">Active Storefront Portrait</p>
                </div>

                <form action="edit_profile.php" method="POST" enctype="multipart/form-data" class="login-form">
                    
                    <div class="form-group">
                        <label style="color: rgba(255,255,255,0.4);">Account Username (Locked)</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($profile['username']); ?>" style="opacity: 0.5; cursor: not-allowed;" readonly>
                    </div>

                    <div class="form-group">
                        <label style="color: rgba(255,255,255,0.4);">Account Email Address (Locked)</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($profile['email']); ?>" style="opacity: 0.5; cursor: not-allowed;" readonly>
                    </div>

                    <div class="form-group">
                        <label for="profile_pic">Update Display Portrait (.jpg, .png)</label>
                        <input type="file" id="profile_pic" name="profile_pic" class="form-control" accept="image/*" style="padding-top: 7px;">
                    </div>

                    <div class="form-group">
                        <label for="specialty">Primary Trade Specialty *</label>
                        <select name="specialty" id="specialty" class="form-control" onchange="toggleOtherSkillsField()" required>
                            <option value="" disabled <?php if(empty($profile['specialty'])) echo 'selected'; ?>>-- Select Your Main Trade Category --</option>
                            <option value="Plumbing" <?php if(($profile['specialty'] ?? '') === 'Plumbing') echo 'selected'; ?>>Plumbing (Bomba)</option>
                            <option value="Electrical" <?php if(($profile['specialty'] ?? '') === 'Electrical') echo 'selected'; ?>>Electrical (Stima)</option>
                            <option value="Masonry" <?php if(($profile['specialty'] ?? '') === 'Masonry') echo 'selected'; ?>>Masonry / Mason (Ujenzi)</option>
                            <option value="Carpentry" <?php if(($profile['specialty'] ?? '') === 'Carpentry') echo 'selected'; ?>>Carpentry (Useremala)</option>
                            <option value="Painting" <?php if(($profile['specialty'] ?? '') === 'Painting') echo 'selected'; ?>>Painting (Rangi)</option>
                            <option value="Other" <?php if($is_custom_specialty) echo 'selected'; ?>>Other Skills / Specify Below</option>
                        </select>
                    </div>

                    <div class="form-group" id="other_skills_container" style="display: <?php echo $is_custom_specialty ? 'block' : 'none'; ?>; margin-top: 10px;">
                        <label for="other_specialty">Specify Custom Skill / Specialty Trade *</label>
                        <input type="text" id="other_specialty" name="other_specialty" class="form-control" 
                               value="<?php echo $is_custom_specialty ? htmlspecialchars($profile['specialty']) : ''; ?>" 
                               placeholder="e.g., Welding, Electronic Repairs, Tiling">
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Public Phone Number (Digits Only) *</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" 
                               inputmode="numeric" pattern="[0-9]+"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                               value="<?php echo htmlspecialchars($profile['phone_number'] ?? ''); ?>" 
                               placeholder="e.g., +254700111222" required>
                    </div>

                    <div class="form-group">
                        <label for="bio">Professional Bio & Experience Summary *</label>
                        <textarea id="bio" name="bio" class="form-control" style="min-height: 110px;" 
                                  placeholder="Introduce yourself to prospective clients..." required><?php echo htmlspecialchars($profile['bio'] ?? ''); ?></textarea>
                    </div>

                    <button type="submit" class="btn-submit-job" style="background:#4285F4;">Save Profile Modifications</button>
                </form>

            </div>
        </div>
    </main>

    <script>
        // Toggles visibility of custom text input based on selection
        function toggleOtherSkillsField() {
            const specialtySelect = document.getElementById('specialty');
            const customSkillContainer = document.getElementById('other_skills_container');
            const customSkillInput = document.getElementById('other_specialty');
            
            if (specialtySelect.value === 'Other') {
                customSkillContainer.style.display = 'block';
                customSkillInput.setAttribute('required', 'required');
            } else {
                customSkillContainer.style.display = 'none';
                customSkillInput.removeAttribute('required');
                customSkillInput.value = ''; // Clean old entries
            }
        }
    </script>
    <script src="assets/scripts.js"></script>
</body>
</html>