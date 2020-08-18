<?php

session_start();
include_once("xhtml/login.html");


if(isset($_POST["username"]) && isset($_POST["passwd"])) {
    
    include_once("class/Database.php");
    $db = new Database();
    $row = $db->select_user($_POST["username"]);
    $db->close_db();

    if(!empty($row["Password"]) && strcmp($row["Password"], md5($_POST["passwd"])) == 0) {
        $_SESSION["id"] = $row["id"];
        $_SESSION["uname"] = $row["Username"];
        header('Location: index.php');
    } else {
        echo '<script> 
                alert("帳號密碼錯誤");
                location.href = "login.php";
            </script>';
    }
    
   
}

