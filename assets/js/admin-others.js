//# - ID
//. = class

$(document).ready(function () {
    // Show-Hide for password change on edit page
    $(document).on('click', '#change-password-button', function () {
        $('.password-divs').removeAttr('hidden', 'true');
        $('.password-fields').attr('required', 'true');
        $('#change-password-button').attr('hidden', 'true');
        $('#submit-button').val('yes-password');
    });
    
    // Show-Hide for password change on edit page
    $(document).on('click', '#discard-password-button', function () {
        $('.password-divs').attr('hidden', 'true');
        $('.password-fields').removeAttr('required');
        $('.password-fields').val('');
        $('#change-password-button').removeAttr('hidden', 'true');
        $('#submit-button').val('no-password');
    });
});