<?php
$page_title = 'Contact Us';
$page_description = 'Get in touch with our banking experts';
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

<!-- Contact Form Section -->
<section class="services-section">
    <div class="container">
        <div class="section-header">
            <h2>Get in Touch</h2>
            <p>We're here to help with all your banking needs</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: start;">
            <!-- Contact Form -->
            <div style="background: white; padding: 40px; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <h3 style="margin-bottom: 30px;">Send us a Message</h3>

                <form id="contact-form" data-validate>
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" class="form-control" required>
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="account">Account Services</option>
                            <option value="loan">Loan Information</option>
                            <option value="card">Credit Card</option>
                            <option value="business">Business Banking</option>
                            <option value="complaint">Complaint</option>
                            <option value="support">Technical Support</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" class="form-control" rows="5" required placeholder="Please describe your inquiry in detail"></textarea>
                    </div>

                    <div class="form-group">
                        <label style="display: flex; align-items: center; cursor: pointer;">
                            <input type="checkbox" name="privacy" required style="margin-right: 10px;">
                            I agree to the <a href="pages/legal/privacy.php" target="_blank">Privacy Policy</a>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-paper-plane" style="margin-right: 10px;"></i>
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 style="margin-bottom: 30px;">Contact Information</h3>

                <div style="margin-bottom: 40px;">
                    <div style="display: flex; align-items: center; margin-bottom: 25px; padding: 20px; background: var(--light-color); border-radius: var(--border-radius);">
                        <div style="width: 50px; height: 50px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px; flex-shrink: 0;">
                            <i class="fas fa-phone" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px;">Phone</h4>
                            <p style="margin: 0; color: var(--text-light);"><?php echo $config['contact']['phone']; ?></p>
                            <small style="color: var(--text-light);">24/7 Customer Service</small>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 25px; padding: 20px; background: var(--light-color); border-radius: var(--border-radius);">
                        <div style="width: 50px; height: 50px; background: var(--secondary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px; flex-shrink: 0;">
                            <i class="fas fa-envelope" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px;">Email</h4>
                            <p style="margin: 0; color: var(--text-light);"><?php echo $config['contact']['email']; ?></p>
                            <small style="color: var(--text-light);">Response within 24 hours</small>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; margin-bottom: 25px; padding: 20px; background: var(--light-color); border-radius: var(--border-radius);">
                        <div style="width: 50px; height: 50px; background: var(--accent-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 20px; flex-shrink: 0;">
                            <i class="fas fa-map-marker-alt" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 style="margin-bottom: 5px;">Address</h4>
                            <p style="margin: 0; color: var(--text-light);"><?php echo $config['contact']['address']; ?></p>
                            <small style="color: var(--text-light);">Visit our head office</small>
                        </div>
                    </div>
                </div>

                <h4 style="margin-bottom: 20px;">Business Hours</h4>
                <div style="background: white; padding: 25px; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                        <span>Monday - Friday</span>
                        <span style="font-weight: 500;"><?php echo $config['contact']['working_hours']; ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid var(--border-color);">
                        <span>Saturday</span>
                        <span style="font-weight: 500;"><?php echo $config['contact']['weekend_hours']; ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>Sunday</span>
                        <span style="font-weight: 500; color: var(--danger-color);">Closed</span>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <h4 style="margin-bottom: 15px;">Follow Us</h4>
                    <div class="social-links" style="justify-content: flex-start;">
                        <?php if($config['social']['facebook']): ?>
                            <a href="<?php echo $config['social']['facebook']; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <?php endif; ?>
                        <?php if($config['social']['twitter']): ?>
                            <a href="<?php echo $config['social']['twitter']; ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if($config['social']['linkedin']): ?>
                            <a href="<?php echo $config['social']['linkedin']; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                        <?php endif; ?>
                        <?php if($config['social']['instagram']): ?>
                            <a href="<?php echo $config['social']['instagram']; ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="product-highlights">
    <div class="container">
        <div class="section-header">
            <h2>Frequently Asked Questions</h2>
            <p>Quick answers to common questions</p>
        </div>

        <div class="accordion" style="max-width: 800px; margin: 0 auto;">
            <div class="accordion-item" style="margin-bottom: 15px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <div class="accordion-header" style="padding: 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="margin: 0;">What are your banking hours?</h4>
                    <i class="fas fa-chevron-down" style="color: var(--primary-color);"></i>
                </div>
                <div class="accordion-content" style="padding: 0 20px 20px; display: none;">
                    <p>Our branches are open Monday to Friday from 8:00 AM to 5:00 PM, and Saturday from 9:00 AM to 1:00 PM. Online banking is available 24/7.</p>
                </div>
            </div>

            <div class="accordion-item" style="margin-bottom: 15px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <div class="accordion-header" style="padding: 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="margin: 0;">How can I open a bank account?</h4>
                    <i class="fas fa-chevron-down" style="color: var(--primary-color);"></i>
                </div>
                <div class="accordion-content" style="padding: 0 20px 20px; display: none;">
                    <p>You can open an account online through our website, visit any of our branches, or call our customer service team. You'll need valid ID, proof of address, and initial deposit.</p>
                </div>
            </div>

            <div class="accordion-item" style="margin-bottom: 15px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <div class="accordion-header" style="padding: 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="margin: 0;">What loan options do you offer?</h4>
                    <i class="fas fa-chevron-down" style="color: var(--primary-color);"></i>
                </div>
                <div class="accordion-content" style="padding: 0 20px 20px; display: none;">
                    <p>We offer personal loans, home loans, auto loans, business loans, and specialized financing solutions. Each comes with competitive rates and flexible terms.</p>
                </div>
            </div>

            <div class="accordion-item" style="margin-bottom: 15px; background: white; border-radius: var(--border-radius); box-shadow: var(--box-shadow);">
                <div class="accordion-header" style="padding: 20px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                    <h4 style="margin: 0;">Is online banking secure?</h4>
                    <i class="fas fa-chevron-down" style="color: var(--primary-color);"></i>
                </div>
                <div class="accordion-content" style="padding: 0 20px 20px; display: none;">
                    <p>Yes, our online banking uses 256-bit SSL encryption, multi-factor authentication, and real-time fraud monitoring to ensure your security.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Accordion functionality
    const accordionHeaders = document.querySelectorAll('.accordion-header');

    accordionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const item = this.parentElement;
            const content = item.querySelector('.accordion-content');
            const icon = this.querySelector('i');

            const isActive = item.classList.contains('active');

            // Close all accordions
            document.querySelectorAll('.accordion-item').forEach(i => {
                i.classList.remove('active');
                i.querySelector('.accordion-content').style.display = 'none';
                i.querySelector('.accordion-header i').style.transform = 'rotate(0deg)';
            });

            // Open clicked accordion if it wasn't active
            if (!isActive) {
                item.classList.add('active');
                content.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
            }
        });
    });

    // Form submission
    document.getElementById('contact-form').addEventListener('submit', function(e) {
        e.preventDefault();

        // Here you would normally send the form data to a server
        alert('Thank you for your message! We will get back to you within 24 hours.');
        this.reset();
    });
});
</script>

<?php include('../includes/footer.php'); ?>