export const initializeFileUpload = () => {
    const MAX_FILE_SIZE = 20 * 1024 * 1024; // 20MB

    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            handleFileSelection(this, MAX_FILE_SIZE);
        });
    });

    initializeDragAndDrop();
};

const handleFileSelection = (input, maxSize) => {
    // Remove any existing messages
    const existingMessages = input.parentElement.querySelectorAll('.file-message');
    existingMessages.forEach(msg => msg.remove());

    const file = input.files[0];
    if (!file) return;

    const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
    const messageDiv = document.createElement('div');
    messageDiv.className = `file-message text-sm mt-2 ${file.size > maxSize ? 'text-red-500' : 'text-green-500'}`;
    
    if (file.size > maxSize) {
        messageDiv.textContent = `File too large: ${fileSizeMB}MB (maximum: 20MB)`;
        input.value = '';
    } else {
        messageDiv.textContent = `File size: ${fileSizeMB}MB`;
    }
    
    input.parentElement.appendChild(messageDiv);
};