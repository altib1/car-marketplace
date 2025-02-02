export function initializeConversation() {
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('messageForm');
        const messagesContainer = document.getElementById('messages');
        const locale = document.documentElement.lang || 'en';
        let canPoll = true; // Add this flag to control polling
    
        // Scroll to bottom initially
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    
        // Create message HTML
        function createMessageHTML(content, currentUserEmail) {
            const initial = currentUserEmail.charAt(0).toUpperCase();
            const now = new Date();
            const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            
            return `
                <div class="flex justify-end items-end gap-2">
                    <div class="bg-blue-600 text-white rounded-2xl rounded-br-none px-4 py-2 max-w-[80%] shadow-sm group hover:shadow-md transition-shadow">
                        <p class="text-sm">${content}</p>
                        <span class="text-xs opacity-75 mt-1 block group-hover:opacity-100 transition-opacity">
                            ${time}
                        </span>
                    </div>
                </div>
            `;
        }
    
        form?.addEventListener('submit', async function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const input = form.querySelector('input[name="content"]');
            const content = input.value.trim();
            
            if (!content) return;
            
            submitButton.disabled = true;
            canPoll = false; // Disable polling before sending
            
            try {
                const response = await fetch(`/${locale}/chat/send`, {
                    method: 'POST',
                    body: formData
                });
                
                if (response.ok) {
                    // Add the message to the chat immediately
                    const currentUserEmail = form.getAttribute('data-user-email');
                    const messageHTML = createMessageHTML(content, currentUserEmail);
                    messagesContainer.insertAdjacentHTML('beforeend', messageHTML);
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    input.value = '';
                    
                    // Wait a bit before allowing polling to resume
                    setTimeout(() => {
                        canPoll = true;
                    }, 1000); // Wait 1 second before resuming polls
                }
            } catch (error) {
                console.error('Error:', error);
                canPoll = true; // Re-enable polling even if there's an error
            } finally {
                submitButton.disabled = false;
            }
        });
    
        // Poll for new messages
        setInterval(async () => {
            if (!canPoll) return; // Skip polling if flag is false
            
            try {
                const response = await fetch(window.location.href);
                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMessages = doc.getElementById('messages');
                
                if (newMessages && newMessages.innerHTML !== messagesContainer.innerHTML) {
                    messagesContainer.innerHTML = newMessages.innerHTML;
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            } catch (error) {
                console.error('Error polling messages:', error);
            }
        }, 2000);
    });

    // Add ajax call for conversations 

    document.addEventListener('DOMContentLoaded', function() {
        // Load conversations when page loads (once)
        function loadConversations() {
            const locale = document.documentElement.lang || 'en';
            
            fetch(`/${locale}/chat/`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('conversations-container').innerHTML = html;
            })
            .catch(error => {
                console.error('Error loading conversations:', error);
            });
        }
    
        // Initial load
        loadConversations();
    
        function refreshConversations() {
            const locale = document.documentElement.lang || 'en';
            const btn = document.getElementById('refreshBtn');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'animate-pulse');
    
            fetch(`/${locale}/chat/`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('conversations-container').innerHTML = html;
                setTimeout(() => {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'animate-pulse');
                }, 2000); // Disable button for 2 seconds
            })
            .catch(() => {
                setTimeout(() => {
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'animate-pulse');
                }, 2000); // Disable button for 2 seconds even on error
            });
        }
    
        // Attach refreshConversations to the refresh button
        document.getElementById('refreshBtn').addEventListener('click', refreshConversations);
    });
}