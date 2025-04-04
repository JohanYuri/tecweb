<?php
    use TECWEB\MYAPI\Delete\Delete;
    require_once __DIR__ . '/../vendor/autoload.php';


    $productos = new Products('marketzone');
    $productos->delete( $_POST['id'] );
    echo $productos->getData();
?>