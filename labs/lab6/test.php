<?php
session_start();
if (isset($_POST['country'])) {
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
    <p>
        <?php
        echo "Вы из страны: " . $_SESSION['country'];
        ?>
    </p>
    <a href="index.php">Назад</a>
</body>
</html>