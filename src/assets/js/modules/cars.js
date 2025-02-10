export function initializeCars() {
    document.addEventListener('DOMContentLoaded', function() {
        const brandSelect = document.getElementById('publication_brand');
        const modelSelect = document.getElementById('publication_model');
        const motorisationTypeSelect = document.getElementById('publication_motorizationType');
        const locale = document.documentElement.lang || 'en';

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
            fetch(`/${locale}/publication/models/${brandId}`)
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
            fetch(`/${locale}/publication/motorisation-types/${modelId}`)
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

    // filters responsivenes for mobile

    document.addEventListener('DOMContentLoaded', function() {
        const filterSection = document.getElementById('filter-section');
        const toggleFiltersBtn = document.getElementById('toggle-filters');
        const closeFiltersBtn = document.getElementById('close-filters');
    
        // Toggle filters on mobile
        toggleFiltersBtn.addEventListener('click', function() {
            filterSection.classList.remove('-translate-x-full');
            filterSection.classList.remove('opacity-0');
            filterSection.classList.add('translate-x-0');
            filterSection.classList.add('opacity-100');
        });
    
        // Close filters on mobile
        closeFiltersBtn.addEventListener('click', function() {
            filterSection.classList.add('-translate-x-full');
            filterSection.classList.add('opacity-0');
            filterSection.classList.remove('translate-x-0');
            filterSection.classList.remove('opacity-100');
        });
    
        // Close filters when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (!filterSection.contains(event.target) && 
                !toggleFiltersBtn.contains(event.target) && 
                window.innerWidth < 1024) {
                filterSection.classList.add('-translate-x-full');
                filterSection.classList.add('opacity-0');
                filterSection.classList.remove('translate-x-0');
                filterSection.classList.remove('opacity-100');
            }
        });
    });

    // Bank estimation

    document.addEventListener('DOMContentLoaded', function() {
        const vehiclePriceInput = document.getElementById('vehiclePrice');
        if (!vehiclePriceInput) return;
        
        const interestRateInput = document.getElementById('interestRate');
        const loanDurationSelect = document.getElementById('loanDuration');
        const monthlyPaymentDisplay = document.getElementById('monthlyPayment');
        const totalInterestDisplay = document.getElementById('totalInterest');
    
        function calculateLoan() {
            const principal = parseFloat(vehiclePriceInput.value);
            const annualRate = parseFloat(interestRateInput.value) / 100;
            const months = parseInt(loanDurationSelect.value);
            
            if (isNaN(principal) || isNaN(annualRate) || principal <= 0 || annualRate < 0) {
                monthlyPaymentDisplay.textContent = '€0.00';
                totalInterestDisplay.textContent = '€0.00';
                return;
            }
    
            const monthlyRate = annualRate / 12;
            
            // Using the amortization formula
            const monthlyPayment = principal * 
                (monthlyRate * Math.pow(1 + monthlyRate, months)) / 
                (Math.pow(1 + monthlyRate, months) - 1);
                
            const totalPayment = monthlyPayment * months;
            const totalInterest = totalPayment - principal;
    
            // Format numbers with thousands separator
            const formatter = new Intl.NumberFormat('de-DE', {
                style: 'currency',
                currency: 'EUR',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    
            monthlyPaymentDisplay.textContent = formatter.format(monthlyPayment);
            totalInterestDisplay.textContent = formatter.format(totalInterest);
        }
    
        vehiclePriceInput.addEventListener('input', calculateLoan);
        interestRateInput.addEventListener('input', calculateLoan);
        loanDurationSelect.addEventListener('change', calculateLoan);
    
        // Initial calculation
        calculateLoan();
    });
}