export const initializeChatModal = () => {
    const modal = document.getElementById('chatModal');
    const form = document.getElementById('sendMessageForm');
    
    if (!modal || !form) return;

    document.querySelector('[data-modal-target="chatModal"]')?.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });
    
    document.querySelector('[data-modal-close]')?.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    form.addEventListener('submit', handleChatFormSubmit);
};

const handleChatFormSubmit = async (e) => {
    e.preventDefault();
    try {
        const response = await fetch('/chat/send', {
            method: 'POST',
            body: new FormData(e.target)
        });
        
        if (response.ok) {
            document.getElementById('chatModal').classList.add('hidden');
            e.target.reset();
            window.location.href = '/chat';
        }
    } catch (error) {
        console.error('Error sending message:', error);
    }
};