<?php
    // Reuse existing database connection from get_products.php
    // Only include DatabaseConnect if not already loaded
    if (!class_exists('DatabaseConnect')) {
        include(ROOT_DIR."app/config/DatabaseConnect.php");
        $db = new DatabaseConnect();
        $conn = $db->connectDB();
    }

    // Function to get products by category
    function getProductsByCategory($categoryId, $limit = 4) {
        // Create new database connection for this function
        $db = new DatabaseConnect();
        $conn = $db->connectDB();
        $productList = [];
        
        try {
            $sql = "SELECT * FROM `products` WHERE `category_id` = ? LIMIT ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $categoryId, PDO::PARAM_INT);
            $stmt->bindParam(2, $limit, PDO::PARAM_INT);
            $stmt->execute();
            $productList = $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();
        }
        
        return $productList;
    }

    // Get products for each category
    $cpuProducts = getProductsByCategory(2, 4);        // CPU category
    $caseProducts = getProductsByCategory(1, 4);       // Case category  
    $storageProducts = getProductsByCategory(7, 4);    // Storage category (for SSD)

    // Get category names
    $categories = [
        1 => ['name' => 'Cases', 'products' => $caseProducts],
        2 => ['name' => 'CPU', 'products' => $cpuProducts], 
        7 => ['name' => 'SSD', 'products' => $storageProducts]
    ];
?> 