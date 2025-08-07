<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>index.php">Z-Commerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>index.php">Home</a>
                    </li>

                    <?php if(!isset($_SESSION["username"])) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>registration.php">Register</a>
                    </li>
                    <?php }?>
                    
                    <!-- display products link if admin -->
                    <?php if(isset($_SESSION["username"]) && (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == "1")) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>views/admin/products/index.php">Products</a>
                    </li>
                    <?php } ?>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>cart.php">Cart</a>
                    </li>


                    <!-- Dropdown for Signed-in User -->
                    <!-- if naka set yung $_SESSION["fullname"], dun lang lalabas yung name ng user-->
                    <?php if(isset($_SESSION["fullname"])){ ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $_SESSION["fullname"]; ?> <!-- Replace with dynamic username -->
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="/logout.php" method="POST">
                                <button class="dropdown-item" href="logout.php">Logout</>
                                </form>
                            <?php } ?>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
