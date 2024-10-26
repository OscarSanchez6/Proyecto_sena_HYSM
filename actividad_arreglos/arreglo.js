//Primero organizamos el arreglo para dar solucion a cuantos numeros se repiten con la funcion .sort()
let numeros=[1, 2, 3, 4, 2, 3, 5, 1, 2, 4, 6, 7, 8, 5, 5].sort();

document.write("este es el arreglo "+numeros+"<br>");
document.write("<br>");


//con la funcion .length() obtenemos el numero de elementos que hay en el arreglo
document.write("el numero de elementos es de "+numeros.length+"<br>");

let tamañoArreglo= numeros.length-1;
document.write("el tamaño del arreglo es de"+tamañoArreglo);
document.write("<br>");

//aqui declare variables que almacenaran los valores como indica su nombre 
let unicosElementos = [];
let almacenadorDeVecesRepetidas = [];
//este contador inicia en uno por que contara el numero de veces que se repite un numero
let contador = 1;

//el for va a recorrer los elementos en numeros y el if compara si el numero es igual al que se esta recorriendo
//y el contador aumentara
for(let i = 0; i < numeros.length; i++){
    if(numeros[i+1] === numeros[i]){
        contador++;
        //si es contrario osea si el numero no es igual al anterior el unico numero no repetido se almacena en unicos elementos con la funcion .push
        //tambien agrega el contador actual al arreglo almacenadorDeVecesRepetidas
        //y el contador queda en 1 nuevamente para que los numeros que no se repiten tomen el valor de 1
    }else{
        unicosElementos.push(numeros[i]);
        almacenadorDeVecesRepetidas.push(contador);
        contador=1;
    }
}
document.write("<br>");
//este ciclo nos sirve para recorrer los unicoselementos y el numero de veces que se repiten de los arreglos
//para luego mostrarlos 
for (let j = 0; j < unicosElementos.length; j++){
    document.write("el numero "+ unicosElementos[j] + " se repite "+ almacenadorDeVecesRepetidas[j]+" veces <br>");
}



