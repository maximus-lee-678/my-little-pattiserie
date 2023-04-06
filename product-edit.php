<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=view-all-products.php");
    exit;
}

$product_id = $_POST["product-id"];

// Create database connection.
$config = parse_ini_file('../../private/db-config.ini');
$conn = new mysqli($config['servername'], $config['username'],$config['password'], $config['dbname']);
// Check connection
if ($conn->connect_error) {
    $errorMsg = "Connection failed: " . $conn->connect_error;
    $success = false;
} else {
    // Select product based on products_id
    $stmt = $conn->prepare("SELECT * FROM products WHERE products_id = ?");
    // Bind & execute the query statement:
    $stmt->bind_param("s", $product_id);
    // execute the query statement:
    if (!$stmt->execute()) {
        $errorMsg = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        $success = false;
    } else {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $item_name = $row['item_name'];
            $price = $row['price'];
            $summary = $row['summary'];
            $last_updated = $row['last_updated'];
            $category = $row['category'];
            $sub_category = $row['sub_category'];
            $active = $row['active'];
        } else {
            $errorMsg = "Product not found!";
            $success = false;
        }
        $stmt->close();
    }
    $conn->close();
}

if (!$success) {
    echo $errorMsg;
}
?>

<body>
    <main class="container">
        <div style="float:right;">
            <a class="bi bi-x-square" style="font-size:36px;" id="close-view"></a>
        </div><br>
        <form action="product-edit-process.php" id="product-edit" method="post">
            <div class="form-group">
                <label for="item-name">Item Name:</label>
                <input class="form-control"  maxlength="60" 
                       disabled="disabled" name="item-name" placeholder="Enter Item Name" value="<?php echo $item_name; ?>">
            </div>
                <div class="form-group">
                    <label for="price">Price: ($)</label>
                    <input class="form-control" type="number" onkeydown="javascript: return event.keyCode !== 69" step=".01" 
                           disabled="disabled" required name="price" placeholder="Enter Item Price" value="<?php echo $price; ?>">
                </div>
            <div class="form-group">
                <label for="summary">Summary:</label>
                <textarea class="form-control" disabled="disabled" rows="4"  maxlength="225" 
                          name="summary" required placeholder="Enter Summary"><?php echo $summary; ?></textarea>
            </div>
            <span style="display:flex; flex-wrap:wrap;">
                <div class="form-group" style="flex:1;">
                        <label for="category">Category:</label><br>
                        <select class="form-control" name="category" id="category" disabled="disabled" required>
                            <option selected readonly value="<?php echo $category; ?>"><?php echo $category; ?></option>
                            <option value="Sweets">Sweets</option>
                            <option value="Beverages">Beverages</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label for="subcategory">Subcategory:</label>
                        <select class="form-control" name="subcategory" id="subcategory" disabled="disabled" required>
                            <option selected readonly value="<?php echo $sub_category; ?>"><?php echo $sub_category; ?></option>
                        </select>
                    </div>
            </span>
            <span style="white-space:normal;">
                <div class="form-group edit-features" style="display:inline-block;" hidden>
                    <button class="btn btn-success" id="submit-button" type="submit" name="submit" value="<?php echo $product_id; ?>">Submit</button>
                </div>
                <div class="form-group edit-features" style="display:inline-block;" hidden>
                    <a class="btn btn-secondary" id="discard-button" style="color:white;">Discard Changes</a>
                </div>
                <div class="form-group edit-features" style="display:inline-block;" hidden>
                    <button class="btn btn-danger" id="delete-button" type="delete" name="delete" value="<?php echo $product_id; ?>">Delete</button>
                </div>
            </span>
        </form>
        <div class="form-group">
            <button class="btn btn-secondary" id="edit-button" type="edit" name="edit">Edit</button>
        </div>
        <div class="form-group">
            <p>Last Updated: <?php echo $last_updated; ?></p>
        </div>
    </main>
</body>