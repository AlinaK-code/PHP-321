<!-- Пример: 27 - X = 17 -->
<?php

// $x = null;
// $a = 27;
// $b = 17;
// echo $a  - $x = $b

$equation = "27 - x = 17 ";

function solveEquation($equation) {
    //Убираю пробелы
    $equation = str_replace(" ", "", $equation); //Теперь у нас что-то типа 27-х=17

    //Разделяю уравнение на 2 части
    $parts = explode("=", $equation); // Теперь у нас что-то типа ["27-x", "17"]
    $left = $parts[0];
    $right = $parts[1];

    //Определяю позицию х
    if(strpos($left, "x")!== false) {
        $xin = 'left';
        $expression = $parts[0];
        $result = $parts[1];
    } elseif (strpos($right, "x")!== false) {
        $xin = 'right';
        $expression = $parts[1];
        $result = $parts[0];
    } else {
        return "Переменная х не найдена в уравнении :("; //Теперь expression = "27-x", result = "17"
    };

    //Определяю оператор (+ - * /)
    $operators = ['+', '-', '*', '/'];
    foreach ($operators as $op) {
        if (strpos($expression, $op) !== false) {
            $operators = $op;
            break;
        }
    };
    
    //Разбиваю на операнды 
    $operands = explode($op, $expression); //Теперь у нас operands = ["27", "x"], operatop= "-", result = "17"
    if (count($operands) !== 2) {
        return "Неверный формат выражения";
    }

    //Снова определяю позицию х, но уже в expression:
    if(strpos($operands[0], "x")!==false){
        $x_pos = 'first';
        $known = $operands[1];
    } else{
        $x_pos = 'second';
        $known = $operands[0]; //Теперь у нас known = "27"
    }; 

    //Привожу строки к числам 
    $known = (float)$known;
    $result = (float)$result; //теперь result = 17, known = 27

    //Собираю уравнение
    switch($operators){
        case "+":
            $x = ($x_pos === 'first') ? $result - $known : $result - $known;
            break;
        case "-":
            $x = ($x_pos === 'first') ? $result + $known: $known - $result;
            break;
        case "*":
            $x = ($x_pos === 'first') ? $result / $known : $result / $known;
            break;
        case "/":
             $x = ($x_pos === 'first') ? $result * $known : $known / $result;
            break;  
        default:
        return "Неизвестный оператор :(";
        
    };
    return "x = ".$x;
};

echo solveEquation("27 * x = 17");
