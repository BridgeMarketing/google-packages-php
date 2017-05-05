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

if(isset($argv[1]) && isset($argv[2]) ){
    $argument1 = $argv[1];
    $argument2 = $argv[2];
}else{
    die("no arguments provided");
}

try {

    $query = "SELECT * FROM `$manage_db_name`  WHERE `id` BETWEEN $argument1 AND $argument2";
    $result = mysql_query($query);

    if (!$result) {
        echo "Could not successfully run query ($query) from DB: " . mysql_error();
        exit;
    }

    while ($row = mysql_fetch_assoc($result)) {
        $id= $row["id"];
        $package= $row["package"];
        $data = get_data($package);
        $glue = ',';
        //$data = mb_convert_encoding($data, 'HTML-ENTITIES', "UTF-8");
        $dom = new DOMDocument();
        $dom->loadHTML($data);
        $cat = getElementsByClass($dom , 'a' , 'category' , false);
        $category = 'none';
        $downloads = 'none';
        $query = $id . $glue . $package . $glue;
        if($cat && $cat[0]){
            $metainfoholder = getElementsByClass($dom , 'div' , 'meta-info' );
            $category = $cat[0]->nodeValue;
            if($metainfoholder && $metainfoholder[1]){
                $numDownloads = getElementsByClass($metainfoholder[1] , 'div' , 'content' );
                if($numDownloads && $numDownloads[0]){
                    $downloads = $numDownloads[0]->nodeValue;
                    $category = trim($category);
                    $category = str_replace(',', ';', $category);
                    $downloads = trim($downloads);
                    $downloads = str_replace(',', '', $downloads);
                    $downloads = str_replace(' ', '', $downloads);
                    echo $query . $category . $glue . $downloads;
                    echo PHP_EOL;
                    //$query = "UPDATE `$manage_db_name` SET `updated_at` = NOW(),`category`='$category',`downloads`='$downloads' WHERE `package`='$package'";
                    //mysql_query($query, $mysql_conn) or die(mysql_error());
                }
            }
        }


//        echo $id;
//        echo PHP_EOL;
//        echo $package;
//        echo PHP_EOL;

    }

} catch (Exception $e) {
    # 500 Internal Server Error
    error(500);
}


function getElementsByClass(&$parentNode, $tagName, $className, $strict = true)
{
    $nodes = array();

    $childNodeList = $parentNode->getElementsByTagName($tagName);
    for ($i = 0; $i < $childNodeList->length; $i++) {
        $temp = $childNodeList->item($i);
        $cls = $temp->getAttribute('class');
        //  if (($cls == $className) || (stripos($cls, $className . ' ' ) !==false)) {
        if ($strict) {
            if (($cls == $className)) {
                $nodes[] = $temp;
            }
        } else {
            if ((stripos($cls, $className) !== false)) {
                $nodes[] = $temp;
            }
        }

    }

    return $nodes;
}
function get_data($suffix = "")
{
    $data = null;
    $url = PREFIX . $suffix;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;

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