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

    const searchInputs = document.querySelectorAll('.product-search-input');
    let searchTimer;
    let searchRequest;
    const closeSuggestions = () => {
        document.querySelectorAll('.search-suggestions').forEach((list) => {
            list.classList.remove('show');
            list.replaceChildren();
        });
    };

    const showSuggestions = (list, products) => {
        list.replaceChildren();
        if (!products.length) {
            const empty = document.createElement('div');
            empty.className = 'search-suggestion-empty';
            empty.textContent = 'No matching products found';
            list.appendChild(empty);
            list.classList.add('show');
            return;
        }

        products.forEach((product) => {
            const link = document.createElement('a');
            link.className = 'search-suggestion';
            link.href = `/shop?search=${encodeURIComponent(product.name)}`;
            link.setAttribute('role', 'option');

            if (product.type === 'category') {
                const icon = document.createElement('span');
                icon.className = 'search-suggestion-category-icon';
                icon.innerHTML = '<i class="fa-solid fa-layer-group"></i>';
                link.appendChild(icon);
            } else if (product.image) {
                const image = document.createElement('img');
                image.src = product.image;
                image.alt = '';
                link.appendChild(image);
            }

            const details = document.createElement('span');
            details.className = 'search-suggestion-details';
            const name = document.createElement('span');
            name.className = 'search-suggestion-name';
            name.textContent = product.name;
            const price = document.createElement('span');
            price.className = 'search-suggestion-price';
            price.textContent = product.type === 'category' ? 'View category products' : `₹${product.price}`;
            details.append(name, price);
            link.appendChild(details);
            list.appendChild(link);
        });
        list.classList.add('show');
    };

    searchInputs.forEach((input) => {
        input.addEventListener('input', () => {
            const term = input.value.trim();
            searchInputs.forEach((otherInput) => {
                if (otherInput !== input) otherInput.value = input.value;
            });
            window.clearTimeout(searchTimer);
            if (searchRequest) searchRequest.abort();
            if (term.length < 2) {
                closeSuggestions();
                return;
            }

            searchTimer = window.setTimeout(async () => {
                searchRequest = new AbortController();
                try {
                    const response = await fetch(`${window.productSearchUrl}?q=${encodeURIComponent(term)}`, {
                        headers: { Accept: 'application/json' },
                        signal: searchRequest.signal
                    });
                    if (!response.ok) throw new Error('Search request failed');
                    const data = await response.json();
                    const list = input.closest('.nav-search')?.querySelector('.search-suggestions');
                    if (list) showSuggestions(list, data.products || []);
                } catch (error) {
                    if (error.name !== 'AbortError') closeSuggestions();
                }
            }, 250);
        });
        input.addEventListener('focus', () => {
            if (input.value.trim().length >= 2) input.dispatchEvent(new Event('input'));
        });
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.nav-search')) closeSuggestions();
    });

    selectTab(initialTab);
    if (window.authPanelOpen) {
        authPanel?.classList.add('show');
        document.body.style.overflow = 'hidden';
    }
});
