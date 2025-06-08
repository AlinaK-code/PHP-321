<?php
//Задание 1: написать сессию test и вывести ее на экран
session_start();
$_SESSION['test'] = 'test';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['brtd'])) {
    // Устанавила куки на 1 год
    setcookie('birthday', $_POST['brtd'], time() + 60*60*24*365);
    // Перезагру страницу для применения куки
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

function daysUntilBirthday($birthdayString) {
    $birthday = new DateTime($birthdayString);
    $today = new DateTime('today');
    $nextBirthday = new DateTime($today->format('Y') . '-' . $birthday->format('m-d'));
    
    if ($nextBirthday < $today) {
        $nextBirthday->modify('+1 year');
    }
    
    return $today->diff($nextBirthday)->days;
}

//Задание 2: написать сессию reloads
$reloads = $_SESSION['reloads'] ?? 0;
$message = $reloads == 0 ? "Вы еще ни разу не обновляли страницу, не упустите свой шанс!" : "Вы обновили страницу {$reloads} раз";
echo $message;

$_SESSION['reloads'] = $reloads + 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab-6</title>
</head>

<body>
    <?php
    $Birthday = isset($_COOKIE['birthday']);
    $birthdayForm = '
        <form action="lab6.php" method="post">
            <label for="brtd">Когда у вас день рождения?</label>
            <input type="date" name="brtd" id="brtd" required>
            <button type="submit">Отправить</button>
        </form>
    ';

    $birthdayMessage = '';
    if ($Birthday) {
        $daysUntil = daysUntilBirthday($_COOKIE['birthday']);
        $birthdayMessage = $daysUntil === 0 
            ? "<h2>🎉 С днем рождения! Поздравляем! 🎂</h2>"
            : "<p>До вашего дня рождения осталось дней: {$daysUntil}</p>";
        
        $birthdayForm = '
            <form action="lab6.php" method="post">
                <label for="brtd">Изменить дату рождения:</label>
                <input type="date" name="brtd" id="brtd" value="' . htmlspecialchars($_COOKIE['birthday']) . '" required>
                <button type="submit">Изменить</button>
            </form>
        ';
    }

    echo $birthdayMessage;
    echo $birthdayForm;
    ?>

    <p>
        Значение сессии test: <?php echo $_SESSION['test']; ?><br> 
    </p>
</body>

</html>