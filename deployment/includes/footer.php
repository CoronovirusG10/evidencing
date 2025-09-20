    </main>
    <!-- End Main Content Wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-column footer-about">
                        <img src="<?php echo $config['logo']['white']; ?>" alt="<?php echo $config['site_name']; ?>" class="footer-logo">
                        <p><?php echo $config['site_tagline']; ?></p>
                        <div class="footer-contact">
                            <p><i class="fas fa-phone"></i> <?php echo $config['contact']['phone']; ?></p>
                            <p><i class="fas fa-envelope"></i> <?php echo $config['contact']['email']; ?></p>
                            <p><i class="fas fa-map-marker-alt"></i> <?php echo $config['contact']['address']; ?></p>
                        </div>
                        <div class="social-links">
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
                            <?php if($config['social']['youtube']): ?>
                                <a href="<?php echo $config['social']['youtube']; ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php foreach($config['footer_links'] as $section_title => $links): ?>
                    <div class="footer-column">
                        <h3><?php echo $section_title; ?></h3>
                        <ul class="footer-links">
                            <?php foreach($links as $link_text => $link_url): ?>
                            <li><a href="<?php echo $link_url; ?>"><?php echo $link_text; ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>

                    <?php if($config['features']['mobile_app']): ?>
                    <div class="footer-column footer-apps">
                        <h3>Download Our App</h3>
                        <p>Bank on the go with our mobile app</p>
                        <div class="app-buttons">
                            <a href="<?php echo $config['mobile_apps']['ios']; ?>" class="app-button">
                                <img src="/UI-UX/assets/images/app-store.png" alt="Download on App Store">
                            </a>
                            <a href="<?php echo $config['mobile_apps']['android']; ?>" class="app-button">
                                <img src="/UI-UX/assets/images/google-play.png" alt="Get it on Google Play">
                            </a>
                        </div>
                        <div class="qr-code">
                            <img src="/UI-UX/assets/images/qr-code.png" alt="QR Code">
                            <p>Scan to download</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="footer-middle">
            <div class="container">
                <div class="footer-features">
                    <div class="footer-feature">
                        <i class="fas fa-shield-alt"></i>
                        <h4>Secure Banking</h4>
                        <p>256-bit SSL encryption</p>
                    </div>
                    <div class="footer-feature">
                        <i class="fas fa-clock"></i>
                        <h4>24/7 Support</h4>
                        <p>Always here to help</p>
                    </div>
                    <div class="footer-feature">
                        <i class="fas fa-mobile-alt"></i>
                        <h4>Mobile Banking</h4>
                        <p>Bank anywhere, anytime</p>
                    </div>
                    <div class="footer-feature">
                        <i class="fas fa-award"></i>
                        <h4>Award Winning</h4>
                        <p>Best bank awards</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <div class="copyright">
                        <p>&copy; <?php echo date('Y'); ?> <?php echo $config['company']['legal_name']; ?>. All rights reserved.</p>
                        <p><?php echo $config['company']['license']; ?> | <?php echo $config['company']['registration']; ?></p>
                    </div>
                    <div class="footer-legal-links">
                        <a href="/UI-UX/pages/legal/terms.php">Terms & Conditions</a>
                        <a href="/UI-UX/pages/legal/privacy.php">Privacy Policy</a>
                        <a href="/UI-UX/pages/legal/cookies.php">Cookie Policy</a>
                        <a href="/UI-UX/pages/legal/security.php">Security</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Cookie Consent -->
    <div id="cookie-consent" class="cookie-consent">
        <div class="cookie-content">
            <p>We use cookies to improve your experience on our website. By browsing this website, you agree to our use of cookies.</p>
            <div class="cookie-buttons">
                <button id="accept-cookies" class="btn btn-primary">Accept</button>
                <a href="/UI-UX/pages/legal/cookies.php" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?php echo $base_path; ?>assets/js/main.js"></script>
    <script src="<?php echo $base_path; ?>assets/js/banking-portal.js"></script>
</body>
</html>