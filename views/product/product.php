<?php
    session_start();
    require_once($_SERVER["DOCUMENT_ROOT"]."/app/config/Directories.php");

    include(ROOT_DIR."app/config/DatabaseConnect.php");
    $db = new DatabaseConnect();
    $conn = $db->connectDB();

    //this variable will hold product data from db
    $product = [];
    $related_products = [];
    $id = @$_GET['id'];
    $category = ["1" => "Case", "2" => "CPU", "3" => "GPU", "4" => 
    "Motherboard", "5" => "PSU", "6" => "RAM", "7" => "Storage"];

    

    try {

        $sql  = "SELECT * FROM products WHERE products.id = $id "; //select statement here
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $product = $stmt->fetch();

        // Fetch related products from the same category (excluding current product)
        if (!empty($product)) {
            $related_sql = "SELECT * FROM products WHERE category_id = :category_id AND id != :current_id LIMIT 4";
            $related_stmt = $conn->prepare($related_sql);
            $related_stmt->bindParam(':category_id', $product['category_id']);
            $related_stmt->bindParam(':current_id', $id);
            $related_stmt->execute();
            $related_products = $related_stmt->fetchAll();
        }

    } catch (PDOException $e) {
        echo "Connection Failed: " . $e->getMessage();
        $db = null;
    }

    require_once(ROOT_DIR."includes/header.php");

    if(isset($_SESSION["error"])){ 
        $messErr = $_SESSION["error"]; 
        unset($_SESSION["error"]);   
    }
    
    if(isset($_SESSION["success"])){ 
        $messSucc = $_SESSION["success"]; 
        unset($_SESSION["success"]);
    }
?>
    <!-- Navbar -->
    <?php require_once(ROOT_DIR."includes/navbar.php"); ?>

<!-- Product Details -->
    <div class="container my-5 bg-bpod">
        <div class="container mt-5">
            
            <!-- message response -->
            <?php if (isset($messSucc)){ ?> 
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?php echo $messSucc; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <?php if (isset($messErr)){ ?> 
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?php echo $messErr; ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    <img src="<?php echo BASE_URL.$product["image_url"]; ?>" alt="Product Image" class="img-fluid border border-warning border-5" style="height:500px">
                </div>

                <!-- Product Information -->
                
                <div class="col-md-6">
                    <form action="<?php echo BASE_URL; ?>app/cart/add_to_cart.php" method="POST">
                        <input type="hidden" class=form-control id="id" name="id" value="<?php echo $product["id"]; ?>">
                        <h2><?php echo $product["product_name"] ?></h2>
                        <div class="mb-3"><span class="badge text-bg-info"><?php echo $category[$product["category_id"]];?></span></div>
                        <p class="lead text-warning fw-bold">PHP <?php echo number_format($product["unit_price"],2) ?></p>
                        <p class="product-description fw-bold"> <?php echo htmlspecialchars($product['product_description']); ?></p>

                        <!-- Quantity Selection -->
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" id="decrement-btn">-</button>
                                <input type="number" id="quantity" name="quantity" class="form-control text-center" value="1" min="1" max="10" style="max-width: 60px;">
                                <button class="btn btn-outline-secondary" type="button" id="increment-btn">+</button>
                                <span class="input-group-text">/ Remaining Stocks: <?php echo $product["stocks"] ?></span>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg"  <?php echo ($product["stocks"] <= 0 ? "disabled" : ""); ?>> 
                                <?php echo $product["stocks"] <= 0 ? "Out of Stock" : "Add to cart"; ?></button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>

        <!-- Related Products -->
        <div class="container my-5">
            <h3>Related Products - <?php echo $category[$product["category_id"]]; ?></h3>
            <?php if (!empty($related_products)): ?>
                <div class="row">
                    <?php foreach ($related_products as $related_product): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="<?php echo BASE_URL.$related_product["image_url"]; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($related_product["product_name"]); ?>" style="height: 200px; object-fit: cover;">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?php echo htmlspecialchars($related_product["product_name"]); ?></h5>
                                    <p class="card-text text-warning fw-bold">PHP <?php echo number_format($related_product["unit_price"], 2); ?></p>
                                    <div class="mt-auto">
                                        <a href="<?php echo BASE_URL; ?>views/product/product.php?id=<?php echo $related_product["id"]; ?>" class="btn btn-primary">View Product</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <p>No related products found in the <?php echo $category[$product["category_id"]]; ?> category.</p>
                </div>
            <?php endif; ?>
        </div>

    </div> 
    
<script>
    document.getElementById('decrement-btn').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) { // Ensures quantity doesn't go below 1
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById('increment-btn').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let currentValue = parseInt(quantityInput.value);
        quantityInput.value = currentValue + 1;
    });
</script>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
    <p>&copy; 2024 Z-Commerce. All rights reserved.</p>
    <nav>
        <a href="#" class="text-white">Privacy Policy</a> | 
        <a href="#" class="text-white">Terms & Conditions</a>
    </nav>
</footer>

   
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
