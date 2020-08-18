<?php
//存讀使用者設定時間檔案
class Timelog
{

   var $filename;

   function Timelog()
   {
       $this->filename = "/HDD/STATUSLOG/Timelog";
   }

   function read_timelog()
   {
       $ret = array();
       if(is_file($this->filename)) {
           $data = file($this->filename);
           foreach($data as $key => $val) {
               $ret[$key] = explode(",", $val);
           }
       }

       return $ret;
   }


    function find_timelog($sid)
    {
        if(is_file($this->filename)) {   
            $ret = file($this->filename);
            foreach($ret as $val) {
                $tmp = explode(",", $val);
                    if($tmp[0] == $sid) {
                        return $tmp[1];
                        break;
                    }
                
            }
        }
        return 0;
    }
    
    function write_timelog($str, $findSessionId=null)
    {
        if(is_file($this->filename)) {
            $data = file($this->filename);
            if($findSessionId != null) {
                $found = false;
                foreach($data as $key => $val) {
                    $tmp = explode(",", $val);
                    if($tmp[0] == $findSessionId) {
                        $data[$key] = $str . "\n";
                        $found = true;
                        break;
                    }
                }

                if(!$found) {
                    $data[$key+1] = $str . "\n";
                }
                $tmpFile = $this->filename . "_tmp";
                $fp = fopen($tmpFile, "w+");
                foreach($data as $line) {
                    fwrite($fp, $line);
                }
                fclose($fp);
                exec("/bin/mv " . $tmpFile . " " . $this->filename);
                return;  
            }           
        }
        exec("/bin/echo \"" . $str ."\" >> " . $this->filename);
    }
}