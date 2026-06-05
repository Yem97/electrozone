(function() {
    'use strict';

    // Application namespace
    window.EcommerceApp = window.EcommerceApp || {};

    // Utility functions
    const Utils = {
        // Safely execute function when DOM is ready
        onReady: function(fn) {
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', fn);
            } else {
                fn();
            }
        },

        // Debounce function for performance
        debounce: function(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },

        // Check if element is in viewport
        isInViewport: function(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }
    };

    // Cart functionality enhancement
    const Cart = {
        init: function() {
            this.bindEvents();
            this.updateCartDisplay();
        },

        bindEvents: function() {
            // Handle quantity changes
            document.addEventListener('change', function(e) {
                if (e.target.matches('input[name*="quantity"]')) {
                    Cart.handleQuantityChange(e.target);
                }
            });

            // Handle add to cart buttons
            document.addEventListener('click', function(e) {
                if (e.target.matches('.add-to-cart-btn')) {
                    Cart.handleAddToCart(e.target);
                }
            });
        },

        handleQuantityChange: Utils.debounce(function(input) {
            const quantity = parseInt(input.value) || 1;
            if (quantity < 1) {
                input.value = 1;
                return;
            }
            // Auto-submit form or make AJAX call here if needed
        }, 500),

        handleAddToCart: function(button) {
            // Add loading state
            button.disabled = true;
            button.textContent = 'Adding...';
            
            // Reset after animation
            setTimeout(() => {
                button.disabled = false;
                button.textContent = 'Add to Cart';
            }, 1000);
        },

        updateCartDisplay: function() {
            // Update cart count if element exists
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                // This would typically come from server or localStorage
                // cartCount.textContent = getCartItemCount();
            }
        }
    };

    // Form validation enhancement
    const Forms = {
        init: function() {
            this.bindValidation();
        },

        bindValidation: function() {
            const forms = document.querySelectorAll('form[data-validate]');
            forms.forEach(form => {
                form.addEventListener('submit', this.validateForm);
            });
        },

        validateForm: function(e) {
            const form = e.target;
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                e.preventDefault();
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
        }
    };

    // Search functionality
    const Search = {
        init: function() {
            this.bindSearch();
        },

        bindSearch: function() {
            const searchInputs = document.querySelectorAll('input[type="search"]');
            searchInputs.forEach(input => {
                input.addEventListener('input', Utils.debounce(this.handleSearch, 300));
            });
        },

        handleSearch: function(e) {
            const query = e.target.value.trim();
            if (query.length >= 2) {
                // Implement search functionality
                console.log('Searching for:', query);
            }
        }
    };

    // Mobile menu handling
    const MobileMenu = {
        init: function() {
            this.bindMobileMenu();
        },

        bindMobileMenu: function() {
            const toggle = document.querySelector('.navbar-toggler');
            const menu = document.querySelector('.navbar-collapse');
            
            if (toggle && menu) {
                toggle.addEventListener('click', () => {
                    menu.classList.toggle('show');
                    const expanded = menu.classList.contains('show');
                    toggle.setAttribute('aria-expanded', expanded);
                });

                // Close on outside click
                document.addEventListener('click', (e) => {
                    if (!toggle.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.remove('show');
                        toggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        }
    };

    // Image lazy loading
    const Images = {
        init: function() {
            this.lazyLoad();
        },

        lazyLoad: function() {
            const images = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        }
    };

    // Initialize all modules
    EcommerceApp.init = function() {
      // App Initialization
      document.addEventListener('DOMContentLoaded', function() {
          console.log('App initialization started');

          // Disable Bootstrap dropdown auto-initialization
          if (window.bootstrap && window.bootstrap.Dropdown) {
              // Prevent Bootstrap from auto-initializing dropdowns
              document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(element => {
                  element.removeAttribute('data-bs-toggle');
              });
          }

          // Initialize custom dropdowns after a small delay to ensure DOM is fully ready
          setTimeout(function() {
              if (typeof CustomDropdown !== 'undefined') {
                  new CustomDropdown();
                  console.log('Custom dropdown initialized');
              } else {
                  console.log('CustomDropdown class not found, loading script...');

                  // Load custom dropdown script if not already loaded
                  const script = document.createElement('script');
                  script.src = '/js/custom-dropdown.js';
                  script.onload = function() {
                      new CustomDropdown();
                      console.log('Custom dropdown loaded and initialized');
                  };
                  document.head.appendChild(script);
              }
          }, 100);

          console.log('App initialization completed');
      });
    };

    // Auto-initialize
    EcommerceApp.init();

})();