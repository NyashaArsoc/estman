document.addEventListener('DOMContentLoaded', function () {
    const selectAllCheckbox = document.getElementById('select-all');
    const itemCheckboxes = document.querySelectorAll('.select-item');
    const selectedItemsInfo = document.getElementById('selected-items-info');
    const allocateButton = document.getElementById('btn-upload-stkbatch');

    function updateSelectedItemsInfo() {
        const selectedCount = document.querySelectorAll('.select-item:checked').length;
        // selectedItemsInfo.style.display = selectedCount > 0 ? 'block' : 'none';
        selectedItemsInfo.textContent = selectedCount > 0 ? `${selectedCount} items selected` : '';
        allocateButton.disabled = selectedCount === 0;
    }

    selectAllCheckbox.addEventListener('change', function () {
        itemCheckboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
        updateSelectedItemsInfo();
    });

    itemCheckboxes.forEach(checkbox => checkbox.addEventListener('change', updateSelectedItemsInfo));

    updateSelectedItemsInfo(); // Initial check
});
//button disable submit
function disableButtonAndSubmit(button, id) {
    // Disable the button
    $(button).prop('disabled', true);
    $(button).css('background-color', '#ccc');
    $(button).text('submitting...'); // Change button text
    // Submit the form
    $("#" + id).submit();
}
//button submit
$("#btn-multi-select").click(function () { disableButtonAndSubmit(this, "defaultform"); });