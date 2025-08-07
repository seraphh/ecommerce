<?php
session_start();
    // received user input
    $fullname = $_POST["fullName"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"];


    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        // verify password and confirmPassword to be match
        if(trim($password) == trim($confirmPassword)){

            
            // connect database
            $host = "sql207.infinityfree.com";  // InfinityFree database host
            $database = "if0_39652843_ecommerce";  // "ecommerce"
            $dbusername = "if0_39652843";          // "root"
            $dbpassword = "thzquyTCexJhp7A";     // ""
    // insert record
    // validate confirmpassword

            $dsn = "mysql:host=$host;dbname=$database;";
            try {
                $conn = new PDO($dsn, $dbusername, $dbpassword);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $stmt = $conn->prepare("INSERT INTO users (fullname,username,password,created_at,updated_at) VALUES (:p_fullname,:p_username,:p_password,NOW(),NOW())");
                $stmt->bindParam(':p_fullname', $fullname);
                $stmt->bindParam(':p_username', $username);
                $stmt->bindParam(':p_password', $password);

                $password = password_hash(trim($password), PASSWORD_BCRYPT);

                if($stmt->execute()){
                    header("location: /registration.php");
                    $_SESSION["success"] = "Registration successful";
                    exit;

                } else { 
                    header("location: /registration.php");
                    $_SESSION["error"] = "Insert Error";
                    exit;
                }

            } catch (Exception $e){
            echo "Connection Failed: " . $e->getMessage();
            }
            
    } else {
        header("location: /registration.php");
        $_SESSION["error"] = "Password Mismatch";
        exit;
    }
}
?>