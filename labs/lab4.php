<?php

// Задание 1: 'a1b2c3' -> 'a11b22c33'
$str = 'a1b2c3';
$res = preg_replace('/[\d]/', '$0$0', $str);
echo $res.'<br>';

// Задание 2: поиск собаки
$str2 = "My em@il is alinakamatali@gmail.com";
$res2 = preg_match_all('/@/', $str2);
echo $res2.'<br>';

// Задание 3: нохождение ссылок
$str3 = 'http://site.ru http://site.ru/ https://site.ru https://site.ru/';
preg_match_all('/https?:\/\/[\S]+/', $str3, $matches);
print_r($matches);
echo '<br>';

// Задание 4: валидация почты
$str4 = 'user@sub.example.com mymail@gmail.ru my.mail@mail.ru my-mail@mail.ru my_mail@mail.ru mail@mail.com mail@mail.by mail@yandex.ru';
preg_match_all('/\b[a-z0-9_.-]+@(?:[a-z0-9-]+\.)+[a-z]{2,}\b/', $str4, $matches4 );
print_r($matches4);
echo '<br>';

//Задание 5: использование колбэков
$str5 = "2aaa'3'bbb'4' ";
$res5 = preg_replace_callback('/\'(\d+)\'/', 
function($matches5){
    $number = $matches5[1]*2; //Так как мы использовали группу захвата, matches - массив, где matches[0] 
    // это полное совпадение'3', а matches[1] совпадение из группы захвата, т.е просто число 3
    return "'$number'";
    },
$str5
);
echo $res5.'<br>';

//Задание 6
$str6 = "2 3 4 5 6 100";
$res6 = preg_replace_callback('/(\d+)/', 
function($matches6) {
    return $matches6[0]**2; 
}, $str6
);

echo $res6.'<br>';

//Задание 7
$str7 = "'aa aba abba abbba abca abea";
$res7 = preg_match_all('/a{1}b*a{1}/', $str6, $matches7);
print_r($matches7);

//Задание 8
$str8 =  'avb a1b a2b a3b a4b a5b abb acb';
$res8 = preg_match_all('/a{1}\Db{1}/', $str8, $matches8);
print_r($matches8);




