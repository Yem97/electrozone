// Bootstrap Conflict Fix
document.addEventListener('DOMContentLoaded', function() {
    // Prevent Bootstrap from interfering with custom dropdowns
    const customDropdowns = document.querySelectorAll('.custom-dropdown');

    customDropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.custom-dropdown-toggle');
        if (toggle) {
            // Remove any Bootstrap dropdown attributes
            toggle.removeAttribute('data-bs-toggle');
            toggle.removeAttribute('data-toggle');
            toggle.removeAttribute('data-bs-target');
            toggle.removeAttribute('data-target');
        }
    });

    // Disable Bootstrap dropdown on custom dropdowns
    if (window.bootstrap && window.bootstrap.Dropdown) {
        const originalDropdown = window.bootstrap.Dropdown;
        window.bootstrap.Dropdown = function(element, config) {
            // Don't initialize Bootstrap dropdown on custom dropdowns
            if (element.classList.contains('custom-dropdown-toggle')) {
                return {
                    toggle: function() {},
                    show: function() {},
                    hide: function() {},
                    dispose: function() {}
                };
            }
            return new originalDropdown(element, config);
        };
    }
});