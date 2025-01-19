export const initializeFormHandlers = () => {
    const brandSelect = document.getElementById('publication_brand');
    const modelSelect = document.getElementById('publication_model');
    const motorisationTypeSelect = document.getElementById('publication_motorizationType');

    if (brandSelect && modelSelect && motorisationTypeSelect) {
        if (brandSelect.value) {
            fetchModels(brandSelect.value, modelSelect.value);
        }

        if (modelSelect.value) {
            fetchMotorisationTypes(modelSelect.value, motorisationTypeSelect.value);
        }

        brandSelect.addEventListener('change', function() {
            motorisationTypeSelect.innerHTML = '<option value="">Choose a motorisation type</option>';
            fetchModels(this.value, '');
        });

        modelSelect.addEventListener('change', function() {
            fetchMotorisationTypes(this.value, '');
        });
    }
};

const fetchModels = async (brandId, selectedModelId) => {
    try {
        const response = await fetch(`/publication/models/${brandId}`);
        const data = await response.json();
        updateSelect('publication_model', data, selectedModelId);
    } catch (error) {
        console.error('Error fetching models:', error);
    }
};

const fetchMotorisationTypes = async (modelId, selectedTypeId) => {
    try {
        const response = await fetch(`/publication/motorisation-types/${modelId}`);
        const data = await response.json();
        updateSelect('publication_motorizationType', data, selectedTypeId);
    } catch (error) {
        console.error('Error fetching motorisation types:', error);
    }
};

const updateSelect = (selectId, data, selectedValue) => {
    const select = document.getElementById(selectId);
    const defaultOption = `<option value="">Choose a ${selectId.split('_')[1]}</option>`;
    const options = data.map(item => {
        const selected = item.id.toString() === selectedValue.toString() ? 'selected' : '';
        return `<option value="${item.id}" ${selected}>${item.name}</option>`;
    });
    select.innerHTML = defaultOption + options.join('');
};