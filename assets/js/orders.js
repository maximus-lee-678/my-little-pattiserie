//# - ID
//. = class

function updateTables(filterName) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("table-contents").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "fill-order-tables.php", false);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    if (filterName != null) {
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

function updateStatus(cart_id, status_upgrade) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("stdout").innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "order-change-status-process.php", false);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send("cart-id=" + cart_id + "&status=" + status_upgrade);
}

$(document).ready(function () {
    // Function to populate order's status bar on first launch
    if ((window.location.href).includes("order-overview.php")) {
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

// Function that sorts table(only for historic)
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

        if (searchValue != "") {
            updateTables(searchValue);
        } else {
            updateTables(null);
        }
    });

    // Function that shows cart contents
    $(document).on('click', '.view-cart', function () {
        var cart_id = $(this).attr("id");
        cart_id = cart_id.replace('cart_', '');

        viewCart(cart_id);
    });

    // Function that upgrades order status
    $(document).on('click', '.prep-status', function (e) {
        e.preventDefault();

        var status = $(this).html();
        var stages = ["Order Placed", "Preparing", "Ready For Collection", "Collected"];
        var status_upgrade;

        var cart_id = $(this).attr("id");
        cart_id = cart_id.replace('status_', '');

        switch (status) {
            case "Pending Payment":
                status_upgrade = stages[0];
                break;
            case "Order Placed":
                status_upgrade = stages[1];
                break;
            case "Preparing":
                status_upgrade = stages[2];
                break;
            case "Ready For Collection":
                status_upgrade = stages[3];
                break;
            default:
                alert("You cannot change that!");
                return;
        }

        var answer = confirm("Do you want to update ID: " + cart_id + " from '" + status + "' to '" + status_upgrade + "'?");
        if (answer) {
            updateStatus(cart_id, status_upgrade);
            updateTables(null);
        }

    });

    // Function that closes pop up when close is clicked
    $(document).on('click', '#close-view', function () {
        $('body').attr('style', '');
        $('#overlay').attr('style', 'display:none;');
        $('#edit-popup').attr('hidden', 'true');
        $('#edit-popup').html('');
    });
});
