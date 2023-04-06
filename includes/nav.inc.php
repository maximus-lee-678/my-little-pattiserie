

<nav class="navbar sticky-top navbar-expand-lg navbar-light navbar-bg-custom">
    <div class="container-sm">
        <a href="./index.php" class="navbar-brand"><img src="./assets/img/logo4.png" class="company-logo img-fluid" alt="Company Logo"></a>


        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarList">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id='navbarList'>
            <ul class="navbar-nav ml-auto">

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pt-3" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Menu
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="./sweetPage.php">Sweets</a>
                        <a class="dropdown-item" href="./beveragePage.php">Beverages</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a href="./aboutPage.php" class="nav-link pt-3 mr-2">About</a>
                </li>


                <li class="nav-item">
                    <a href="./contact-us.php" class="nav-link pt-3 mr-2">Contact Us</a>
                </li>



                <?php
                if (isset($_SESSION["member_id"])) {
                    echo '<li class="nav-item">';
                    echo '<a href="./shoppingCart.php" class="nav-link mr-2"><i class="bi bi-bag"></i></a>';
                    echo '</li>';
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-person-circle"></i></a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                    echo '<a class="dropdown-item" href="./profile.php">Profile</a>';
                    echo '<a class="dropdown-item" href="./includes/logout.inc.php">Logout</a>';
                    echo '</div>';
                    echo '</li>';
                } else {
                    echo '<li class="nav-item dropdown">';
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-person-circle"></i></a>';
                    echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
                    echo '<a class="dropdown-item" href="./login.php">Login</a>';
                    echo '<a class="dropdown-item" href="./register.php">Register</a>';
                    echo '</div>';
                    echo '</li>';
                }
                ?>

            </ul>
        </div>
    </div>
</nav>