<?php
    use TECWEB\MYAPI\Read\search;
    require_once __DIR__ . '/../vendor/autoload.php';


    $productos = new search('marketzone');
    $productos->search( $_GET['search'] );
    echo $productos->getData();
?>