<?php
session_start();

// Инициализация счетчика при первом посещении
if (!isset($_SESSION['reloads'])) {
    $_SESSION['reloads'] = 0;
}

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['reloads']++;
    // Перенаправляем на эту же страницу методом GET чтобы избежать повторной отправки формы
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

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
    if ($_SESSION['reloads'] == 0) {
        echo "<p>Вы еще ни разу не отправляли форму, не упустите свой шанс!</p>";
    } else {
        echo "<p>Вы отправили форму " . $_SESSION['reloads'] . " раз</p>";
    }
    ?>

    <form method="POST" action="">
        <input type="submit" value="Отправить форму">
    </form>

    <p>Текущее значение счетчика: <?php echo $_SESSION['reloads']; ?></p>
</body>
</html> 