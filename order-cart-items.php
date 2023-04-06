<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=order-overview.php");
    exit;
}
// Functions
// Function to sanitize inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$cart_id = sanitize_input($_POST['cart-id']);
?>

<main class="container">
    <div style="float:right;">
        <a class="bi bi-x-square" style="font-size:36px;" id="close-view"></a>
    </div>
    <div>
        <p>Cart ID: <?php echo $cart_id; ?></p>
    </div>
    <table class="table table-sm" style="border-style:solid;">
        <tr>
            <th scope="col"><p class="btn btn-static">Item Name</th>
            <th scope="col"><p class="btn btn-static">Quantity</p></th>
        </tr>

        <?php
        $config = parse_ini_file('../../private/db-config.ini');
        $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
        // Check connection
        if ($conn->connect_error) {
            $captionText = "Connection failed: " . $conn->connect_error;
        } else {
            // Prepare the statement:
            $stmt = $conn->prepare("SELECT item_name,cart_items.quantity FROM cart_items INNER JOIN products ON cart_items.products_id = products.products_id WHERE cart_id=?");
            // Bind & execute the query statement:
            $stmt->bind_param("s", $cart_id);
            // execute the query statement:
            if (!$stmt->execute()) {
                $captionText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }

            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $captionText = "Retrieved " . $result->num_rows . " rows.";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr><td>" . $row["item_name"] .
                    "</td>\n<td>" . $row["quantity"] . "</tr>\n\n";
                }
            } else {
                $captionText = "Retrieved 0 rows.";
            }
            $stmt->close();
        }
        $conn->close();
        echo "<caption>" . $captionText . "</caption>";
        ?>

    </table>
</main>