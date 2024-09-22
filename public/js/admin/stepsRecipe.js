document.addEventListener('DOMContentLoaded', function() {
    const addStepBtn = document.getElementById('addStepBtn');
    const preparationInput = document.getElementById('preparationInput');
    const preparationList = document.getElementById('preparationList');
    const preparationHiddenInput = document.getElementById('preparationHiddenInput');
    let editingStep = null; // Variable para mantener el paso que se está editando

    addStepBtn.addEventListener('click', function() {
        const stepText = preparationInput.value.trim();
        if (stepText !== '') {
            if (editingStep) {
                // Actualizar el paso existente
                editingStep.querySelector('.step-text').textContent = stepText;
                editingStep = null; // Limpiar la referencia de edición
            } else {
                // Agregar un nuevo paso
                addStepToList(stepText);
            }
            preparationInput.value = ''; // Limpiar el campo de input
            updatePreparationInput();
        }
    });

    function addStepToList(stepText) {
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
        li.innerHTML = `
            <div class="row w-100">
                <div class="col-lg-9 col-12 ps-3">
                    <span class="step-text">${stepText}</span>
                </div>
                <div class="col-lg-2 col-12 d-flex">
                    <button type="button" class="btn btn-sm btn-warning me-2" onclick="editStep(this)">Editar</button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeStep(this)">Eliminar</button>
                </div>
            </div>
        `;
        preparationList.appendChild(li);
    }

    window.editStep = function(button) {
        editingStep = button.closest('li'); // Guardar la referencia al paso que se está editando
        const stepText = editingStep.querySelector('.step-text').textContent;
        preparationInput.value = stepText; // Llevar el texto del paso al input para editar
    };

    window.removeStep = function(button) {
        const li = button.closest('li');
        li.remove(); // Eliminar el paso de la lista
        updatePreparationInput(); // Actualizar el campo oculto
    };

    function updatePreparationInput() {
        const steps = Array.from(preparationList.querySelectorAll('.step-text')).map(span => span.textContent);
        preparationHiddenInput.value = steps.join('@'); // Guardar los pasos concatenados en el input oculto
    }
});
