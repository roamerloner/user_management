document.addEventListener('DOMContentLoaded', function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(toolTipTriggerEl){
        return new bootstrap.Tooltip(toolTipTriggerEl)
    })



    const selectAll = document.getElementById('selectAll');
    const userCheckboxes = document.querySelectorAll('.user-select');

    selectAll.addEventListener('change', function(){
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateButtonStates();
    });

    userCheckboxes.forEach(checkbox =>{
        checkbox.addEventListener('change', function(){
            updateSelectAllState();
            updateButtonStates();
        });
    });

    const filterinput = document.getElementById('filterInput');
    filterinput.addEventListener('input', function(){
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? ' ' : 'none';
        });
    });

    document.getElementById('blockBtn').addEventListener('click', () => performAction('block'));
    document.getElementById('unblockBtn').addEventListener('click', () => performAction('unblock'));
    document.getElementById('deleteBtn').addEventListener('click', () => performAction('delete'));

    function updateSelectAllState() {
        const checkboxes = Array.from(userCheckboxes);
        selectAll.checked = checkboxes.every(checkbox => checkbox.checked);
        selectAll.indeterminate = !selectAll.checked && checkboxes.some(checkbox => checkbox.checked);
    }

   function updateButtonStates(){
    const hasSelection = Array.from(userCheckboxes).some(checkbox => checkbox.checked);
    document.getElementById('blockBtn').disabled = !hasSelection;
    document.getElementById('unblockBtn').disabled = !hasSelection;
    document.getElementById('deleteBtn').disabled = !hasSelection;
   }

   function performAction(action) {
    const selectedIds = Array.from(userCheckboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value);

    if (!selectedIds.length) return;


    fetch('actions.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: action,
            ids: selectedIds
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            console.log(data.message || 'An error occurred');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

updateButtonStates();


});