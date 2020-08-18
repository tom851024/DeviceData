<?php
session_start();
if(isset($_SESSION["id"])) {
    include_once("class/Timelog.php");
    include_once("class/UserData.php");
    
    $uData = new UserData($_SESSION["id"]);
    $data = $uData->read_data();
    usort($data, "date_sort_desc");
    
    
    if(isset($_GET["search"]) && !empty($data)) { //搜尋
        $data = search($data, $_GET["search"]);
    } elseif (isset($_GET["psearch"]) && !empty($data)) {
        $data = p_search($data, $_GET["psearch"]);
    }

    if(isset($_GET["order"]) && isset($_GET["sc"]) && preg_match("/^[0-9]+$/", $_GET["order"]) && preg_match("/^[0-9]+$/", $_GET["sc"]) && !empty($data)) {
        //排序
        $orderArr = array( //各排序代表參數
            "Date" => "0",
            "LoadAve" => "1",
            "Task" => "4",
            "RunningTask" => "5",
            "Cpu" => "6",
            "Pid1" => "7",
            "Pid2" => "8",
            "Pid3" => "9",
            "Process1" => "10",
            "Process2" => "11",
            "Process3" => "12",
            "DESC" => "0",
            "ASC" => "1"
        );

        if($_GET["order"] == $orderArr["Date"]) {
            if($_GET["sc"] ==  $orderArr["ASC"]) {
                usort($data, "date_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "date_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["LoadAve"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "loadAve_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "loadAve_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["Task"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "task_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "task_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["RunningTask"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "rtask_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "rtask_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["Cpu"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "cpu_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "cpu_sort_desc");
            }
        }


        if($_GET["order"] == $orderArr["Pid1"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "pid1_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "pid1_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["Pid2"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "pid2_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "pid2_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["Pid3"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "pid3_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "pid3_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["Process1"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "proc1_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "proc1_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["Process2"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "proc2_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "proc2_sort_desc");
            }
        }

        if($_GET["order"] == $orderArr["Process3"]) {
            if($_GET["sc"] == $orderArr["ASC"]) {
                usort($data, "proc3_sort_asc");
            } else if($_GET["sc"] ==  $orderArr["DESC"]) {
                usort($data, "proc3_sort_desc");
            }
        }
    }

    $per = 10;
    $pages = ceil(count($data)/$per);//總頁數

    //目前頁數
    if(isset($_GET["page"]) && $_GET["page"] <= $pages && $_GET["page"] > 0 && preg_match("/^[0-9]+$/", $_GET["page"])) {
        $page = $_GET["page"];
    } else {
        $page = 1;
    }
    $data = page_data($data, $page);




    $timelog = new Timelog();

    if(isset($_POST["time"])) { //設定時間
        if($_POST["time"] == "1" || $_POST["time"] == "3" || $_POST["time"] == "5"){
            $input = $_SESSION["id"] . "," . $_POST["time"];
            $timelog->write_timelog($input, $_SESSION["id"]);
        }
    }

    $userTime = $timelog->find_timelog($_SESSION["id"]);


    include_once("xhtml/index.html");   

   

   
} else {
    header('Location: login.php');
}




function date_sort_asc($a, $b) 
{ //日期升序
    return strtotime($a[0]) - strtotime($b[0]);
}

function date_sort_desc($a, $b)
{ //日期降序
    return -(strtotime($a[0]) - strtotime($b[0]));
}

function loadAve_sort_asc($a, $b)
{ //load Average升序
    return ($a[1] - $b[1]) * 100;
}

function loadAve_sort_desc($a, $b)
{ //load Average降序
    return -($a[1] - $b[1]) * 100;
}

function task_sort_asc($a, $b)
{ //task升序
    return $a[4] - $b[4];
}

function task_sort_desc($a, $b)
{ //task降序
    return -($a[4] - $b[4]);
}

function rtask_sort_asc($a, $b)
{ //running task升序
    return $a[5] - $b[5];
}

function rtask_sort_desc($a, $b)
{ //running task降序
    return -($a[5] - $b[5]);
}

function cpu_sort_asc($a, $b)
{ //cpu升序
    return (floatval($a[6]) - floatval($b[6])) * 100;
}

function cpu_sort_desc($a, $b)
{ //cpu降序
    return -(floatval($a[6]) - floatval($b[6])) * 100;
}

function pid1_sort_asc($a, $b)
{ //升序
    return $a[7] - $b[7];
}

function pid1_sort_desc($a, $b)
{ //降序
    return -($a[7] - $b[7]);
}

function pid2_sort_asc($a, $b)
{ //升序
    return $a[8] - $b[8];
}

function pid2_sort_desc($a, $b)
{ //降序
    return -($a[8] - $b[8]);
}

function pid3_sort_asc($a, $b)
{ //升序
    return $a[9] - $b[9];
}

function pid3_sort_desc($a, $b)
{ //降序
    return -($a[9] - $b[9]);
}

function proc1_sort_asc($a, $b)
{ //process升序
    return strcmp($a[10], $b[10]); 
}

function proc1_sort_desc($a, $b)
{ //process降序
    return -(strcmp($a[10], $b[10])); 
}

function proc2_sort_asc($a, $b)
{ //process升序
    return strcmp($a[11], $b[11]); 
}

function proc2_sort_desc($a, $b)
{ //process降序
    return -(strcmp($a[11], $b[11])); 
}

function proc3_sort_asc($a, $b)
{ //process升序
    return strcmp($a[12], $b[12]); 
}

function proc3_sort_desc($a, $b)
{ //process降序
    return -(strcmp($a[12], $b[12])); 
}


function search($data, $str)
{ //時間搜尋
    $sk = 0;
    $tmpArr = array();
    foreach($data as $dSearch) {
        if(preg_match("/$str/", $dSearch[0])) {
            $tmpArr[$sk] = $dSearch;
            $sk++;
        }
    }
    return $tmpArr;
}

function p_search($data, $str)
{ //PID搜尋
    $sk = 0;
    $tmpArr = array();
    foreach($data as $search) {
        if(strcmp($str, $search[7]) == 0 || strcmp($str, $search[8]) == 0 || strcmp($str, $search[9]) == 0) {
            $tmpArr[$sk] = $search;
            $sk++;
        }
    }
    return $tmpArr;
}


function page_data($data, $page)
{ //獲得該頁數資料
    global $per;
    $start = ($page - 1) * $per;
    if(count($data) > $start+$per) {
        for($i = $start; $i < $start+$per; $i++) {
            $tmpArr[$i] = $data[$i];
        }
    } else {
        for($i = $start; $i < count($data); $i++) {
            $tmpArr[$i] = $data[$i];
        }
    }
   
    return $tmpArr;
}