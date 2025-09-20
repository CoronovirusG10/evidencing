/**
 * Main JavaScript File - Banking Website
 */

document.addEventListener('DOMContentLoaded', function() {

    // Mobile Menu Toggle
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileNav = document.querySelector('.mobile-nav');
    const mobileNavClose = document.querySelector('.mobile-nav-close');
    const body = document.body;

    if (mobileMenuToggle && mobileNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileNav.classList.add('active');
            body.style.overflow = 'hidden';

            // Create overlay
            const overlay = document.createElement('div');
            overlay.className = 'mobile-nav-overlay active';
            body.appendChild(overlay);

            overlay.addEventListener('click', closeMobileMenu);
        });

        if (mobileNavClose) {
            mobileNavClose.addEventListener('click', closeMobileMenu);
        }

        function closeMobileMenu() {
            mobileNav.classList.remove('active');
            body.style.overflow = '';

            const overlay = document.querySelector('.mobile-nav-overlay');
            if (overlay) {
                overlay.remove();
            }
        }

        // Populate mobile menu
        populateMobileMenu();
    }

    // Search Toggle
    const searchToggle = document.querySelector('.search-toggle');
    const searchOverlay = document.querySelector('.search-overlay');
    const searchClose = document.querySelector('.search-close');

    if (searchToggle && searchOverlay) {
        searchToggle.addEventListener('click', function() {
            searchOverlay.classList.add('active');
            body.style.overflow = 'hidden';

            // Focus on search input
            const searchInput = searchOverlay.querySelector('input[type="text"]');
            if (searchInput) {
                setTimeout(() => searchInput.focus(), 300);
            }
        });

        if (searchClose) {
            searchClose.addEventListener('click', function() {
                searchOverlay.classList.remove('active');
                body.style.overflow = '';
            });
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                searchOverlay.classList.remove('active');
                body.style.overflow = '';
            }
        });
    }

    // Sticky Header
    const header = document.querySelector('.main-header');
    if (header) {
        let lastScrollTop = 0;

        window.addEventListener('scroll', function() {
            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > 100) {
                header.classList.add('sticky');

                if (scrollTop > lastScrollTop) {
                    header.classList.add('hidden');
                } else {
                    header.classList.remove('hidden');
                }
            } else {
                header.classList.remove('sticky', 'hidden');
            }

            lastScrollTop = scrollTop;
        });
    }

    // Back to Top Button
    const backToTop = document.getElementById('back-to-top');
    if (backToTop) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Cookie Consent
    const cookieConsent = document.getElementById('cookie-consent');
    const acceptCookies = document.getElementById('accept-cookies');

    if (cookieConsent && !localStorage.getItem('cookiesAccepted')) {
        setTimeout(() => {
            cookieConsent.classList.add('show');
        }, 2000);

        if (acceptCookies) {
            acceptCookies.addEventListener('click', function() {
                localStorage.setItem('cookiesAccepted', 'true');
                cookieConsent.classList.remove('show');
            });
        }
    }

    // Form Validation
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });

    // Smooth Scroll for Anchor Links
    const anchorLinks = document.querySelectorAll('a[href^="#"]:not([href="#"])');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                const headerHeight = header ? header.offsetHeight : 0;
                const targetPosition = targetElement.offsetTop - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Number Counter Animation
    const counters = document.querySelectorAll('.counter');
    const observerOptions = {
        threshold: 0.5
    };

    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.getAttribute('data-target'));
                animateCounter(counter, target);
                counterObserver.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => {
        counterObserver.observe(counter);
    });

    // Language Switcher
    const languageSwitch = document.getElementById('language-switch');
    if (languageSwitch) {
        languageSwitch.addEventListener('change', function() {
            const selectedLang = this.value;
            // In a real application, this would trigger a language change
            console.log('Language switched to:', selectedLang);

            // For demo purposes, show a message
            if (selectedLang === 'ar') {
                document.dir = 'rtl';
            } else {
                document.dir = 'ltr';
            }
        });
    }

    // Loan Calculator
    const loanCalculator = document.getElementById('loan-calculator');
    if (loanCalculator) {
        const calculateBtn = loanCalculator.querySelector('#calculate-loan');

        if (calculateBtn) {
            calculateBtn.addEventListener('click', function() {
                const principal = parseFloat(document.getElementById('loan-amount').value);
                const rate = parseFloat(document.getElementById('interest-rate').value);
                const tenure = parseFloat(document.getElementById('loan-tenure').value);

                if (principal && rate && tenure) {
                    const monthlyRate = (rate / 100) / 12;
                    const emi = (principal * monthlyRate * Math.pow(1 + monthlyRate, tenure)) /
                               (Math.pow(1 + monthlyRate, tenure) - 1);

                    const totalAmount = emi * tenure;
                    const totalInterest = totalAmount - principal;

                    // Display results
                    document.getElementById('monthly-emi').textContent = formatCurrency(emi);
                    document.getElementById('total-interest').textContent = formatCurrency(totalInterest);
                    document.getElementById('total-amount').textContent = formatCurrency(totalAmount);

                    // Show results section
                    document.getElementById('calculation-results').style.display = 'block';
                }
            });
        }
    }

    // Currency Converter
    const currencyConverter = document.getElementById('currency-converter');
    if (currencyConverter) {
        const convertBtn = currencyConverter.querySelector('#convert-currency');

        if (convertBtn) {
            convertBtn.addEventListener('click', async function() {
                const amount = parseFloat(document.getElementById('amount').value);
                const fromCurrency = document.getElementById('from-currency').value;
                const toCurrency = document.getElementById('to-currency').value;

                if (amount && fromCurrency && toCurrency) {
                    // In a real application, this would fetch actual exchange rates
                    const exchangeRates = {
                        'USD': { 'EUR': 0.85, 'GBP': 0.73, 'AED': 3.67 },
                        'EUR': { 'USD': 1.18, 'GBP': 0.86, 'AED': 4.32 },
                        'GBP': { 'USD': 1.37, 'EUR': 1.16, 'AED': 5.03 },
                        'AED': { 'USD': 0.27, 'EUR': 0.23, 'GBP': 0.20 }
                    };

                    let convertedAmount;
                    if (fromCurrency === toCurrency) {
                        convertedAmount = amount;
                    } else {
                        const rate = exchangeRates[fromCurrency][toCurrency];
                        convertedAmount = amount * rate;
                    }

                    document.getElementById('converted-amount').textContent =
                        `${formatCurrency(convertedAmount, toCurrency)}`;
                    document.getElementById('conversion-results').style.display = 'block';
                }
            });
        }
    }

    // Tab Component
    const tabContainers = document.querySelectorAll('.tabs-container');
    tabContainers.forEach(container => {
        const tabs = container.querySelectorAll('.tab-btn');
        const panels = container.querySelectorAll('.tab-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const targetPanel = this.getAttribute('data-tab');

                // Remove active class from all tabs and panels
                tabs.forEach(t => t.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));

                // Add active class to clicked tab and corresponding panel
                this.classList.add('active');
                const panel = container.querySelector(`#${targetPanel}`);
                if (panel) {
                    panel.classList.add('active');
                }
            });
        });
    });

    // Accordion Component
    const accordions = document.querySelectorAll('.accordion');
    accordions.forEach(accordion => {
        const headers = accordion.querySelectorAll('.accordion-header');

        headers.forEach(header => {
            header.addEventListener('click', function() {
                const item = this.parentElement;
                const isActive = item.classList.contains('active');

                // Close all accordion items
                accordion.querySelectorAll('.accordion-item').forEach(i => {
                    i.classList.remove('active');
                });

                // Open clicked item if it wasn't active
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
    });

    // Helper Functions

    function populateMobileMenu() {
        const desktopMenu = document.querySelector('.nav-menu');
        const mobileMenu = document.querySelector('.mobile-menu');

        if (!desktopMenu || !mobileMenu) return;

        // Clone desktop menu items to mobile menu
        const menuItems = desktopMenu.querySelectorAll('.nav-item');

        menuItems.forEach(item => {
            const link = item.querySelector('> a');
            const dropdown = item.querySelector('.dropdown-menu');

            const mobileItem = document.createElement('li');

            if (dropdown) {
                mobileItem.className = 'has-submenu';

                const mainLink = document.createElement('a');
                mainLink.href = link.href;
                mainLink.textContent = link.textContent;
                mobileItem.appendChild(mainLink);

                const submenu = document.createElement('ul');
                submenu.className = 'submenu';

                const dropdownLinks = dropdown.querySelectorAll('a');
                dropdownLinks.forEach(subLink => {
                    const submenuItem = document.createElement('li');
                    const submenuLink = document.createElement('a');
                    submenuLink.href = subLink.href;
                    submenuLink.textContent = subLink.textContent;
                    submenuItem.appendChild(submenuLink);
                    submenu.appendChild(submenuItem);
                });

                mobileItem.appendChild(submenu);

                // Toggle submenu
                mainLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    mobileItem.classList.toggle('active');
                });
            } else {
                const simpleLink = document.createElement('a');
                simpleLink.href = link.href;
                simpleLink.textContent = link.textContent;
                mobileItem.appendChild(simpleLink);
            }

            mobileMenu.appendChild(mobileItem);
        });
    }

    function validateForm(form) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showFieldError(field, 'This field is required');
                isValid = false;
            } else {
                clearFieldError(field);
            }

            // Email validation
            if (field.type === 'email' && field.value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(field.value)) {
                    showFieldError(field, 'Please enter a valid email address');
                    isValid = false;
                }
            }

            // Phone validation
            if (field.type === 'tel' && field.value) {
                const phoneRegex = /^\d{9,15}$/;
                if (!phoneRegex.test(field.value.replace(/\D/g, ''))) {
                    showFieldError(field, 'Please enter a valid phone number');
                    isValid = false;
                }
            }
        });

        return isValid;
    }

    function showFieldError(field, message) {
        clearFieldError(field);
        field.classList.add('error');

        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        field.parentElement.appendChild(errorDiv);
    }

    function clearFieldError(field) {
        field.classList.remove('error');
        const existingError = field.parentElement.querySelector('.field-error');
        if (existingError) {
            existingError.remove();
        }
    }

    function animateCounter(element, target) {
        const duration = 2000; // 2 seconds
        const steps = 60;
        const stepDuration = duration / steps;
        const increment = target / steps;
        let current = 0;

        const timer = setInterval(() => {
            current += increment;

            if (current >= target) {
                current = target;
                clearInterval(timer);
            }

            element.textContent = Math.round(current).toLocaleString();
        }, stepDuration);
    }

    function formatCurrency(amount, currency = 'USD') {
        const symbols = {
            'USD': '$',
            'EUR': '€',
            'GBP': '£',
            'AED': 'AED '
        };

        const symbol = symbols[currency] || currency + ' ';
        return symbol + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
    }

    // Add CSS for search overlay (if not already in CSS)
    if (searchOverlay && !searchOverlay.classList.contains('initialized')) {
        const style = document.createElement('style');
        style.textContent = `
            .search-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0,0,0,0.95);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
                z-index: 9999;
            }

            .search-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .search-overlay-content {
                width: 90%;
                max-width: 600px;
                position: relative;
            }

            .search-close {
                position: absolute;
                top: -40px;
                right: 0;
                background: transparent;
                border: none;
                color: white;
                font-size: 2rem;
                cursor: pointer;
            }

            .search-form {
                display: flex;
                background-color: white;
                border-radius: 8px;
                overflow: hidden;
            }

            .search-form input {
                flex: 1;
                padding: 20px;
                border: none;
                font-size: 1.25rem;
                outline: none;
            }

            .search-form button {
                padding: 20px 30px;
                background-color: var(--primary-color);
                color: white;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .search-form button:hover {
                background-color: var(--secondary-color);
            }

            .main-header.sticky {
                position: fixed;
                top: 0;
                width: 100%;
                transition: transform 0.3s ease;
            }

            .main-header.hidden {
                transform: translateY(-100%);
            }

            .field-error {
                color: var(--danger-color);
                font-size: 0.875rem;
                margin-top: 5px;
            }

            .form-control.error {
                border-color: var(--danger-color);
            }
        `;
        document.head.appendChild(style);
        searchOverlay.classList.add('initialized');
    }
});