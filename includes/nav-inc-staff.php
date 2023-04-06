<?php
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-light navbar-bg-custom">
    <div class="container-sm">
        <a href="#" class="navbar-brand"><img src="./assets/img/logo4.png" class="company-logo img-fluid" alt="Company Logo"></a>

        <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarList">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id='navbarList'>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="./order-overview.php" class="nav-link pt-3 mr-2">Orders Overview</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="bi bi-person-circle"></i></a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="./admin-profile-edit.php">Profile</a>
                        <a class="dropdown-item" href="./admin-logout-process.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>