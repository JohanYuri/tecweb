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

    //Ejercicio 3
    function primeroInt()
    {
        if(isset($_GET['numero']))
        {
            $num = $_GET['numero'];
            $num_aleatorio = NULL;

            do{
                $num_aleatorio = rand(0,1000);
                echo "$num_aleatorio <br>";
            }
            while (($num_aleatorio % $num) != 0);

            echo $num_aleatorio . ' es multiplo de ' . $num;
        }
        else
        {
            echo 'para comenzar, teclea "?numero=X en la barra de direcciones!"';
        }
    }    

    //Ejercicio 4
    function generarArregloAlfabeto() 
    {
        $arreglo = [];

        for ($i = 97; $i <= 122; $i++) 
        {
            $arreglo[$i] = chr($i);
        }

        echo '<table border = 1>';
        echo '<tr><th>Índice</th><th>Valor</th></tr>';

        foreach ($arreglo as $index => $value) {
            echo "<tr><td>$index</td><td>$value</td></tr>";
        }
        echo '</table>';
    }
    
    
    
?>