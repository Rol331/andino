// EduFix Main JavaScript
$(document).ready(function() {
    
    // Back to Top Button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn();
        } else {
            $('.back-to-top').fadeOut();
        }
    });
    
    $('.back-to-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 800);
        return false;
    });
    
    // Smooth scrolling for anchor links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 80
            }, 1000);
        }
    });
    
    // Navbar scroll effect
    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $('.header-area').addClass('scrolled');
        } else {
            $('.header-area').removeClass('scrolled');
        }
    });
    
    // Course card hover effects
    $('.course-card').hover(
        function() {
            $(this).find('.course-image img').css('transform', 'scale(1.05)');
        },
        function() {
            $(this).find('.course-image img').css('transform', 'scale(1)');
        }
    );
    
    // Event card hover effects
    $('.event-card').hover(
        function() {
            $(this).find('.event-date').css('background', '#0056b3');
        },
        function() {
            $(this).find('.event-date').css('background', '#007bff');
        }
    );
    
    // Blog card hover effects
    $('.blog-card').hover(
        function() {
            $(this).find('.blog-image img').css('transform', 'scale(1.05)');
        },
        function() {
            $(this).find('.blog-image img').css('transform', 'scale(1)');
        }
    );
    
    // Form validation
    $('form').on('submit', function(e) {
        var isValid = true;
        $(this).find('input[required], select[required]').each(function() {
            if ($(this).val() === '') {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Por favor completa todos los campos requeridos.');
        }
    });
    
    // Remove validation classes on input
    $('input, select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Newsletter form submission
    $('.newsletter-form').on('submit', function(e) {
        e.preventDefault();
        var email = $(this).find('input[type="email"]').val();
        var privacyCheck = $(this).find('#privacyCheck').is(':checked');
        
        if (!email) {
            alert('Por favor ingresa tu email.');
            return;
        }
        
        if (!privacyCheck) {
            alert('Por favor acepta la política de privacidad.');
            return;
        }
        
        // Here you would typically send the data to your server
        alert('¡Gracias por suscribirte! Te mantendremos informado.');
        $(this)[0].reset();
    });
    
    // Counter animation
    function animateCounters() {
        $('.stat-number').each(function() {
            var $this = $(this);
            var countTo = $this.attr('data-count');
            
            $({ countNum: $this.text() }).animate({
                countNum: countTo
            }, {
                duration: 2000,
                easing: 'swing',
                step: function() {
                    $this.text(Math.floor(this.countNum));
                },
                complete: function() {
                    $this.text(this.countNum);
                }
            });
        });
    }
    
    // Trigger counter animation when in viewport
    $(window).scroll(function() {
        $('.stat-number').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                if (!$(this).hasClass('animated')) {
                    $(this).addClass('animated');
                    animateCounters();
                }
            }
        });
    });
    
    // Mobile menu toggle
    $('.navbar-toggler').click(function() {
        $(this).toggleClass('active');
    });
    
    // Close mobile menu when clicking on a link
    $('.navbar-nav .nav-link').click(function() {
        $('.navbar-collapse').collapse('hide');
    });
    
    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
    
    // Add loading states to buttons
    $('.btn').click(function() {
        if ($(this).hasClass('btn-loading')) {
            return false;
        }
        
        $(this).addClass('btn-loading');
        $(this).prop('disabled', true);
        
        setTimeout(() => {
            $(this).removeClass('btn-loading');
            $(this).prop('disabled', false);
        }, 2000);
    });
    
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Initialize popovers
    $('[data-bs-toggle="popover"]').popover();
    
    // Add scroll spy for navigation
    $('body').scrollspy({ target: '.navbar-nav', offset: 100 });
    
    // Parallax effect for hero section
    $(window).scroll(function() {
        var scrolled = $(this).scrollTop();
        var parallax = $('.hero-section');
        var speed = scrolled * 0.5;
        parallax.css('transform', 'translateY(' + speed + 'px)');
    });
    
    // Add animation classes when elements come into view
    function checkAnimation() {
        $('.animate-on-scroll').each(function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            
            if (elementBottom > viewportTop && elementTop < viewportBottom) {
                $(this).addClass('animated');
            }
        });
    }
    
    $(window).scroll(checkAnimation);
    checkAnimation(); // Check on page load
    
    // Add CSS for animations
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .animate-on-scroll {
                opacity: 0;
                transform: translateY(30px);
                transition: all 0.6s ease;
            }
            .animate-on-scroll.animated {
                opacity: 1;
                transform: translateY(0);
            }
            .btn-loading {
                position: relative;
                color: transparent !important;
            }
            .btn-loading:after {
                content: '';
                position: absolute;
                width: 16px;
                height: 16px;
                top: 50%;
                left: 50%;
                margin-left: -8px;
                margin-top: -8px;
                border: 2px solid transparent;
                border-top-color: #ffffff;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .header-area.scrolled {
                background: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(10px);
            }
        `)
        .appendTo('head');
    
    // Add animation classes to elements
    $('.course-card, .event-card, .blog-card, .tuition-card, .highlight-item').addClass('animate-on-scroll');
    
    console.log('EduFix JavaScript loaded successfully!');
});
