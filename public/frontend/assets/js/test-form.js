document.addEventListener('DOMContentLoaded', function () {
    bindCreateQuizz();
    bindUpdateQuizz();
});

// Handles the "Add Option" logic for Create Modal
function bindCreateQuizz() {
    const wrapper = document.getElementById('options-wrapper');
    const addBtn = document.getElementById('add-option-btn');
    if (!wrapper || !addBtn) return;

    let optionIndex = wrapper.querySelectorAll('.input-group').length;
    const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');

    addBtn.addEventListener('click', function () {
        if (optionIndex >= alphabet.length) return alert('Maximum number of options reached.');

        const div = document.createElement('div');
        div.classList.add('input-group', 'mb-2');

        div.innerHTML = `
            <span class="input-group-text" style="background-color: #424242">${alphabet[optionIndex]}</span>
            <input type="text" name="options[]" class="form-control" required>
            <div class="input-group-text" style="background-color: #424242">
                <input class="form-check-input mt-0" type="radio" name="correct_option" value="${optionIndex}" required>
                <label class="ms-1 mb-0 small">Correct</label>
            </div>
        `;

        wrapper.appendChild(div);
        optionIndex++;
    });
}

// Handles the "Add Option" logic for each Edit Modal
function bindUpdateQuizz() {
    const allEditModals = document.querySelectorAll('[id^="edit-options-wrapper"]');

    allEditModals.forEach((wrapper) => {
        const modalId = wrapper.closest('.modal')?.id;
        if (!modalId) return;

        const addBtn = document.querySelector(`#${modalId} .edit-add-option-btn`);
        if (!addBtn) return;

        let optionIndex = wrapper.querySelectorAll('.input-group').length;
        const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('');

        addBtn.addEventListener('click', function () {
            if (optionIndex >= alphabet.length) return alert('Maximum options reached.');

            const div = document.createElement('div');
            div.classList.add('input-group', 'mb-2');

            div.innerHTML = `
                <span class="input-group-text">${alphabet[optionIndex]}</span>
                <input type="text" name="options[]" class="form-control" required>
                <div class="input-group-text">
                    <input type="radio" name="correct_option" value="${optionIndex}" class="form-check-input mt-0" required>
                    <label class="ms-1 mb-0 small">Correct</label>
                </div>
            `;

            wrapper.appendChild(div);
            optionIndex++;
        });
    });
}
