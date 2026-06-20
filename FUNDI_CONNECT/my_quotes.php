<?php
include 'connect.php';
session_start();

// Security Guard: Restrict access to logged-in Fundis only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'fundi') {
    header("Location: login.php");
    exit;
}

$fundi_id = $_SESSION['user_id'];

// SQL Query: Pull all bids submitted by this Fundi, joining the related Job and Client name
$ledger_sql = "SELECT b.id AS bid_id, b.bid_amount, b.estimated_days, b.proposal_notes, b.status AS bid_status,
                      j.category, j.location, u.username AS client_name
               FROM bids b
               JOIN jobs j ON b.job_id = j.id
               JOIN users u ON j.client_id = u.id
               WHERE b.fundi_id = '$fundi_id'
               ORDER BY b.id DESC";
               
$ledger_result = mysqli_query($conn, $ledger_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bids Ledger - Fundi Connect</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body class="login-page-body">

    <main class="login-hero-wrapper hero-wrapper-top-aligned">
        <div class="ledger-wrapper">
            
            <div class="back-home-container" style="position: static; margin-bottom: 25px; text-align: left;">
                <a href="fundi_dashboard.php" class="back-btn">← Back to Workspace</a>
            </div>

            <div class="welcome-banner fundi-banner">
                <h2>✉️ Submitted Price Quotes</h2>
                <p class="subtext-muted">Track all active proposals sent out to potential clients and monitor job wins.</p>
            </div>

            <div class="ledger-container">
                <?php if ($ledger_result && mysqli_num_rows($ledger_result) > 0): ?>
                    <?php while($quote = mysqli_fetch_assoc($ledger_result)): ?>
                        
                        <div class="ledger-card">
                            <div class="ledger-info">
                                <h3><?php echo htmlspecialchars($quote['category']); ?> Repair Job</h3>
                                <div class="ledger-details">
                                    <p style="margin-bottom: 4px;"><strong>📍 Location:</strong> <?php echo htmlspecialchars($quote['location']); ?></p>
                                    <p style="margin-bottom: 8px;"><strong>👤 Client:</strong> <?php echo htmlspecialchars($quote['client_name']); ?></p>
                                    <p style="font-style: italic; font-size: 0.85rem; color: rgba(255,255,255,0.5);">
                                        Your Pitch: "<?php echo htmlspecialchars($quote['proposal_notes']); ?>"
                                    </p>
                                </div>
                            </div>

                            <div class="ledger-financials">
                                <div class="ledger-price">KES <?php echo number_format($quote['bid_amount']); ?></div>
                                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.4); margin-bottom: 10px;">⏱️ Est: <?php echo $quote['estimated_days']; ?> Day(s)</p>
                                
                                <?php 
                                    $status = $quote['bid_status'];
                                    if ($status === 'pending') {
                                        echo '<span class="bid-status-badge badge-bid-pending">Under Review</span>';
                                    } elseif ($status === 'accepted') {
                                        echo '<span class="bid-status-badge badge-bid-accepted">🎉 Accepted (Won)</span>';
                                        // If won, provide a friction-free call link to the customer
                                        echo '<br><a href="tel:+254700000000" class="btn-contact-client">📞 Call Client</a>';
                                    } else {
                                        echo '<span class="bid-status-badge badge-bid-declined">Declined</span>';
                                    }
                                ?>
                            </div>
                        </div>

                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="glass-login-card" style="padding: 40px; text-align: center; width: 100%;">
                        <p class="subtext-muted">You haven't sent out any price quotes yet.</p>
                        <a href="available_jobs.php" class="btn-fundi-action" style="display: inline-block; margin-top: 15px; padding: 10px 25px;">Find Open Tasks</a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <script src="assets/scripts.js"></script>
</body>
</html>