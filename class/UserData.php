<?php
//存讀裝置資訊檔案
class UserData
{
    var $filename;
    
    function UserData($id)
    {
        $this->filename = "/HDD/STATUSLOG/" . $id . "_log";
    }

    function read_data()
    {
        $ret = array();
        if(is_file($this->filename)) {
            $data = file($this->filename);
            foreach($data as $key => $val) {
                $ret[$key] = explode(",,", $val);
            }
        }
        return $ret;
    }

    function write_data($loadAve, $task, $cpuLoad)
    {
        if(is_file($this->filename)) {
            exec("wc -l $this->filename", $ret, $code);
            if($code == 0) {
                $line = preg_split("/[\s]/", $ret[0], -1, PREG_SPLIT_NO_EMPTY);
                if($line[0] > 3499) {
                    $insert = date("Y-m-d H:i") . ",," . implode(",,", $loadAve) . ",," . implode(",,", $task) . ",," . implode(",,", $cpuLoad["pid"]) . ",," . implode(",,", $cpuLoad["pro"]) . ",," . implode(",,", $cpuLoad["cpu"]) . "\n";
                    $data = file($this->filename);
                    $tmpFname = $this->filename . "_tmp";
                    $fp = fopen($this->filename, "w+");
                    $data[count($data)] = $insert;
                    unset($data[0]);
                    array_values($data);
                    foreach($data as $val) {
                        fwrite($fp, $val);
                    }
                    fclose($fp);
                    exec("/bin/mv " . $tmpFname . " " . $this->filename);
                } else {
                    $insert = date("Y-m-d H:i") . ",," . implode(",,", $loadAve) . ",," . implode(",,", $task) . ",," . implode(",,", $cpuLoad["pid"]) . ",," . implode(",,", $cpuLoad["pro"]) . ",," . implode(",,", $cpuLoad["cpu"]);
                    exec("/bin/echo \"" . $insert ."\" >> " . $this->filename);
                }       
            } else {
                echo 'error';
            }
        } else {
            $insert = date("Y-m-d H:i") . ",," . implode(",,", $loadAve) . ",," . implode(",,", $task) . ",," . implode(",,", $cpuLoad["pid"]) . ",," . implode(",,", $cpuLoad["pro"]) . ",," . implode(",,", $cpuLoad["cpu"]);
            exec("/bin/echo \"" . $insert ."\" >> " . $this->filename);
        }
    
    }

}