
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>My Little Patisserie</title>


        <!--jQuery-->
        <script
            defer
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"
        ></script>

        <!--Bootstrap JS-->
        <script
            defer
            src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"
            integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
            crossorigin="anonymous"
        ></script>

        <link
            rel="stylesheet"
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
            crossorigin="anonymous"
            />

        <!-- CSS -->
        <link rel="stylesheet" href="./assets/css/main.css" />
        <link rel="stylesheet" href="./assets/css/max.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;500&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap">

        <!-- JS -->
        <script defer src="./assets/js/products.js"></script>

    </head>

    <body>
        <!-- Navbar -->
        <?php include "./includes/nav-inc-manager.php" ?>

        <main class="container">
            <h1>Product Creation</h1>
            <form action="create-new-product-process.php" onsubmit="return confirm('Are you sure?');" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="item-name">Item Name:</label>
                    <input class="form-control" id="item-name"  maxlength="60" 
                           required name="item-name" placeholder="Enter Item Name">
                </div>
                <div class="form-group">
                    <label for="price">Price: ($)</label>
                    <input class="form-control" id="price" type="number" onkeydown="javascript: return event.keyCode !== 69 && event.keyCode !== 189" step=".01" min="0" 
                           required name="price" placeholder="Enter Item Price">
                </div>
                <div class="form-group">
                    <label for="summary">Summary:</label>
                    <textarea class="form-control" id="summary" rows="4"  maxlength="225" 
                              name="summary" placeholder="Enter Summary"></textarea>
                </div>
                <span style="display:flex; flex-wrap:wrap;">
                    <div class="form-group" style="flex:1;">
                        <label for="category">Category:</label><br>
                        <select class="form-control" name="category" id="category" required>
                            <option selected readonly value="">Select a category:</option>
                            <option value="Sweets">Sweets</option>
                            <option value="Beverages">Beverages</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex:1;">
                        <label for="subcategory">Subcategory:</label>
                        <select class="form-control" name="subcategory" id="subcategory" required>
                            <option selected readonly value="">Select a subcategory:</option>
                        </select>
                    </div>
                </span>
                <div class="form-group">
                    <label for="upload-image">Upload Image:</label><br>
                    <input type="file" name="upload-image" accept=".jpg,.jpeg,.png">
                </div>
                <div class="form-group">
                    <button class="btn btn-secondary" type="submit" name ="submit" href="create-new-product-process.php">Submit</button>
                </div>
            </form>
        </main>

        <?php include "./includes/footer-inc-admin.php" ?>

    </body>
</html>
