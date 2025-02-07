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
        echo'<p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
        pero que además sea múltiplo de un número dado.</p>';
        echo '<ul>';
            echo '<li>Crear una variante de este script utilizando el ciclo do-while.</li>';
            echo '<li>El número dado se debe obtener vía GET.</li>';
        echo '</ul>';
        echo '<br>';
        primeroInt();
        echo '<hr><br>';

        //Ejercicio 4
        echo '<h2>Ejercicio 4</h2>';
        echo'<p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
        a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
        el valor en cada índice. Es decir:</p>';
        echo '<img src="src/img/EJ4_Ejemplo_1.png"';
        echo '<ul>';
            echo '<li>Crea el arreglo con un ciclo for';
            echo '<li>Lee el arreglo y crea una tabla en XHTML con echo y un ciclo foreach</li>';
        echo '</ul>';
        echo '<img src="src/img/EJ4_Ejemplo_2.png"';
        $arregloAlfabeto = generarArregloAlfabeto();
        mostrarTablaAlfabeto($arregloAlfabeto);
        echo '<hr><br>';

        //Ejercicio 5
        echo '<h2>Ejercicio 5</h2>';
        echo'<p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de
        sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de
        bienvenida apropiado. Por ejemplo: <br>Bienvenida, usted está en el rango de edad permitido.
        <br>En caso contrario, deberá devolverse otro mensaje indicando el error.</p>';  
        
        echo'<a href="EJ5.php">
                <button>Formulario EJ5</button>
            </a>';
    ?>    
</body>
</html>
