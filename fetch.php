#!/PGRAM/php/bin/php -q
<?

if($_SERVER['REQUEST_METHOD'] == "") {
    include_once("class/Timelog.php");
    $tFile = new Timelog();
    $time = $tFile->read_timelog();

    if(!empty($time)) {
        include_once("class/Device.php");
        include_once("class/UserData.php");

        foreach($time as $val) {
            $loadTime = $val[1];
            $min = date("i");
            if($min % $loadTime == 0) {
                $uData = new UserData($val[0]);
                $dev = new Device();
                $loadAve = $dev->fetch_load_average();
                $task = $dev->fetch_task_cpu();
                $cpuLoad = $dev->fetch_cpu_load();

                $uData->write_data($loadAve, $task, $cpuLoad);
            }
        }
    } 
}



    
