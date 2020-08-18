<?php
class Database
{
     var $conn;

     function Database()
     {
        $this->conn = mysql_connect(":/tmp/mysql.sock", "root", "l7fwmysql");
        if(!$this->conn) {
            die("connect error!: ". mysql_error());
        }
        mysql_query("set names utf8");
     }

     function select_user($uname)
     {
         mysql_select_db("User", $this->conn);
         $sql = "select * from User where Username='" . $uname . "'";
         $res = mysql_query($sql);
         $row = mysql_fetch_assoc($res);
         return $row;
     }

     function insert_user($uname, $passwd)
     {
        mysql_select_db("User", $this->conn);
        $ps = md5($passwd);
        $sql = "Insert into User (Username, Password) values ('$uname', '$ps')";
        mysql_query($sql);
     }

     function close_db()
     {
         mysql_close($this->conn);
     }
}