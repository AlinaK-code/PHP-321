<!-- <!DOCTYPE html>
<html lang="en"<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Правители России</title>
</head>
<body>
    <form action="lab3.php" method="GET">
    <label for="pravitel">Ведите век римскими цифрами: <br> <br></label>
    <input type="text" name="vek" id="pravitel">
    <button type="submit">Отправить</button>
    </form>

    <form action="lab3.php" method="GET">
    <label for="caps"><br>Напишите любое предложение: <br> <br></label>
    <textarea id="caps" name="text" rows="5" cols="33"></textarea>
    <button type="submit">Отправить</button>
    </form>

</body>
</html>  -->


<!-- Задача 1: правители
$XVI="Иван Васильевич";
$XVIII="Пётр Алексеевич";
$XIX="Николай Павлович";

if(!empty($_GET["vek"])) {
    $vek = $_GET["vek"];
    echo "В {$vek} веке царствовал ". $$vek;
} else{
    echo "<br> Упс, не знаю, кто царствовал в этом веке. Надо было учить историю в школе....";
}
-->

<!-- Задача 2: жесткие ссылки -->

<!DOCTYPE html>
<html lang="en"<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Правители России</title>
</head>
<body>

    <form action="lab3.php" method="GET">
    <label for="caps"><br>Напишите любое предложение: <br> <br></label>
    <textarea id="caps" name="text" rows="5" cols="33"></textarea>
    <button type="submit">Отправить</button>
    </form>

</body>
</html> 

<?php

function transformer(& $parts_arr){
    for($i=0; $i<count($parts_arr); $i++){
        if (($i + 1) % 2===0){
            $parts_arr[$i] = mb_strtoupper($parts_arr[$i]); //Функция strtoupper работате только с английскими словами, поэтому используем mb_strtoupper
        }
    }
    return implode(" ", $parts_arr);
};


if(!empty($_GET["text"])) {
    $text = $_GET["text"];
    $parts_arr = explode(" ",$text);
    echo transformer($parts_arr). "<br>";
}

else{
    echo "Пожалуйста, введите что-то!". "<br>";
}; 

?>


<!-- //Задача 3: Определить размер файла
$image_path = $_SERVER['DOCUMENT_ROOT'] . "/" . "feedback__woman.jpg";
$image_size_bytes = filesize($image_path);
$image_size_MB = round($image_size_bytes/ (1024*1024), 3);

echo "Размер файла  " . "\"". $image_path . "\"". "  составляет  " . $image_size_MB . " Мб."; -->

<!-- // Задача 4: переименовать файл
$new_name = rename('D:\XAMPP\htdocs\old.txt', 'D:\XAMPP\htdocs\new.txt'); -->

<!-- //Задача 5: создание файла
$created_file = file_put_contents("test.txt", "12345"); -->

<!-- //Задача 6: прочитать и вывести содержание файла
$filename = "test.txt";
echo file_get_contents($filename); -->

<?php 

function calculateTrigonometry(string $funct, float $param){
    $param = deg2rad($param);
    switch (strtolower($funct)) {
        case 'sin':
            $trigFunction = 'sin';
            break;
        case 'cos':
            $trigFunction = 'cos';
            break;
        case 'tan':
            $trigFunction = 'tan';
            break;
        default:
            echo "Упс, введено неккоректное значение :(";
    }
    return $trigFunction($param);
};

$expression = file_get_contents('D:\XAMPP\htdocs\Task\expression.txt');
function calculateExpression($expr){
    $expr = str_replace('30',deg2rad(30), $expr);
    $res = eval( "return $expr;" );
    echo "{$expr} = $res ";
}

//calculateExpression($expression);