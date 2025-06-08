<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    if (isset($_POST['expression'])) {
        $result = calculate($_POST['expression']);
        echo json_encode($result);
    } else {
        echo json_encode(['error' => 'Выражение не передано']);
    }
    exit;
}

function validateScaples($val) {
    $count = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') {
            $count++;
        } elseif ($val[$i] == ')') {
            $count--;
            if ($count < 0) {
                return false;
            }
        }
    }
    return $count == 0;
}

function calculate($val) {
    $val = str_replace(' ', '', $val);
    
    if (strlen($val) == 0) {
        return ['error' => 'Пустое выражение'];
    }
    
    if (!validateScaples($val)) {
        return ['error' => 'Ошибка в скобках'];
    }


    if ($val[0] === '-') {
        $val = "0" . $val;
    } else {
        $val = "0+" . $val;
    }


    $val = str_replace('--', '+', $val);
    $val = str_replace('+-', '-', $val);
    $val = str_replace('-+', '-', $val);
    $val = str_replace('++', '+', $val);


    if (preg_match('/[^0-9+\-*\/\(\)\.]/', $val)) {
        return ['error' => 'Недопустимые символы'];
    }

    if (preg_match('/[\+\-\*\/]{2,}/', $val)) {
        return ['error' => 'Последовательные операторы недопустимы'];
    }

    try {
   
        while (preg_match('/(\-?\d+\.?\d*)([\/\*])(\-?\d+\.?\d*)/', $val, $matches)) {
            $left = (float)$matches[1];
            $operator = $matches[2];
            $right = (float)$matches[3];
            
            switch ($operator) {
                case '*':
                    $newVal = $left * $right;
                    break;
                case '/':
                    if ($right == 0) {
                        return ['error' => 'Деление на ноль'];
                    }
                    $newVal = $left / $right;
                    break;
            }
            $val = str_replace($matches[0], $newVal, $val);
        }

        while (preg_match('/(\-?\d+\.?\d*)([\+\-])(\-?\d+\.?\d*)/', $val, $matches)) {
            $left = (float)$matches[1];
            $operator = $matches[2];
            $right = (float)$matches[3];
            $newVal = $operator === '+' ? $left + $right : $left - $right;
            $val = str_replace($matches[0], $newVal, $val);
        }

    
        if (!is_numeric($val)) {
            return ['error' => 'Ошибка вычисления'];
        }
        return ['result' => round((float)$val, 8)];
    } catch (Exception $e) {
        error_log("Ошибка вычисления: " . $e->getMessage());
        return ['error' => 'Ошибка вычисления'];
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор Каматали</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="calculator">
        <h1>Калькулятор</h1>
        <div class="display" id="display">0</div>
        <div class="error-display" id="error-display"></div>
        <div class="buttons">
            <button class="openScaple">(</button>
            <button class="closeScaple">)</button>
            <button class="reset">C</button>
            <button class="delete">←</button>
            
            <button class="num7">7</button>
            <button class="num8">8</button>
            <button class="num9">9</button>
            <button class="division">/</button>
            
            <button class="num4">4</button>
            <button class="num5">5</button>
            <button class="num6">6</button>
            <button class="multiplier">*</button>
            
            <button class="num1">1</button>
            <button class="num2">2</button>
            <button class="num3">3</button>
            <button class="minus">-</button>
            
            <button class="num0">0</button>
            <button class="dot">.</button>
            <button class="calculate">=</button>
            <button class="plus">+</button>
        </div>
    </div>
    <script src="index.js"></script>
</body>
</html>