document.addEventListener('DOMContentLoaded', (event) => {
  const skillsPool = document.querySelector('.skills');
  sortChildren(skillsPool, 'id');

  // If POST variable, set event listener to remove buttons of selected skills

  const skillRemoveButtons = document.querySelectorAll('.remove-skill');

  if (skillRemoveButtons.length > 0) {
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

  const dropZone = document.querySelector('.drop-zone');

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
