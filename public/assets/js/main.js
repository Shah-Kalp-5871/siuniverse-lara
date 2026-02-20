// Main JavaScript for SIU UNIVERSE

document.addEventListener('DOMContentLoaded', function () {
    // Initialize all animations and interactions

    // Add subtle animation to all cards on page load
    const cards = document.querySelectorAll('.bg-white.rounded-xl, .bg-white.rounded-2xl');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            anime({
                targets: card,
                opacity: 1,
                translateY: 0,
                duration: 600,
                easing: 'easeOutCubic',
                delay: index * 50
            });
        }, 100);
    });

    // Add ripple effect to buttons
    const buttons = document.querySelectorAll('button:not(.no-ripple)');
    buttons.forEach(button => {
        button.addEventListener('click', function (e) {
            const x = e.clientX - e.target.getBoundingClientRect().left;
            const y = e.clientY - e.target.getBoundingClientRect().top;

            const ripple = document.createElement('span');
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.classList.add('ripple');

            this.appendChild(ripple);

            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add CSS for ripple effect
    const style = document.createElement('style');
    style.textContent = `
        .ripple {
            position: absolute;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        }
        
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        button {
            position: relative;
            overflow: hidden;
        }
    `;
    document.head.appendChild(style);

    // Handle WhatsApp and Download buttons
    const allButtons = document.querySelectorAll('button');
    allButtons.forEach(button => {
        const text = button.textContent.toLowerCase();

        if (text.includes('join whatsapp')) {
            button.addEventListener('click', function () {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-external-link-alt mr-2"></i>Redirecting to WhatsApp...';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    showNotification('WhatsApp group link would open here (UI only)', 'info');
                }, 1000);
            });
        }

        if (text.includes('download')) {
            button.addEventListener('click', function () {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Downloading...';
                this.disabled = true;

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = false;
                    showNotification('File download would start here (UI only)', 'success');
                }, 1500);
            });
        }
    });

    // Add scroll progress indicator
    if (window.innerWidth > 768) {
        const progressBar = document.createElement('div');
        progressBar.className = 'fixed top-0 left-0 h-1 bg-gradient-to-r from-primary to-accent z-50';
        progressBar.style.width = '0%';
        progressBar.id = 'scroll-progress';
        document.body.appendChild(progressBar);

        window.addEventListener('scroll', () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progressBar.style.width = scrolled + '%';
        });
    }

    // Parallax effect for hero sections
    const heroSections = document.querySelectorAll('section.bg-gradient-to-br');
    window.addEventListener('scroll', () => {
        heroSections.forEach(section => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            section.style.transform = `translate3d(0, ${rate}px, 0)`;
        });
    });

    // Initialize tooltips
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(el => {
        el.addEventListener('mouseenter', function () {
            const tooltip = document.createElement('div');
            tooltip.className = 'fixed bg-gray-900 text-white px-3 py-2 rounded-lg text-sm z-50';
            tooltip.textContent = this.title;
            tooltip.id = 'custom-tooltip';

            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + rect.width / 2 + 'px';
            tooltip.style.top = rect.top - 40 + 'px';
            tooltip.style.transform = 'translateX(-50%)';

            document.body.appendChild(tooltip);

            anime({
                targets: tooltip,
                opacity: [0, 1],
                translateY: [10, 0],
                duration: 200,
                easing: 'easeOutCubic'
            });
        });

        el.addEventListener('mouseleave', function () {
            const tooltip = document.getElementById('custom-tooltip');
            if (tooltip) {
                anime({
                    targets: tooltip,
                    opacity: 0,
                    translateY: -10,
                    duration: 150,
                    easing: 'easeInCubic',
                    complete: () => tooltip.remove()
                });
            }
        });
    });
});

// Notification system
function showNotification(message, type = 'info') {
    const colors = {
        info: 'bg-blue-500',
        success: 'bg-green-500',
        warning: 'bg-yellow-500',
        error: 'bg-red-500'
    };

    const icons = {
        info: 'fa-info-circle',
        success: 'fa-check-circle',
        warning: 'fa-exclamation-triangle',
        error: 'fa-times-circle'
    };

    const notification = document.createElement('div');
    notification.className = `fixed bottom-4 right-4 ${colors[type]} text-white p-4 rounded-xl shadow-2xl z-[70] max-w-sm animate-slide-in-right`;
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas ${icons[type]} text-xl"></i>
            <div class="flex-1">
                <p class="text-sm">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="text-white/70 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            anime({
                targets: notification,
                opacity: 0,
                translateX: 100,
                duration: 300,
                easing: 'easeInCubic',
                complete: () => notification.remove()
            });
        }
    }, 5000);
}

// Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function for scroll events
function throttle(func, limit) {
    let inThrottle;
    return function () {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Cookie utility functions
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Local storage utility
const storage = {
    set: (key, value) => {
        try {
            localStorage.setItem(key, JSON.stringify(value));
        } catch (e) {
            console.warn('Local storage not available');
        }
    },
    get: (key) => {
        try {
            return JSON.parse(localStorage.getItem(key));
        } catch (e) {
            console.warn('Local storage not available');
            return null;
        }
    },
    remove: (key) => {
        try {
            localStorage.removeItem(key);
        } catch (e) {
            console.warn('Local storage not available');
        }
    }
};

// Form validation utility
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validateRequired(fields) {
    let isValid = true;
    fields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('border-red-500');
            isValid = false;
        } else {
            field.classList.remove('border-red-500');
        }
    });
    return isValid;
}

// Export utilities for use in other scripts
window.SIUUniverse = {
    showNotification,
    storage,
    validateEmail,
    validateRequired
};