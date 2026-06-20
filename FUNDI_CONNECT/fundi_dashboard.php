<?php
include 'connect.php';
session_start();

// Security Guard: Restrict access to authenticated Fundis only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'fundi') {
    header("Location: login.php");
    exit;
}

$fundi_id = $_SESSION['user_id'];
$username = htmlspecialchars($_SESSION['username']);

// 1. Simulate Business Performance Metrics (In a production build, these use COUNT/AVG SQL queries)
$rating_score    = "4.9";
$completed_jobs  = "18";
$pending_bids     = "3";

// 2. Fetch the 2 most recent pending jobs for the Live Leads Feed module
$feed_sql = "SELECT id, category, location, budget, created_at FROM jobs WHERE status = 'pending' ORDER BY id DESC LIMIT 2";
$feed_result = mysqli_query($conn, $feed_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fundi Workspace - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="dashboard-container">
            
            <!-- Top Control Bar (Status Control Hub) -->
            <div class="top-control-bar">
                <div class="availability-toggle">
                    <span class="switch-label">Work Status:</span>
                    <span class="toggle-status-badge">🟢 Accepting Jobs</span>
                </div>
                <div>
                    <p class="subtext-muted" style="margin:0;">Account: <span class="badge-tag badge-trade" style="background:rgba(46,204,113,0.15); color:#2ecc71; border:1px solid #2ecc71;">Verified Pro</span></p>
                </div>
            </div>

            <!-- Identity Header Block -->
            <div class="welcome-banner fundi-banner">
                <h2>🧰 Fundi Workspace</h2>
                <p class="subtext-muted">Welcome back, <strong class="highlight-white">Expert <?php echo $username; ?></strong></p>
            </div>

            <!-- Business Performance Metric Ribbon -->
            <div class="stat-strip">
                <div class="stat-item">
                    <div class="stat-num">⭐ <?php echo $rating_score; ?></div>
                    <div class="stat-lbl">Reputation Rating</div>
                </div>
                <div class="divider-vertical"></div>
                <div class="stat-item">
                    <div class="stat-num"><?php echo $completed_jobs; ?></div>
                    <div class="stat-lbl">Jobs Completed</div>
                </div>
                <div class="divider-vertical"></div>
                <div class="stat-item">
                    <div class="stat-num"><?php echo $pending_bids; ?></div>
                    <div class="stat-lbl">Bids Under Review</div>
                </div>
            </div>

            <!-- Real-Time Job Feed Module -->
            <div class="live-feed-section">
                <div class="feed-header">
                    <h3>🎯 Nearby Incoming Leads</h3>
                    <div class="pulse-indicator">
                        <div class="pulse-dot"></div> Live Feed Active
                    </div>
                </div>

                <div class="feed-container">
                    <?php if ($feed_result && mysqli_num_rows($feed_result) > 0): ?>
                        <?php while($job = mysqli_fetch_assoc($feed_result)): ?>
                            <div class="lead-row">
                                <div class="lead-details">
                                    <h4><?php echo htmlspecialchars($job['category']); ?> Required</h4>
                                    <div class="lead-meta">
                                        <span>📍 <?php echo htmlspecialchars($job['location']); ?></span>
                                        <span>💰 Est. Budget: <fieldset class="text-cash" style="display:inline; border:none; padding:0;">KES <?php echo number_format($job['budget'] ?? 0); ?></fieldset></span>
                                    </div>
                                </div>
                                <a href="available_jobs.php?apply_id=<?php echo $job['id']; ?>" class="btn-quick-bid">Send Quote</a>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div style="text-align: center; color: rgba(255,255,255,0.4); padding: 10px 0;">
                            <p>No new job listings found in your region. Check back shortly!</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Operational Utilities Action Matrix -->
            <div class="actions-grid">
                
                <!-- Toolkit A: Lead Directory Explorer -->
                <div class="dashboard-card">
                    <div>
                        <div class="card-icon">💼</div>
                        <h3>Find Nearby Jobs</h3>
                        <p>Open the comprehensive leads map. Filter customer requests by trade classification, local distance fields, or wallet budgets.</p>
                    </div>
                    <a href="available_jobs.php" class="btn-fundi-action">Browse Open Tasks</a>
                </div>

                <!-- Toolkit B: Estimates Accounting Ledger -->
                <div class="dashboard-card">
                    <div>
                        <div class="card-icon">✉️</div>
                        <h3>My Active Quotes</h3>
                        <p>Track pricing bids currently out with clients. Review customer counteroffers, read contract terms, or adjust pricing values.</p>
                    </div>
                    <a href="my_quotes.php" class="btn-fundi-action">Manage Bids</a>
                </div>

                <!-- Toolkit C: Virtual Profile Storefront Configurations -->
                <div class="dashboard-card">
                    <div>
                        <div class="card-icon">⚙️</div>
                        <h3>Profile & Settings</h3>
                        <p>Configure details visible to potential employers. Edit telephone lines, add expertise certifications, or update your bio array.</p>
                    </div>
                    <a href="edit_profile.php" class="btn-fundi-action">Configure Bio</a>
                </div>

            </div>

            <!-- Secure Sign Out Anchor boundaries -->
            <div class="footer-navigation">
                <a href="logout.php" class="btn-logout-secure">🚪 Terminate Session (Log Out)</a>
            </div>

        </div>
    </main>

    <script src="assets/scripts.js"></script>
</body>
</html>