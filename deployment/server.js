const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const port = process.env.PORT || 8080;

// Serve static files from public directory
app.use('/assets', express.static(path.join(__dirname, 'public/assets')));
app.use('/images', express.static(path.join(__dirname, 'public/images')));

// Serve Next.js banking app
app.use('/internet-banking', express.static(path.join(__dirname, 'internet-banking')));

// Handle banking app routes
app.get('/internet-banking/*', (req, res) => {
    res.sendFile(path.join(__dirname, 'internet-banking/index.html'));
});

// Landing page template
const landingPageHTML = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizon Bank - Banking Excellence for Your Future</title>
    <meta name="description" content="Welcome to Horizon Bank - Your trusted banking partner offering comprehensive wholesale, SME, and personal banking solutions.">

    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="/assets/images/logo-main.png" alt="Horizon Bank" class="logo-img">
                    <span class="logo-text">Horizon Bank</span>
                </div>
                <nav class="main-nav">
                    <ul class="nav-menu">
                        <li><a href="/">Home</a></li>
                        <li><a href="/about">About</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/contact">Contact</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <a href="/internet-banking" class="btn btn-primary">
                        <i class="fas fa-laptop"></i>
                        Internet Banking
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section modern-hero">
        <div class="hero-background">
            <div class="container">
                <div class="hero-content-wrapper">
                    <div class="hero-content">
                        <div class="hero-badge">
                            <i class="fas fa-award"></i>
                            <span>Premier Commercial Bank in UAE</span>
                        </div>
                        <h1 class="hero-title">Banking Excellence for Your Future</h1>
                        <p class="hero-subtitle">Experience world-class banking with innovative solutions, personalized service, and cutting-edge technology for individuals and businesses.</p>

                        <div class="hero-buttons">
                            <a href="/internet-banking" class="btn btn-primary btn-lg">
                                <i class="fas fa-laptop"></i>
                                <span>Internet Banking</span>
                            </a>
                            <a href="/contact" class="btn btn-outline-white btn-lg">
                                <i class="fas fa-user-plus"></i>
                                <span>Open Account</span>
                            </a>
                        </div>

                        <div class="hero-features">
                            <div class="feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Bank-Level Security</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-clock"></i>
                                <span>24/7 Digital Banking</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-globe"></i>
                                <span>Global Network</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-mobile-alt"></i>
                                <span>WhatsApp Banking</span>
                            </div>
                        </div>
                    </div>
                    <div class="hero-visual">
                        <div class="hero-image">
                            <img src="/assets/images/hero-banking.jpg" alt="Modern Banking Solutions">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Banking Portal Section -->
    <section class="banking-portal-section">
        <div class="container">
            <div class="portal-header">
                <h2 class="section-title">Internet Banking Portal</h2>
                <p class="section-subtitle">Secure access to your banking services</p>
            </div>

            <div class="portal-tabs">
                <div class="tab-buttons">
                    <button class="tab-btn active" data-tab="personal">
                        <i class="fas fa-user"></i>
                        Personal Banking
                    </button>
                    <button class="tab-btn" data-tab="business">
                        <i class="fas fa-building"></i>
                        Business Banking
                    </button>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="personal">
                        <div class="login-features">
                            <div class="feature-grid">
                                <div class="feature-card">
                                    <i class="fas fa-chart-line"></i>
                                    <h3>Account Overview</h3>
                                    <p>Real-time balance and transaction history</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-exchange-alt"></i>
                                    <h3>Quick Transfers</h3>
                                    <p>Instant transfers between accounts and beneficiaries</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    <h3>Bill Payments</h3>
                                    <p>Pay utilities, credit cards, and other bills online</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-mobile-alt"></i>
                                    <h3>Mobile Banking</h3>
                                    <p>Access your accounts on the go with our mobile app</p>
                                </div>
                            </div>
                            <div class="portal-actions">
                                <a href="/internet-banking/sign-in" class="btn btn-primary btn-large">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Access Personal Banking
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="business">
                        <div class="login-features">
                            <div class="feature-grid">
                                <div class="feature-card">
                                    <i class="fas fa-building"></i>
                                    <h3>Corporate Dashboard</h3>
                                    <p>Comprehensive view of all business accounts</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-users"></i>
                                    <h3>Multi-User Access</h3>
                                    <p>Role-based access for team members</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-file-alt"></i>
                                    <h3>Bulk Payments</h3>
                                    <p>Process multiple payments efficiently</p>
                                </div>
                                <div class="feature-card">
                                    <i class="fas fa-chart-bar"></i>
                                    <h3>Financial Reports</h3>
                                    <p>Detailed analytics and reporting tools</p>
                                </div>
                            </div>
                            <div class="portal-actions">
                                <a href="/internet-banking/sign-in" class="btn btn-primary btn-large">
                                    <i class="fas fa-briefcase"></i>
                                    Access Business Banking
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Our Banking Services</h2>
                <p class="section-subtitle">Comprehensive financial solutions for all your needs</p>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-piggy-bank"></i>
                    </div>
                    <h3>Personal Banking</h3>
                    <p>Savings accounts, current accounts, and personal loans tailored to your lifestyle.</p>
                    <a href="/services/personal" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Business Banking</h3>
                    <p>Corporate accounts, trade finance, and business loans for growing enterprises.</p>
                    <a href="/services/business" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Investment Services</h3>
                    <p>Wealth management, portfolio advisory, and investment opportunities.</p>
                    <a href="/services/investment" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h3>Cards & Payments</h3>
                    <p>Credit cards, debit cards, and modern payment solutions.</p>
                    <a href="/services/cards" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <img src="/assets/images/logo-white.png" alt="Horizon Bank">
                        <span>Horizon Bank</span>
                    </div>
                    <p>Your trusted banking partner providing innovative financial solutions with exceptional service and cutting-edge technology.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/contact">Contact</a></li>
                        <li><a href="/internet-banking">Internet Banking</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Services</h4>
                    <ul class="footer-links">
                        <li><a href="/services/personal">Personal Banking</a></li>
                        <li><a href="/services/business">Business Banking</a></li>
                        <li><a href="/services/investment">Investments</a></li>
                        <li><a href="/services/cards">Cards & Payments</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-phone"></i> +971 4 123 4567</p>
                        <p><i class="fas fa-envelope"></i> info@horizonbank.ae</p>
                        <p><i class="fas fa-map-marker-alt"></i> Dubai, UAE</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-bottom-content">
                    <p>&copy; 2024 Horizon Bank. All rights reserved.</p>
                    <div class="footer-bottom-links">
                        <a href="/privacy">Privacy Policy</a>
                        <a href="/terms">Terms of Service</a>
                        <a href="/security">Security</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/banking-portal.js"></script>
</body>
</html>`;

// Routes
app.get('/', (req, res) => {
    res.send(landingPageHTML);
});

app.get('/about', (req, res) => {
    res.send(landingPageHTML.replace('Banking Excellence for Your Future', 'About Horizon Bank'));
});

app.get('/services', (req, res) => {
    res.send(landingPageHTML.replace('Banking Excellence for Your Future', 'Our Banking Services'));
});

app.get('/contact', (req, res) => {
    res.send(landingPageHTML.replace('Banking Excellence for Your Future', 'Contact Horizon Bank'));
});

// Health check
app.get('/health', (req, res) => {
    res.json({ status: 'healthy', timestamp: new Date().toISOString() });
});

// Start server
app.listen(port, () => {
    console.log(`Horizon Bank server running on port ${port}`);
});