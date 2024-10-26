<?php
$numeros = [1, 2, 3, 4, 2, 3, 5, 1, 2, 4, 6, 7, 8, 5, 5];
 
//para visualizar el arreglo numeros usamos print_r()
print_r($numeros);
echo "<br>";
echo "<br>";
echo "el numero de elementos es de: ".count($numeros)."<br>";

$totalelemen = count($numeros)-1;
echo "el tamaño del arreglo es de: ".($totalelemen);
echo "<br>";
echo "<br>";

//array_count_values nos permite reconocer entre el arreglo los numeros que tiene y las veces que se repite
//frecuencia almacenara los numeros de
$frecuencia = array_count_values($numeros);

//usamos un foreach para que repita sobre la frecuencia o itere
//en cada iteracion va a asignar la clave del elemento a $numero y valor a $cantidad
//la condicion if nos permite seleccionar los numeros y el numero de veces que se repite con cantidad mayor o igual a 1

foreach ($frecuencia as $numero => $cantidad) {
    if ($cantidad >= 1) {
        echo "el numero $numero se repite $cantidad veces.<br>";
    }
}


?>