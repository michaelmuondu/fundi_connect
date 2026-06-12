document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.carousel-slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn'); // This will be null now
    
    let currentSlide = 0;
    const slideInterval = 5000; // 5 seconds
    let autoPlayTimer;

    // Changes the visible slide
    function changeSlide(index) {
        if (index >= slides.length) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = index;
        }

        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
    }

    // Directional triggers
    function handleNext() {
        changeSlide(currentSlide + 1);
        resetTimer();
    }

    function handlePrev() {
        changeSlide(currentSlide - 1);
        resetTimer();
    }

    // SAFEGUARD: Only add listeners if the elements actually exist in HTML
    if (prevBtn) {
        prevBtn.addEventListener('click', handlePrev);
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', handleNext);
    }

    // Indicator dots click tracking
    dots.forEach(dot => {
        dot.addEventListener('click', (e) => {
            const targetIndex = parseInt(e.target.getAttribute('data-slide'));
            changeSlide(targetIndex);
            resetTimer();
        });
    });

    // Automatic Rotation Mechanics
    function startTimer() {
        autoPlayTimer = setInterval(handleNext, slideInterval);
    }

    function resetTimer() {
        clearInterval(autoPlayTimer);
        startTimer();
    }

    // Launch Carousel loop
    startTimer();
});
//navbar
// --- FUNDI CONNECT NAVIGATION ENGINE ---
document.addEventListener('DOMContentLoaded', () => {
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            // Toggle the 'active' class on menu container
            navMenu.classList.toggle('active');
            
            // Optional: Animate hamburger button bars into an 'X' shape
            navToggle.classList.toggle('toggle-open');
        });

        // Close mobile navbar automatically if user clicks elsewhere on page
        document.addEventListener('click', (e) => {
            if (!navToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                navToggle.classList.remove('toggle-open');
            }
        });
    }
});

// body
// --- FUNDI CONNECT INTERACTIVE ENGINE ---
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('fundiSearch');
    const locationSelect = document.getElementById('locationFilter');
    const categoryCards = document.querySelectorAll('.category-card');
    const fundiCards = document.querySelectorAll('.fundi-card');

    let activeCategory = 'all';

    // 1. Search and Filter Execution Function
    function filterFundis() {
        const searchText = searchInput.value.toLowerCase();
        const selectedLocation = locationSelect.value;

        fundiCards.forEach(card => {
            const name = card.querySelector('h3').textContent.toLowerCase();
            const specialty = card.querySelector('.specialty').textContent.toLowerCase();
            const cardCategory = card.getAttribute('data-category');
            const cardLocation = card.getAttribute('data-location');

            // Evaluation Criteria Checks
            const matchesSearch = name.includes(searchText) || specialty.includes(searchText);
            const matchesCategory = (activeCategory === 'all' || cardCategory === activeCategory);
            const matchesLocation = (selectedLocation === 'all' || cardLocation === selectedLocation);

            if (matchesSearch && matchesCategory && matchesLocation) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // 2. Event Listeners for Live Filtering Input
    if(searchInput) searchInput.addEventListener('input', filterFundis);
    if(locationSelect) locationSelect.addEventListener('change', filterFundis);

    // 3. Category Select Interactivity Switcher
    categoryCards.forEach(card => {
        card.addEventListener('click', () => {
            categoryCards.forEach(c => c.classList.remove('active'));
            card.classList.add('active');
            
            activeCategory = card.getAttribute('data-category');
            filterFundis();
        });
    });
});

// 4. Interactive "Connect Now" System
function connectFundi(fundiName) {
    const toast = document.getElementById('connectionToast');
    toast.textContent = `Connecting you with ${fundiName}... Please wait.`;
    toast.classList.add('show');

    // Automatically hide notification bar after 3.5 seconds
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3500);
}
// footer
// --- FUNDI CONNECT FOOTER MODULE ---
document.addEventListener('DOMContentLoaded', () => {
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterEmail = document.getElementById('newsletterEmail');
    const newsletterMessage = document.getElementById('newsletterMessage');

    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault(); // Stop standard page reload sequences
            
            const emailValue = newsletterEmail.value;

            // Simulate AJAX Processing response delay 
            newsletterMessage.textContent = "Registering email...";
            newsletterMessage.style.color = "#f1c40f"; 

            setTimeout(() => {
                newsletterMessage.textContent = "Thank you for subscribing to Fundi Connect!";
                newsletterMessage.className = "newsletter-status success";
                newsletterEmail.value = ""; // Clear form field input channel
            }, 1200);
        });
    }
});
// login page
// --- FUNDI CONNECT INTERACTIVE AUTHENTICATION MECHANISMS ---
document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.querySelector('.login-form');
    const googleBtn = document.querySelector('.btn-google-oauth');

    if (loginForm) {
        loginForm.addEventListener('submit', () => {
            const submitBtn = loginForm.querySelector('.btn-submit-auth');
            // Prevent multiple parallel double tap post submission anomalies
            submitBtn.textContent = "...Processing...";
            submitBtn.style.opacity = "0.7";
            submitBtn.style.pointerEvents = "none";
        });
    }

    if (googleBtn) {
        googleBtn.addEventListener('click', () => {
            googleBtn.style.opacity = "0.6";
            googleBtn.querySelector('span').textContent = "Opening Google Secure Sign-In...";
        });
    }
});
// register page
const translations = {
    en: {
        btnBack: "← Home",
        langBtn: "ENG / KISW",
        heroTitle: "Connect with Local Experts",
        heroSubtitle: "Join our community of trusted, vetted professionals and grow your brand network seamlessly.",
        formTitle: "Create Account",
        lblFullName: "Full Name",
        lblEmail: "Email Address",
        lblPassword: "Password",
        btnSubmit: "Register",
        footerText: "Already have an account? ",
        footerLink: "Login",
        placeholderName: "John Doe"
    },
    sw: {
        btnBack: "← Nyumbani",
        langBtn: "KISW / ENG",
        heroTitle: "Ungana na Mafundi Bora",
        heroSubtitle: "Jiunge na mtandao wetu wa mafundi wanaoaminika na uinue biashara yako kwa urahisi.",
        formTitle: "Sajili Akaunti",
        lblFullName: "Majina Kamili",
        lblEmail: "Anwani ya Barua Pepe",
        lblPassword: "Nywila",
        btnSubmit: "Sajili",
        footerText: "Tayari una akaunti? ",
        footerLink: "Ingia",
        placeholderName: "Juma Ali"
    }
};

