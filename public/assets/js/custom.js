document.addEventListener('DOMContentLoaded', function () {
    // document.getElementById('pageLoader').classList.remove('hidden');
    //
    // setTimeout(function () {
    //     document.getElementById('pageLoader').classList.add('hidden');
    // }, 1500);
// });
// Livewire.on('close-edit-modal', () => {
//     document.querySelector('#close-edit-modal').click();
// });
//
// Livewire.on('close-create-modal', () => {
//     document.querySelector('#close-create-modal').click();
// });
//
// Livewire.on('close-delete-modal', () => {
//     document.querySelector('#close-delete-modal').click();
// });
//
// Livewire.on('close-deactivate-modal', () => {
//     document.querySelector('#close-deactivate-modal').click();
// });
//
// Livewire.on('close-assign-modal', () => {
//     document.querySelector('#close-assign-modal').click();
// });
//
// Livewire.on('close-show-modal', () => {
//     document.querySelector('#close-show-modal').click();
// });
// // Wait for Livewire to be available before using it
// document.addEventListener('DOMContentLoaded', function() {
//     // Check if Livewire is available
//     if (typeof Livewire === 'undefined') {
//         console.warn('Livewire not available, waiting for initialization...');
//
//         // Wait for Livewire to be ready
//         document.addEventListener('livewire:init', function() {
//             console.log('Livewire initialized, custom scripts ready');
//             initializeCustomScripts();
//         });
//     } else {
//         console.log('Livewire available, initializing custom scripts');
//         initializeCustomScripts();
//     }
// });
//
// function initializeCustomScripts() {
//     // Your custom scripts that depend on Livewire go here
//
//     // Example: Livewire event listeners
//     if (typeof Livewire !== 'undefined' && Livewire.on) {
//         // Listen for Livewire events
//         Livewire.on('notification', (message) => {
//             console.log('Notification:', message);
//             // Handle notifications here
//         });
//
//         // Listen for tab changes
//         Livewire.on('tabChanged', (tab) => {
//             console.log('Tab changed to:', tab);
//             // Handle tab changes here
//         });
//     }
//
//     // Non-Livewire dependent scripts can go here
//     initializeGeneralScripts();
// }

    function initializeGeneralScripts() {
        // Scripts that don't depend on Livewire

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced form validation
        const forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(form => {
            form.addEventListener('submit', function (e) {
                if (!validateForm(this)) {
                    e.preventDefault();
                    return false;
                }
            });
        });

        // Add loading states to buttons
        const loadingButtons = document.querySelectorAll('[data-loading]');
        loadingButtons.forEach(button => {
            button.addEventListener('click', function () {
                addLoadingState(this);
            });
        });

        // Initialize tooltips (if using a tooltip library)
        initializeTooltips();

        // Initialize modals
        initializeModals();

        // Image lazy loading fallback
        initializeLazyLoading();

        console.log('General scripts initialized');
    }

    function validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showFieldError(field, 'این فیلد الزامی است');
                isValid = false;
            } else {
                clearFieldError(field);
            }
        });

        return isValid;
    }

    function showFieldError(field, message) {
        // Remove existing error
        clearFieldError(field);

        // Add error class
        field.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');

        // Create error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error text-red-500 text-sm mt-1';
        errorDiv.textContent = message;

        // Insert error message
        field.parentNode.insertBefore(errorDiv, field.nextSibling);
    }

    function clearFieldError(field) {
        // Remove error classes
        field.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');

        // Remove error message
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    function addLoadingState(button) {
        // Store original content
        const originalContent = button.innerHTML;
        button.dataset.originalContent = originalContent;

        // Add loading content
        button.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        در حال پردازش...
    `;

        // Disable button
        button.disabled = true;

        // Auto-restore after 5 seconds (fallback)
        setTimeout(() => {
            removeLoadingState(button);
        }, 5000);
    }

    function removeLoadingState(button) {
        if (button.dataset.originalContent) {
            button.innerHTML = button.dataset.originalContent;
            button.disabled = false;
            delete button.dataset.originalContent;
        }
    }

    function initializeTooltips() {
        // Initialize tooltips if you're using a tooltip library
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        tooltipElements.forEach(element => {
            // Add tooltip functionality here
            element.addEventListener('mouseenter', function () {
                showTooltip(this, this.dataset.tooltip);
            });

            element.addEventListener('mouseleave', function () {
                hideTooltip();
            });
        });
    }

    function showTooltip(element, text) {
        // Create tooltip if it doesn't exist
        let tooltip = document.getElementById('custom-tooltip');
        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.id = 'custom-tooltip';
            tooltip.className = 'absolute z-50 px-3 py-2 text-sm text-white bg-gray-900 rounded-lg shadow-lg pointer-events-none';
            document.body.appendChild(tooltip);
        }

        tooltip.textContent = text;
        tooltip.style.display = 'block';

        // Position tooltip
        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
    }

    function hideTooltip() {
        const tooltip = document.getElementById('custom-tooltip');
        if (tooltip) {
            tooltip.style.display = 'none';
        }
    }

    function initializeModals() {
        // Modal functionality
        const modalTriggers = document.querySelectorAll('[data-modal-target]');
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function () {
                const modalId = this.dataset.modalTarget;
                const modal = document.getElementById(modalId);
                if (modal) {
                    showModal(modal);
                }
            });
        });

        // Close modal on background click
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('modal-backdrop')) {
                closeModal(e.target.closest('.modal'));
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.active');
                if (openModal) {
                    closeModal(openModal);
                }
            }
        });
    }

    function showModal(modal) {
        modal.classList.add('active');
        document.body.classList.add('modal-open');
    }

    function closeModal(modal) {
        modal.classList.remove('active');
        document.body.classList.remove('modal-open');
    }

    function initializeLazyLoading() {
        // Simple lazy loading implementation
        const lazyImages = document.querySelectorAll('img[data-src]');

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

            lazyImages.forEach(img => imageObserver.observe(img));
        } else {
            // Fallback for older browsers
            lazyImages.forEach(img => {
                img.src = img.dataset.src;
                img.classList.remove('lazy');
            });
        }
    }

// Utility functions
    const utils = {
        // Debounce function
        debounce: function (func, wait, immediate) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    timeout = null;
                    if (!immediate) func(...args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func(...args);
            };
        },

        // Throttle function
        throttle: function (func, limit) {
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
        },

        // Format numbers for Persian locale
        formatNumber: function (num) {
            return new Intl.NumberFormat('fa-IR').format(num);
        },

        // Convert English digits to Persian
        toPersianDigits: function (str) {
            const persianDigits = '۰۱۲۳۴۵۶۷۸۹';
            const englishDigits = '0123456789';

            return str.toString().replace(/[0-9]/g, (digit) => {
                return persianDigits[englishDigits.indexOf(digit)];
            });
        }
    };

// Make utils available globally
    window.utils = utils;

// Export functions for use in other scripts
    window.customScripts = {
        addLoadingState,
        removeLoadingState,
        showModal,
        closeModal,
        showTooltip,
        hideTooltip,
        validateForm
    };
})
