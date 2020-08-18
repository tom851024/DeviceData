<?php

class Device
{
    function fetch_load_average()
    {
        $ret = array();
        $res = array();
        $ret = file("/proc/loadavg");
        $tmp = explode(" ", $ret[0]);
        $res[0] = trim($tmp[0]); //1分鐘平均負載
        $res[1] = trim($tmp[1]); //5分鐘平均負載
        $res[2] = trim($tmp[2]); //15分鐘平均負載
        return $res;
    }

    function fetch_task_cpu()
    {
        $ret = array();
        $res = array();
        exec("top -n 1 -b", $ret);
        
        if(!empty($ret[1])) {
            $tmp = preg_split("/[\s]+/", $ret[1], -1, PREG_SPLIT_NO_EMPTY);
            $res[0] = $tmp[1]; //task數量
            $res[1] = $tmp[3]; //runnint task
        }
        
        if(!empty($ret[2])) {
            $tmp2 = preg_split("/[\s]/", $ret[2], -1, PREG_SPLIT_NO_EMPTY);
            $idcpu = substr($tmp2[4], 0, -3); //cpu閒置
            $uscpu = 100 - floatval($idcpu); //cpu使用率
            $res[2] = $uscpu . "%";
        }
        return $res;
    }

    function fetch_cpu_load()
    {
        $ret = array();
        $res = array();
        exec("ps aux --sort -pcpu", $ret, $code);

        if($code == 0) {
            for($i = 0; $i < 3; $i++) {
                $process = "";
                $tmp = preg_split("/[\s]/", $ret[$i+1], -1, PREG_SPLIT_NO_EMPTY);
                $res["pid"][$i] = $tmp[1]; //pid
                $res["cpu"][$i] = $tmp[2]; //程序cpu使用量
                for($j = 10; $j < count($tmp); $j++) {
                    $process .= $tmp[$j] . " ";
                }
                $res["pro"][$i] = $process; //程序執行指令
            }
        }
       
        return $res;
    }

   
}