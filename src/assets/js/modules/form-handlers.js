import flatpickr from "flatpickr";

export function initializeFormHandlers() {
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize flatpickr for date inputs
        flatpickr('.datepicker', {
            dateFormat: 'Y-m-d',
            allowInput: true
        });

        // Generic function to handle adding new items
        function addItemHandler(addButton, containerClass, removeButtonClass) {
            const container = document.querySelector('.' + containerClass);
            const prototype = container.dataset.prototype;
            let index = container.children.length;

            addButton.addEventListener('click', function() {
                const newForm = prototype.replace(/__name__/g, index);
                const template = document.createElement('div');
                template.innerHTML = newForm;
                
                // Create the wrapper div
                const wrapper = document.createElement('div');
                wrapper.className = containerClass.includes('images') ? 'image-item relative group' : 'service-item relative group';
                
                // Create the flex container
                const flexContainer = document.createElement('div');
                flexContainer.className = 'flex items-center space-x-4';
                
                // Add appropriate classes to the input
                const input = template.querySelector('input');
                if (containerClass.includes('images')) {
                    input.className = 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100';
                } else {
                    input.className = 'block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm';
                }
                
                // Add remove button
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = removeButtonClass + ' hidden group-hover:block text-red-600 hover:text-red-800';
                removeButton.innerHTML = `
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                `;
                
                // Assemble the elements
                flexContainer.appendChild(input);
                flexContainer.appendChild(removeButton);
                wrapper.appendChild(flexContainer);
                container.appendChild(wrapper);
                
                // Add remove functionality
                removeButton.addEventListener('click', function() {
                    wrapper.remove();
                });
                
                index++;
            });
        }

        // Initialize all dynamic form sections
        const addBackgroundImage = document.querySelector('.add-background-image');
        const addLogoImage = document.querySelector('.add-logo-image');
        const addService = document.querySelector('.add-service');

        if (addBackgroundImage) {
            addItemHandler(addBackgroundImage, 'background-images', 'remove-image');
        }
        if (addLogoImage) {
            addItemHandler(addLogoImage, 'logo-images', 'remove-image');
        }
        if (addService) {
            addItemHandler(addService, 'services', 'remove-service');
        }

        // Add remove functionality to existing items
        document.querySelectorAll('.remove-image, .remove-service').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.image-item, .service-item').remove();
            });
        });
    });
}