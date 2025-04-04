<?php
    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__.'/myapi/Read/Read.php';

    $productos = new Products('marketzone');
    $productos->list();
    echo $productos->getData();
?>