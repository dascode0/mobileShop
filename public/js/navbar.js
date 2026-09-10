// Array of placeholder texts
const placeholders = [
    "Search for Vivo",
    "Search for Iphone 16",
    "Search for Oneplus",
    "Search for oppo",
    "Search for Samsung",
    "Search for Xiaomi"
];

let index = 0;
const searchBox = document.getElementById("searchBox");

// Function to change placeholder every 2 seconds
setInterval(() => {
    searchBox.setAttribute("placeholder", placeholders[index]);
    index = (index + 1) % placeholders.length;
}, 2000); // 2000ms = 2 seconds


// ----------side panel---------------
document.addEventListener('DOMContentLoaded', function () {
    const signupBtn = document.getElementById('signup-btn');
    const authPanel = document.getElementById('auth-panel');
    const closePanel = document.getElementById('close-panel');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    if (signupBtn) {
        signupBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            console.log('Sign In button clicked');
            authPanel.classList.add('show');
        });
    }

    if (authPanel) {
        authPanel.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    }

    if (closePanel) {
        closePanel.addEventListener('click', () => {
            authPanel.classList.remove('show');
        });
    }

    if (loginTab && registerTab && loginForm && registerForm) {
        loginTab.addEventListener('click', () => {
            loginForm.style.display = 'block';
            registerForm.style.display = 'none';
            loginTab.style.opacity = 3;
            registerTab.style.opacity = 0.3;
        });

        registerTab.addEventListener('click', () => {
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
            loginTab.style.opacity = 0.3;
            registerTab.style.opacity = 3;
        });
    }

    // Responsive Navbar: Close auth panel when clicking outside (mobile UX)
    document.addEventListener('click', function (event) {
        if (authPanel && authPanel.classList.contains('show')) {
            if (!authPanel.contains(event.target) && event.target !== signupBtn) {
                authPanel.classList.remove('show');
            }
        }
    });

    // Ensure navbar toggler works for mobile nav (Bootstrap handles collapse, but fallback for custom nav)
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarNav = document.getElementById('navbarNav');
    if (navbarToggler && navbarNav) {
        navbarToggler.addEventListener('click', function () {
            navbarNav.classList.toggle('show');
        });
    }
});

