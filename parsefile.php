<?php
set_time_limit(0);
define('PREFIX', 'https://play.google.com/store/apps/details?id=');

error_reporting(E_ERROR);



if(isset($argv[1])){
    $argument1 = $argv[1];
}else{
    die("no arguments provided");
}

//sleep prevents google ban
//sleep ( rand ( 0, 1));
try {

    $handle = fopen($argument1,'r');
    while ( ($row = fgetcsv($handle) ) !== FALSE ) {



        sleep ( rand ( 3, 7));
        $id= $row[0];
        $package= $row[1];
        $data = get_data($package);
        //echo $data;
        $glue = ',';
        //$data = mb_convert_encoding($data, 'HTML-ENTITIES', "UTF-8");
        $dom = new DOMDocument();
        $dom->loadHTML($data);


       $banned =  $dom->getElementById('infoDiv0');
       $prefix  = $id . $glue . $package . $glue;
       if($banned){
           $category = 'banned';
           $downloads = 'banned';
       }else{
           $cat = getElementsByClass($dom , 'a' , 'category' , false);
           $category = 'none';
           $downloads = 'none';

           if($cat && $cat[0]){
               $metainfoholder = getElementsByClass($dom , 'div' , 'meta-info' );
               $category = $cat[0]->nodeValue;
               $category = trim($category);
               $category = str_replace(',', ';', $category);
               if($metainfoholder && $metainfoholder[1]){
                   $numDownloads = getElementsByClass($metainfoholder[1] , 'div' , 'content' );
                   if($numDownloads && $numDownloads[0]){
                       $downloads = $numDownloads[0]->nodeValue;

                       $downloads = trim($downloads);
                       $downloads = str_replace(',', '', $downloads);
                       $downloads = str_replace(' ', '', $downloads);
                   }

                   if($downloads == 'Varieswithdevice'){
                       $numDownloads = getElementsByClass($metainfoholder[2] , 'div' , 'content' );
                       if($numDownloads && $numDownloads[0]){
                           $downloads = $numDownloads[0]->nodeValue;
                           $downloads = trim($downloads);
                           $downloads = str_replace(',', '', $downloads);
                           $downloads = str_replace(' ', '', $downloads);
                       }
                   }
               }
           }
       }



        echo $prefix . $category . $glue . $downloads;
        echo PHP_EOL;
//        echo $id;
//        echo PHP_EOL;
//        echo $package;
//        echo PHP_EOL;

    }

} catch (Exception $e) {
    # 500 Internal Server Error
    die('error 500');
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



