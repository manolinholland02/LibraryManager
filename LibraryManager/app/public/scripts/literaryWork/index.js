document.addEventListener('DOMContentLoaded', function () {
    const typeSelectElement = document.getElementById('type');
    const additionalInputContainer = document.getElementById('additionalInputForSelectedType');

    //евент лисънър за задаване на тип на произведение (при добавяне на ново в библиотеката)
    typeSelectElement.addEventListener('change', function () {
        const selectedType = this.value;
        additionalInputContainer.innerHTML = '';

        //Генерира хтмл-а на формата спрямо типа на избраното произведение
        if (selectedType === "0") {
            additionalInputContainer.innerHTML = `
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" min="1" max="20" value="1" required>
            </div>
            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" required>
            </div>
            `;
        } else if (selectedType === "1") {
            additionalInputContainer.innerHTML = `
            <div class="mb-3">
                <label for="issueDate" class="form-label">Issue Date</label>
                <input type="text" class="form-control" id="issueDate" name="issueDate" required>
            </div>
            `;
        } else if (selectedType === "2") {
            additionalInputContainer.innerHTML = `
            <div class="mb-3">
                <input type="checkbox" class="form-check-input" id="isFree" name="isFree">
                <label for="isFree" class="form-label">Free?</label>
            </div>
            `;
        }
    });
});

//Изтрива форм инпъта на несъбмитната форма
function resetForm(form) {
    form.reset();
}
