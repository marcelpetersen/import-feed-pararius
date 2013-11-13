<?php
// set import feed pararius url:
$url = 'http://example.com/pararius.xml';

// check if host is development or production:
$host = '';
if (isset($_SERVER['SERVER_NAME'])) {
    $host = substr($_SERVER['SERVER_NAME'], 0, 5);
}
if ($host == 'local') {
    // development:
    error_reporting(-1);
    ini_set('display_errors', '1');
    $local = TRUE;
} else {
    // production:
    error_reporting(0);
    ini_set('display_errors', '0');
    $local = FALSE;
}
// set default charset:
ini_set('default_charset', 'UTF-8');
// set no time limit:
set_time_limit(0);

// get pararius feed:
$xml = getXml($url);
if ($xml == FALSE) {
    echo 'xml error';
    exit();
}
// clean up and parse xml feed:
$xml = str_replace("&#8217;","'", $xml); // replace '.
$xml = str_replace("&#160;","", $xml); // replace nbsp.

$parsedXml = new SimpleXMLElement($xml);

// list items:
foreach ($parsedXml->member->items->item as $item) {
    echo '<pre>';
    var_dump($item);
    echo '</pre>';
}

// functions:
function getXml($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Bot');
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 600); // 600 = 10 minutes.
    $r = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    if ($info['http_code'] == 200) {
        return $r;
    }
    
    return FALSE;
}
function getImage($url, $dir)
{
    $lfile = fopen($dir.'/'.basename($url), "w");
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Bot');
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 60 = 1 minute.
    curl_setopt($ch, CURLOPT_FILE, $lfile);
    $r = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    
    fclose($lfile);
    
    if ($info['http_code'] == 200) {
        return TRUE;
    }
    
    return FALSE;
}