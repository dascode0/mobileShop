// Checkout Page JavaScript Functionality

document.addEventListener('DOMContentLoaded', function() {
    initializeCheckout();
});

let currentStep = 1;
const totalSteps = 3;
let cartData = null;
let selectedAddressId = null;

function initializeCheckout() {
    // Initialize step navigation
    updateProgressSteps();
    
    // Load cart data from backend
    loadCartData();
    
    // Initialize form handlers
    initializeAddressHandlers();
    initializePaymentHandlers();
    
    // Initialize address selection
    initializeAddressSelection();
    
    // Show first step
    showStep(1);
}

// Load cart data from backend
async function loadCartData() {
    try {
        const response = await fetch('/checkout/cart-items');
        if (response.ok) {
            cartData = await response.json();
            updateOrderSummary();
        } else {
            showNotification('Failed to load cart data', 'error');
        }
    } catch (error) {
        console.error('Error loading cart data:', error);
        showNotification('Failed to load cart data', 'error');
    }
}

// Step Navigation Functions
function nextStep(step) {
    if (validateCurrentStep()) {
        currentStep = step;
        showStep(step);
        updateProgressSteps();
    }
}

function prevStep(step) {
    currentStep = step;
    showStep(step);
    updateProgressSteps();
}

function showStep(step) {
    // Hide all steps
    for (let i = 1; i <= totalSteps; i++) {
        const stepElement = document.getElementById(`step-${i}`);
        if (stepElement) {
            stepElement.style.display = 'none';
        }
    }
    
    // Show current step
    const currentStepElement = document.getElementById(`step-${step}`);
    if (currentStepElement) {
        currentStepElement.style.display = 'block';
    }
}

function updateProgressSteps() {
    const steps = document.querySelectorAll('.step');
    steps.forEach((step, index) => {
        const stepNumber = index + 1;
        step.classList.remove('active', 'completed');
        
        if (stepNumber < currentStep) {
            step.classList.add('completed');
        } else if (stepNumber === currentStep) {
            step.classList.add('active');
        }
    });
}

function validateCurrentStep() {
    switch (currentStep) {
        case 1:
            return validateLoginStep();
        case 2:
            return validateAddressStep();
        case 3:
            return validatePaymentStep();
        default:
            return true;
    }
}

function validateLoginStep() {
    // Check if user is logged in or proceeding as guest
    const isLoggedIn = document.querySelector('.logged-in-section');
    const guestMode = sessionStorage.getItem('guestCheckout');
    
    if (isLoggedIn || guestMode === 'true') {
        return true;
    }
    
    showNotification('Please login or continue as guest', 'warning');
    return false;
}

function validateAddressStep() {
    const selectedAddress = document.querySelector('input[name="selected_address"]:checked');
    if (!selectedAddress) {
        showNotification('Please select a delivery address', 'warning');
        return false;
    }
    selectedAddressId = selectedAddress.value;
    updateSelectedAddressSummary();
    return true;
}

function validatePaymentStep() {
    const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (!selectedPayment) {
        showNotification('Please select a payment method', 'warning');
        return false;
    }
    return true;
}

// Add CSRF token to page head if not present
function ensureCSRFToken() {
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const token = document.createElement('meta');
        token.name = 'csrf-token';
        token.content = document.querySelector('input[name="_token"]')?.value || '';
        document.head.appendChild(token);
    }
}

function handleLogin(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Signing In...';
    submitBtn.disabled = true;
    
    // Simulate login API call
    setTimeout(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Simulate successful login
        showNotification('Login successful!', 'success');
        
        // Update UI to show logged in state
        updateLoginState({
            name: formData.get('email').split('@')[0],
            email: formData.get('email')
        });
        
        // Auto-proceed to next step
        setTimeout(() => {
            nextStep(2);
        }, 1000);
    }, 2000);
}

