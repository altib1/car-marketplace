export function initializeFileUpload() {
    document.querySelectorAll('.border-dashed').forEach(zone => {
        const input = zone.querySelector('input[type="file"]');
        const previewContainer = zone.querySelector('.space-y-1');
        const defaultContent = previewContainer.innerHTML;

        // Drag & drop handlers
        zone.addEventListener('dragover', e => {
            e.preventDefault();
            zone.classList.add('border-blue-500', 'bg-blue-50');
        });

        zone.addEventListener('dragleave', e => {
            e.preventDefault();
            zone.classList.remove('border-blue-500', 'bg-blue-50');
        });

        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('border-blue-500', 'bg-blue-50');
            if (input) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });

        // File change handler
        if (input) {
            input.addEventListener('change', () => {
                const file = input.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        // Create new preview
                        const preview = document.createElement('div');
                        preview.className = 'space-y-1 text-center';
                        preview.innerHTML = `
                            <img src="${e.target.result}" class="mx-auto h-48 w-auto mb-4">
                            <div class="flex text-sm text-gray-600">
                                <label for="${input.id}" class="relative cursor-pointer rounded-md font-medium text-blue-600 hover:text-blue-500">
                                    <span>Change image</span>
                                </label>
                                <button type="button" class="ml-2 text-red-600 hover:text-red-800">Cancel</button>
                            </div>
                            <p class="text-xs text-gray-500">${file.name}</p>
                        `;

                        // Replace content while keeping input
                        previewContainer.innerHTML = '';
                        previewContainer.appendChild(preview);
                        previewContainer.appendChild(input);

                        // Add cancel handler
                        preview.querySelector('button').addEventListener('click', () => {
                            input.value = '';
                            previewContainer.innerHTML = defaultContent;
                            previewContainer.appendChild(input);
                        });
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
}