<?php
/**
 * Site Configuration File
 * Customize all branding and site settings here
 */

return [
    // Basic Site Information
    'site_name' => 'Horizon Bank',
    'site_tagline' => 'Your Banking Partner for Success',
    'site_url' => 'http://localhost/UI-UX',

    // Company Information
    'company' => [
        'legal_name' => 'Horizon Bank Corporation',
        'established' => '1974',
        'license' => 'Licensed by Central Bank',
        'registration' => 'Company Reg. No. 12345'
    ],

    // Branding
    'logo' => [
        'main' => '/assets/images/logo/horizon-logo.png',
        'white' => '/assets/images/logo/horizon-logo-white.png',
        'favicon' => '/assets/images/logo/favicon.ico'
    ],

    // Contact Information
    'contact' => [
        'phone' => '600 56 56 56',
        'email' => 'info@horizonbank.com',
        'support_email' => 'support@horizonbank.com',
        'address' => '123 Financial District, Main Street, City',
        'working_hours' => 'Monday - Friday: 8:00 AM - 5:00 PM',
        'weekend_hours' => 'Saturday: 9:00 AM - 1:00 PM'
    ],

    // Social Media
    'social' => [
        'facebook' => 'https://facebook.com/horizonbank',
        'twitter' => 'https://twitter.com/horizonbank',
        'linkedin' => 'https://linkedin.com/company/horizonbank',
        'instagram' => 'https://instagram.com/horizonbank',
        'youtube' => 'https://youtube.com/horizonbank'
    ],

    // Theme Colors (can be overridden in CSS)
    'colors' => [
        'primary' => '#003366',      // Deep Blue
        'secondary' => '#0066CC',    // Bright Blue
        'accent' => '#FF6B35',       // Orange
        'success' => '#28A745',      // Green
        'warning' => '#FFC107',      // Yellow
        'danger' => '#DC3545',       // Red
        'dark' => '#2C3E50',         // Dark Gray
        'light' => '#F8F9FA',        // Light Gray
        'white' => '#FFFFFF',        // White
        'text' => '#333333'          // Text Color
    ],

    // Language Settings
    'languages' => [
        'default' => 'en',
        'available' => [
            'en' => 'English',
            'ar' => 'العربية'
        ]
    ],

    // Features Toggle
    'features' => [
        'online_banking' => true,
        'mobile_app' => true,
        'calculator_tools' => true,
        'live_chat' => false,
        'currency_converter' => true,
        'branch_locator' => true,
        'atm_locator' => true
    ],

    // Banking Services Configuration
    'services' => [
        'wholesale' => [
            'enabled' => true,
            'name' => 'Wholesale Banking',
            'description' => 'Comprehensive banking solutions for large corporations'
        ],
        'sme' => [
            'enabled' => true,
            'name' => 'SME Banking',
            'description' => 'Tailored solutions for small and medium enterprises'
        ],
        'personal' => [
            'enabled' => true,
            'name' => 'Personal Banking',
            'description' => 'Complete banking services for individuals'
        ]
    ],

    // Quick Links Configuration
    'quick_links' => [
        'Online Banking' => '#online-banking',
        'Open Account' => '/forms/account-opening.php',
        'Apply for Loan' => '/forms/loan-application.php',
        'Find Branch/ATM' => '/pages/about/locations.php',
        'Contact Us' => '/pages/about/contact.php'
    ],

    // Footer Links
    'footer_links' => [
        'About Us' => [
            'About Horizon Bank' => '/pages/about/',
            'Leadership Team' => '/pages/about/leadership.php',
            'Careers' => '/pages/about/careers.php',
            'Press Room' => '/pages/about/press.php'
        ],
        'Customer Service' => [
            'Contact Us' => '/pages/about/contact.php',
            'Find a Branch' => '/pages/about/locations.php',
            'FAQs' => '/pages/support/faqs.php',
            'Complaint & Feedback' => '/forms/feedback.php'
        ],
        'Resources' => [
            'Forms & Documents' => '/pages/resources/forms.php',
            'Rates & Charges' => '/pages/resources/rates.php',
            'Security Center' => '/pages/resources/security.php',
            'Terms & Conditions' => '/pages/legal/terms.php'
        ]
    ],

    // SEO Configuration
    'seo' => [
        'default_title' => 'Horizon Bank - Your Banking Partner',
        'default_description' => 'Horizon Bank offers comprehensive banking solutions for wholesale, SME, and personal banking needs.',
        'default_keywords' => 'banking, loans, accounts, credit cards, business banking, personal banking',
        'og_image' => '/assets/images/og-image.jpg'
    ],

    // App Downloads
    'mobile_apps' => [
        'ios' => 'https://apps.apple.com/app/horizonbank',
        'android' => 'https://play.google.com/store/apps/horizonbank'
    ]
];