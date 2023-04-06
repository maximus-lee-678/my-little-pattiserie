<?php
session_start();
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=view-all-products.php");
    exit;
}

header("refresh: 0; url=view-all-products.php");
// Functions
// Function to sanitize inputs
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<?php

if (isset($_POST['submit'])) {
    // form parameters
    $products_id = sanitize_input($_POST['submit']);
    $item_name = sanitize_input($_POST['item-name']);
    $price = sanitize_input($_POST['price']);
    $summary = sanitize_input($_POST['summary']);
    $image_alt_text = sanitize_input($_POST['item-name']);
    $category = sanitize_input($_POST['category']);
    $subcategory = sanitize_input($_POST['subcategory']);

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $displayText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement: 
        $stmt = $conn->prepare("UPDATE products SET item_name=?, price=?, summary=?, image_alt_text=?, last_updated=date_format(curdate(), '%d %M %Y'), category=?, sub_category=? WHERE products_id=?");
        // Bind & execute the query statement:
        $stmt->bind_param("sssssss", $item_name, $price, $summary, $image_alt_text, $category, $subcategory, $products_id);
        if (!$stmt->execute()) {
            $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $displayText = $item_name . " successfully updated!";
        }
        $stmt->close();
    }
    $conn->close();

    echo $displayText;
}

if (isset($_POST['delete'])) {
    $item_name = sanitize_input($_POST['item-name']);
    $products_id = sanitize_input($_POST['delete']);

    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $displayText = "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare the statement:
        $stmt = $conn->prepare("UPDATE products SET active='NO' WHERE products_id=?");
        // Bind & execute the query statement:
        $stmt->bind_param("s", $products_id);
        // execute the query statement:
        if (!$stmt->execute()) {
            $displayText = "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $displayText = $item_name . " successfully deleted.";
        }
        $stmt->close();
    }
    $conn->close();

    echo $displayText;
}

// if file was submitted
if (isset($_POST['image-submit'])) {
    if (file_exists($_FILES['upload-image']['tmp_name']) || is_uploaded_file($_FILES['upload-image']['tmp_name'])) {
        
        $products_id = sanitize_input($_POST['image-submit']);

        // file parameters
        $file_name = $_FILES['upload-image']['name'];            // stores filename
        $file_tmp_name = $_FILES['upload-image']['tmp_name'];     // stores the temporary filename
        $file_size = $_FILES['upload-image']['size'];            // stores filesize
        $file_error = $_FILES['upload-image']['error'];          // stores error codes, if any
        $file_extension = explode('.', $file_name);           // explode() first seperates file names to tokens separated by '.'s 
        $file_extension = strtolower(end($file_extension));   // we then lowercase the last token and store it in fileExtension
        // additional parameters
        $image_path = './assets/products/' . "id_" . $products_id . "." . $file_extension;
        $allowed = array('jpg', 'jpeg', 'png');             // allowed extensions
        

        if (!in_array($file_extension, $allowed)) {
            $displayText = " Incorrect file type!";
            exit;
        } else if ($file_error !== 0) {
            $displayText = " Error uploading file to website!";
            exit;
        } else if ($file_size > (50 * 1000 * 1000)) { //bigger than 50 mb = 50000 kb = 50000000 b
            $displayText = " File size too large!";
            exit;
        } else {
            if (move_uploaded_file($file_tmp_name, $image_path)) {     // if file is successfully saved
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    $displayText = " Connection failed: " . $conn->connect_error;
                } else {
                    // Prepare statement 3: Updating image_path of new product
                    $stmt = $conn->prepare("UPDATE products SET image_path = ? WHERE products_id = ?");
                    // Bind & execute the query statement:
                    $stmt->bind_param("ss", $image_path, $products_id);
                    if (!$stmt->execute()) {
                        $displayText = " Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    } else {
                        $displayText = "Image saved to website!";
                    }
                    $stmt->close();
                }
                $conn->close();
            } else {                                                       // if file could not be moved to 'products'
                $displayText = " Image could not be saved to website!";
            }
        }
        
        $_SESSION["passed_stdout"] = $displayText;
    }
}
?>