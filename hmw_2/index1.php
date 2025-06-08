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

        <header style="display: flex; gap:8rem; margin-bottom: 3rem;">
            <img src="Logo_Polytech_rus_main.jpg" alt="Логотип Московского политеха" style="max-width: 20%">
            <h1 style="text-align: center">Домашняя работа: Feedback form</h1>
        </header>

        <main>
            <form action="https://httpbin.org/post" method="POST" class="form">
                <div class="form__wrapper">

                </div>
                <div class="wrapper">
                    <div class="form__group">
                        <label for="name" name="name">Имя:</label>
                        <input type="text" id="name" required>
                    </div>

                    <div class="form__group">
                        <label for="email" name="email">Адрес электронной почты:</label>
                        <input type="email" id="email" required>
                    </div>

                    <div class="form__group">
                        <fieldset>

                            <legend> Тип обращения: </legend>

                            <div class="mini-wrap">
                                <input type="radio" name="feedback-type" id="complaint" required>
                                <label for="colmplaint">Жалоба</label>
                            </div>

                            <div class="mini-wrap">
                                <input type="radio" name="feedback-type" id="sugestion" required>
                                <label for="sugestion">Предложение </label>
                            </div>

                            <div class="mini-wrap">
                                <input type="radio" name="feedback-type" id="gratitude" required>
                                <label for="gratitude">Благодарность</label>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <div class="wrapper">
                    <div class="form__group">
                        <label for="feedback">Текст обращения:</label>
                        <textarea name="feedback" id="feedback" rows="5" cols="33" required></textarea>
                    </div>

                    <div class="form__group">
                        <fieldset>
                            <legend>Вариант ответа:</legend>

                            <div class="mini-wrap">
                                <input type="checkbox" name="send-via" id="send-via-text">
                                <label for="send-via-text">СМС</label>
                            </div>


                            <div class="mini-wrap">
                                <input type="checkbox" name="send-via" id="send-via-mail">
                                <label for="send-via-mail">Почта</label>
                            </div>

                        </fieldset>
                    </div>
                </div>

                <button type="submit">Отправить</button>
            </form>

        </main>
    </div>

    <footer style="height: 50px">
        <p style="display: flex">
            Задание для самостоятельной работы (без описания)
        </p>

        <a href="index2.php">Следующая страница →</a>
    </footer>
</body>

</html>