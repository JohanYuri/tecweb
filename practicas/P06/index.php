<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>

</head>
<body>
    <?php
        require_once 'src/funciones.php'; //Se incluye el archivo funciones.php

        //Ejercicio 1
        echo'<h2>Ejercicio 1</h2>';
        echo'<p>Escribir un programa para comprobar si un número es múltiplo de 5 y 7</p>';
        multiplo(5,7); //Se llama a la función y se dan los números que queremos saber si son multiplos de un tercer
        echo '<hr><br>';
        
        //Ejercicio 2
        echo'<h2>Ejercicio 2</h2>';
        echo'<p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
        secuencia compuesta por:</p>';
        echo '<p>Por ejemplo:</p>';
        echo '<img src="src/img/EJ2_Ejemplo.png"';
        echo '<br><br>';
        numaleatorios();
        echo '<hr><br>';

        //Ejercicio 3
        echo '<h2>Ejercicio 3</h2>';
        echo'<p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una
        secuencia compuesta por:</p>';

        
    
    ?>    
</body>
</html>
