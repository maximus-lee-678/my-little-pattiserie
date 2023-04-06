//# - ID
//. = class

function viewStaff(idName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("edit-popup").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "staff-edit.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("staff-id=" + idName);

    $('body').attr('style', 'overflow:hidden;');
    $('#overlay').attr('style', 'display:block;');
    $('#edit-popup').removeAttr('hidden');
}

function newStaffInitial() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("edit-popup").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "create-new-staff.php", true);
    xhttp.send();

    $('body').attr('style', 'overflow:hidden;');
    $('#overlay').attr('style', 'display:block;');
    $('#edit-popup').removeAttr('hidden');
}

function resetPassword(idName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("stdout").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "staff-edit-process.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("reset=" + idName);
}

function updateTables(sortBy, sortOrder, filterName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table-contents").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "fill-staff-tables.php", false);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    if (sortBy != null && sortOrder != null) {
        xhttp.send("sort-by=" + sortBy + "&direction=" + sortOrder);
    } else if (filterName != null) {
        xhttp.send("staff-name=" + filterName);
    } else {
        xhttp.send();
    }
}

$(document).ready(function () {
    // Function to populate view-all-products's status bar on first launch
    if ((window.location.href).includes("staff-overview.php")) {
        var output = $("#stdout").html();
        output = output.trim();

        var today = new Date();
        var timeHour = today.getHours();
        var timeMin = today.getMinutes();

        if (timeHour < 10) {
            timeHour = '0' + timeHour.toString();
        }
        if (timeMin < 10) {
            timeMin = '0' + timeMin.toString();
        }

      if (output.includes("Welcome")) {
            $("#stdout").append("Page Loaded at: " + timeHour + ":" + timeMin + ".");
        }
    }

// Function that sorts table
    $(document).on('click', '.table-top', function () {
        var fullId = $(this).attr("id");
        var sortOrder, sortBy;

        if ($(this).html().includes("arrow-up")) {
            sortOrder = "DESC";
        } else {
            sortOrder = "ASC";
        }

        sortBy = fullId.replace("table-top-", "");
        updateTables(sortBy, sortOrder, null);

        if ($(this).html().includes("arrow-down")) {
            $(document).find('#' + fullId).append('<i class="bi bi-arrow-up"></i>');
        } else if ($(this).html().includes("arrow-up")) {
            $(document).find('#' + fullId).append('<i class="bi bi-arrow-down"></i>');
        } else {
            $(document).find('#' + fullId).append('<i class="bi bi-arrow-up"></i>');
        }
    });

    // Function that sorts table by name
    $(document).on('keyup', '#search-field', function () {
        var searchValue = $(this).val();

        updateTables(null, null, searchValue);

        // disable sort and disable button
        if (searchValue != "") {
            $('.table-top').attr('class', 'btn btn-static');
        } else {
            $('#table-top-staffID').append('<i class="bi bi-arrow-up"></i>');
        }
    });

    // Function that produces view more popup
    $(document).on('click', '.view-details', function () {
        var idName = $(this).attr("id");
        idName = idName.replace('view_', '');

        viewStaff(idName);
    });

    // Function that confirm password reset
    $(document).on('click', '.reset-password', function (e) {
        e.preventDefault();
        var answer = confirm('Do you want to reset password?');
        if (answer) {
            var idName = $(this).attr("id");
            idName = idName.replace('reset_', '');

            resetPassword(idName);
        }
    });

    // Function that closes pop up when close is clicked
    $(document).on('click', '#close-view', function () {
        $('body').attr('style', '');
        $('#overlay').attr('style', 'display:none;');
        $('#edit-popup').attr('hidden', 'true');
        $('#edit-popup').html('');
    });

    // Function that enables editing
    $(document).on('click', '#edit-button', function () {
        $('#edit-button').attr('hidden', 'true');
        $('.edit-features').removeAttr('hidden', 'true');
        $('.form-control').removeAttr('disabled');
    });

    // Function that requeries information for current id as changes were discarded
    $(document).on('click', '#discard-button', function (e) {
        e.preventDefault(); // stop normal execution
        
        var answer = confirm('Are you sure you want to discard changes?');
        if (answer) {
            var idName = $('#submit-button').val();
            viewStaff(idName);
        }
    });

    // AJAX for new staff initial
    $(document).on('click', '#new-staff-button', function (e) {
        e.preventDefault(); // stop normal link execution
        newStaffInitial();
    });

    // AJAX for new staff submit
    $(document).on('submit', '#staff-create', function (e) {
        e.preventDefault(); // stop normal form execution

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(), // serializes the form's elements
            success: function (data)
            {
                document.getElementById("stdout").innerHTML = data;
                updateTables(null, null, null);
                $('#table-top-staffID').append('<i class="bi bi-arrow-up"></i>');
                $('body').attr('style', '');
                $('#overlay').attr('style', 'display:none;');
                $('#edit-popup').attr('hidden', 'true');
                $('#edit-popup').html('');
            }
        });
    });

    // AJAX for edit staff
    $(document).on('submit', '#staff-edit', function (e) {
        e.preventDefault(); // stop normal form execution

        var operation = $(document.activeElement).attr("id");       // either submit-button or delete-button
        var staffID = $('#submit-button').val();                    // staff id
        operation = operation.replace("-button", "");              // change to either submit or delete

        var answer = confirm('Are you sure you want to ' + operation + '?');
        if (answer) {
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize() + "&" + operation + "=" + staffID, // serializes the form's elements
                success: function (data)
                {
                    document.getElementById("stdout").innerHTML = data;
                    updateTables(null, null, null);
                    $('#table-top-staffID').append('<i class="bi bi-arrow-up"></i>');
                    $('body').attr('style', '');
                    $('#overlay').attr('style', 'display:none;');
                    $('#edit-popup').attr('hidden', 'true');
                    $('#edit-popup').html('');
                }
            });
        }
    });
});