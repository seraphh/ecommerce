    <!-- Header -->
    <?php 
    session_start();
    require_once("includes/header.php");
        //check if session["error"] exists
        if(isset($_SESSION["error"])){ 
            $messErr = $_SESSION["error"]; //assign value of _SESSION["error"] to messErr
            unset($_SESSION["error"]);
            
        }
    ?>

    <!-- Navbar -->
    <?php require_once("includes/navbar.php") ?>


    <!-- Login Form -->
    <div class="container content my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Login to Your Account</h4>
                    </div>
                    <div class="card-body">

                        <?php if (isset($_SESSION["success"])){ ?> 
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong><?php echo $_SESSION["success"]; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php   } ?>
                        
                        <?php if (isset($messErr)){ ?> 
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?php echo $messErr; ?></strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php   } ?>

                        <form action="app\auth\Login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Don't have an account? <a href="registration.php" class="text-primary">Register here</a></p>
                        <a href="#" class="text-danger">Forgot password?</a>
                    </div>
                </div>
            </div> 
        </div>
    </div>

    <?php require_once("includes/footer.php") ?>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>