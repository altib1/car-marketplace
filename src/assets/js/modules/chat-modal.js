export function initializeChatModal() {
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('chatModal');
        const form = document.getElementById('sendMessageForm');
        const locale = document.documentElement.lang || 'en';
        // Modal handlers
        document.querySelector('[data-modal-target="chatModal"]')?.addEventListener('click', () => {
            modal.classList.remove('hidden');
        });
        
        document.querySelector('[data-modal-close]')?.addEventListener('click', () => {
            modal.classList.add('hidden');
        });

        // Form submission
        form?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            
            try {
                const response = await fetch(`/${locale}/chat/send`, {
                    method: 'POST',
                    body: formData
                });
                
                if (response.ok) {
                    modal.classList.add('hidden');
                    form.reset();
                    window.location.href = `/${locale}/chat`;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
}