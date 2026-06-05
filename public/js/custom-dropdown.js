

// Custom Dropdown Implementation
class CustomDropdown {
    constructor() {
        this.init();
    }

    init() {
        // Wait for DOM to be ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.setupDropdowns());
        } else {
            this.setupDropdowns();
        }
    }

    setupDropdowns() {
        // Remove any existing event listeners to prevent duplicates
        this.removeExistingListeners();
        
        const dropdownToggles = document.querySelectorAll('.custom-dropdown-toggle, .dropdown-toggle');
        
        dropdownToggles.forEach(toggle => {
            this.setupDropdown(toggle);
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.custom-dropdown, .dropdown')) {
                this.closeAllDropdowns();
            }
        });

        // Close dropdowns on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllDropdowns();
            }
        });
    }

    removeExistingListeners() {
        // Remove Bootstrap dropdown functionality to prevent conflicts
        const existingToggles = document.querySelectorAll('.custom-dropdown-toggle, .dropdown-toggle');
        existingToggles.forEach(toggle => {
            toggle.removeAttribute('data-bs-toggle');
            toggle.removeAttribute('data-toggle');
            toggle.removeAttribute('data-bs-target');
            toggle.removeAttribute('data-target');
        });
    }

    setupDropdown(toggle) {
        const dropdown = toggle.closest('.custom-dropdown, .dropdown');
        const menu = dropdown.querySelector('.custom-dropdown-menu, .dropdown-menu');
        
        if (!menu) {
            console.error('Dropdown menu not found for toggle:', toggle);
            return;
        }

        toggle.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            const isOpen = menu.classList.contains('show');
            
            // Close all other dropdowns first
            this.closeAllDropdowns();
            
            // Toggle current dropdown
            if (!isOpen) {
                this.openDropdown(toggle, menu);
            }
        });
    }

    openDropdown(toggle, menu) {
        menu.classList.add('show');
        toggle.setAttribute('aria-expanded', 'true');
        
        // Position the dropdown
        this.positionDropdown(toggle, menu);
    }

    closeDropdown(toggle, menu) {
        menu.classList.remove('show');
        toggle.setAttribute('aria-expanded', 'false');
    }

    closeAllDropdowns() {
        const openDropdowns = document.querySelectorAll('.custom-dropdown-menu.show, .dropdown-menu.show');
        openDropdowns.forEach(menu => {
            const dropdown = menu.closest('.custom-dropdown, .dropdown');
            const toggle = dropdown.querySelector('.custom-dropdown-toggle, .dropdown-toggle');
            if (toggle) {
                this.closeDropdown(toggle, menu);
            }
        });
    }

    positionDropdown(toggle, menu) {
        const rect = toggle.getBoundingClientRect();
        const viewport = {
            width: window.innerWidth,
            height: window.innerHeight
        };

        // Reset positioning
        menu.style.position = 'absolute';
        menu.style.top = '';
        menu.style.left = '';
        menu.style.right = '';
        menu.style.transform = '';

        // Calculate position relative to the toggle button
        menu.style.top = '100%';
        menu.style.left = '0';
        menu.style.right = 'auto';

        // Check if dropdown would go off screen
        setTimeout(() => {
            const menuRect = menu.getBoundingClientRect();
            
            // Adjust horizontal position if needed
            if (menuRect.right > viewport.width) {
                menu.style.left = 'auto';
                menu.style.right = '0';
            }
            
            // Adjust vertical position if needed
            if (menuRect.bottom > viewport.height) {
                menu.style.top = 'auto';
                menu.style.bottom = '100%';
            }
        }, 1);
    }
}

// Initialize dropdown functionality
function initializeDropdowns() {
    // Disable Bootstrap dropdowns
    if (window.bootstrap && window.bootstrap.Dropdown) {
        // Override Bootstrap dropdown initialization
        const originalInit = window.bootstrap.Dropdown.getOrCreateInstance;
        window.bootstrap.Dropdown.getOrCreateInstance = function() {
            return {
                toggle: function() {},
                show: function() {},
                hide: function() {},
                dispose: function() {}
            };
        };
    }
    
    // Initialize our custom dropdown
    new CustomDropdown();
    
    console.log('Custom dropdown initialized');
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeDropdowns);
} else {
    initializeDropdowns();
}

// Also initialize immediately if DOM is already loaded
setTimeout(initializeDropdowns, 100);

