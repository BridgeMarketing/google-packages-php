<?php

# Credentials
define('HOST', 'localhost');
define('PORT', 3306);
define('USER', 'peter');
define('PASSWORD', 'gramercy');
define('DB', 'google-packages');

# Don't display errors
//ini_set( "display_errors", "0" );
error_reporting(E_ALL);

# Error handler
function error($code = "")
{

    $admin_emails = array('lev.savranskiy@thebridgecorp.com');
    $subj = 'ERROR ' . HOST . ':' . PORT . ' CODE: ' . $code;
    $msg = $subj;
    echo $msg;
    echo PHP_EOL;
    foreach ($admin_emails as $email) {
        echo $email;
        echo PHP_EOL;
        mail($email, $subj, $msg);
    }

    exit;
}

# Register global error handler
//register_shutdown_function('error');

try {
    $manage_db_name = 'google-packages';
    $mysql_conn = mysql_get_con($manage_db_name);

    $fp = fopen("/home/bridgedev/google-packages/Packagenames.csv", "r");
$i = 0;
    while (!feof($fp)) {
        if (!$line = fgetcsv($fp)) {
            echo 'no line';
            continue;
        } else {
            $query = "INSERT INTO `$manage_db_name` (`package`)
                VALUES('" . $line[0] . "')";
            echo $i++ ;
            echo PHP_EOL;
            echo $query;
            echo PHP_EOL;
        }

       // break;

        mysql_query($query, $mysql_conn) or die(mysql_error());


    }


    echo PHP_EOL;
} catch (Exception $e) {
    # 500 Internal Server Error
    error(500);
}

function mysql_get_con($db_name)
{
    $db = "10.0.3.34";
    $db = "localhost";
    $username = "peter";
    $password = "gramercy";
    $con = mysql_pconnect($db, $username, $password);
    if (!$con) {
        $subj =  "cannot connect to management db " . $db;
        $msg =  "hostname: " . gethostname() . PHP_EOL ;
        $msg .=  "db: " . $db . PHP_EOL ;
        $msg .=  "username: " . $username . PHP_EOL;
        loginfo($msg);
        mailer($subj, $msg);
        die($msg);
    }
    mysql_select_db($db_name, $con);
    return $con;
}