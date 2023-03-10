<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">E-commerce</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo setActive('Home') ?>" aria-current="page" href="dashboard.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo setActive('Categories') ?>" aria-current="page" href="#">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo setActive('Items') ?>" aria-current="page" href="#">Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo setActive('Members') ?>" aria-current="page" href="members.php">Members</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo setActive('Statistic') ?>" aria-current="page" href="#">Statistic</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo setActive('Logs') ?>" aria-current="page" href="#">Logs</a>
                </li>
            </ul>
            <ul class="navbar-nav ">
                <li class="nav-item dropdown d-flex">
                    <?php
                    $id = $_SESSION['user_id'];
                    $us = $connection->query("SELECT * FROM users WHERE UserID=$id");
                    $us = $us->fetch(PDO::FETCH_ASSOC);
                    $srcImg = $us['ImgeUser'];
                    ?>
                    <img src="includes/uploads/<?php echo $srcImg ?>" alt="" class="img-nav">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $_SESSION['user_name'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-left" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item <?php echo setActive('EditeProfile') ?>" href=" EditProfile.php">Edit
                                Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>