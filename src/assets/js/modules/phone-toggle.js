export function initializePhoneToggle() {
    document.addEventListener('DOMContentLoaded', function() {
        const phoneButtons = document.querySelectorAll('[data-phone]');
        
        phoneButtons.forEach(button => {
            button.addEventListener('click', function() {
                const phoneNumber = this.dataset.phone;
                const phoneText = this.querySelector('.phone-text');
                
                if (phoneText.textContent === 'Show Phone Number') {
                    phoneText.textContent = phoneNumber;
                    this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    this.classList.add('bg-green-600', 'hover:bg-green-700');
                } else {
                    phoneText.textContent = 'Show Phone Number';
                    this.classList.remove('bg-green-600', 'hover:bg-green-700');
                    this.classList.add('bg-blue-600', 'hover:bg-blue-700');
                }
            });
        });
    });
}