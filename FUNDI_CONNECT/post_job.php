<?php
include 'connect.php';
session_start();

// Security Guard: Ensure only logged-in clients can access this submission portal
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit;
}

$client_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category    = mysqli_real_escape_string($conn, $_POST['category']);
    $location    = mysqli_real_escape_string($conn, $_POST['location']);
    $budget      = mysqli_real_escape_string($conn, $_POST['budget']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sql = "INSERT INTO jobs (client_id, category, location, budget, description, status) 
            VALUES ('$client_id', '$category', '$location', '$budget', '$description', 'pending')";

    if (mysqli_query($conn, $sql)) {
        $success_msg = "🚀 Job posted successfully! Local Fundis have been alerted.";
    } else {
        $error_msg = "⚠️ Systems Error: Could not publish your request.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Request - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="form-container-card" style="max-width: 500px; padding: 10px; width:100%; box-sizing: border-box;">
            
            <div class="back-home-container" style="position: static; margin-bottom: 20px; text-align: left;">
                <a href="client_dashboard.php" class="back-btn">← Back to Dashboard</a>
            </div>

            <div class="glass-login-card" style="width: 100%; box-sizing: border-box; text-align: left; padding: 25px;">
                
                <div class="card-header" style="text-align: center; margin-bottom: 20px;">
                    <h2 style="font-size: 1.6rem; font-weight:600; margin-bottom: 5px;">📝 Post a New Request</h2>
                    <p class="subtext-muted" style="font-size: 0.85rem;">Fill out the details below to receive competitive estimates from professionals.</p>
                </div>

                <?php if(!empty($success_msg)): ?>
                    <div class="alert-msg alert-success" style="background: rgba(46, 204, 113, 0.2); color: #2ecc71; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 0.9rem; border: 1px solid #2ecc71;">
                        <?php echo $success_msg; ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty($error_msg)): ?>
                    <div class="alert-msg alert-error" style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; padding: 12px; border-radius: 8px; margin-bottom: 15px; font-size: 0.9rem; border: 1px solid #e74c3c;">
                        <?php echo $error_msg; ?>
                    </div>
                <?php endif; ?>

                <form action="post_job.php" method="POST" class="login-form">
                    
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="margin-bottom: 6px; display: block; font-size: 0.9rem; font-weight: 500;">Select Service Field *</label>
                        <select name="category" class="form-control" style="width: 100%; background: rgba(0,0,0,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 12px; border-radius: 8px; font-size:0.9rem;" required>
                            <option value="" disabled selected>-- Select a Trade Category --</option>
                            <option value="Plumbing">Plumbing</option>
                            <option value="Electrical">Electrical</option>
                            <option value="Masonry">Masonry</option>
                            <option value="Carpentry">Carpentry</option>
                            <option value="Painting">Painting</option>
                        </select>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="margin-bottom: 6px; display: block; font-size: 0.9rem; font-weight: 500;">Your Location / Neighborhood *</label>
                        <input type="text" name="location" class="form-control" style="width: 100%; background: rgba(0,0,0,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 12px; border-radius: 8px; font-size:0.9rem;" placeholder="e.g., Kilimani, Nairobi or Bamburi, Mombasa" required>
                    </div>

                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="margin-bottom: 6px; display: block; font-size: 0.9rem; font-weight: 500;">Estimated Budget (KES) (Optional)</label>
                        <input type="number" name="budget" class="form-control" style="width: 100%; background: rgba(0,0,0,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 12px; border-radius: 8px; font-size:0.9rem;" placeholder="e.g., 2500">
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="margin-bottom: 6px; display: block; font-size: 0.9rem; font-weight: 500;">Describe the Issue Clearly & Concisely *</label>
                        <textarea name="description" class="form-control" style="width: 100%; background: rgba(0,0,0,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 12px; border-radius: 8px; min-height: 90px; font-size:0.9rem; line-height:1.4;" placeholder="Provide details like: 'The kitchen sink pipe is leaking under the counter...'" required></textarea>
                    </div>

                    <button type="submit" class="btn-submit-auth" style="width: 100%; padding: 12px; font-weight: 600; background: #4285F4; border-radius: 8px; color: white; border: none; font-size: 1rem; cursor: pointer;">🚀 Publish Job Request</button>
                </form>

            </div>
        </div>
    </main>

</body>
</html>