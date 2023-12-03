<?php
$page = isset($_GET['page']) ? $_GET['page'] : "home";

$folder ="";
$files = glob($folder."*.php");

if(in_array($page.".php",$files)){
    require($page.".php");
}
else{
    echo "could not find the file";
}



?>