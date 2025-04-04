<?php
    use TECWEB\MYAPI\Products;
    require_once __DIR__.'/myapi/Read/Read.php';

    $productos = new Products('marketzone');
    $productos->single( $_POST['id'] );
    echo $productos->getData();
?>