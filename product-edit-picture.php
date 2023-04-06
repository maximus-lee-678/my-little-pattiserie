<?php
if (($_SERVER['REQUEST_METHOD'] != 'POST')) {
    header("refresh: 0; url=view-all-products.php");
    exit;
}
$there_were_two = explode("_", $_POST['product-id']);
?>

<body>
    <main class="container">
        <div style="float:right;">
            <a class="bi bi-x-square" style="font-size:36px;" id="close-view"></a>
        </div><br>
        <form action="product-edit-process.php" id="product-edit-picture" onsubmit="return confirm('Are you sure?');" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="upload-image" id="upload-image">Upload Image for <?php echo $there_were_two[1]; ?>:</label><br>
                <input type="file" name="upload-image" required id="upload-image" accept=".jpg,.jpeg,.png">
            </div>
            <div class="form-group">
                <button class="btn btn-success" id="submit-button" type="submit" name="image-submit" value="<?php echo $there_were_two[0]; ?>">Submit</button>
            </div>
        </form>
    </main>
</body>