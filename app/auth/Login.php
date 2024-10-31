<?php

// received user input
$username = $_POST["username"];
$password = $_POST["password"];

session_start();

include('../config/DatabaseConnect.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        //db connection
        $db = new DatabaseConnect();
        $conn = $db->connectDB();

            // connect database

    // insert record
    // validate confirmpassword

            try {

                $stmt = $conn->prepare('SELECT * FROM `users` WHERE username = :p_username');
                $stmt->bindParam(':p_username', $username);
                $stmt->execute();
                $users = $stmt->fetchAll();
                if($users){
                    if(password_verify($password,$users[0]["password"])){
                        $_SESSION = []; 
                        session_regenerate_id(true);
                        $_SESSION['user_id']  = $users[0]['id']; 
                        $_SESSION['username'] = $users[0]['username']; 
                        $_SESSION['fullname'] = $users[0]['fullname']; 
                        $_SESSION['is_admin'] = $users[0]['is_admin']; 

                        header("location: /index.php");
                        exit;

                    } else { 
                        header("location: /login.php");
                        $_SESSION["error"] = "Password not match";
                        exit;
                    }
                } else {
                    header("location: /login.php");
                    $_SESSION["error"] = "User not found";
                    exit;
                }

                 //    $password = password_hash(trim($password), PASSWORD_BCRYPT);


            } catch (Exception $e){
            echo "Connection Failed: " . $e->getMessage();
            }
            
}

?>