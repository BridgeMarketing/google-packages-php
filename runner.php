<?php
set_time_limit(0);

$start  = 2400000;
$total  = 4200000;
$step   = 16000;
for (;$start < $total; $start  = $start + $step  ){
    $end  = $start + $step;
    $cmd   = "nohup /usr/bin/php /home/bridgedev/google-packages/parseparams.php $start $end >/home/bridgedev/google-packages/logs/data_{$start}_{$end}.csv &";
    echo $cmd;
    echo PHP_EOL;
    shell_exec($cmd);

}