<?php
session_start();

function calculateExpression($expression) {
    // Удаляем все пробелы
    $expression = preg_replace('/\s+/', '', $expression);
    
    // Проверяем на пустое выражение
    if (empty($expression)) {
        return ['error' => 'Выражение не может быть пустым'];
    }

    // Проверяем на допустимые символы
    if (!preg_match('/^[0-9+\-*\/\(\).]+$/', $expression)) {
        return ['error' => 'Выражение содержит недопустимые символы'];
    }

    // Проверяем парность скобок
    if (substr_count($expression, '(') !== substr_count($expression, ')')) {
        return ['error' => 'Непарные скобки в выражении'];
    }

    try {
        // Безопасное выполнение выражения
        $result = @eval('return ' . $expression . ';');
        
        if ($result === false && error_get_last()['type'] === E_ERROR) {
            return ['error' => 'Ошибка в выражении'];
        }
        
        if (!is_finite($result)) {
            return ['error' => 'Деление на ноль'];
        }
        
        // Сохраняем результат в сессии
        if (!isset($_SESSION['history'])) {
            $_SESSION['history'] = [];
        }
        $_SESSION['history'][] = [
            'expression' => $expression,
            'result' => $result
        ];
        
        // Оставляем только последние 5 вычислений
        if (count($_SESSION['history']) > 5) {
            array_shift($_SESSION['history']);
        }
        
        return ['result' => $result];
    } catch (Exception $e) {
        return ['error' => 'Ошибка вычисления'];
    }
}

$result = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['expression'])) {
    $calculation = calculateExpression($_POST['expression']);
    if (isset($calculation['error'])) {
        $error = $calculation['error'];
    } else {
        $result = $calculation['result'];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="calculator-container">
        <div class="calculator">
            <form method="post" id="calc-form">
                <input type="text" name="expression" id="display" readonly>
                <div class="buttons">
                    <button type="button" class="operator" onclick="appendToDisplay('(')">(</button>
                    <button type="button" class="operator" onclick="appendToDisplay(')')">)</button>
                    <button type="button" class="operator" onclick="clearDisplay()">C</button>
                    <button type="button" class="operator" onclick="backspace()">←</button>
                    
                    <button type="button" onclick="appendToDisplay('7')">7</button>
                    <button type="button" onclick="appendToDisplay('8')">8</button>
                    <button type="button" onclick="appendToDisplay('9')">9</button>
                    <button type="button" class="operator" onclick="appendToDisplay('/')">/</button>
                    
                    <button type="button" onclick="appendToDisplay('4')">4</button>
                    <button type="button" onclick="appendToDisplay('5')">5</button>
                    <button type="button" onclick="appendToDisplay('6')">6</button>
                    <button type="button" class="operator" onclick="appendToDisplay('*')">*</button>
                    
                    <button type="button" onclick="appendToDisplay('1')">1</button>
                    <button type="button" onclick="appendToDisplay('2')">2</button>
                    <button type="button" onclick="appendToDisplay('3')">3</button>
                    <button type="button" class="operator" onclick="appendToDisplay('-')">-</button>
                    
                    <button type="button" onclick="appendToDisplay('0')">0</button>
                    <button type="button" onclick="appendToDisplay('.')">.</button>
                    <button type="button" class="equals" onclick="calculate()">=</button>
                    <button type="button" class="operator" onclick="appendToDisplay('+')">+</button>
                </div>
            </form>
            
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($result !== ''): ?>
                <div class="result">Результат: <?php echo htmlspecialchars($result); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($_SESSION['history'])): ?>
                <div class="history">
                    <h3>История вычислений:</h3>
                    <ul>
                        <?php foreach (array_reverse($_SESSION['history']) as $item): ?>
                            <li><?php echo htmlspecialchars($item['expression'] . ' = ' . $item['result']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html> 