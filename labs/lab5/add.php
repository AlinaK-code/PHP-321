<!-- модуль для добавления новой записи в базу данных; -->
<?php
require_once __DIR__ . '/db.php';

function validateContactData($data) {
    $errors = [];
    
    // Проверка обязательных полей
    $required = ['surname', 'name', 'gender', 'birthdate', 'phone'];
    foreach ($required as $field) {
        if (empty($data[$field])) {
            $errors[] = "Поле " . ucfirst($field) . " обязательно для заполнения";
        }
    }
    
    // Проверка email
    if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Неверный формат email";
    }
    
    // Проверка даты рождения
    if (!empty($data['birthdate'])) {
        $birthdate = strtotime($data['birthdate']);
        if ($birthdate > time()) {
            $errors[] = "Дата рождения не может быть в будущем";
        }
    }
    
    // Проверка телефона
    if (!empty($data['phone']) && !preg_match('/^[0-9+\-\(\)\s]{10,}$/', $data['phone'])) {
        $errors[] = "Неверный формат телефона";
    }
    
    return $errors;
}

function addForm()
{
    $html = '<div style="max-width: 600px; margin: 0 auto;">';
    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = validateContactData($_POST);
        if (empty($errors)) {
            $success = addContact();
            if ($success) {
                $html .= '<div class="message success">Запись успешно добавлена</div>';
            } else {
                $html .= '<div class="message error">Ошибка при добавлении записи</div>';
            }
        } else {
            $html .= '<div class="message error">' . implode('<br>', $errors) . '</div>';
        }
    }

    $html .= '<form method="POST" action="index.php?action=add" style="max-width: 600px; margin: 0 auto;">
        <div style="margin-bottom: 10px;">
            <label>Фамилия: <input type="text" name="surname" value="' . htmlspecialchars($_POST['surname'] ?? '') . '" required></label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Имя: <input type="text" name="name" value="' . htmlspecialchars($_POST['name'] ?? '') . '" required></label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Отчество: <input type="text" name="patronymic" value="' . htmlspecialchars($_POST['patronymic'] ?? '') . '"></label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Пол: 
                <select name="gender" required>
                    <option value="">Выберите пол</option>
                    <option value="male"' . (($_POST['gender'] ?? '') === 'male' ? ' selected' : '') . '>Мужской</option>
                    <option value="female"' . (($_POST['gender'] ?? '') === 'female' ? ' selected' : '') . '>Женский</option>
                </select>
            </label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Дата рождения: <input type="date" name="birthdate" value="' . htmlspecialchars($_POST['birthdate'] ?? '') . '" required></label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Телефон: <input type="tel" name="phone" value="' . htmlspecialchars($_POST['phone'] ?? '') . '" required placeholder="+7 (999) 999-99-99"></label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Адрес: <textarea name="address">' . htmlspecialchars($_POST['address'] ?? '') . '</textarea></label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Email: <input type="email" name="email" value="' . htmlspecialchars($_POST['email'] ?? '') . '"></label>
        </div>
        <div style="margin-bottom: 10px;">
            <label>Комментарий: <textarea name="comment">' . htmlspecialchars($_POST['comment'] ?? '') . '</textarea></label>
        </div>
        <div>
            <input type="submit" value="Добавить" class="btn btn-primary">
        </div>
    </form></div>';

    return $html;
}

function addContact()
{
    global $pdo;

    try {
        $stmt = $pdo->prepare("INSERT INTO contacts (surname, name, patronymic, gender, birthdate, phone, address, email, comment, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([
            $_POST['surname'],
            $_POST['name'],
            $_POST['patronymic'],
            $_POST['gender'],
            $_POST['birthdate'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['email'],
            $_POST['comment']
        ]);
    } catch (PDOException $e) {
        error_log("Error adding contact: " . $e->getMessage());
        return false;
    }
}
?>