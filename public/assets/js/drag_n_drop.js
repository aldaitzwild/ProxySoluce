document.addEventListener('DOMContentLoaded', (event) => {
  const skillsPool = document.querySelector('.skills');
  const dropZone = document.querySelector('.drop-zone');
  const skillsInitial = [].slice.call(skillsPool.children);

  sortSkills(skillsPool, 'id');

  const filterInput = document.querySelector('.skills-filter');
  addFilterHandler(filterInput, skillsInitial, skillsPool);

  // If POST variable and dropZone therefore non empty, sort selected skills and add eventListeners to remove skill buttons
  if (dropZone.children.length > 0) {
    sortSkills(dropZone, 'id', false);

    const skillRemoveButtons = document.querySelectorAll('.remove-skill');
    skillRemoveButtons.forEach((button) =>
      addRemoveButtonHandler(button, skillsPool, filterInput, skillsInitial)
    );
  }

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
    this.classList.add('over');
    this.classList.add('border-primary');
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
    this.classList.remove('border-primary');
    this.classList.add('border-secondary');
    const target = e.target;
    if (target) {
      e.preventDefault();
      // Get the id of the target and add the moved element to the target's DOM
      dragged.parentNode.removeChild(dragged);
      target.appendChild(dragged);

      /* Add remove button to skill */
      addRemoveButton(dragged, skillsPool, filterInput, skillsInitial);
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
          `\n!!! Are you sure you to remove the following skill ?\n\n-- ${skillToBeRemoved.firstChild.nodeValue.trim()} --`
        )
      ) {
        return;
      }
      skillToBeRemoved.checked = false;

      /* Delete remove button from skill */
      skillToBeRemoved.removeChild(skillToBeRemoved.children[1]);

      /* Remove skill from dropzone */
      skillToBeRemoved.parentNode.removeChild(skillToBeRemoved);

      /* Add skill to skill pool and sort skill pool */
      skillsInitialIds = skillsInitial.map((x) => x.id);
      if (!skillsInitialIds.includes(skillToBeRemoved.id))
        skillsInitial.push(skillToBeRemoved);

      sortSkills(skillsPool, 'id');
      addFilterHandler(input, skillsInitial, skillsPool, true);
      filterSkills(input, skillsInitial, skillsPool);
    }
  });
}

// Input filter handler

function addFilterHandler(input, skillsInitial, skillsPool, update = false) {
  function handleChangeValue(e) {
    const target = e.target;

    if (target) {
      filterSkills(input, skillsInitial, skillsPool);
    }
  }

  if (update) {
    input.removeEventListener('input', handleChangeValue);
  }
  input.addEventListener('input', handleChangeValue);
}

/* ************************************************* */
/* Helper functions */
/* ************************************************* */

// Sort skills within container

function sortSkills(parent, itemToCompare, filterChecked = true) {
  const childSorted = [].slice
    .call(parent.children)
    .sort((a, b) => a[`${itemToCompare}`].localeCompare(b[`${itemToCompare}`]));

  updateSkills(parent, childSorted, filterChecked);
}

// Filter skills within container

function filterSkills(input, skills, skillsContainer) {
  const filter = input.value.toLowerCase();

  if (filter === '') {
    updateSkills(skillsContainer, skills);
  } else {
    const skillsFiltered = skills.filter((skill) =>
      skill['id'].toLowerCase().includes(filter)
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

/* ************************************************* */
// Add remove button function to skill upon drag in drop zone
/* ************************************************* */

function addRemoveButton(skill, skillsPool, filterInput, skillsInitial) {
  skill.insertAdjacentHTML(
    'beforeend',
    "<button type='button' class='remove-skill ml-2 px-1 py-0 btn btn-danger'>X</button>"
  );

  skill.checked = true;

  // Skill removal function
  const removeSkillButton = document.querySelector(
    `#${skill.id} .remove-skill`
  );
  addRemoveButtonHandler(
    removeSkillButton,
    skillsPool,
    filterInput,
    skillsInitial
  );
}
