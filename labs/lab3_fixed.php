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
function transformer($str){
<!-- тут была ошибка: передать нужно массив в имплоде и экспло -->
    $parts = explode(" ",$str); <!--На этом этапе получаем массив из подстрок строки text -->
    for($i=0; $i< count($parts); $i++){
        if (($i + 1) % 2===0){
            $parts[$i] = strtoupper($parts[$i]);
       
        }
    }
    return implode(" ", $parts);
};



if(!empty($_GET["text"])) {
    $text = $_GET["text"];
    echo transformer($text). "<br>";
}

else{
    echo "Пожалуйста, введите что-то!". "<br>";
};