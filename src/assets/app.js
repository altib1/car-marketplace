// assets/app.js
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';



document.addEventListener('DOMContentLoaded', function() {
    const brandSelect = document.getElementById('publication_brand');
    const modelSelect = document.getElementById('publication_model');
    const motorisationTypeSelect = document.getElementById('publication_motorizationType');

    // Load initial data if values are pre-selected
    if (brandSelect.value) {
        fetchModels(brandSelect.value, modelSelect.value);
    }

    if (modelSelect.value) {
        fetchMotorisationTypes(modelSelect.value, motorisationTypeSelect.value);
    }

    brandSelect.addEventListener('change', function() {
        const brandId = this.value;
        motorisationTypeSelect.innerHTML = '<option value="">Choose a motorisation type</option>';
        fetchModels(brandId, '');
    });

    modelSelect.addEventListener('change', function() {
        const modelId = this.value;
        fetchMotorisationTypes(modelId, '');
    });

    function fetchModels(brandId, selectedModelId) {
        fetch(`/publication/models/${brandId}`)
            .then(response => response.json())
            .then(data => {
                modelSelect.innerHTML = '<option value="">Choose a model</option>';
                data.forEach(model => {
                    const option = document.createElement('option');
                    option.value = model.id;
                    option.textContent = model.name;
                    if (model.id.toString() === selectedModelId.toString()) {
                        option.selected = true;
                    }
                    modelSelect.appendChild(option);
                });
            });
    }

    function fetchMotorisationTypes(modelId, selectedTypeId) {
        fetch(`/publication/motorisation-types/${modelId}`)
            .then(response => response.json())
            .then(data => {
                motorisationTypeSelect.innerHTML = '<option value="">Choose a motorisation type</option>';
                data.forEach(motorisationType => {
                    const option = document.createElement('option');
                    option.value = motorisationType.id;
                    option.textContent = motorisationType.name;
                    if (motorisationType.id.toString() === selectedTypeId.toString()) {
                        option.selected = true;
                    }
                    motorisationTypeSelect.appendChild(option);
                });
            });
    }
});

// back to top script
document.addEventListener('DOMContentLoaded', function () {
    const backToTopButton = document.getElementById('backToTop');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 300) {
            backToTopButton.classList.remove('opacity-0', 'invisible');
        } else {
            backToTopButton.classList.add('opacity-0', 'invisible');
        }
    });

    backToTopButton.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

// Phone number toggle function
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

// template _form.html.twig of the shop

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

// template edit.html.twig of the shop

document.addEventListener('DOMContentLoaded', function() {
    // Initialize flatpickr
    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d',
        allowInput: true,
        monthSelectorType: 'static',
        disableMobile: true
    });

    // Services Collection Handler
    const servicesCollection = document.getElementById('services-collection');
    const addServiceBtn = document.querySelector('.add-service-btn');
    let serviceIndex = document.querySelectorAll('.service-entry').length;

    if (addServiceBtn && servicesCollection) {
        addServiceBtn.addEventListener('click', function() {
            const prototype = servicesCollection.dataset.prototype;
            const newForm = prototype.replace(/__name__/g, serviceIndex);
            
            // Create wrapper div
            const wrapper = document.createElement('div');
            wrapper.className = 'service-entry flex items-center space-x-2';
            wrapper.innerHTML = `
                ${newForm}
                <button type="button" class="remove-service p-2 text-red-500 hover:text-red-700 transition-colors duration-200">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;

            // Add classes to the input
            const input = wrapper.querySelector('input');
            input.className = 'flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-lg transition-colors duration-200';
            input.placeholder = 'Enter service name';

            servicesCollection.appendChild(wrapper);
            serviceIndex++;

            // Add remove functionality
            const removeBtn = wrapper.querySelector('.remove-service');
            removeBtn.addEventListener('click', function() {
                wrapper.remove();
            });
        });
    }

    // Add remove functionality to existing service entries
    document.querySelectorAll('.remove-service').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.service-entry').remove();
        });
    });

    // File Upload Preview
    function handleFileUpload(input) {
        const container = input.closest('.border-dashed');
        const originalContent = container.innerHTML;

        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        container.innerHTML = `
                            <div class="space-y-2">
                                <img src="${e.target.result}" class="mx-auto h-32 w-32 object-cover rounded-lg" />
                                <div class="text-center">
                                    <button type="button" class="text-sm text-red-600 hover:text-red-800">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        `;

                        // Add remove functionality
                        container.querySelector('button').addEventListener('click', function() {
                            container.innerHTML = originalContent;
                            input.value = '';
                            handleFileUpload(input);
                        });
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
    }

    // Initialize file upload handlers
    document.querySelectorAll('input[type="file"]').forEach(input => {
        handleFileUpload(input);
    });

    // Drag and drop functionality
    const dropZones = document.querySelectorAll('.border-dashed');
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-blue-500', 'bg-blue-50');
        });

        zone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50');
        });

        zone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50');
            
            const input = this.querySelector('input[type="file"]');
            if (input) {
                const dt = new DataTransfer();
                dt.items.add(e.dataTransfer.files[0]);
                input.files = dt.files;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
});

// template create.html.twig of the shop

document.addEventListener('DOMContentLoaded', function() {
    // Initialize flatpickr
    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d',
        allowInput: true,
        monthSelectorType: 'static',
        disableMobile: true
    });

    // File Upload Handler
    document.querySelectorAll('.border-dashed').forEach(zone => {
        const input = zone.querySelector('input[type="file"]');
        const previewArea = zone.querySelector('.preview-area');
        const defaultContent = previewArea.innerHTML;

        zone.addEventListener('dragover', e => {
            e.preventDefault();
            zone.classList.add('border-blue-500');
        });

        zone.addEventListener('dragleave', e => {
            e.preventDefault();
            zone.classList.remove('border-blue-500');
        });

        zone.addEventListener('drop', e => {
            e.preventDefault();
            zone.classList.remove('border-blue-500');
            if (input) {
                input.files = e.dataTransfer.files;
                input.dispatchEvent(new Event('change'));
            }
        });

        if (input) {
            input.addEventListener('change', () => {
                const file = input.files[0];
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewArea.innerHTML = `
                            <div class="space-y-2 text-center">
                                <img src="${e.target.result}" class="mx-auto h-32 w-32 object-cover rounded-lg" />
                                <button type="button" class="text-sm text-red-600 hover:text-red-800">Remove</button>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });

            zone.addEventListener('click', e => {
                if (e.target.tagName === 'BUTTON') {
                    previewArea.innerHTML = defaultContent;
                    input.value = '';
                }
            });
        }
    });
});