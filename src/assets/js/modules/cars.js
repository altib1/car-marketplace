export function initializeCars() {
    document.addEventListener('DOMContentLoaded', function() {
        const brandSelect = document.getElementById('publication_brand');
        const modelSelect = document.getElementById('publication_model');
        const motorisationTypeSelect = document.getElementById('publication_motorizationType');
        brandSelect.addEventListener('change', function() {
            const brandId = this.value;
            motorisationTypeSelect.innerHTML = '<option value="">Choose a motorisation type</option>';
            fetchModels(brandId);
        });
        modelSelect.addEventListener('change', function() {
            const modelId = this.value;
            fetchMotorisationTypes(modelId);
        });
        function fetchModels(brandId) {
            fetch(`/publication/models/${brandId}`)
                .then(response => response.json())
                .then(data => {
                    modelSelect.innerHTML = '<option value="">Choose a model</option>';
                    data.forEach(model => {
                        const option = document.createElement('option');
                        option.value = model.id;
                        option.textContent = model.name;
                        modelSelect.appendChild(option);
                    });
                });
        }
        function fetchMotorisationTypes(modelId) {
            fetch(`/publication/motorisation-types/${modelId}`)
                .then(response => response.json())
                .then(data => {
                    motorisationTypeSelect.innerHTML = '';
                    motorisationTypeSelect.innerHTML = '<option value="">Choose a motorisation type</option>';
                    data.forEach(motorisationType => {
                        const option = document.createElement('option');
                        option.value = motorisationType.id;
                        option.textContent = motorisationType.name;
                        motorisationTypeSelect.appendChild(option);
                    });
                });
        }
    });
}