function handleRegister(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Creating Account...';
    submitBtn.disabled = true;
    
    // Simulate registration API call
    setTimeout(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        
        // Simulate successful registration
        showNotification('Account created successfully!', 'success');
        
        // Update UI to show logged in state
        updateLoginState({
            name: formData.get('name'),
            email: formData.get('email')
        });
        
        // Auto-proceed to next step
        setTimeout(() => {
            nextStep(2);
        }, 1000);
    }, 2000);
}

function proceedAsGuest() {
    sessionStorage.setItem('guestCheckout', 'true');
    showNotification('Continuing as guest', 'info');
    
    // Update UI for guest mode
    const step1 = document.getElementById('step-1');
    const loginSection = step1.querySelector('.login-section');
    
    if (loginSection) {
        loginSection.innerHTML = `
            <div class="guest-mode-section">
                <div class="guest-info">
                    <div class="guest-avatar">
                        <i class="fa-solid fa-user-secret"></i>
                    </div>
                    <div class="guest-details">
                        <h4>Guest Checkout</h4>
                        <p class="text-muted">You're proceeding as a guest user</p>
                    </div>
                    <button class="btn-continue" onclick="nextStep(2)">
                        <i class="fa-solid fa-arrow-right me-2"></i>Continue
                    </button>
                </div>
            </div>
        `;
    }
}

function updateLoginState(user) {
    const step1 = document.getElementById('step-1');
    const loginSection = step1.querySelector('.login-section');
    
    if (loginSection) {
        loginSection.innerHTML = `
            <div class="logged-in-section">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="user-details">
                        <h4>Welcome back, ${user.name}!</h4>
                        <p class="text-muted">${user.email}</p>
                    </div>
                    <button class="btn-continue" onclick="nextStep(2)">
                        <i class="fa-solid fa-arrow-right me-2"></i>Continue
                    </button>
                </div>
            </div>
        `;
    }
}

// Address Management Functions
function initializeAddressHandlers() {
    const addressForm = document.getElementById('new-address-form');
    if (addressForm) {
        addressForm.addEventListener('submit', handleAddAddress);
    }
}

function initializeAddressSelection() {
    ensureCSRFToken();
    
    const addressCards = document.querySelectorAll('.address-card');
    addressCards.forEach(card => {
        card.addEventListener('click', function() {
            selectAddress(this);
        });
    });
    
    // Check if there's a pre-selected address
    const selectedRadio = document.querySelector('input[name="selected_address"]:checked');
    if (selectedRadio) {
        selectedAddressId = selectedRadio.value;
        const selectedCard = selectedRadio.closest('.address-card');
        if (selectedCard) {
            selectedCard.classList.add('selected');
        }
    }
}

// Initialize payment method handlers
function initializePaymentHandlers() {
    document.addEventListener('change', function(e) {
        if (e.target.name === 'payment_method') {
            // Update UI to show selected payment method
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            e.target.closest('.payment-option').classList.add('selected');
        }
    });
}

function selectAddress(card) {
    // Remove selection from all cards
    document.querySelectorAll('.address-card').forEach(c => {
        c.classList.remove('selected');
    });
    
    // Select clicked card
    card.classList.add('selected');
    
    // Check the radio button
    const radio = card.querySelector('input[type="radio"]');
    if (radio) {
        radio.checked = true;
        selectedAddressId = radio.value;
        updateSelectedAddressSummary();
    }
}

function toggleAddressForm() {
    const form = document.getElementById('address-form');
    const isVisible = form.style.display !== 'none';
    
    if (isVisible) {
        form.style.display = 'none';
        // Reset form to add mode when closing
        resetFormToAddMode();
    } else {
        form.style.display = 'block';
        // Scroll to form
        form.scrollIntoView({ behavior: 'smooth' });
    }
}

