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

    // import forms handling

    document.addEventListener('DOMContentLoaded', function() {
        const isImportCheckbox = document.querySelector('[data-toggle-import-fields]');
        const importFields = document.querySelectorAll('.import-field');
    
        function toggleImportFields() {
            const isEnabled = isImportCheckbox.checked;
            importFields.forEach(field => {
                const parentDiv = field.closest('.form-group');
                if (parentDiv) {
                    parentDiv.style.display = isEnabled ? 'block' : 'none';
                }
                field.disabled = !isEnabled;
                if (isEnabled) {
                    field.required = field.id !== 'publication_isCustomsDutyPaid';
                }
            });
        }
    
        if (isImportCheckbox) {
            // Initial state
            toggleImportFields();
    
            // Listen for changes
            isImportCheckbox.addEventListener('change', toggleImportFields);
        }
    });
}