<?php
// 1) Crie um array
$array = [];

// 2) Popule este array com 7 números
for ($i = 0; $i < 7; $i++) {
    array_push($array, rand(10, 20));
}
echo "<p>O array inicial é: [" . implode(",", $array) . "]</p>";

// 3) Imprima o número da terceira posição do array
echo "<p>3º número: " . $array[2] . "</p>";

// 4) Crie uma variável com todos os itens do array no formato de string separado por vírgula
$string = implode(",", $array);

// 5) Crie um novo array a partir da variável no formato de string que foi criada e destrua o array anterior
$newArray = explode(",", $string);
unset($array);

// 6) Crie uma condição para verificar se existe o valor 14 no array
$arrayHas14 = array_keys($newArray, 14);
if ($arrayHas14) {
    echo "<p>O array possui o valor 14 " . ngettext("na posição", "nas posições", count($arrayHas14)) . " [" . implode(",", $arrayHas14) . "]</p>";
}else{
    echo "<p>O array não possui nenhum elemento com o valor 14</p>";
}

// 7) Faça uma busca em cada posição. Se o número da posição atual for menor que o da posição anterior (valor anterior que não foi excluído do array ainda), exclua esta posição
$aux = $newArray[0];
foreach ($newArray as $key => $value) {
    if ($aux > $value) {
        unset($newArray[$key]);
        continue;
    }
    $aux = $value;
}
echo "<p>Array após as remoções: [" . implode(",", $newArray) . "]</p>";

// 8) Remova a última posição deste array
echo "<p>O elemento " . array_pop($newArray) . " foi removido!</p>";

// 9) Conte quantos elementos tem neste array
echo "<p>O array possui " . count($newArray) . " elemento(s)!</p>";

// 10) Inverta as posições deste array
$newArray = array_reverse($newArray);
echo "<p>O array final é: [" . implode(",", $newArray) . "]</p>";
