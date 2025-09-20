# Banking Website UI/UX - Static PHP Template

This is a static PHP banking website template inspired by NBQ Bank's design. It provides a complete, customizable banking website with modern UI/UX and responsive design.

## 🌟 Features

- **Modern Banking Design**: Clean, professional design inspired by NBQ Bank
- **Fully Responsive**: Works perfectly on desktop, tablet, and mobile devices
- **Customizable Branding**: Easy to customize logos, colors, and content
- **Three Banking Sections**: Wholesale, SME, and Personal banking
- **Interactive Elements**: Forms, calculators, and animations
- **SEO Optimized**: Meta tags, structured data, and semantic HTML
- **Performance Optimized**: Fast loading with optimized CSS and JavaScript

## 📁 Project Structure

```
UI-UX/
├── index.php                 # Homepage
├── README.md                 # This documentation
├── config/
│   └── site.config.php       # Main configuration file
├── includes/
│   ├── header.php            # Header template
│   ├── footer.php            # Footer template
│   └── functions.php         # Helper functions
├── assets/
│   ├── css/
│   │   ├── main.css         # Main stylesheet
│   │   └── responsive.css   # Responsive styles
│   ├── js/
│   │   └── main.js          # JavaScript functionality
│   └── images/              # Image assets
├── pages/
│   ├── wholesale/           # Wholesale banking pages
│   ├── sme/                 # SME banking pages
│   ├── personal/            # Personal banking pages
│   └── about/               # About and contact pages
├── forms/                   # Form templates
└── components/              # Reusable components
```

## 🚀 Quick Start

### 1. Server Requirements
- PHP 7.4 or higher
- Web server (Apache/Nginx)
- No database required (static files)

### 2. Installation
1. Copy the UI-UX folder to your web server
2. Configure your web server to serve PHP files
3. Access via browser: `http://your-domain/UI-UX/`

### 3. Basic Customization
Edit `config/site.config.php` to customize:
- Site name and tagline
- Company information
- Contact details
- Colors and branding
- Social media links

## 🎨 Customization Guide

### Branding Customization

#### 1. Change Site Name and Logo
```php
// In config/site.config.php
'site_name' => 'Your Bank Name',
'site_tagline' => 'Your Banking Tagline',
'logo' => [
    'main' => '/assets/images/logo/your-logo.png',
    'white' => '/assets/images/logo/your-logo-white.png',
    'favicon' => '/assets/images/logo/favicon.ico'
]
```

#### 2. Update Colors
```php
// In config/site.config.php
'colors' => [
    'primary' => '#YOUR_PRIMARY_COLOR',
    'secondary' => '#YOUR_SECONDARY_COLOR',
    'accent' => '#YOUR_ACCENT_COLOR'
]
```

#### 3. Contact Information
```php
// In config/site.config.php
'contact' => [
    'phone' => 'YOUR_PHONE_NUMBER',
    'email' => 'your-email@domain.com',
    'address' => 'Your Bank Address'
]
```

### Design Customization

#### 1. CSS Variables
The design uses CSS custom properties for easy theming:
```css
/* In assets/css/main.css */
:root {
    --primary-color: #003366;
    --secondary-color: #0066CC;
    --accent-color: #FF6B35;
    /* Update these to match your brand */
}
```

#### 2. Typography
```css
/* In assets/css/main.css */
:root {
    --font-family-primary: 'Your-Font', sans-serif;
    --font-family-heading: 'Your-Heading-Font', sans-serif;
}
```

### Content Customization

#### 1. Homepage Sections
Edit `index.php` to update:
- Hero section content
- Service descriptions
- Company statistics
- Feature highlights

#### 2. Service Pages
Update content in:
- `pages/wholesale/index.php`
- `pages/sme/index.php`
- `pages/personal/index.php`

#### 3. Navigation Menu
Modify navigation in `includes/header.php`:
```php
<li class="nav-item">
    <a href="/your-page/">Your Menu Item</a>
</li>
```

## 📱 Responsive Design

The template includes comprehensive responsive design:
- **Desktop**: Full layout with mega menus
- **Tablet**: Optimized for touch interfaces
- **Mobile**: Collapsible navigation and stacked layouts

### Breakpoints
- Desktop: 1024px and above
- Tablet: 768px to 1023px
- Mobile: 767px and below

## 🛠 Advanced Customization

### Adding New Pages

1. Create new PHP file in appropriate directory
2. Include the header and footer:
```php
<?php
$page_title = 'Your Page Title';
$page_description = 'Page description for SEO';
include('../../includes/functions.php');
include('../../includes/header.php');
?>

<!-- Your content here -->

<?php include('../../includes/footer.php'); ?>
```

### Creating Custom Components

Use the helper functions in `includes/functions.php`:
```php
// Service card
echo getServiceCard(
    'Service Title',
    'Service description',
    'fas fa-icon',
    '/link/to/service',
    'Button Text'
);

// Feature box
echo getFeatureBox(
    'Feature Title',
    ['Feature 1', 'Feature 2', 'Feature 3'],
    'Learn More',
    '/feature/link'
);
```

### JavaScript Functionality

The template includes:
- Mobile menu toggle
- Search overlay
- Smooth scrolling
- Form validation
- Loan calculator
- Currency converter
- Cookie consent

Extend functionality in `assets/js/main.js`.

## 📊 Interactive Elements

### Loan Calculator
The template includes a working loan calculator:
- EMI calculation
- Interest calculation
- Total amount calculation

### Currency Converter
Basic currency conversion with placeholder rates.

### Forms
All forms include:
- Client-side validation
- Responsive design
- Error handling

## 🔧 Configuration Options

### Feature Toggles
```php
// In config/site.config.php
'features' => [
    'online_banking' => true,
    'mobile_app' => true,
    'calculator_tools' => true,
    'live_chat' => false,
    'currency_converter' => true
]
```

### SEO Settings
```php
'seo' => [
    'default_title' => 'Your Bank - Banking Made Simple',
    'default_description' => 'Your bank description',
    'default_keywords' => 'banking, loans, accounts',
    'og_image' => '/assets/images/og-image.jpg'
]
```

## 🌐 Multi-language Support

The template includes basic multi-language structure:
```php
'languages' => [
    'default' => 'en',
    'available' => [
        'en' => 'English',
        'ar' => 'العربية'
    ]
]
```

## 📞 Support & Maintenance

### Browser Support
- Chrome 60+
- Firefox 60+
- Safari 12+
- Edge 79+

### Performance Optimization
- Minified CSS and JavaScript
- Optimized images
- Lazy loading
- Caching headers

### Security Considerations
- Input sanitization
- XSS protection
- CSRF tokens (if adding forms processing)
- Secure headers

## 🎯 Best Practices

1. **Always backup** before making changes
2. **Test responsive design** on multiple devices
3. **Optimize images** before uploading
4. **Use semantic HTML** for accessibility
5. **Follow naming conventions** for consistency

## 📝 License

This template is provided as-is for customization and use. Please ensure you have appropriate licenses for any images or assets you add.

## 🤝 Contributing

Feel free to suggest improvements or report issues. This template is designed to be easily extensible and customizable.

---

**Need Help?**
- Check the configuration file: `config/site.config.php`
- Review the helper functions: `includes/functions.php`
- Examine existing pages for examples
- Test thoroughly on different devices

**Happy Banking! 🏦**