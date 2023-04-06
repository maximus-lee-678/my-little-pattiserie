//# - ID
//. = class

function viewProduct(idName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("edit-popup").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "product-edit.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("product-id=" + idName);

    $('body').attr('style', 'overflow:hidden;');
    $('#overlay').attr('style', 'display:block;');
    $('#edit-popup').removeAttr('hidden');
}

function updateImage(idName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("edit-popup").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "product-edit-picture.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("product-id=" + idName);

    $('body').attr('style', 'overflow:hidden;');
    $('#overlay').attr('style', 'display:block;');
    $('#edit-popup').removeAttr('hidden');
}

function updateTables(sortBy, sortOrder, filterName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table-contents").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "fill-product-tables.php", false);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    if (sortBy != null && sortOrder != null) {
        xhttp.send("sort-by=" + sortBy + "&direction=" + sortOrder);
    } else if (filterName != null) {
        xhttp.send("item-name=" + filterName);
    } else {
        xhttp.send();
    }
}

$(document).ready(function () {
    // Function to populate view-all-products's status bar on first launch
    if ((window.location.href).includes("view-all-products.php")) {
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

    // Function to dynamically fill subcategory after selection
    $(document).on('change', '#category', function () {
        $('#subcategory').html('<option selected readonly value="">Select a subcategory:</option>');

        if ($(this).val() == "Sweets") {
            $(document).find('#subcategory').append('<option value="Pastry">Pastry</option>');
            $(document).find('#subcategory').append('<option value="Cakes">Cakes</option>');
        }
        if ($(this).val() == "Beverages") {
            $(document).find('#subcategory').append('<option value="Tea">Tea</option>');
            $(document).find('#subcategory').append('<option value="Coffee">Coffee</option>');
            $(document).find('#subcategory').append('<option value="Others">Others</option>');
        }
    });

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

        // disable sort and disable button
        if (searchValue != "") {
            updateTables(null, null, searchValue);
            $('.table-top').attr('class', 'btn btn-static');
        } else {
            updateTables(null, null, null);
            $('#table-top-products_id').append('<i class="bi bi-arrow-up"></i>');
        }
    });

    // Function that produces view more popup
    $(document).on('click', '.view-details', function () {
        var idName = $(this).attr("id");
        idName = idName.replace('view_', '');

        viewProduct(idName);
    });

    // Function that produces image upload popup
    $(document).on('click', '.image-upload', function () {
        var idName = $(this).attr("id");
        idName = idName.replace('file_', '');

        updateImage(idName);
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
            viewProduct(idName);
        }

    });

    // AJAX for edit product
    $(document).on('submit', '#product-edit', function (e) {
        e.preventDefault(); // stop normal form execution

        var operation = $(document.activeElement).attr("id");       // either submit-button or delete-button
        var product_id = $('#submit-button').val();                    // product id
        operation = operation.replace("-button", "");              // change to either submit or delete

        var answer = confirm('Are you sure you want to ' + operation + '?');
        if (answer) {
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize() + "&" + operation + "=" + product_id, // serializes the form's elements
                success: function (data)
                {
                    document.getElementById("stdout").innerHTML = data;
                    updateTables(null, null, null);
                    $('#table-top-products_id').append('<i class="bi bi-arrow-up"></i>');
                    $('body').attr('style', '');
                    $('#overlay').attr('style', 'display:none;');
                    $('#edit-popup').attr('hidden', 'true');
                    $('#edit-popup').html('');
                }
            });
        }
    });
});