<?php
include 'connect.php';
session_start();

// Security Guard: Restrict to authenticated Fundis only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'fundi') {
    header("Location: login.php");
    exit;
}

$fundi_id = $_SESSION['user_id'];
$success_msg = "";
$error_msg = "";

// Handle Bid Submission Execution
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_bid'])) {
    $job_id         = mysqli_real_escape_string($conn, $_POST['job_id']);
    $bid_amount     = mysqli_real_escape_string($conn, $_POST['bid_amount']);
    $estimated_days = mysqli_real_escape_string($conn, $_POST['estimated_days']);
    $proposal_notes = mysqli_real_escape_string($conn, $_POST['proposal_notes']);

    // Check for duplicate applications to protect data integrity
    $check_sql = "SELECT id FROM bids WHERE job_id = '$job_id' AND fundi_id = '$fundi_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        $error_msg = "⚠️ You have already submitted a proposal for this job entry.";
    } else {
        $insert_sql = "INSERT INTO bids (job_id, fundi_id, bid_amount, estimated_days, proposal_notes, status) 
                       VALUES ('$job_id', '$fundi_id', '$bid_amount', '$estimated_days', '$proposal_notes', 'pending')";
        
        if (mysqli_query($conn, $insert_sql)) {
            $success_msg = "🚀 Quote dispatched successfully! The client has been notified.";
        } else {
            $error_msg = "⚠️ Systems Error: Failed to log your bid proposal.";
        }
    }
}

// Fetch all pending jobs, cross-referencing user profile information
$jobs_sql = "SELECT j.*, u.username AS client_name 
             FROM jobs j 
             JOIN users u ON j.client_id = u.id 
             WHERE j.status = 'pending' 
             ORDER BY j.id DESC";
$jobs_result = mysqli_query($conn, $jobs_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Job Pipeline - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="job-feed-container">
            
            <!-- Navigation Back Array -->
            <div class="back-home-container" style="position: static; margin-bottom: 25px; text-align: left;">
                <a href="fundi_dashboard.php" class="back-btn">← Back to Workspace</a>
            </div>

            <div class="welcome-banner fundi-banner">
                <h2>💼 Live Repair Opportunities</h2>
                <p class="subtext-muted">Review open customer files in your area and send tailored pricing bids.</p>
            </div>

            <!-- Global Response Messages -->
            <?php if(!empty($success_msg)): ?>
                <div class="alert-msg alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>
            <?php if(!empty($error_msg)): ?>
                <div class="alert-msg alert-error"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <!-- Job Feed Array Matrix -->
            <div class="feed-wrapper">
                <?php if ($jobs_result && mysqli_num_rows($jobs_result) > 0): ?>
                    <?php while($job = mysqli_fetch_assoc($jobs_result)): ?>
                        
                        <div class="job-post-card">
                            <div class="job-card-header">
                                <div class="job-title-block">
                                    <h3><?php echo htmlspecialchars($job['category']); ?> Work Requested</h3>
                                    <p style="font-size:0.85rem; color: rgba(255,255,255,0.5); margin:0;">Posted by: <?php echo htmlspecialchars($job['client_name']); ?></p>
                                </div>
                                <div class="job-tags-row">
                                    <span class="badge-tag badge-trade">📍 <?php echo htmlspecialchars($job['location']); ?></span>
                                    <span class="badge-tag badge-rating" style="background: rgba(46,204,113,0.15); color:#2ecc71; border-color:#2ecc71;">
                                        💰 KES <?php echo number_format($job['budget'] ?? 0); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="job-description">
                                <p><?php echo nl2br(htmlspecialchars($job['description'])); ?></p>
                            </div>

                            <!-- Interactive Inline Bid Pitch Form -->
                            <div class="bid-drawer-form">
                                <h4>Pitch a Professional Service Estimate</h4>
                                <form action="available_jobs.php" method="POST">
                                    <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                    
                                    <div class="bid-form-row">
                                        <div class="form-group">
                                            <label>Your Quote Price (KES) *</label>
                                            <input type="number" name="bid_amount" class="form-control" placeholder="e.g. 2200" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Est. Duration (Days) *</label>
                                            <input type="number" name="estimated_days" class="form-control" placeholder="e.g. 1" required>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin-bottom: 15px;">
                                        <label>Proposal Message to Client *</label>
                                        <textarea name="proposal_notes" class="form-control" style="min-height: 70px;" placeholder="Describe how you plan to fix the problem and your availability..." required></textarea>
                                    </div>

                                    <button type="submit" name="submit_bid" class="btn-toggle-bid">Submit Quote to Client</button>
                                </form>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="glass-login-card" style="padding: 40px; text-align: center; width:100%;">
                        <p class="subtext-muted">There are no active job posts available at the moment. Check your live feed shortly!</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <script src="assets/scripts.js"></script>
</body>
</html>