async function handleAddAddress(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Saving...';
    submitBtn.disabled = true;
    
    try {
        const response = await fetch('/addresses', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Create new address card
            const addressList = document.querySelector('.address-list');
            const noAddresses = addressList.querySelector('.no-addresses');
            if (noAddresses) {
                noAddresses.remove();
            }
            
            const newAddressCard = document.createElement('div');
            newAddressCard.className = 'address-card selected';
            newAddressCard.setAttribute('data-address-id', result.address.id);
            
            newAddressCard.innerHTML = `
                <div class="address-content">
                    <div class="address-header">
                        <h6><i class="fa-solid fa-home me-2"></i>Address</h6>
                        <div class="address-actions">
                            <button class="btn-edit" onclick="editAddress(${result.address.id})">
                                <i class="fa-solid fa-edit"></i>
                            </button>
                            <button class="btn-delete" onclick="deleteAddress(${result.address.id})">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <p class="address-text">
                        ${result.address.full_name}<br>
                        ${result.address.address}<br>
                        ${result.address.city}, ${result.address.state} ${result.address.pincode}<br>
                        Phone: ${result.address.phone_number}
                        ${result.address.alternative_phone ? '<br>Alt: ' + result.address.alternative_phone : ''}
                    </p>
                </div>
                <input type="radio" name="selected_address" value="${result.address.id}" class="address-radio" checked>
            `;
            
            // Remove selection from existing cards
            document.querySelectorAll('.address-card').forEach(card => {
                card.classList.remove('selected');
                const radio = card.querySelector('input[type="radio"]');
                if (radio) radio.checked = false;
            });
            
            // Add new card
            addressList.appendChild(newAddressCard);
            
            // Add click handler
            newAddressCard.addEventListener('click', function() {
                selectAddress(this);
            });
            
            // Set as selected
            selectedAddressId = result.address.id;
            
            // Hide form and show success
            toggleAddressForm();
            e.target.reset();
            showNotification('Address added successfully!', 'success');
        } else {
            showNotification('Failed to add address', 'error');
        }
    } catch (error) {
        console.error('Error adding address:', error);
        showNotification('Failed to add address', 'error');
    } finally {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

function getAddressIcon(type) {
    switch (type) {
        case 'home': return 'home';
        case 'work': return 'building';
        default: return 'location-dot';
    }
}

async function editAddress(addressId) {
    try {
        // Get address data from server
        const response = await fetch(`/addresses/${addressId}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        if (response.ok) {
            const address = await response.json();
            populateEditForm(address, addressId);
        } else {
            showNotification('Failed to load address data', 'error');
        }
    } catch (error) {
        console.error('Error loading address:', error);
        showNotification('Failed to load address data', 'error');
    }
}

function populateEditForm(address, addressId) {
    // Show the address form
    const form = document.getElementById('address-form');
    const formTitle = form.querySelector('h5');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Update form title and button
    formTitle.textContent = 'Edit Delivery Address';
    submitBtn.innerHTML = '<i class="fa-solid fa-save me-2"></i>Update Address';
    
    // Populate form fields
    const formElement = document.getElementById('new-address-form');
    formElement.querySelector('input[name="full_name"]').value = address.full_name || '';
    formElement.querySelector('input[name="phone_number"]').value = address.phone_number || '';
    formElement.querySelector('input[name="pincode"]').value = address.pincode || '';
    formElement.querySelector('input[name="address"]').value = address.address || '';
    formElement.querySelector('input[name="city"]').value = address.city || '';
    formElement.querySelector('select[name="state"]').value = address.state || '';
    formElement.querySelector('input[name="alternative_phone"]').value = address.alternative_phone || '';
    
    // Store the address ID for updating
    formElement.setAttribute('data-edit-id', addressId);
    
    // Show the form
    form.style.display = 'block';
    form.scrollIntoView({ behavior: 'smooth' });
    
    // Update form handler to handle edit mode
    formElement.removeEventListener('submit', handleAddAddress);
    formElement.addEventListener('submit', handleUpdateAddress);
}

async function handleUpdateAddress(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    const addressId = e.target.getAttribute('data-edit-id');
    
    // Show loading state
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Updating...';
    submitBtn.disabled = true;
    
    try {
        // Convert FormData to URLSearchParams for PUT request
        const params = new URLSearchParams();
        for (const [key, value] of formData.entries()) {
            params.append(key, value);
        }
        
        const response = await fetch(`/addresses/${addressId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: params
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Update the address card in the DOM
            const addressCard = document.querySelector(`[data-address-id="${addressId}"]`);
            if (addressCard) {
                const addressText = addressCard.querySelector('.address-text');
                addressText.innerHTML = `
                    ${result.address.full_name}<br>
                    ${result.address.address}<br>
                    ${result.address.city}, ${result.address.state} ${result.address.pincode}<br>
                    Phone: ${result.address.phone_number}
                    ${result.address.alternative_phone ? '<br>Alt: ' + result.address.alternative_phone : ''}
                `;
                
                // Update selected address summary if this address is selected
                if (selectedAddressId == addressId) {
                    updateSelectedAddressSummary();
                }
            }
            
            // Reset form to add mode
            resetFormToAddMode();
            
            // Hide form and show success
            toggleAddressForm();
            showNotification('Address updated successfully!', 'success');
        } else {
            console.error('Update failed:', result);
            const errorMessage = result.message || 'Failed to update address';
            showNotification(errorMessage, 'error');
        }
    } catch (error) {
        console.error('Error updating address:', error);
        showNotification('Network error: Failed to update address', 'error');
    } finally {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

function resetFormToAddMode() {
    const form = document.getElementById('address-form');
    const formTitle = form.querySelector('h5');
    const submitBtn = form.querySelector('button[type="submit"]');
    const formElement = document.getElementById('new-address-form');
    
    // Reset form title and button
    formTitle.textContent = 'Add Delivery Address';
    submitBtn.innerHTML = '<i class="fa-solid fa-save me-2"></i>Save Address';
    
    // Remove edit ID
    formElement.removeAttribute('data-edit-id');
    
    // Reset form
    formElement.reset();
    
    // Restore original form handler
    formElement.removeEventListener('submit', handleUpdateAddress);
    formElement.addEventListener('submit', handleAddAddress);
}

async function deleteAddress(addressId) {
    const confirmation = await Swal.fire({
        icon: 'warning',
        title: 'Delete this address?',
        text: 'This action cannot be undone.',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        confirmButtonColor: '#dc3545'
    });

    if (confirmation.isConfirmed) {
        try {
            const response = await fetch(`/addresses/${addressId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                const addressCard = document.querySelector(`[data-address-id="${addressId}"]`);
                if (addressCard) {
                    addressCard.remove();
                    
                    // Check if this was the selected address
                    if (selectedAddressId == addressId) {
                        selectedAddressId = null;
                        updateSelectedAddressSummary();
                    }
                    
                    // Check if no addresses left
                    const remainingAddresses = document.querySelectorAll('.address-card');
                    if (remainingAddresses.length === 0) {
                        const addressList = document.querySelector('.address-list');
                        addressList.innerHTML = `
                            <div class="no-addresses">
                                <i class="fa-solid fa-location-dot mb-3"></i>
                                <p>No addresses found. Please add a delivery address to continue.</p>
                            </div>
                        `;
                    }
                    
                    showNotification('Address deleted successfully', 'success');
                }
            } else {
                showNotification(result.message || 'Failed to delete address', 'error');
            }
        } catch (error) {
            console.error('Error deleting address:', error);
            showNotification('Failed to delete address', 'error');
        }
    }
}

// Payment Functions
function initializePaymentHandlers() {
    const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
    paymentOptions.forEach(option => {
        option.addEventListener('change', handlePaymentSelection);
    });
}

function handlePaymentSelection(e) {
    const selectedMethod = e.target.value;
    
    // Remove active class from all payment options
    document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('active');
    });
    
    // Add active class to selected option
    e.target.closest('.payment-option').classList.add('active');
    
    // Update payment method display
    updatePaymentMethodDisplay(selectedMethod);
}

function updatePaymentMethodDisplay(method) {
    // This would update any payment-specific UI elements
    console.log('Selected payment method:', method);
}

// Order Placement
async function placeOrder() {
    if (!validateCurrentStep()) {
        return;
    }
    
    const placeOrderBtn = document.querySelector('.btn-place-order');
    const originalText = placeOrderBtn.innerHTML;
    
    // Show loading state
    placeOrderBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i>Processing Order...';
    placeOrderBtn.disabled = true;
    
    try {
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
        if (!paymentMethod) {
            showNotification('Please select a payment method', 'error');
            return;
        }

        const orderData = {
            address_id: selectedAddressId,
            payment_method: paymentMethod.value
        };
        
        const response = await fetch('/checkout/place-order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify(orderData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification(`Order placed successfully! Your order ID is ${result.order_number}.`, 'success');

            setTimeout(() => {
                // Send the customer straight to their Orders tab, with this
                // order highlighted, so the order ID is right there for them.
                window.location.href = `/account?tab=orders&order=${result.order_id}`;
            }, 1800);
        } else {
            showNotification(result.message || 'Failed to place order', 'error');
        }
    } catch (error) {
        console.error('Error placing order:', error);
        showNotification('Failed to place order', 'error');
    } finally {
        // Reset button
        placeOrderBtn.innerHTML = originalText;
        placeOrderBtn.disabled = false;
    }
}

function getSelectedAddress() {
    const selectedRadio = document.querySelector('input[name="selected_address"]:checked');
    if (selectedRadio) {
        const addressCard = selectedRadio.closest('.address-card');
        return {
            id: selectedRadio.value,
            text: addressCard.querySelector('.address-text').innerText
        };
    }
    return null;
}

function getSelectedPaymentMethod() {
    const selectedRadio = document.querySelector('input[name="payment_method"]:checked');
    return selectedRadio ? selectedRadio.value : null;
}

// Update order summary with backend data
function updateOrderSummary() {
    if (!cartData) return;
    
    document.getElementById('subtotal-amount').textContent = `₹${cartData.subtotal.toLocaleString()}`;
    document.getElementById('tax-amount').textContent = `₹${cartData.tax.toLocaleString()}`;
    
    const shippingElement = document.getElementById('shipping-amount');
    if (cartData.shipping === 0) {
        shippingElement.textContent = 'FREE';
        shippingElement.className = 'text-success';
    } else {
        shippingElement.textContent = `₹${cartData.shipping.toLocaleString()}`;
        shippingElement.className = '';
    }
    
    document.getElementById('total-amount').textContent = `₹${cartData.total.toLocaleString()}`;
}

// Update selected address summary in step 3
function updateSelectedAddressSummary() {
    const summaryElement = document.getElementById('selected-address-summary');
    
    if (selectedAddressId) {
        const selectedCard = document.querySelector(`[data-address-id="${selectedAddressId}"]`);
        if (selectedCard) {
            const addressText = selectedCard.querySelector('.address-text').innerHTML;
            summaryElement.innerHTML = addressText;
        }
    } else {
        summaryElement.innerHTML = '<p class="text-muted">Please select an address from Step 2</p>';
    }
}

// Utility Functions
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <div class="notification-content">
            <i class="fa-solid fa-${getNotificationIcon(type)} me-2"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${getNotificationColor(type)};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;
    
    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function getNotificationIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'exclamation-circle';
        case 'warning': return 'exclamation-triangle';
        default: return 'info-circle';
    }
}

function getNotificationColor(type) {
    switch (type) {
        case 'success': return 'linear-gradient(135deg, #27ae60 0%, #2ecc71 100%)';
        case 'error': return 'linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)';
        case 'warning': return 'linear-gradient(135deg, #f39c12 0%, #e67e22 100%)';
        default: return 'linear-gradient(135deg, #3498db 0%, #2980b9 100%)';
    }
}

// Initialize checkout when page loads
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCheckout);
} else {
    initializeCheckout();
}
