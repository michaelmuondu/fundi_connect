<?php
include 'connect.php';
session_start();

// Security Guard: Ensure only logged-in clients can view this tracking ledger
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'client') {
    header("Location: login.php");
    exit;
}

$client_id = $_SESSION['user_id'];
$success_msg = "";

// Handle Hiring Decision (Accepting a Bid)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept_bid'])) {
    $bid_id = mysqli_real_escape_string($conn, $_POST['bid_id']);
    $job_id = mysqli_real_escape_string($conn, $_POST['job_id']);

    // 1. Update the chosen bid to 'accepted'
    $update_bid = "UPDATE bids SET status = 'accepted' WHERE id = '$bid_id'";
    mysqli_query($conn, $update_bid);

    // 2. Reject all other bids for this specific job automatically
    $reject_others = "UPDATE bids SET status = 'declined' WHERE job_id = '$job_id' AND id != '$bid_id'";
    mysqli_query($conn, $reject_others);

    // 3. Update the job status itself to 'assigned'
    $update_job = "UPDATE jobs SET status = 'assigned' WHERE id = '$job_id'";
    mysqli_query($conn, $update_job);

    $success_msg = "🎉 Fundi assigned successfully! You can now access their profile to call them.";
}

// Fetch all jobs posted by this specific client
$jobs_sql = "SELECT * FROM jobs WHERE client_id = '$client_id' ORDER BY id DESC";
$jobs_result = mysqli_query($conn, $jobs_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Job Board - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="dashboard-container">
            
            <!-- Navigation Back Array -->
            <div class="back-home-container" style="position: static; margin-bottom: 25px; text-align: left;">
                <a href="client_dashboard.php" class="back-btn">← Back to Dashboard</a>
            </div>

            <div class="welcome-banner">
                <h2>⏳ My Posted Jobs & Offers</h2>
                <p class="subtext-muted">Track your repair listings and review incoming custom price quotes from field experts.</p>
            </div>

            <?php if(!empty($success_msg)): ?>
                <div class="alert-msg alert-success" style="margin-bottom:25px;"><?php echo $success_msg; ?></div>
            <?php endif; ?>

            <!-- Loop Through Client's Posted Jobs -->
            <div class="requests-pipeline">
                <?php if ($jobs_result && mysqli_num_rows($jobs_result) > 0): ?>
                    <?php while($job = mysqli_fetch_assoc($jobs_result)): ?>
                        
                        <div class="request-manager-card">
                            <div class="request-header-meta">
                                <div>
                                    <h3 style="font-size:1.25rem; font-weight:600; margin-bottom:4px;"><?php echo htmlspecialchars($job['category']); ?> Request</h3>
                                    <p style="font-size:0.85rem; color:rgba(255,255,255,0.5); margin:0;">Posted on: <?php echo date('M d, Y', strtotime($job['created_at'])); ?></p>
                                </div>
                                <div>
                                    <span class="status-indicator-badge <?php echo ($job['status'] === 'pending') ? 'status-pending' : 'status-assigned'; ?>">
                                        Status: <?php echo $job['status']; ?>
                                    </span>
                                </div>
                            </div>

                            <p style="font-size:0.95rem; color:rgba(255,255,255,0.8); margin-bottom:15px; line-height:1.5;">
                                <strong>Description:</strong> <?php echo htmlspecialchars($job['description']); ?>
                            </p>

                            <!-- Sub-Query: Fetch incoming bids for THIS specific job entry -->
                            <div class="bid-review-list">
                                <h4 style="font-size:1rem; font-weight:600; margin-bottom:12px; color:#4285F4;">🛠️ Received Estimates</h4>
                                
                                <?php
                                $job_id = $job['id'];
                                $bids_sql = "SELECT b.*, u.username AS fundi_name FROM bids b 
                                             JOIN users u ON b.fundi_id = u.id 
                                             WHERE b.job_id = '$job_id'";
                                $bids_result = mysqli_query($conn, $bids_sql);
                                ?>

                                <?php if ($bids_result && mysqli_num_rows($bids_result) > 0): ?>
                                    <?php while($bid = mysqli_fetch_assoc($bids_result)): ?>
                                        
                                        <div class="bid-proposal-row">
                                            <div style="flex:1; text-align:left;">
                                                <h5 style="font-size:1rem; margin-bottom:4px; color:#fff;">Fundi: <?php echo htmlspecialchars($bid['fundi_name']); ?></h5>
                                                <p style="font-size:0.85rem; color:rgba(255,255,255,0.7); margin-bottom:6px;">"<?php echo htmlspecialchars($bid['proposal_notes']); ?>"</p>
                                                <span style="font-size:0.85rem; color:rgba(255,255,255,0.5);">⏱️ Est. Time: <?php echo $bid['estimated_days']; ?> Day(s)</span>
                                            </div>
                                            <div style="text-align:right; min-width:140px;">
                                                <p style="color:#2ecc71; font-weight:700; font-size:1.1rem; margin-bottom:8px;">KES <?php echo number_format($bid['bid_amount']); ?></p>
                                                
                                                <?php if($job['status'] === 'pending'): ?>
                                                    <!-- Accept Bid Form Trigger -->
                                                    <form action="my_requests.php" method="POST">
                                                        <input type="hidden" name="bid_id" value="<?php echo $bid['id']; ?>">
                                                        <input type="hidden" name="job_id" value="<?php echo $job['id']; ?>">
                                                        <button type="submit" name="accept_bid" class="btn-accept-bid">Accept Offer & Hire</button>
                                                    </form>
                                                <?php else: ?>
                                                    <span style="font-size:0.85rem; font-weight:600; color: <?php echo ($bid['status'] === 'accepted') ? '#2ecc71' : '#ff4d4d'; ?>">
                                                        <?php echo strtoupper($bid['status']); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <p style="font-size:0.85rem; color:rgba(255,255,255,0.4); font-style:italic;">No estimates received from local Fundis yet. Keeping tracking active...</p>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="glass-login-card" style="padding:40px; text-align:center; width:100%;">
                        <p class="subtext-muted">You haven't posted any service requests yet.</p>
                        <a href="post_job.php" class="btn-action-link" style="display:inline-block; margin-top:15px; padding:10px 25px;">Create Your First Post</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <script src="assets/scripts.js"></script>
</body>
</html>