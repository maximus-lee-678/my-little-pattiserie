//# - ID
//. = class

function updateTables(sortBy, sortOrder, filterName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table-contents").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "fill-order-historic-tables.php", false);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    if (sortBy != null && sortOrder != null) {
        xhttp.send("sort-by=" + sortBy + "&direction=" + sortOrder);
    } else if (filterName != null) {
        xhttp.send("cust-name=" + filterName);
    } else {
        xhttp.send();
    }
}

function viewCart(cart_id) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("edit-popup").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "order-cart-items.php", true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("cart-id=" + cart_id);

    $('body').attr('style', 'overflow:hidden;');
    $('#overlay').attr('style', 'display:block;');
    $('#edit-popup').removeAttr('hidden');
}

$(document).ready(function () {
    // Function to populate order's status bar on first launch
    if ((window.location.href).includes("order-overview-historic.php")) {
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
        console.log(sortOrder + sortBy);
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
            $('#table-top-collect_date').append('<i class="bi bi-arrow-up"></i>');
        }
    });

    // Function that shows cart contents
    $(document).on('click', '.view-cart', function () {
        var cart_id = $(this).attr("id");
        cart_id = cart_id.replace('cart_', '');

        viewCart(cart_id);
    });

    // Function that closes pop up when close is clicked
    $(document).on('click', '#close-view', function () {
        $('body').attr('style', '');
        $('#overlay').attr('style', 'display:none;');
        $('#edit-popup').attr('hidden', 'true');
        $('#edit-popup').html('');
    });
});
