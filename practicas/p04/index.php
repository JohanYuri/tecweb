<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>

<body>

    //EJERCICIO 1
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>

    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>
    <br>

    //EJERCICIO 2
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>

    <?php
        // Definiendo las variables
        $a = "ManejadorSQL";
        $b = 'MySQL';
        $c = &$a;
        
        echo '<li>a. Ahora muestra el contenido de cada variable</li>';
        echo '<h4>Respuestas:</h4>';
        echo '<ul>';
            echo '<li>$a = ' . $a . '</li>';
            echo '<li>$b = ' . $b . '</li>';
            echo '<li>$c = ' . $c . '</li>';
        echo '</ul>';

        echo '<li>b. Agrega al código actual las siguientes asignaciones:</li>';
        echo '$a = "PHP server"<br>';
        echo '$b = &$a<br><br>';
        $a = "PHP server";
        $b = &$a;

        echo '<ul>';
            echo '<li>$a = ' . $a . '</li>';
            echo '<li>$b = ' . $b . '</li>';
        echo '</ul>';
        echo '<h4>¿Qué pasó en el segundo bloque de asignaciones?</h4>';
        echo 'Respuesta: Se asigno otro valor a la variable $a y a la variable $b se asigno como un apuntador a la varibale $a por lo que las dos tendran el mismo valor';
    ?>
    
    //EJERCICIO 3
    <h2>Ejercicio 3</h2>
    <p>Muestra el contenido de cada variable inmediatamente después de cada asignación,
    verificar la evolución del tipo de estas variables (imprime todos los componentes de los
    arreglo):</p>

    <?php
    //1
    echo '1- Se asigna $a = "PHP5"';
    $a="PHP5";
    echo '<br>';
    echo $a; 
    echo '<br><br>';
    
    //2
    echo '2- Se asigna $z[] = &$a';
    $z[]=&$a;
    echo '<br>';
    var_dump($z);
    echo '<br><br>';

    //3
    echo '3- Se asigna $b = “5a version de PHP”;';
    $b = "5a version de PHP";
    echo '<br>';
    echo $b;
    echo '<br><br>';

    //4
    echo '4- Se asigna $c = $b*10;';
    @$c = $b*10;
    echo '<br>';
    echo $c;
    echo '<br><br>';

    //5
    echo '5- Se asigna $a .= $b;';
    $a .= $b;
    echo '<br>';
    echo $a;
    echo '<br><br>';

    //6
    echo '6- Se asigna $b *= $c;';
    $b *= $c;
    echo '<br>';
    echo $b;
    echo '<br><br>';

    //7
    echo '7- Se asigna $z[0] = “MySQL”;';
    $z[0] = "MySQL";
    echo '<br>';
    var_dump($z);
    echo '<br><br>';
    ?>

    //EJERCICIO 4
    <h2>Ejercicio 4</h2>
    <p>Lee y muestra los valores de las variables del ejercicio anterior, pero ahora con la ayuda de
    la matriz $GLOBALS o del modificador global de PHP.</p>

    <?php
    echo 'Usando $GLOBALS: <br><br>';
    echo '$a: ', $GLOBALS['a'], '<br>';
    echo '$b: ', $GLOBALS['b'], '<br>';
    echo '$c: ', $GLOBALS['c'], '<br>';
    echo '$z[]: ', var_dump($GLOBALS['z']), '<br><hr>';
    
    unset($a);
    unset($b);
    unset($c);
    unset($z);
    ?>

    //EJERCICIO 5
    <h2>Ejercicio 5</h2>
    <p>Dar el valor de las variables $a, $b, $c al final del siguiente script:</p>

    <?php
        echo '$a = “7 personas”;<br>
        $b = (integer) $a;<br>
        $a = “9E3”;<br>
        $c = (double) $a;<br><br>';

        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;

        echo '<h4>Respuesta:</h4>'; 
        echo '<ul>';
            echo '<li>$a = ' . $a . '</li>';
            echo '<li>$b = ' . $b . '</li>';
            echo '<li>$c = ' . $c . '</li>';
        echo '</ul>';
    ?>
</body>
</html>