
<div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card h-100 product-card">
                    <a href="<?php echo BASE_URL; ?>views/product/product.php?id=<?php  echo $product["id"]; ?>" class="text-decoration-none"> 
                    <img src="<?php echo BASE_URL. $product["image_url"]; ?>" class="card-img-top mx-auto" alt="Product Image" style="height:250px;width:250px;object-fit:cover;"></a>
                    <div class="card-body text-center d-flex flex-column">
                        <h6 class="card-title"><?php echo $product["product_name"] ?></h6>
                        <p class="card-text text-primary fw-bold">PHP <?php echo number_format($product["unit_price"],2)?></p>
                        <div class="mt-auto">
                            <form action="<?php echo BASE_URL;?>app/cart/add_to_cart.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $product["id"]; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button class="btn btn-success btn-sm w-100 add-to-cart-btn" <?php echo ($product["stocks"] <= 0 ? "disabled" : ""); ?>>
                                <?php echo ($product["stocks"] <= 0 ? "Out of Stock" : "Add to Cart");?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