// Target reference updates:
const heroSubtitle = document.getElementById('heroSubtitle');

// Inside your updateUI(lang) function loop, add:
if(heroSubtitle) heroSubtitle.textContent = data.heroSubtitle;
//LOGO
document.addEventListener("DOMContentLoaded", () => {
    const preloader = document.getElementById("site-preloader");
    
    if (preloader) {
        // Wait for the entire window lifecycle (styles, backgrounds, assets) to fully compile
        window.addEventListener("load", () => {
            // Add an intentional 800ms presentation delay so users can appreciate the animation
            setTimeout(() => {
                preloader.classList.add("fade-out");
                
                // Completely clean up the DOM tree after the opacity fade finishes
                setTimeout(() => {
                    preloader.remove();
                }, 600); 
                
            }, 800);
        });
        
        // Safety Fallback: Force slide out preloader after 4.5 seconds if a local script or background image gets hung up
        setTimeout(() => {
            if (document.getElementById("site-preloader")) {
                preloader.classList.add("fade-out");
                setTimeout(() => preloader.remove(), 600);
            }
        }, 4500);
    }
});
// paswords styles
// Ensure script initializes safely after DOM rendering completes
document.addEventListener('DOMContentLoaded', () => {
    
    const passwordToggle = document.getElementById('passwordToggle');
    const passwordInput = document.getElementById('password');

    // Verification check prevents console errors if a user is visiting a page without this specific form element
    if (passwordToggle && passwordInput) {
        
        passwordToggle.addEventListener('click', () => {
            // Check the current structural type state 
            const isPassword = passwordInput.getAttribute('type') === 'password';
            
            if (isPassword) {
                // Switch input property type to expose plain text character string
                passwordInput.setAttribute('type', 'text');
                
                // Swap icon to indicate standard hide action (using a crossed-eye emoji representation)
                passwordToggle.querySelector('.eye-icon').textContent = '🙈';
            } else {
                // Revert type attribute securely back to hidden bullet notation
                passwordInput.setAttribute('type', 'password');
                
                // Reset back to normal view icon representation
                passwordToggle.querySelector('.eye-icon').textContent = '👁️';
            }
        });
    }
});
