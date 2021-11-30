<?php

function timestamp() {
    return '[' . date("d.m.Y H:i") . "]";
}

function getIPAddress() {  
    //whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  

    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
    
     //whether ip is from the remote address  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}

# logs basic information for incoming file uploads
function writeToLog($host, $file_name, $failed) {
    $log_message = 
        timestamp() . " " . 
        getIPAddress() . " " . 
        ($failed ? 'failed ' : 'successfull ') . 
        $file_name;
    
    $log = fopen('../.log', 'a');
    fwrite($log, "\r\n" . $log_message);
    fclose($log);
}

$_failed = true;
$_host = getIPAddress();
$_auth = isset($_GET["auth"]) ? $_GET["auth"] : "";
$file_name = isset($_GET["name"]) ? $_GET["name"] : "";

# check if the auth matches with the stored hash
if (md5($_auth) == fgets(fopen("../.env", "r")) && $file_name != "") {
    unlink("../s/" . $file_name);
    $_failed = false;
    echo "file deletion successful";
} else
    echo "invalid credentials or empty filename";


writeToLog($_host, $file_name, $_failed);