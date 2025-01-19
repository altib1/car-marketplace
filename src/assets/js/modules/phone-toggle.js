export const initializePhoneToggle = () => {
    const phoneButtons = document.querySelectorAll('[data-phone]');
    
    phoneButtons.forEach(button => {
        button.addEventListener('click', function() {
            const phoneNumber = this.dataset.phone;
            const phoneText = this.querySelector('.phone-text');
            
            const isShowing = phoneText.textContent !== 'Show Phone Number';
            phoneText.textContent = isShowing ? 'Show Phone Number' : phoneNumber;
            
            this.classList.toggle('bg-blue-600', isShowing);
            this.classList.toggle('hover:bg-blue-700', isShowing);
            this.classList.toggle('bg-green-600', !isShowing);
            this.classList.toggle('hover:bg-green-700', !isShowing);
        });
    });
};