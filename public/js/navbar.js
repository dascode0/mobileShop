document.addEventListener('DOMContentLoaded', () => {
    const placeholders = ['Search for Vivo', 'Search for iPhone 16', 'Search for OnePlus', 'Search for Oppo', 'Search for Samsung', 'Search for Xiaomi'];
    const searchBox = document.getElementById('searchBox');
    let placeholderIndex = 0;

    if (searchBox) {
        window.setInterval(() => {
            searchBox.placeholder = placeholders[placeholderIndex];
            placeholderIndex = (placeholderIndex + 1) % placeholders.length;
        }, 2500);
    }

    const signupButton = document.getElementById('signup-btn');
    const authPanel = document.getElementById('auth-panel');
    const closePanel = document.getElementById('close-panel');
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    const selectTab = (tab) => {
        const isLogin = tab === 'login';
        loginForm.hidden = !isLogin;
        registerForm.hidden = isLogin;
        loginTab.classList.toggle('active', isLogin);
        registerTab.classList.toggle('active', !isLogin);
    };

    const initialTab = window.authPanelTab === 'register' ? 'register' : 'login';

    signupButton?.addEventListener('click', () => {
        authPanel.classList.add('show');
        selectTab(initialTab);
        document.body.style.overflow = 'hidden';
    });

    const closeAuthPanel = () => {
        authPanel?.classList.remove('show');
        document.body.style.overflow = '';
    };

    closePanel?.addEventListener('click', closeAuthPanel);
    loginTab?.addEventListener('click', () => selectTab('login'));
    registerTab?.addEventListener('click', () => selectTab('register'));
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeAuthPanel(); });
    document.addEventListener('click', (event) => {
        if (authPanel?.classList.contains('show') && !authPanel.contains(event.target) && !signupButton?.contains(event.target)) closeAuthPanel();
    });

    selectTab(initialTab);
    if (window.authPanelOpen) {
        authPanel?.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
});
