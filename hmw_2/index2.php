<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Каматали Алина 241-321 Hmw2</title>
</head>

<body>
    <div class="content" style="min-height: calc(100vh - 70px)">

        <header style="display: flex; gap:6rem; margin-bottom: 5rem;">
            <img src="Logo_Polytech_rus_main.jpg" alt="Логотип Московского политеха" style="max-width: 20%">
            <h1 style="text-align: center">Домашняя работа: Feedback form</h1>
        </header>

        <main>
            <label for="feedback"></label>

            <textarea rows="15" cols="8" name="feedback" id="feedback"
                style="width: 60%; margin: 0 auto; padding: 2rem">
                <?php
                $url = "https://httpbin.org/post";
                print_r(get_headers($url))
                ?>
            </textarea>

        </main>
    </div>

    <footer style="height: 50px">
        <p style="display: flex">
            Задание для самостоятельной работы (без описания)
        </p>
        <a href="index1.php">← Предыдущая страница</a>
    </footer>
</body>

</html>