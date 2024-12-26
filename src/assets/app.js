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