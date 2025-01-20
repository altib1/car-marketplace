export function initializeConversation() {
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('messageForm');
        const messagesContainer = document.getElementById('messages');
    
        // Scroll to bottom initially
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    
        form?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            
            try {
                const response = await fetch('/chat/send', {
                    method: 'POST',
                    body: formData
                });
                
                if (response.ok) {
                    location.reload();
                }
            } catch (error) {
                console.error('Error:', error);
            } finally {
                submitButton.disabled = false;
            }
        });
    
        // Poll for new messages
        setInterval(async () => {
            const response = await fetch(window.location.href);
            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newMessages = doc.getElementById('messages');
            
            if (newMessages && newMessages.innerHTML !== messagesContainer.innerHTML) {
                messagesContainer.innerHTML = newMessages.innerHTML;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        }, 3000);
    });
}