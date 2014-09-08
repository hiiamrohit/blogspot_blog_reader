<?php


    error_reporting(E_ALL);
    ini_set("display_errors", 1);

    function __autoload($classname) {
        require_once("classes/" . $classname . ".php");
    }

    $url = 'http://phpquestionanswer.blogspot.in';
    $limit = 10;
    $blog = new blogReader($url, $limit);

    echo $data = $blog->totalArticle();
    
    exit;

?>


