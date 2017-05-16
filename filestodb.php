<?php
set_time_limit(0);
# Credentials
define('HOST', 'localhost');
define('PORT', 3306);
define('USER', 'peter');
define('PASSWORD', 'gramercy');
define('DB', 'google-packages');
define('PREFIX', 'https://play.google.com/store/apps/details?id=');

# Don't display errors
//ini_set( "display_errors", "0" );
error_reporting(0);

$manage_db_name = 'google-packages';
$mysql_conn = mysql_get_con($manage_db_name);

$dir = '/home/bridgedev/google-packages/logs/';

$files = scandir($dir);

foreach($files as $file) {

    if (($handle = fopen($dir .$file, "r")) !== FALSE) {
        echo "<b>Filename: " . basename($file) . "</b><br><br>";
        while (($data = fgetcsv($handle, 4096, ",")) !== FALSE) {
            print_r($data);
            $package  = $data[1];
            $category  = $data[2];
            $downloads  = $data[3];
            $query = "UPDATE `$manage_db_name` SET `updated_at` = NOW(),`category`='$category',`downloads`='$downloads' WHERE `package`='$package'";
            //mysql_query($query, $mysql_conn) or die(mysql_error());
            echo $query;
            echo PHP_EOL;
        }

        fclose($handle);
    } else {
        echo "Could not open file: " . $file;
    }

}

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