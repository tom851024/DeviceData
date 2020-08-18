<?php
include_once("xhtml/register.html");

if(isset($_POST["username"]) && isset($_POST["passwd"])) {
    if(preg_match("/^[!%&*@_\-\"\$\'a-zA-Z0-9]+$/", $_POST["username"])) {
        if(preg_match("/^[!%&*@_\-\"\$\'a-zA-Z0-9]+$/", $_POST["passwd"])) {
            if(strcmp($_POST["passwd"], $_POST["repasswd"]) == 0) {
                include_once("class/Database.php");
                include_once("class/Timelog.php");


                $db = new Database();
                $row = $db->select_user($_POST["username"]);
                if(empty($row["id"])) {
                    $db->insert_user($_POST["username"], $_POST["passwd"]);
                    $row2 = $db->select_user($_POST["username"]);
                    $db->close_db();
                    $userId = $row2["id"];

                    $input = $userId . ",1"; //插入預設時間1分鐘
                    $file = new Timelog();
                    $file->write_timelog($input);
                    echo '<script> 
                        alert("新增成功");
                        location.href = "login.php";
                    </script>';
                } else {
                    echo '<script>
                            alert("已有相同帳號，請輸入其他帳號");
                            location.href = "register.php";
                        </script>';
                } 
            } else {
                echo '<script>
                        alert("確認密碼和密碼不一致");
                        location.href = "register.php";
                    </script>';
            }
        } else {
            echo '<script>
                    alert("密碼格式錯誤");
                    location.href = "register.php";
                </script>';
        }
    } else {
        echo '<script>
                alert("帳號格式錯誤");
                location.href = "register.php";
            </script>';
    }
}


