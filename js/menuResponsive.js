const primaryNavigation = document.querySelector('.navbar_items');
const navToggleOpen = document.querySelector('.nav_toggle_open');
const navToggleClose = document.querySelector('.nav_toggle_close');

[navToggleOpen, navToggleClose].forEach(navToggle => {
    navToggle.addEventListener('click', () => {
        const visibility = primaryNavigation.getAttribute('data-visible');
    
        if (visibility === "false") {
            primaryNavigation.setAttribute('data-visible', 'true');
            navToggle.setAttribute('aria-expanded', 'true');
        } else if (visibility === "true") {
            primaryNavigation.setAttribute('data-visible', 'false');
            navToggle.setAttribute('aria-expanded', 'false');
        }
    });
});