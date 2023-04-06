<?php
session_start();

if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=create-new-product.php");
    exit;
}

header("refresh: 0; url=view-all-products.php");
?>


<?php

//Functions
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
    //form parameters
    $item_name = sanitize_input($_POST['item-name']);
    $price = sanitize_input($_POST['price']);
    $quantity = 100000;
    $summary = sanitize_input($_POST['summary']);
    $image_path = "none";
    $image_alt_text = sanitize_input($_POST['item-name']);
    $category = sanitize_input($_POST['category']);
    $subcategory = sanitize_input($_POST['subcategory']);
    $active = 'YES';
    $products_id = "";

    $captionText = "";
    $success = true;
    $image_save_error = "";

    // Create database connection.
    $config = parse_ini_file('../../private/db-config.ini');
    $conn = new mysqli($config['servername'], $config['username'], $config['password'], $config['dbname']);
    // Check connection
    if ($conn->connect_error) {
        $captionText .= "Connection failed: " . $conn->connect_error;
    } else {
        // Prepare statement 1: Inserting info into database with temp image_path
        $stmt = $conn->prepare("INSERT INTO products (item_name, price, quantity, summary, image_path, image_alt_text, last_updated, category, sub_category, active )  VALUES ( ?,?,?,?,?,?, date_format(curdate(), '%d %M %Y'),?,?,?)");
        //Bind & execute the query statement: 
        $stmt->bind_param("sssssssss", $item_name, $price, $quantity, $summary, $image_path, $image_alt_text, $category, $subcategory, $active);
        if (!$stmt->execute()) {
            $captionText .= "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        } else {
            $captionText .= $item_name . " added to database! ";
        }

        // Prepare statement 2: Retrieving last row's id from database
        $stmt = $conn->prepare("SELECT products_id FROM products ORDER BY products_id DESC LIMIT 1");
        // execute the query statement:
        if (!$stmt->execute()) {
            $captionText .= "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
        }

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $products_id = $row["products_id"];
        } else {
            $captionText .= "Something went wrong when finding id of new product! ";
        }
        $stmt->close();
    }
    $conn->close();

    if (file_exists($_FILES['upload-image']['tmp_name']) || is_uploaded_file($_FILES['upload-image']['tmp_name'])) {
        $file_name = $_FILES['upload-image']['name'];            // stores filename
        $file_tmp_name = $_FILES['upload-image']['tmp_name'];     // stores the temporary filename
        $file_size = $_FILES['upload-image']['size'];            // stores filesize
        $file_error = $_FILES['upload-image']['error'];          // stores error codes, if any
        $file_extension = explode('.', $file_name);           // explode() first seperates file names to tokens separated by '.'s 
        $file_extension = strtolower(end($file_extension));   // we then lowercase the last token and store it in fileExtension
        $image_path = './assets/products/' . "id_" . $products_id . "." . $file_extension;

        $allowed = array('jpg', 'jpeg', 'png');             // allowed extensions

        if (!in_array($file_extension, $allowed)) {
            $captionText .= "Incorrect file type! ";
        } else if ($file_error !== 0) {
            $captionText .= "Error uploading file to website! ";
        } else if ($file_size > (50 * 1000 * 1000)) { //bigger than 50 mb = 50000 kb = 50000000 b
            $captionText .= "File size too large! ";
        } else {
            $image_path = "./assets/products/id_" . $products_id . "." . $file_extension;    // name file is to be saved as

            if (move_uploaded_file($file_tmp_name, $image_path)) {     // if file is successfully saved
                $config = parse_ini_file('../../private/db-config.ini');
                $conn = new mysqli($config['servername'], $config['username'],
                        $config['password'], $config['dbname']);
                // Check connection
                if ($conn->connect_error) {
                    $captionText .= "Connection failed: " . $conn->connect_error;
                } else {
                    // Prepare statement 3: Updating image_path of new product
                    $stmt = $conn->prepare("UPDATE products SET image_path = ? WHERE products_id = ?");
                    // Bind & execute the query statement:
                    $stmt->bind_param("ss", $image_path, $products_id);
                    if (!$stmt->execute()) {
                        $captionText .= "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
                    } else {
                        $captionText .= "Image and Image Path saved to database! ";
                    }
                    $stmt->close();
                }
                $conn->close();
            } else {                                                       // if file could not be moved to 'products'
                $captionText .= "Image could not be saved to database! ";
            }
        }
    }
    else{
        $captionText .= "Image not uploaded, remember to do so in the future! ";
    }
    
    $_SESSION["passed_stdout"] = $captionText;
    
} else {
    $_SESSION["passed_stdout"] = "Did not arrive via POST! ";
}
?>
