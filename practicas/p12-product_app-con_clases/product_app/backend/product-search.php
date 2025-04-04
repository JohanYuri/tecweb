<?php
    use TECWEB\MYAPI\Products;
    require_once __DIR__.'/myapi/Read/Read.php';

    $productos = new Products('marketzone');
    $productos->search( $_GET['search'] );
    echo $productos->getData();
?>