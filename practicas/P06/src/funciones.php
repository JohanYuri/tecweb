<?php
    //Ejercicio 1 Multuplos de 5 y 7
    function  multiplo($num1, $num2)
    {
        if(isset($_GET['numero']))
        {
            $num = $_GET['numero'];
            if(($num % $num1) == 0 && ($num % $num2) == 0)
            {
                echo 'El número ' .$num. ' SI es multiplo de ' .$num1. ' ni del número '.$num2. '<br>' ;
            }
            else
            {
                echo 'El número ' .$num. ' NO es multiplo de ' .$num1. ' ni del número '.$num2. '<br>' ;
            }
        }
        
    }
    
    //Ejercicio 2
    function numaleatorios()
    {
        $matriz []= [];
        $inte=0;
        $generados=0;

        do
        {
            $num1 = rand(0,100);
            $num2 = rand(0,100);
            $num3 = rand(0,100);

            $matriz[]= [$num1,$num2,$num3];
            @$inte++;
            $generados +=3;
        }while(!((($num1 % 2) != 0) && (($num2 % 2) == 0) && (($num3 % 2) != 0)));
        
        
        foreach ($matriz as $fila) {
            echo '<br>' . implode(' ', $fila);  // Imprimir los tres números en cada fila
        }
        
        echo '<br><br>' . $generados . ' numeros generados en ' . $inte . ' iteraciones.<br>';
    }
?>