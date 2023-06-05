const attractionsSelect = document.getElementById('attractions');
const firstAttractionSelect = document.getElementById('firstAttraction');

attractionsSelect.addEventListener('change', updateFirstAttractionOptions);

function updateFirstAttractionOptions() {
    const selectedAttractions = Array.from(attractionsSelect.selectedOptions).map(option => option.value);

    firstAttractionSelect.innerHTML = ""; // Uklonimo sve opcije iz donjeg selecta

    selectedAttractions.forEach(attractionId => {
        const option = document.createElement('option');
        option.value = attractionId;
        option.textContent = attractionsSelect.querySelector(`[value="${attractionId}"]`).textContent;
        firstAttractionSelect.appendChild(option);
    });
}