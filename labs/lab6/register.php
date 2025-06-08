<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
    <h2>Форма регистрации</h2>
    
    <form action="" method="post">
        <div>
            <label for="firstname">Имя:</label><br>
            <input type="text" id="firstname" name="firstname" required>
        </div>
        
        <div>
            <label for="lastname">Фамилия:</label><br>
            <input type="text" id="lastname" name="lastname" required>
        </div>
        
        <div>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" 
                value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" 
                required>
        </div>
        
        <div>
            <label for="password">Пароль:</label><br>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div style="margin-top: 10px;">
            <button type="submit">Зарегистрироваться</button>
        </div>
    </form>

    <p><a href="email.php">Вернуться к вводу email</a></p>
</body>
</html> 