//create
export function initializeShop() {
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for date inputs
        flatpickr('.datepicker', {
            dateFormat: 'Y-m-d',
            allowInput: true,
            defaultDate: new Date()
        });
    
        // Services Collection Handler
        const addServiceBtn = document.querySelector('.add-service-btn');
        const servicesContainer = document.querySelector('#services-collection');
        
        if (addServiceBtn && servicesContainer) {
            let index = servicesContainer.children.length;
            const prototype = servicesContainer.dataset.prototype;
        
            // Add new service
            addServiceBtn.addEventListener('click', function() {
                const newForm = prototype.replace(/__name__/g, index);
                const serviceEntry = document.createElement('div');
                serviceEntry.className = 'service-entry flex items-center space-x-2';
                serviceEntry.innerHTML = newForm;
            
                // Add classes to the input
                const input = serviceEntry.querySelector('input');
                input.className = 'flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg transition-colors duration-200';
                input.placeholder = 'Enter service name';
            
                // Add remove button
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'remove-service p-2 text-red-500 hover:text-red-700 transition-colors duration-200';
                removeBtn.innerHTML = `
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                `;
            
                serviceEntry.appendChild(removeBtn);
                servicesContainer.appendChild(serviceEntry);
            
                // Add remove functionality
                removeBtn.addEventListener('click', function() {
                    serviceEntry.remove();
                });
            
                index++;
            });
        
            // Add remove functionality to existing services
            document.querySelectorAll('.remove-service').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.service-entry').remove();
                });
            });
        }

                // Handle file uploads and previews
        document.querySelectorAll('input[type="file"]').forEach(fileInput => {
            fileInput.addEventListener('change', function() {
                const previewArea = this.closest('.relative').querySelector('.preview-area');
                if (previewArea && this.files && this.files[0]) {
                    const file = this.files[0];
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        previewArea.innerHTML = `
                            <div class="p-4">
                                <img src="${e.target.result}" class="mx-auto h-48 object-contain" />
                                <p class="text-center text-gray-500 mt-2">${file.name}</p>
                            </div>
                        `;
                    };
                    
                    reader.readAsDataURL(file);
                    
                    // Remove any error messages when a file is selected
                    const errorDiv = fileInput.parentNode.querySelector('.file-error');
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                }
            });
        });

        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                let hasErrors = false;
                
                // Validate required file inputs
                document.querySelectorAll('input[type="file"][required]').forEach(fileInput => {
                    if (!fileInput.files || !fileInput.files[0]) {
                        e.preventDefault();
                        hasErrors = true;
                        
                        // Create error message if it doesn't exist
                        let errorDiv = fileInput.parentNode.querySelector('.file-error');
                        if (!errorDiv) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'file-error text-red-500 text-sm mt-1 font-medium';
                            errorDiv.textContent = 'Please select a file';
                            
                            // Insert after the preview area
                            const previewArea = fileInput.parentNode.querySelector('.preview-area');
                            if (previewArea) {
                                previewArea.parentNode.insertBefore(errorDiv, previewArea.nextSibling);
                            } else {
                                fileInput.parentNode.appendChild(errorDiv);
                            }
                        }
                    }
                });
                
                // Fix duplicate validation messages
                const nameField = document.querySelector('#shop_name');
                if (nameField) {
                    const errorMessages = nameField.parentNode.querySelectorAll('.text-red-500');
                    if (errorMessages.length > 1) {
                        // Keep only the first error message
                        for (let i = 1; i < errorMessages.length; i++) {
                            errorMessages[i].remove();
                        }
                    }
                }
                
                if (hasErrors) {
                    // Focus the first field with an error
                    const firstErrorField = document.querySelector('.file-error')?.parentNode.querySelector('input');
                    if (firstErrorField) {
                        firstErrorField.scrollIntoView({behavior: 'smooth', block: 'center'});
                    }
                }
            });
        }
    });
}