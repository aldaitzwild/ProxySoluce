document.addEventListener('DOMContentLoaded', (event) => {
  const skillsPool = document.querySelector('.skills');
  const dropZone = document.querySelector('.drop-zone');

  const skillsInitial = [].slice.call(skillsPool.getElementsByTagName('li'));
  sortSkills(skillsInitial, 'id');
  updateSkills(skillsPool, skillsInitial);

  // If POST variable and dropZone therefore non empty, sort selected skills and add eventListeners to remove skill buttons
  if (dropZone.children.length > 0) {
    const skillsSelected = [].slice.call(dropZone.getElementsByTagName('li'));
    sortSkills(skillsSelected);
    updateSkills(dropZone, skillsSelected, false);

    skillsSelected.forEach((skill) => {
      skill.checked = true;
      skillsInitial.push(skill);
    });

    sortSkills(skillsInitial);
  }

  const filterInput = document.querySelector('.skills-filter');
  addFilterHandler(filterInput, skillsInitial, skillsPool);

  // Add remove handler to all removeButtons
  const skillRemoveButtons = document.querySelectorAll('.remove-skill');
  skillRemoveButtons.forEach((button) =>
    addRemoveButtonHandler(button, skillsPool, filterInput, skillsInitial)
  );

  // Initialize dragged element
  let dragged;

  /* Start and end drag n drop sequence */
  function handleDragStart(e) {
    this.style.opacity = '0.4';

    const target = e.target;
    if (target) {
      dragged = target;
    }
  }

  function handleDragEnd(e) {
    this.style.opacity = '1';
  }

  function handleDrop(e) {
    e.stopPropagation(); // stops the browser from redirecting.
    return false;
  }

  const skillItems = document.querySelectorAll('.skills__item');

  skillItems.forEach((skill) => {
    skill.addEventListener('dragstart', handleDragStart);
    skill.addEventListener('dragend', handleDragEnd);
    skill.addEventListener('drop', handleDrop);
  });

  /* Add visual cues for drop zone */

  function handleDragEnter(e) {
    const target = e.target;
    if (target) {
      e.preventDefault();
      // Set the dropEffect to move
      e.dataTransfer.dropEffect = 'move';
    }
    this.classList.remove('border-secondary');
    this.classList.add('over', 'border-primary');
  }

  function handleDragLeave(e) {
    this.classList.add('border-secondary');
  }

  function handleDragOver(e) {
    if (e.preventDefault) {
      e.preventDefault();
    }

    return false;
  }

  // Handle skill drop and skill removal

  function handleDropZone(e) {
    this.classList.remove('over');
    this.classList.add('border-secondary');
    const target = e.target;
    if (target) {
      e.preventDefault();
      // Add the moved element to the target's DOM
      dragged.parentNode.removeChild(dragged);
      target.appendChild(dragged);

      dragged.checked = true;
    }
  }

  dropZone.addEventListener('dragenter', handleDragEnter);
  dropZone.addEventListener('dragleave', handleDragLeave);
  dropZone.addEventListener('dragover', handleDragOver);
  dropZone.addEventListener('drop', handleDropZone);
});

/* ******************************************************************************* */
/* ******************************************************************************* */
/* ******************************************************************************* */

/* ************************************************* */
/* Handler functions */
/* ************************************************* */

// Remove button handler

function addRemoveButtonHandler(button, skillsPool, input, skillsInitial) {
  button.addEventListener('click', function handleRemoveSkill(e) {
    const target = e.target;
    if (target) {
      const skillToBeRemoved = target.parentNode;
      if (
        !confirm(
          `\n Etes-vous sur de vouloir retirer cette compétences de votre liste ? \n\n ${skillToBeRemoved.firstChild.nodeValue.trim()} `
        )
      ) {
        return;
      }
      skillToBeRemoved.checked = false;

      /* Remove skill from dropzone */
      skillToBeRemoved.parentNode.removeChild(skillToBeRemoved);

      filterSkills(input, skillsInitial, skillsPool);
    }
  });
}

// Input filter handler

function addFilterHandler(input, skillsInitial, skillsPool) {
  function handleChangeValue(e) {
    const target = e.target;

    if (target) {
      filterSkills(input, skillsInitial, skillsPool);
    }
  }
  input.addEventListener('input', handleChangeValue);
}

/* ************************************************* */
/* Helper functions */
/* ************************************************* */

// Filter skills within container

function filterSkills(input, skills, skillsContainer) {
  const filter = input.value.toLowerCase();

  if (!filter === '') {
    updateSkills(skillsContainer, skills);
  } else {
    const skillsFiltered = skills.filter((skill) =>
      skill.firstChild.nodeValue.toLowerCase().includes(filter)
    );
    updateSkills(skillsContainer, skillsFiltered);
  }
}

// Update skills display in container

function updateSkills(container, skills, filterChecked = true) {
  container.innerHTML = '';

  if (filterChecked) {
    skills.forEach((skill) => {
      if (!skill.checked) container.appendChild(skill);
    });
  } else {
    skills.forEach((skill) => container.appendChild(skill));
  }
}

// Sort skills

function sortSkills(array) {
  array.sort((a, b) =>
    a.firstChild.nodeValue.localeCompare(b.firstChild.nodeValue)
  );
}
