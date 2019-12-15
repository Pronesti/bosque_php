<?php

function crearBosqueVacio($n):array {
return array_fill(0,$n,0);
}

function sucesoAleatorio($p):bool {
    if (random_int(0,100) < $p){
        return true;
    }else{
        return false;
    }
}

function brotes(&$bosque, $p):array {
    foreach($bosque as $k => $v){
        if (sucesoAleatorio($p)){
            $bosque[$k] = 1;
        }
    }
    print("Brotes: \n");
    graficar($bosque);
    return $bosque;
}

function cuantos($bosque, $tipo):int {
    $contador = 0;
    foreach($bosque as $k => $v){
        if ($bosque[$k] == $tipo){
            $contador = $contador + 1;
        }
    }
    return $contador;
}

function rayos(&$bosque, $f):array {
    foreach($bosque as $k => $v){
        if ($bosque[$k] == 1 && sucesoAleatorio($f)){
            $bosque[$k] = -1;
        }
    }
    print("Rayos: \n");
    graficar($bosque);
    return $bosque;
}

function propagacion(&$bosque):array {
    $i=count($bosque)-1;
    $n = 10;
    while ($n > 0){
    foreach($bosque as $k => $v){
        if ($v == 1 && ((isset($bosque[$k-1]) && $bosque[$k-1] == -1) || (isset($bosque[$k+1]) && $bosque[$k+1] == -1))){
            $bosque[$k] = -1;
        }
        if ($v == 1 && $k == 0 && $bosque[count($bosque)-1] == -1){ // si tengo un arbol primer lugar y un fuego en el ultimo lo incendio
            $bosque[$k] = -1;
        }

        if($v == 1 && $k == count($bosque)-1 && $bosque[0] == -1 ){ // si estoy en el ultimo lugar tengo un arbol y el primero es un fuego lo incendio
            $bosque[$k] = -1;
        }
    }
    $n = $n - 1;
    }
   /*  while (0 < $i){
        if ($bosque[$i] == 1 && ((isset($bosque[$i-1]) && $bosque[$i-1] == -1) || (isset($bosque[$i+1]) && $bosque[$i+1] == -1))){
            $bosque[$i] = -1;
        }
        if ($bosque[$i] == 1 && $i == 0 && $bosque[count($bosque)-1] == -1){ // si tengo un arbol primer lugar y un fuego en el ultimo lo incendio
            $bosque[$i] = -1;
        }

        if($bosque[$i] == 1 && $i == count($bosque)-1 && $bosque[0] == -1 ){ // si estoy en el ultimo lugar tengo un arbol y el primero es un fuego lo incendio
            $bosque[$i] = -1;
        }
        $i = $i - 1; 
    }*/
    print("Propagacion: \n");
    graficar($bosque);
    return $bosque;
}

function limpieza(&$bosque):array {
    foreach($bosque as $k => $v){
        if($v == -1){
            $bosque[$k] = 0;
        }
    }
    print("Limpieza: \n");
    graficar($bosque);
    return $bosque;
}

function añoForestal(&$unBosque, $p, $f):array {
        brotes($unBosque,$p);
        rayos($unBosque, $f);
        propagacion($unBosque);
        limpieza($unBosque);
    return $unBosque;
}

function incendioForestal($p, $f, $n_rep):int {
    $i = 0;
    $unBosque = crearBosqueVacio(100);
    $arbolesRestantes = array($n_rep);
    while ($i < $n_rep){
        añoForestal($unBosque,$p,$f);
        $arbolesRestantes[$i] = cuantos($unBosque, 1);
        $i = $i + 1;
    }
    $total=0;
    foreach($arbolesRestantes as $k => $v){
        $total = $total + $v;
    }
    $promedio= $total/$n_rep;
    //print_r($arbolesRestantes);
    return $promedio;
}

function graficar($bosque){
    print("[");
    foreach($bosque as $k => $v){
        if ($v != -1){
            if ($v == 0){
                print("\e[1;30;40m " . $v);
            }else{ // es 1
                print("\e[0;32;40m " . $v);
            }
        }else{
            print("\e[0;31;40m" . $v . "");
        }
        
        if ($k != count($bosque) - 1){
            print(",");
        }
        print("\e[0m");
    }
    print("] \n");
}

function graficar_emoji($bosque){
    print("[");
    foreach($bosque as $k => $v){
        if ($v != -1){
            if ($v == 0){
                print(" \u{2003} ");
            }else{ // es 1
                print(" \u{1F332} ");
            }
        }else{
            print(" \u{1F525} ");
        }
        
        if ($k != count($bosque) - 1){
            print(",");
        }
    }
    print("] \n");
}

/* $miBosque=brotes(crearBosqueVacio(50),80);
graficar($miBosque);
$rayos = rayos($miBosque, 30);
graficar($rayos);
$propaga = propagacion($rayos);
graficar($propaga) */;

print_r(incendioForestal(80,20,10));

?>