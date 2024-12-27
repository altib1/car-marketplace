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