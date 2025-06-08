<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['email'] = $_POST['email'];
    header('Location: register.php'); //Сразу перекидывает на страницу регистрации
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ввод Email</title>
</head>
<body>
    <form action="" method="post">
        <label for="email">Введите ваш email:</label><br>
        <input type="email" id="email" name="email" required><br>
        <button type="submit">Продолжить</button>
    </form>

    <?php if (isset($_SESSION['email'])): ?>
        <p>Текущий email в сессии: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
    <?php endif; ?>

    <p><a href="register.php">Перейти к регистрации</a></p>
</body>
</html> 