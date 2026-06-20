<?php
include 'connect.php';
session_start();

// Security Guard: Ensure only logged-in clients can search the directory
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit;
}

// 1. Build the Dynamic Filter Query
$category_filter = "";
$selected_category = "";

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $selected_category = mysqli_real_escape_string($conn, $_GET['category']);
    $category_filter = " AND specialty = '$selected_category' ";
}

// 2. Fetch registered Fundis matching the filters
$sql = "SELECT id, username, email, phone_number, specialty, bio 
        FROM users 
        WHERE role = 'fundi'" . $category_filter . " 
        ORDER BY username ASC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find an Expert - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="form-container-card" style="max-width: 600px; padding: 10px;">
            
            <div class="back-home-container" style="position: static; margin-bottom: 20px; text-align: left;">
                <a href="client_dashboard.php" class="back-btn">← Back to Dashboard</a>
            </div>

            <div class="glass-login-card" style="width: 100%; box-sizing: border-box; text-align: left; padding: 25px;">
                <div class="card-header" style="text-align: left; margin-bottom: 20px;">
                    <h2 style="font-size: 1.5rem; margin-bottom: 5px;">🔍 Browse Verified Fundis</h2>
                    <p class="subtext-muted" style="font-size: 0.9rem;">Find reliable, vetted local technicians right in your neighborhood.</p>
                </div>

                <form action="browse_fundis.php" method="GET" class="login-form" style="margin-bottom: 25px;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <label style="margin-bottom: 8px; display: block; font-weight: 500;">Filter by Professional Trade</label>
                        <select name="category" class="form-control" style="width: 100%; background: rgba(0,0,0,0.3); color: #fff; border: 1px solid rgba(255,255,255,0.2); padding: 12px; border-radius: 8px;">
                            <option value="">All Services / General Trades</option>
                            <option value="Plumbing" <?php if($selected_category === 'Plumbing') echo 'selected'; ?>>Plumbing</option>
                            <option value="Electrical" <?php if($selected_category === 'Electrical') echo 'selected'; ?>>Electrical</option>
                            <option value="Masonry" <?php if($selected_category === 'Masonry') echo 'selected'; ?>>Masonry</option>
                            <option value="Carpentry" <?php if($selected_category === 'Carpentry') echo 'selected'; ?>>Carpentry</option>
                            <option value="Painting" <?php if($selected_category === 'Painting') echo 'selected'; ?>>Painting</option>
                        </select>
                    </div>
                    <button type="submit" class="btn-submit-auth" style="width: 100%; padding: 12px; font-weight: 600;">Apply Search Filters</button>
                </form>

                <div class="results-container">
                    <h4 style="font-size: 1rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 8px; margin-bottom: 15px;">Available Experts</h4>
                    
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while($fundi = mysqli_fetch_assoc($result)): ?>
                            
                            <div style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.08); border-radius: 12px; padding: 15px; margin-bottom: 15px;">
                                <h4 style="margin: 0 0 5px 0; font-size: 1.1rem;"><?php echo htmlspecialchars($fundi['username']); ?></h4>
                                <span class="badge-tag" style="background: rgba(66,133,244,0.2); color: #4285f4; font-size: 0.75rem; padding: 3px 8px; border-radius: 4px; display: inline-block; margin-bottom: 10px;">
                                    🛠️ <?php echo htmlspecialchars($fundi['specialty'] ?? 'General Tech'); ?>
                                </span>
                                <p style="font-style: italic; font-size: 0.85rem; color: rgba(255,255,255,0.7); margin: 0 0 12px 0;">
                                    "<?php echo htmlspecialchars($fundi['bio'] ?? 'No bio updated yet.'); ?>"
                                </p>
                                
                                <div style="display: flex; gap: 10px; margin-top: 10px;">
                                    <?php if(!empty($fundi['phone_number'])): ?>
                                        <a href="tel:<?php echo htmlspecialchars($fundi['phone_number']); ?>" style="flex: 1; text-align: center; background: #2ecc71; color: white; text-decoration: none; font-size: 0.85rem; font-weight: 600; padding: 8px; border-radius: 6px;">📞 Call Now</a>
                                    <?php endif; ?>
                                    <a href="mailto:<?php echo htmlspecialchars($fundi['email']); ?>" style="flex: 1; text-align: center; background: rgba(255,255,255,0.1); color: white; text-decoration: none; font-size: 0.85rem; font-weight: 600; padding: 8px; border-radius: 6px; border: 1px solid rgba(255,255,255,0.1);">Email</a>
                                </div>
                            </div>

                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="subtext-muted" style="text-align: center; font-size: 0.85rem; font-style: italic; margin-top: 20px;">
                            No active professionals found matching this category yet.
                        </p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </main>

</body>
</html>