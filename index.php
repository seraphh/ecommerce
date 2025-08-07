    <!-- Header -->
    <?php 
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();
    require_once(__DIR__."/app/config/Directories.php");
    include(ROOT_DIR."app/product/get_products.php");
    include(ROOT_DIR."app/product/get_products_by_category.php");
    require_once(ROOT_DIR."includes/header.php");
    ?>

    <!-- Navbar -->
    <?php require_once("includes/navbar.php") ?>


    <!-- Hero Section -->
    <div class="container-fluid bg-primary text-white text-center py-5">
        <h1 class="display-4">Welcome to Z-Commerce!</h1>
        <p class="lead">Your one-stop destination for amazing deals</p>
        <a href="#products" class="btn btn-light btn-lg">Shop Now</a>
    </div>


    <!-- Product Categories Slider -->
    <div class="container content my-5">
        <h2 class="text-center mb-4">Shop by Category</h2>
        
        <!-- Category Navigation -->
        <div class="category-nav text-center mb-4">
            <button class="category-btn active" data-category="2">CPU</button>
            <button class="category-btn" data-category="1">Cases</button>
            <button class="category-btn" data-category="7">SSD</button>
        </div>

        <!-- Category Slider Container -->
        <div class="category-slider-container position-relative">
            <?php foreach($categories as $categoryId => $categoryData): ?>
            <div class="category-slide" data-category="<?php echo $categoryId; ?>" style="<?php echo $categoryId == 2 ? '' : 'display:none;'; ?>">
                <div class="slider-wrapper position-relative">
                    <div class="products-slider" id="slider-<?php echo $categoryId; ?>">
                        <div class="row flex-nowrap" style="transition: transform 0.3s ease;">
                            <?php if(empty($categoryData['products'])): ?>
                                <div class="col-12 text-center">
                                    <p>No products available in this category yet.</p>
                                </div>
                            <?php else: ?>
                                <?php foreach($categoryData['products'] as $product): ?>
                                    <div class="col-lg-3 col-md-4 col-sm-6 flex-shrink-0 px-2">
                                        <div class="card h-100 product-card">
                                            <a href="<?php echo BASE_URL; ?>views/product/product.php?id=<?php echo $product["id"]; ?>" class="text-decoration-none"> 
                                            <img src="<?php echo BASE_URL. $product["image_url"]; ?>" class="card-img-top mx-auto" alt="Product Image" style="height:200px;width:200px;object-fit:cover;border-radius:8px;margin-top:10px;"></a>
                                            <div class="card-body text-center d-flex flex-column">
                                                <h6 class="card-title text-dark"><?php echo $product["product_name"] ?></h6>
                                                <p class="card-text text-primary fw-bold mb-2">PHP <?php echo number_format($product["unit_price"],2)?></p>
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
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Navigation arrows for when we have enough products -->
                    <?php if(count($categoryData['products']) > 4): ?>
                    <button class="slider-nav slider-prev" data-slider="slider-<?php echo $categoryId; ?>">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="slider-nav slider-next" data-slider="slider-<?php echo $categoryId; ?>">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <style>
        /* Category Navigation Styles */
        .category-nav {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .category-btn {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 2px solid #dee2e6;
            color: #495057;
            padding: 12px 20px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            min-width: 100px;
        }

        .category-btn:hover {
            background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
            border-color: #adb5bd;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .category-btn.active {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.4);
        }

        /* Slider Styles */
        .category-slider-container {
            overflow: hidden;
            position: relative;
            padding: 0 20px;
        }

        .slider-wrapper {
            position: relative;
        }

        .products-slider {
            overflow: visible;
        }

        .products-slider .row {
            margin: 0 -8px;
        }

        .slider-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.9), rgba(11, 94, 215, 0.9));
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
        }

        .slider-nav:hover {
            background: linear-gradient(135deg, rgba(11, 94, 215, 1), rgba(8, 76, 175, 1));
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
        }

        .slider-prev {
            left: -15px;
        }

        .slider-next {
            right: -15px;
        }

        .category-slide {
            transition: all 0.4s ease;
        }

        /* Enhanced Card Styles */
        .product-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .product-card .card-body {
            padding: 1.25rem;
        }

        .product-card .card-title {
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            line-height: 1.3;
            height: 2.6rem;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .add-to-cart-btn {
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(25, 135, 84, 0.3);
        }

        /* Hero Section Enhancement */
        .bg-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 50%, #084298 100%) !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .category-nav {
                gap: 6px;
                margin-bottom: 20px;
            }
            
            .category-btn {
                padding: 10px 16px;
                font-size: 0.8rem;
                min-width: 80px;
            }
            
            .slider-prev, .slider-next {
                display: none;
            }

            .category-slider-container {
                padding: 0 10px;
            }

            .products-slider .row {
                flex-wrap: nowrap;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                padding-bottom: 10px;
            }

            .products-slider .row::-webkit-scrollbar {
                height: 4px;
            }

            .products-slider .row::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            .products-slider .row::-webkit-scrollbar-thumb {
                background: #0d6efd;
                border-radius: 4px;
            }

            .product-card {
                min-width: 250px;
                scroll-snap-align: start;
            }

            .container {
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        @media (max-width: 576px) {
            .category-btn {
                padding: 8px 12px;
                font-size: 0.75rem;
                min-width: 70px;
            }

            .product-card {
                min-width: 220px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }

        /* Loading Animation */
        .category-slide[style*="display: none"] {
            opacity: 0;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Section Divider */
        .section-divider {
            border: none;
            height: 2px;
            background: linear-gradient(90deg, transparent, #dee2e6, transparent);
            margin: 2rem auto;
            width: 60%;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category switching functionality with enhanced UX
            const categoryBtns = document.querySelectorAll('.category-btn');
            const categorySlides = document.querySelectorAll('.category-slide');
            let isTransitioning = false;

            categoryBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    if (isTransitioning) return; // Prevent rapid clicking
                    
                    const targetCategory = this.dataset.category;
                    const currentActiveSlide = document.querySelector('.category-slide[style*="display: block"], .category-slide[style=""]');
                    
                    // Don't switch if already active
                    if (this.classList.contains('active')) return;
                    
                    isTransitioning = true;
                    
                    // Update active button with animation
                    categoryBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show target slide immediately for better responsiveness
                    showTargetSlide(targetCategory);
                });
            });

            function showTargetSlide(targetCategory) {
                // Hide all slides first
                categorySlides.forEach(slide => {
                    slide.style.display = 'none';
                    slide.style.opacity = '0';
                });
                
                // Show target slide
                const targetSlide = document.querySelector(`.category-slide[data-category="${targetCategory}"]`);
                if (targetSlide) {
                    targetSlide.style.display = 'block';
                    
                    // Immediate display for better UX
                    setTimeout(() => {
                        targetSlide.style.opacity = '1';
                        isTransitioning = false;
                    }, 10);
                } else {
                    isTransitioning = false;
                }
            }

            // Initialize first category on page load
            setTimeout(() => {
                const firstActiveBtn = document.querySelector('.category-btn.active');
                if (firstActiveBtn) {
                    const firstCategory = firstActiveBtn.dataset.category;
                    showTargetSlide(firstCategory);
                }
            }, 100);

            // Enhanced slider functionality
            const sliderNavs = document.querySelectorAll('.slider-nav');
            
            sliderNavs.forEach(nav => {
                nav.addEventListener('click', function() {
                    const sliderId = this.dataset.slider;
                    const slider = document.getElementById(sliderId);
                    const row = slider.querySelector('.row');
                    const isNext = this.classList.contains('slider-next');
                    
                    // Get current transform
                    const currentTransform = row.style.transform;
                    let translateX = 0;
                    
                    if(currentTransform && currentTransform.includes('translateX')) {
                        const match = currentTransform.match(/translateX\((-?\d+(?:\.\d+)?)%\)/);
                        if (match) {
                            translateX = parseFloat(match[1]);
                        }
                    }
                    
                    // Calculate slide amount based on screen size
                    const slideAmount = window.innerWidth <= 768 ? 50 : 25;
                    
                    if(isNext) {
                        translateX -= slideAmount;
                    } else {
                        translateX += slideAmount;
                    }
                    
                    // Limit sliding (adjust based on number of items)
                    const maxSlide = window.innerWidth <= 768 ? -100 : -75;
                    translateX = Math.max(Math.min(translateX, 0), maxSlide);
                    
                    row.style.transform = `translateX(${translateX}%)`;
                });
            });

            // Add cart button feedback (without preventing submission)
            const addToCartBtns = document.querySelectorAll('.add-to-cart-btn');
            addToCartBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    if (!this.disabled) {
                        // Just add a visual feedback without preventing submission
                        this.style.transform = 'scale(0.98)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                    }
                });
            });

            // Smooth scroll for "Shop Now" button
            const shopNowBtn = document.querySelector('a[href="#products"]');
            if (shopNowBtn) {
                shopNowBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('products').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            }

            // Add loading animation for images
            const productImages = document.querySelectorAll('.product-card img');
            productImages.forEach(img => {
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
                
                if (img.complete) {
                    img.style.opacity = '1';
                } else {
                    img.style.opacity = '0.3';
                }
            });

            // Simplified touch/swipe support for mobile (only within category slider)
            let touchStartX = 0;
            let touchEndX = 0;
            let swiping = false;
            
            const categoryContainer = document.querySelector('.category-slider-container');
            if (categoryContainer) {
                categoryContainer.addEventListener('touchstart', e => {
                    touchStartX = e.changedTouches[0].screenX;
                    swiping = true;
                });
                
                categoryContainer.addEventListener('touchend', e => {
                    if (!swiping) return;
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                    swiping = false;
                });
            }
            
            function handleSwipe() {
                const swipeThreshold = 80;
                const diff = touchStartX - touchEndX;
                
                if (Math.abs(diff) > swipeThreshold) {
                    const activeBtn = document.querySelector('.category-btn.active');
                    if (activeBtn) {
                        const currentCategory = activeBtn.dataset.category;
                        const categories = ['2', '1', '7']; // CPU, Cases, SSD
                        const currentIndex = categories.indexOf(currentCategory);
                        
                        let nextIndex;
                        if (diff > 0 && currentIndex < categories.length - 1) {
                            // Swipe left - next category
                            nextIndex = currentIndex + 1;
                        } else if (diff < 0 && currentIndex > 0) {
                            // Swipe right - previous category
                            nextIndex = currentIndex - 1;
                        }
                        
                        if (nextIndex !== undefined) {
                            const targetBtn = document.querySelector(`.category-btn[data-category="${categories[nextIndex]}"]`);
                            if (targetBtn && !isTransitioning) {
                                targetBtn.click();
                            }
                        }
                    }
                }
            }
        });
    </script>

    <!-- Section Separator -->
    <div class="container my-5">
        <hr class="section-divider">
    </div>

    <!-- Featured Products Section -->
    <div class="container content my-5" id="products">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="row g-4 justify-content-center">
            <?php
            foreach($productList as $product){
                include(ROOT_DIR.'views/components/product-cart.php');
            }
            ?>
        </div>
    </div>

    <!-- Footer -->
    <?php require_once(ROOT_DIR."includes/footer.php") ?>