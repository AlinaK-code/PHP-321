<?php
// Дано 2 катета найти гипотенузу
 $a = 27; $b = 12;
$hupotenuse = sqrt(pow($a,2) + pow($b,2));
echo round($hupotenuse, 2).'<br>';

//Интерполяция
$hunter = "охотник";
$wants = "желает";
$know = 'знать';
$fizan = 'фазан';
$sits = 'сидит'; 


echo ('<br>' ."Каждый {$hunter} {$wants} {$know} где {$sits} {$fizan} ").'<br>';

//Округление

$a = 5.7;
$b = 8.3; 
$c = '5.6';
$d = '9.2кг';

$floor = [
    'a' => floatval($a),
    'b'=> floatval($b),
    'c'=> floatval($c),
    'd'=> floatval(str_replace('кг','', $d)),
];
echo '<br> Пол: <br>';
foreach($floor as $k => $v) {
    echo floor($v) .'<br>';
}
echo '<br> Поталок: <br>';
foreach($floor as $k => $v) {
    echo ceil($v) .'<br>';   
}
echo '<br> Арифметически: <br>';
foreach($floor as $k => $v) {
    echo round($v) .'<br>';
}

//Тернарный оператор. 
$a = 36;
$b = '4';
$b = intval($b);
$res = $a/$b;
$ost = $a % $b;
echo ($a % $b) > 0?"<br> Тип данных в результате деления {$a} на {$b}: " . gettype($res) . "<br> Остаток от деления: " . "{$ost}": "<br> Результат деления: " . "{$a} / {$b} = {$res} <br>";

//Форматирование переменных: сложить 2 переменные и привести к 3 знакам после запятой, также сделать так, чтобы было минимум 4знака до запятой
$money1 = 33.15; 
$money2 = 67.45;
$money3 = $money1 + $money2;
echo "<br>". sprintf("%08.3f", $money3) ."<br>"; //f означает что у нас тип данных float, после точки нам нужно 3 знака, "%08" значит доставить незначащих ноликов чтобы длина стала 8


