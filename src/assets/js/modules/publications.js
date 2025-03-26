export function initializePublications() {
    document.addEventListener('DOMContentLoaded', function() {
        // Show modal and update form action
        document.querySelectorAll('[data-modal-target]').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.getAttribute('data-modal-target'));
                const publicationId = button.getAttribute('data-publication-id');
                const form = modal.querySelector('form');

                // Update the form's action URL with the actual publication ID
                form.action = form.action.replace('__PUBLICATION_ID__', publicationId);

                modal.classList.remove('hidden');
            });
        });

        // Hide modal
        document.querySelectorAll('[data-modal-close]').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.querySelector(button.getAttribute('data-modal-close'));
                modal.classList.add('hidden');
            });
        });

        // Close modal when clicking outside
        const modalOverlay = document.querySelector('.modal-overlay');
        if (modalOverlay) {
            modalOverlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        }
    });

    // import forms handling and sale date

    document.addEventListener('DOMContentLoaded', function() {
        const isImportCheckbox = document.querySelector('[data-toggle-import-fields]');
        const importFieldsContainer = document.querySelector('.import-fields');
        const importFields = document.querySelectorAll('.import-field');

        const isWarrantyCheckbox = document.querySelector('[data-toggle-warranty-fields]');
        const warrantyFieldsContainer = document.querySelector('.warranty-fields');
        const warrantyMonthsField = document.getElementById('publication_warrantyMonths');
    
        function toggleImportFields() {
            const isEnabled = isImportCheckbox.checked;
            importFieldsContainer.style.display = isEnabled ? 'grid' : 'none';
            
            importFields.forEach(field => {
                field.disabled = !isEnabled;
                if (field.id !== 'publication_isCustomsDutyPaid') {
                    field.required = isEnabled;
                }
            });
        }

        function toggleWarrantyFields() {
            const isEnabled = isWarrantyCheckbox.checked;
            
            if (warrantyFieldsContainer) {
                warrantyFieldsContainer.style.display = isEnabled ? 'grid' : 'none';
            }
            
            if (warrantyMonthsField) {
                warrantyMonthsField.disabled = !isEnabled;
                warrantyMonthsField.required = isEnabled;
                
                if (!isEnabled) {
                    warrantyMonthsField.value = '';
                }
            }
        }
    
        if (isWarrantyCheckbox) {
            // Set initial state
            toggleWarrantyFields();
            
            // Handle changes
            isWarrantyCheckbox.addEventListener('change', toggleWarrantyFields);
        }

        if (isImportCheckbox) {
            // Set initial state
            toggleImportFields();
            
            // Handle changes
            isImportCheckbox.addEventListener('change', toggleImportFields);
        }



        const checkbox = document.querySelector('[data-toggle-sale-date]');
        const container = document.querySelector('[data-sale-date-container]');
        
        if (!checkbox || !container) return;
    
        const toggleVisibility = () => {
            container.style.display = checkbox.checked ? 'block' : 'none';
        };
    
        checkbox.addEventListener('change', toggleVisibility);
        toggleVisibility();
    });
}