<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET/POST страничка Каматали Алины</title>
</head>

<body>
    <form action="http://localhost/PHP/labs/lab2.php" method="GET">
        <label for="number">Введите ваше любимое число:</label>
        <input type="text" required id="number" name="favorite_number">
        <button type="submit">Отправить</button>
    </form>
</body>

</html>

<?php
//Задача 1: Дан массив с элементами 'a', 'b', 'c', 'b', 'a'. Подсчитайте сколько раз встречается каждая из букв
function count_values(array $array, string $searchElement)
{
    $count = 0;
    foreach ($array as $value) {
        if ($value === $searchElement) {
            $count++;
        }
    }
    return $count;
}
;

$arr = ['a', 'b', 'c', 'b', 'a'];

echo "<br>";

foreach (array_unique($arr) as $value) {
    echo "Буква {$value} встречается " . count_values($arr, $value) . " раз. <br>";
}
;

//Задача 2: дан массив с элементами 'a'=>1, 'b'=>2, 'c'=>3. Выведите на экран случайный элемент данного массива.
$masiv = array(
    "a" => 1,
    "b" => 2,
    "c" => 3,
);

$randomKey = array_rand($masiv); //функция возвращает рандомный ключ
echo "<br> Рандомный элемент массива [a => 1, b => 2, c => 3]:  " . $masiv[$randomKey];

//Задача 3: Отправьте с помощью GET-запроса число. Выведите его на экран квадрат этого числа.

if(!empty($_GET["favorite_number"])) {
    echo "Получены новые данные: любимое число — " . $_GET["favorite_number"] ."<br>";
} else {
    echo "Переменные не дошли :( <br> Попробуйте ещё раз!" ."<br>";
}

//Задача 4: Дан трехмерный массив с числами, например [[[1, 2], [3, 4]], [[5, 6], [7, 8]]]. 
// Найдите сумму элементов этого массива.

$trechmerniy_masiv = [ [[1, 2], [3, 4]], [[5, 6], [7, 8]] ];
$sum = 0;
foreach ($trechmerniy_masiv as $dvumerniy_masiv) {
    foreach ($dvumerniy_masiv as $masiv) {
    $sum += array_sum($masiv);
    }
};

echo "<br> Сумма элементов трехмерного массива равна: " . $sum;

//Задача 5: дан массив, собрать предложение
$hello_arr = ["Привет, ","мир", "!"];
$text = implode($hello_arr);
echo "<br> <br>". $text;