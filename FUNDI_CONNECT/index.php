<?php
// Start the session securely
if (session_status() === PHP_SESSION_NONE) {
    // Set secure cookie parameters (Good practice for professional sites)
    session_start([
        'cookie_lifetime' => 86400, // 1 day
        'cookie_secure'   => isset($_SERVER['HTTPS']), 
        'cookie_httponly' => true,
        'use_strict_mode' => true
    ]);
}

// Example Session Usage: Track page views
if (!isset($_SESSION['page_views'])) {
    $_SESSION['page_views'] = 1;
} else {
    $_SESSION['page_views']++;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FUNDI CONNECT</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>

    <!-- 1. Full Screen Website Preloader Wrapper -->
    <div id="site-preloader" class="preloader-overlay">
        <div class="preloader-content-box">
            <div class="logo-animation-wrapper-preload">
                <div class="emblem-circle-preload">
                    <svg class="tool-icon-preload wrench-preload" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                    </svg>
                    <svg class="tool-icon-preload lightning-preload" viewBox="0 0 24 24" fill="currentColor">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                    </svg>
                </div>
            </div>
            <div class="logo-brand-text-preload">
                <span class="text-primary-preload">Fundi</span><span class="text-accent-preload">Connect</span>
            </div>
            <div class="loading-bar-container">
                <div class="loading-bar-pulse"></div>
            </div>
        </div>
    </div>

    <!-- 2. Main Site Header -->
    <header class="main-navbar">
    <div class="nav-container">
        
        <a href="index.php" class="logo-container">
            <div class="logo-brand-text">
                <span class="text-primary">Fundi</span><span class="text-accent">Connect</span>
            </div>
        </a>

        <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        <nav class="nav-menu" id="navMenu">
            <ul class="nav-list">
                <li><a href="index.php" class="nav-link active">Home</a></li>
                <li><a href="#" class="nav-link">Find Services</a></li>
                <li><a href="#" class="nav-link">How It Works</a></li>
                <li><a href="register.php" class="nav-link nav-btn-secondary">Join As Fundi</a></li>
                <li><a href="login.php" class="nav-link nav-btn-primary">Login</a></li>
            </ul>
            
            <div class="nav-session-badge">
                <span class="badge-icon">👁️</span>
                <span class="badge-text">Views: <strong><?php echo $_SESSION['page_views']; ?></strong></span>
            </div>
        </nav>

    </div>
</header>

    <!-- 3. Hero Carousel Section -->
    <section class="hero-carousel-container">
        <div class="carousel-slider">
            
            <div class="carousel-slide active">
                <img src="assets/images/technician.jpg" alt="Welcome to Our Platform">
                <div class="carousel-caption">
                    <a href="register.php" class="btn-get-started">Get Started</a>
                </div>
            </div>

            <div class="carousel-slide">
                <img src="assets/images/electrician.jpg" alt="Secure and Scalable">
                <div class="carousel-caption">
                    <a href="register.php" class="btn-get-started">Get Started</a>
                </div>
            </div>

            <div class="carousel-slide">
                <img src="assets/images/masonry.jpg" alt="Smart Analytics">
                <div class="carousel-caption">
                    <a href="register.php" class="btn-get-started">Get Started</a>
                </div>
            </div>

            <div class="carousel-slide">
                <img src="assets/images/mechanic.jpg" alt="Collaborative Tools">
                <div class="carousel-caption">
                    <a href="register.php" class="btn-get-started">Get Started</a>
                </div>
            </div>

            <div class="carousel-slide">
                <img src="assets/images/plumbing.jpg" alt="Get Started Today">
                <div class="carousel-caption">
                    <a href="register.php" class="btn-get-started">Get Started Now</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Search and Listing Directory Grid -->
    <section class="main-content">
        
        <div class="search-hub">
            <h2>Find a Reliable Fundi Near You</h2>
            <p>Select a category or search directly to find vetted professionals in Nairobi.</p>
            
            <div class="search-controls">
                <input type="text" id="fundiSearch" placeholder="Search for 'plumber', 'electrician'...">
                <select id="locationFilter">
                    <option value="all">All Locations</option>
                    <option value="nairobi-cbd">Nairobi CBD</option>
                    <option value="westlands">Westlands</option>
                    <option value="kilimani">Kilimani</option>
                    <option value="kasarani">Kasarani</option>
                </select>
            </div>
        </div>

        <div class="category-grid">
            <div class="category-card active" data-category="all">
                <div class="card-icon">🛠️</div>
                <h3>All Services</h3>
            </div>
            <div class="category-card" data-category="plumbing">
                <div class="card-icon">🪠</div>
                <h3>Plumbing</h3>
            </div>
            <div class="category-card" data-category="electrical">
                <div class="card-icon">⚡</div>
                <h3>Electrical</h3>
            </div>
            <div class="category-card" data-category="carpentry">
                <div class="card-icon">🪚</div>
                <h3>Carpentry</h3>
            </div>
            <div class="category-card" data-category="masonry">
                <div class="card-icon">🧱</div>
                <h3>Masonry</h3>
            </div>
        </div>

        <div class="fundi-listings" id="fundiListings">
            <div class="fundi-card" data-category="plumbing" data-location="westlands">
                <div class="fundi-badge">Verified</div>
                <h3>John Kamau</h3>
                <p class="specialty">Master Plumber</p>
                <p class="location">📍 Westlands, Nairobi</p>
                <div class="rating">⭐ 4.9 (24 Reviews)</div>
                <button class="btn-connect" onclick="connectFundi('John Kamau')">Connect Now</button>
            </div>

            <div class="fundi-card" data-category="electrical" data-location="kilimani">
                <div class="fundi-badge">Verified</div>
                <h3>David Omondi</h3>
                <p class="specialty">Certified Electrician</p>
                <p class="location">📍 Kilimani, Nairobi</p>
                <div class="rating">⭐ 4.8 (19 Reviews)</div>
                <button class="btn-connect" onclick="connectFundi('David Omondi')">Connect Now</button>
            </div>

            <div class="fundi-card" data-category="carpentry" data-location="nairobi-cbd">
                <div class="fundi-badge">Top Rated</div>
                <h3>Alice Mwangi</h3>
                <p class="specialty">Furniture & Cabinet Maker</p>
                <p class="location">📍 Nairobi CBD</p>
                <div class="rating">⭐ 5.0 (32 Reviews)</div>
                <button class="btn-connect" onclick="connectFundi('Alice Mwangi')">Connect Now</button>
            </div>

            <div class="fundi-card" data-category="masonry" data-location="kasarani">
                <div class="fundi-badge">Verified</div>
                <h3>Peter Otieno</h3>
                <p class="specialty">Brick & Tile Mason</p>
                <p class="location">📍 Kasarani, Nairobi</p>
                <div class="rating">⭐ 4.7 (15 Reviews)</div>
                <button class="btn-connect" onclick="connectFundi('Peter Otieno')">Connect Now</button>
            </div>
        </div>

        <div id="connectionToast" class="toast-notification"></div>
    </section>

    <!-- 5. Global Website Footer Section -->
    <footer class="site-footer">
        <div class="footer-container">
            
            <div class="footer-column brand-info">
                <h3 class="footer-logo">Fundi<span>Connect</span></h3>
                <p>Connecting you to trusted, vetted, and professional local artisans in Nairobi. Fast, secure, and reliable service at your doorstep.</p>
                <div class="social-links">
                    <a href="#" aria-label="Facebook">📘</a>
                    <a href="#" aria-label="Twitter">🐦</a>
                    <a href="#" aria-label="Instagram">📸</a>
                    <a href="#" aria-label="LinkedIn">💼</a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="register.php">Join As a Fundi</a></li>
                    <li><a href="#">How it Works</a></li>
                    <li><a href="#">Safety Guidelines</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Support</h4>
                <ul>
                    <li>📍 Nairobi, Kenya</li>
                    <li>📞 +254 700 000 000</li>
                    <li>✉️ support@fundiconnect.co.ke</li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="footer-column newsletter">
                <h4>Stay Updated</h4>
                <p>Subscribe to receive tips, safety updates, and discount service offers.</p>
                <form id="newsletterForm" class="footer-form">
                    <input type="email" id="newsletterEmail" placeholder="Enter your email" required>
                    <button type="submit" class="btn-subscribe">Subscribe</button>
                </form>
                <p id="newsletterMessage" class="newsletter-status"></p>
            </div>

        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; <?php echo date('Y'); ?> Fundi Connect. All Rights Reserved.</p>
                <p>Built with ❤️ for Kenyan Artisans.</p>
            </div>
        </div>
    </footer>

    <script src="assets/scripts.js"></script>
</body>
</html>