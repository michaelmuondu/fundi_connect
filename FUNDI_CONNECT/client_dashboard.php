<?php
include 'connect.php';
session_start();

// Security Guard: Verify active authenticated status
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Workspace - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="form-container-card" style="max-width: 550px; padding: 10px; width: 100%; box-sizing: border-box;">
            
            <div class="glass-login-card" style="width: 100%; box-sizing: border-box; text-align: left; padding: 30px;">
                
                <div class="card-header" style="text-align: left; margin-bottom: 25px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px;">
                    <h2 style="font-size: 1.6rem; font-weight: 700; margin-bottom: 5px;">🛠️ Client Portal</h2>
                    <p class="subtext-muted" style="font-size: 0.9rem;">Logged securely as: <strong style="color: #4285F4;"><?php echo htmlspecialchars($username); ?></strong></p>
                </div>

                <div class="dashboard-menu-links" style="display: flex; flex-direction: column; gap: 20px;">
                    
                    <div style="background: rgba(231, 76, 60, 0.1); border: 1px solid rgba(231, 76, 60, 0.2); padding: 15px; border-radius: 12px;">
                        <h4 style="margin: 0 0 4px 0; font-size: 1.05rem; color: #ff4d4d;">🚨 Need Urgent Assistance?</h4>
                        <p style="margin: 0 0 10px 0; font-size: 0.85rem; color: rgba(255,255,255,0.7); line-height: 1.4;">Have an active disaster like a bursting pipe? Skip bidding and dial help immediately.</p>
                        <a href="tel:+254700000000" style="color: #ff4d4d; font-weight: 600; text-decoration: none; font-size: 0.9rem;">📞 Call Emergency Fundi &rarr;</a>
                    </div>

                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 12px;">
                        <h4 style="margin: 0 0 4px 0; font-size: 1.05rem; color: #fff;">📄 Post a New Request</h4>
                        <p style="margin: 0 0 10px 0; font-size: 0.85rem; color: rgba(255,255,255,0.6); line-height: 1.4;">Describe your issue, set your location, and connect with nearby tradespeople.</p>
                        <a href="post_job.php" style="color: #4285F4; font-weight: 600; text-decoration: none; font-size: 0.9rem;">Create Job Post &rarr;</a>
                    </div>

                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 12px;">
                        <h4 style="margin: 0 0 4px 0; font-size: 1.05rem; color: #fff;">🔍 Book a Verified Fundi</h4>
                        <p style="margin: 0 0 10px 0; font-size: 0.85rem; color: rgba(255,255,255,0.6); line-height: 1.4;">Browse active technicians in your neighborhood. Filter profiles by trade specialty.</p>
                        <a href="browse_fundis.php" style="color: #4285F4; font-weight: 600; text-decoration: none; font-size: 0.9rem;">Browse Directory &rarr;</a>
                    </div>

                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); padding: 15px; border-radius: 12px;">
                        <h4 style="margin: 0 0 4px 0; font-size: 1.05rem; color: #fff;">⏳ My Active Orders</h4>
                        <p style="margin: 0 0 10px 0; font-size: 0.85rem; color: rgba(255,255,255,0.6); line-height: 1.4;">Track progress loops on submitted work posts and review incoming estimates.</p>
                        <a href="my_requests.php" style="color: #4285F4; font-weight: 600; text-decoration: none; font-size: 0.9rem;">View Orders Status &rarr;</a>
                    </div>

                </div>

                <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1); text-align: center;">
                    <a href="logout.php" style="color: #ff4d4d; font-size: 0.9rem; font-weight: 600; text-decoration: none;">🚪 Terminate Session (Log Out)</a>
                </div>

            </div>
        </div>
    </main>

</body>
</html>