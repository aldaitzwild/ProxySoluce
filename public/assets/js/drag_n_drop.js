document.addEventListener('DOMContentLoaded', (event) => {
  const skillsPool = document.querySelector('.skills');
  const dropZone = document.querySelector('.drop-zone');
  sortChildren(skillsPool, 'id');

  let filter;

  const filterInput = document.querySelector('.skills-filter');
  addSortingHandler(filterInput, filter, skillsPool, skillsPool.children);

  // If POST variable and dropZone therefore non empty, sort selected skills and add eventListeners to remove skill buttons
  if (dropZone.children.length > 0) {
    sortChildren(dropZone, 'id');

    const skillRemoveButtons = document.querySelectorAll('.remove-skill');
    skillRemoveButtons.forEach((button) =>
      addRemoveButtonHandler(button, button.parentNode, skillsPool)
    );
  }

  // Initialize dragged element and skill to be removed element (in drop zone)

  let dragged;
  let skillToBeRemoved;

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
    this.classList.remove('over');
    this.classList.remove('border-primary');
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
    this.classList.remove('border-primary');
    const target = e.target;
    if (target) {
      e.preventDefault();
      // Get the id of the target and add the moved element to the target's DOM
      dragged.parentNode.removeChild(dragged);
      target.appendChild(dragged);

      /* Add remove button to skill */
      dragged.insertAdjacentHTML(
        'beforeend',
        "<button type='button' class='remove-skill ml-2 px-1 py-0 btn btn-danger'>X</button>"
      );

      // Skill removal function

      const removeSkillButton = document.querySelector(
        `#${dragged.id} .remove-skill`
      );
      addRemoveButtonHandler(removeSkillButton, skillToBeRemoved, skillsPool);
    }
  }

  dropZone.addEventListener('dragenter', handleDragEnter);
  dropZone.addEventListener('dragleave', handleDragLeave);
  dropZone.addEventListener('dragover', handleDragOver);
  dropZone.addEventListener('drop', handleDropZone);
});

function sortChildren(parent, itemToCompare) {
  const childSorted = [].slice
    .call(parent.children)
    .sort((a, b) => a[`${itemToCompare}`].localeCompare(b[`${itemToCompare}`]));

  parent.innerHTML = '';
  childSorted.forEach((child) => parent.appendChild(child));
}

function addRemoveButtonHandler(button, skillToBeRemoved, skillsPool) {
  button.addEventListener('click', function handleRemoveSkill(e) {
    const target = e.target;
    if (target) {
      skillToBeRemoved = target.parentNode;

      /* Delete remove button from skill */
      skillToBeRemoved.removeChild(skillToBeRemoved.children[1]);

      /* Remove skill from dropzone */
      skillToBeRemoved.parentNode.removeChild(skillToBeRemoved);

      /* Add skill to skill pool and sort skill pool */
      skillsPool.appendChild(skillToBeRemoved);
      sortChildren(skillsPool, 'id');
    }
  });
}

function addSortingHandler(input, filter, skillsPool, skillsInitial) {
  const skills = [].slice.call(skillsInitial);
  input.addEventListener('input', function handleChangeValue(e) {
    const target = e.target;

    if (target) {
      filter = input.value.toLowerCase();

      if (filter === '') {
        skillsPool.innerHTML = '';
        skills.forEach((skill) => {
          if (skill.children[1] === undefined) skillsPool.appendChild(skill);
        });
      } else {
        const skillsFiltered = skills.filter(
          (skill) =>
            skill['id'].toLowerCase().includes(filter) &&
            skill.children[1] === undefined
        );
        skillsPool.innerHTML = '';
        skillsFiltered.forEach((skill) => skillsPool.appendChild(skill));
      }
    }
  });
}
