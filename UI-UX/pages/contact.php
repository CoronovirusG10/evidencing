<?php
$page_title = 'Contact Us';
$page_description = 'Get in touch with our banking experts. Find branch locations, contact information, and reach out for support.';
include('../includes/functions.php');
include('../includes/header.php');

$config = getConfig();
?>

<!-- Breadcrumb -->
<div class="breadcrumb">
    <div class="container">
        <ol>
            <li><a href="../index.php">Home</a></li>
            <li class="active">Contact Us</li>
        </ol>
    </div>
</div>

<!-- Hero Section -->
<section class="contact-hero">
    <div class="container">
        <div class="hero-content-wrapper">
            <div class="hero-content">
                <h1>Get in Touch</h1>
                <p>We're here to help with all your banking needs. Connect with our expert team for personalized assistance.</p>

                <div class="contact-stats">
                    <div class="stat-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>24/7 Phone Support</h4>
                            <p><?php echo $config['contact']['phone']; ?></p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>Email Support</h4>
                            <p><?php echo $config['contact']['email']; ?></p>
                        </div>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-comments"></i>
                        <div>
                            <h4>WhatsApp Banking</h4>
                            <p>+971 50 123 4567</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="contact-image-container">
                    <img src="../assets/images/contact-hero.jpg" alt="Customer Support" class="contact-hero-image">
                    <div class="support-badge">
                        <i class="fas fa-headset"></i>
                        <div>
                            <h4>Expert Support</h4>
                            <p>Available 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Information Section -->
<section class="contact-main-section">
    <div class="container">
        <div class="contact-grid">
            <!-- Contact Form -->
            <div class="contact-form-section">
                <div class="form-header">
                    <h2>Send us a Message</h2>
                    <p>Fill out the form below and we'll get back to you within 24 hours</p>
                </div>

                <form id="contact-form" class="contact-form" action="../forms/contact-handler.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="first-name">First Name *</label>
                            <input type="text" id="first-name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last-name">Last Name *</label>
                            <input type="text" id="last-name" name="last_name" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inquiry-type">Inquiry Type *</label>
                        <select id="inquiry-type" name="inquiry_type" required>
                            <option value="">Select an option</option>
                            <option value="account">Account Services</option>
                            <option value="loans">Loans & Credit</option>
                            <option value="business">Business Banking</option>
                            <option value="investment">Investment Services</option>
                            <option value="technical">Technical Support</option>
                            <option value="complaint">Complaint</option>
                            <option value="general">General Inquiry</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="6" required placeholder="Please provide details about your inquiry..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="newsletter" value="1">
                            <span class="checkmark"></span>
                            Subscribe to our newsletter for banking updates and offers
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="privacy" required>
                            <span class="checkmark"></span>
                            I agree to the <a href="../pages/legal/privacy.php" target="_blank">Privacy Policy</a> and <a href="../pages/legal/terms.php" target="_blank">Terms of Service</a> *
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane"></i>
                        <span>Send Message</span>
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="contact-info-section">
                <div class="contact-info-card">
                    <h3>Other Ways to Reach Us</h3>

                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="method-content">
                                <h4>Phone Banking</h4>
                                <p><?php echo $config['contact']['phone']; ?></p>
                                <span>Available 24/7</span>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="method-content">
                                <h4>WhatsApp Banking</h4>
                                <p>+971 50 123 4567</p>
                                <span>Quick and easy banking</span>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="method-content">
                                <h4>Email Support</h4>
                                <p><?php echo $config['contact']['email']; ?></p>
                                <span>Response within 24 hours</span>
                            </div>
                        </div>

                        <div class="contact-method">
                            <div class="method-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="method-content">
                                <h4>Live Chat</h4>
                                <p>Website chat support</p>
                                <span>Mon-Fri, 8 AM - 6 PM</span>
                            </div>
                        </div>
                    </div>

                    <div class="emergency-contact">
                        <h4><i class="fas fa-exclamation-triangle"></i> Emergency Contact</h4>
                        <p>For urgent banking matters outside business hours:</p>
                        <p><strong>+971 800 HORIZON (467496)</strong></p>
                    </div>
                </div>

                <div class="branch-locator-card">
                    <h3>Find a Branch or ATM</h3>
                    <p>Locate our nearest branch or ATM for in-person banking services.</p>
                    <a href="../pages/about/locations.php" class="btn btn-outline">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Branch Locator</span>
                    </a>
                </div>

                <div class="support-hours-card">
                    <h3>Support Hours</h3>
                    <div class="hours-list">
                        <div class="hours-item">
                            <span>Phone Support</span>
                            <span>24/7</span>
                        </div>
                        <div class="hours-item">
                            <span>Email Support</span>
                            <span>24/7</span>
                        </div>
                        <div class="hours-item">
                            <span>Live Chat</span>
                            <span>Mon-Fri: 8 AM - 6 PM</span>
                        </div>
                        <div class="hours-item">
                            <span>Branch Hours</span>
                            <span>Sun-Thu: 8 AM - 5 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common banking questions</p>
        </div>

        <div class="faq-grid">
            <div class="faq-item">
                <div class="faq-question">
                    <h4>How do I open a bank account?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>You can open an account online through our website, visit any of our branches, or call our customer service. You'll need a valid ID, proof of address, and initial deposit.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>What are your current interest rates?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>Interest rates vary by account type and current market conditions. Please visit our rates page or contact us for the most up-to-date information on savings accounts, loans, and deposits.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>How secure is online banking?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>We use industry-leading 256-bit SSL encryption, multi-factor authentication, and continuous monitoring to protect your accounts. Your security is our top priority.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>Can I apply for a loan online?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>Yes, you can apply for personal loans, home loans, and auto loans online. The application process is simple and you'll receive a decision quickly.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>What mobile banking features do you offer?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>Our mobile app offers account management, fund transfers, bill payments, check deposits, ATM locators, and secure messaging with customer service.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    <h4>How do I report a lost or stolen card?</h4>
                    <i class="fas fa-plus"></i>
                </div>
                <div class="faq-answer">
                    <p>Contact us immediately at our 24/7 hotline, use the mobile app, or visit any branch. We'll block your card instantly and issue a replacement within 2-3 business days.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Map Section -->
<section class="map-section">
    <div class="container">
        <div class="section-header">
            <h2>Visit Our Head Office</h2>
            <p>Located in the heart of the business district</p>
        </div>

        <div class="map-content">
            <div class="map-placeholder">
                <div class="map-overlay">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Head Office Location</h3>
                    <p><?php echo $config['contact']['address']; ?></p>
                    <a href="#" class="btn btn-primary">Get Directions</a>
                </div>
            </div>

            <div class="office-info">
                <h3>Head Office Details</h3>
                <div class="office-details">
                    <div class="detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Address</strong>
                            <p><?php echo $config['contact']['address']; ?></p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Business Hours</strong>
                            <p>Sunday - Thursday: 8:00 AM - 5:00 PM<br>
                            Friday: 8:00 AM - 12:00 PM<br>
                            Saturday: Closed</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-car"></i>
                        <div>
                            <strong>Parking</strong>
                            <p>Free customer parking available</p>
                        </div>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-wheelchair"></i>
                        <div>
                            <strong>Accessibility</strong>
                            <p>Wheelchair accessible with dedicated facilities</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('../includes/footer.php'); ?>