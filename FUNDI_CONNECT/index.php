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
<?php
include 'connect.php'; // CRITICAL: This must be at the very top of index.php
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

 <section class="main-content">

    <div class="search-hub">
        <h2>Find a Reliable Fundi Near You</h2>
        <p>Search for plumbers, electricians, carpenters and more.</p>


    <div class="category-grid">
        <div class="category-card active" data-category="all">
            <div class="card-icon">🛠️</div>
            <h3>All Services</h3>
    </div>
        <div class="category-card" data-category="Plumbing">
            <div class="card-icon">🪠</div>
            <h3>Plumbing</h3>
    </div>
        <div class="category-card" data-category="Electrical">
            <div class="card-icon">⚡</div>
            <h3>Electrical</h3>
    </div>
        <div class="category-card" data-category="Carpentry">
            <div class="card-icon">🪚</div>
            <h3>Carpentry</h3>
    </div>
        <div class="category-card" data-category="Masonry">
            <div class="card-icon">🧱</div>
            <h3>Masonry</h3>
    </div>
</div>
// FAQS
     <section class="faq-section" style="max-width: 800px; margin: 60px auto; padding: 0 20px; font-family: sans-serif;">
        
        <div class="section-header" style="text-align: center; margin-bottom: 40px;">
            <h2 style="font-size: 2rem; margin-bottom: 10px; color: #4285F4; font-weight: bold;">Frequently Asked Questions 🇰🇪</h2>
            <p style="color: #333333; font-size: 1.1rem;">Got questions about Fundi Connect? We've got answers.</p>
        </div>

        <div class="faq-container" style="display: flex; flex-direction: column; gap: 15px;">
            
            <div class="faq-item" style="background: #ffffff; border: 1px solid #cccccc; border-radius: 8px; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <button class="faq-question" style="width: 100%; background: #ffffff; border: none; color: #1a1a1a; padding: 20px; text-align: left; font-size: 1.1rem; font-weight: bold; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none;">
                    <span>What is Fundi Connect?</span>
                    <span class="faq-icon" style="transition: transform 0.3s; color: #4285F4;">▼</span>
                </button>
                <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #f9f9f9;">
                    <p style="padding: 20px; margin: 0; color: #444444; line-height: 1.6; font-size: 0.95rem;">
                        Fundi Connect is a digital directory designed to connect local clients directly with skilled, trusted local artisans (Fundis)—such as plumbers, electricians, painters, and carpenters—right within Nairobi neighborhoods.
                    </p>
                </div>
            </div>

            <div class="faq-item" style="background: #ffffff; border: 1px solid #cccccc; border-radius: 8px; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <button class="faq-question" style="width: 100%; background: #ffffff; border: none; color: #1a1a1a; padding: 20px; text-align: left; font-size: 1.1rem; font-weight: bold; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none;">
                    <span>How do I contact a Fundi?</span>
                    <span class="faq-icon" style="transition: transform 0.3s; color: #4285F4;">▼</span>
                </button>
                <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #f9f9f9;">
                    <p style="padding: 20px; margin: 0; color: #444444; line-height: 1.6; font-size: 0.95rem;">
                        It's simple! Use the category grid or search bar to locate the professional trade you need. Click the **"Chat on WhatsApp"** button on their card to automatically open a direct secure WhatsApp chat window with them.
                    </p>
                </div>
            </div>

            <div class="faq-item" style="background: #ffffff; border: 1px solid #cccccc; border-radius: 8px; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <button class="faq-question" style="width: 100%; background: #ffffff; border: none; color: #1a1a1a; padding: 20px; text-align: left; font-size: 1.1rem; font-weight: bold; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none;">
                    <span>Do clients pay any booking fees?</span>
                    <span class="faq-icon" style="transition: transform 0.3s; color: #4285F4;">▼</span>
                </button>
                <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #f9f9f9;">
                    <p style="padding: 20px; margin: 0; color: #444444; line-height: 1.6; font-size: 0.95rem;">
                        No. Fundi Connect is completely free for clients looking for services. You negotiate pricing and settle service terms directly with your chosen artisan on WhatsApp.
                    </p>
                </div>
            </div>

            <div class="faq-item" style="background: #ffffff; border: 1px solid #cccccc; border-radius: 8px; overflow: hidden; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                <button class="faq-question" style="width: 100%; background: #ffffff; border: none; color: #1a1a1a; padding: 20px; text-align: left; font-size: 1.1rem; font-weight: bold; cursor: pointer; display: flex; justify-content: space-between; align-items: center; outline: none;">
                    <span>I am an artisan. How do I join the platform?</span>
                    <span class="faq-icon" style="transition: transform 0.3s; color: #4285F4;">▼</span>
                </button>
                <div class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #f9f9f9;">
                    <p style="padding: 20px; margin: 0; color: #444444; line-height: 1.6; font-size: 0.95rem;">
                        Click on the **Register** link in the navigation menu, choose the **Fundi** role options, and create your account. Once logged in, go to your Workspace dashboard to update your phone line, trade specialization, and showcase profile avatar.
                    </p>
                </div>
            </div>

        </div> </section>
     <!-- 5. Global Website Footer Section -->
    <footer class="site-footer" style="
        background: #111e29; 
        color: #ffffff; 
        margin-top: 60px;
        /* BREAKOUT TRICK: Forces full screen width even inside a wrapper */
        width: 100vw;
        position: relative;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        box-sizing: border-box;
        padding: 60px 0 30px 0;
    ">
        <!-- Inner container ensures text stays perfectly aligned in the center grid -->
        <div class="footer-container" style="
            max-width: 1200px; 
            margin: 0 auto; 
            display: flex; 
            flex-wrap: wrap; 
            gap: 40px; 
            justify-content: space-between;
            padding: 0 40px; /* Gives content breathing room away from the edges */
            box-sizing: border-box;
        ">
            
            <div class="footer-column brand-info" style="flex: 1; min-width: 250px;">
                <h3 class="footer-logo" style="margin-bottom: 15px; font-size: 1.5rem; color: #4285F4;">Fundi<span style="color:#fff;">Connect</span></h3>
                <p style="color: #cbd5e1; line-height: 1.6; font-size: 0.95rem;">Connecting you to trusted, vetted, and professional local artisans in Nairobi. Fast, secure, and reliable service at your doorstep.</p>
                <div class="social-links" style="margin-top: 15px; display: flex; gap: 12px; font-size: 1.2rem;">
                    <a href="#" aria-label="Facebook" style="text-decoration: none;">📘</a>
                    <a href="#" aria-label="Twitter" style="text-decoration: none;">🐦</a>
                    <a href="#" aria-label="Instagram" style="text-decoration: none;">📸</a>
                    <a href="#" aria-label="LinkedIn" style="text-decoration: none;">💼</a>
                </div>
            </div>

            <div class="footer-column" style="flex: 0.5; min-width: 160px;">
                <h4 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 2px solid #4285F4; display: inline-block; padding-bottom: 5px;">Quick Links</h4>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2.2;">
                    <li><a href="index.php" style="color: #cbd5e1; text-decoration: none;">Home</a></li>
                    <li><a href="register.php" style="color: #cbd5e1; text-decoration: none;">Join As a Fundi</a></li>
                    <li><a href="#" style="color: #cbd5e1; text-decoration: none;">How it Works</a></li>
                    <li><a href="#" style="color: #cbd5e1; text-decoration: none;">Safety Guidelines</a></li>
                </ul>
            </div>

            <div class="footer-column" style="flex: 0.5; min-width: 180px;">
                <h4 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 2px solid #4285F4; display: inline-block; padding-bottom: 5px;">Support</h4>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 2.2; color: #cbd5e1;">
                    <li>📍 Nairobi, Kenya</li>
                    <li>📞 +254 700 000 000</li>
                    <li>✉️ support@fundiconnect.co.ke</li>
                    <li><a href="#" style="color: #cbd5e1; text-decoration: none;">Terms & Conditions</a></li>
                </ul>
            </div>

            <div class="footer-column newsletter" style="flex: 1; min-width: 280px;">
                <h4 style="margin-bottom: 20px; font-size: 1.1rem; border-bottom: 2px solid #4285F4; display: inline-block; padding-bottom: 5px;">Stay Updated</h4>
                <p style="color: #cbd5e1; font-size: 0.95rem; margin-bottom: 15px;">Subscribe to receive tips, safety updates, and discount service offers.</p>
                <form id="newsletterForm" class="footer-form" style="display: flex; width: 100%;">
                    <input type="email" id="newsletterEmail" placeholder="Enter your email" required style="flex: 1; padding: 12px; border: 1px solid #334155; border-radius: 4px 0 0 4px; background: #1e293b; color: #fff; outline: none;">
                    <button type="submit" class="btn-subscribe" style="background: #4285F4; color: white; border: none; padding: 12px 20px; border-radius: 0 4px 4px 0; cursor: pointer; font-weight: bold;">Subscribe</button>
                </form>
                <p id="newsletterMessage" class="newsletter-status"></p>
            </div>

        </div>

        <!-- Horizontal divider line -->
        <div style="max-width: 1200px; margin: 40px auto 0 auto; padding: 0 40px; box-sizing: border-box;">
            <div style="border-top: 1px solid #334155; padding-top: 20px; display: flex; flex-wrap: wrap; justify-content: space-between; font-size: 0.85rem; color: #94a3b8;">
                <p>&copy; <?php echo date('Y'); ?> Fundi Connect. All Rights Reserved.</p>
                <p>Built with ❤️ for Kenyan Artisans.</p>
            </div>
        </div>
    </footer>
    
    <script src="assets/scripts.js"></script>
</body>
</html>