<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['country'] = $_POST['country'];
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
    <form action="index.php" method="post">
        <label for="country">Из какой страны вы?</label>
        <input type="text" name="country" id="country" required>
        <button type="submit">Отправить</button>
    </form>
    
    <?php if (isset($_SESSION['country'])): ?>
        <p>Текущее значение в сессии: <?php echo htmlspecialchars($_SESSION['country']); ?></p>
    <?php endif; ?>
    
    <a href="test.php">Перейти на вторую страницу</a>
</body>
</html>