export function initializeLocation() {
    document.addEventListener('DOMContentLoaded', function() {
        const countrySelect = document.getElementById('publication_country');
        const locationSelect = document.getElementById('publication_sellerLocation');
        const locale = document.documentElement.lang || 'en';

        if (countrySelect && locationSelect) {
            countrySelect.addEventListener('change', function() {
                const countryId = this.value;
                fetchLocations(countryId);
            });
        }

        function fetchLocations(countryId) {
            if (!countryId) return;

            fetch(`/${locale}/publication/locations/${countryId}`)
                .then(response => response.json())
                .then(data => {
                    locationSelect.innerHTML = '<option value="">Choose a location</option>';
                    data.forEach(location => {
                        const option = document.createElement('option');
                        option.value = location.id;
                        option.textContent = location.name;
                        locationSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching locations:', error);
                    locationSelect.innerHTML = '<option value="">Error loading locations</option>';
                });
        }
    });
}
