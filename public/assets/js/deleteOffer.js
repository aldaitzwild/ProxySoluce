
const deleteButton = document.getElementById('deleteOffer');

deleteButton.addEventListener('click', (event) => {
    const confirm = window.confirm('Etes vous sur de vouloir supprimer cette annonce ?');
        if (confirm == true) {
            return true;
        } else {
            event.stopPropagation();
            event.preventDefault();
    return false;
    }
})