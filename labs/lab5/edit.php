<!-- модуль для редактирования существующей записи базы данных; -->
<?php
require_once __DIR__ . '/db.php';

function getContact($id) {
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching contact: " . $e->getMessage());
        return false;
    }
}

function getEditForm($id = null)
{
    global $pdo;
    $html = '<div style="max-width: 800px; margin: 0 auto;">';

    try {
        // Получаем все контакты для списка
        $contacts = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname, name")->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching contacts list: " . $e->getMessage());
        return '<div class="message error">Ошибка при загрузке списка контактов</div>';
    }

    if (empty($contacts)) {
        return '<div class="message info">Нет доступных контактов для редактирования</div>';
    }

    // Вывод списка контактов
    $html .= '<div class="contact-list">';
    foreach ($contacts as $contact) {
        $activeClass = ($contact['id'] == $id) ? ' class="active"' : '';
        $html .= '<a href="index.php?action=edit&id=' . $contact['id'] . '"' . $activeClass . '>' .
            htmlspecialchars($contact['surname'] . ' ' . $contact['name']) . '</a>';
    }
    $html .= '</div>';

    // Если контакт не выбран, выбираем первый
    if (!$id && !empty($contacts)) {
        $id = $contacts[0]['id'];
    }

    // Получаем данные контакта
    $contactData = getContact($id);
    
    if (!$contactData) {
        return $html . '<div class="message error">Контакт не найден</div>';
    }

    // Обработка формы редактирования
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $errors = validateContactData($_POST); // Используем функцию валидации из add.php
        if (empty($errors)) {
            $result = updateContact($id);
            if ($result) {
                $html .= '<div class="message success">Запись успешно обновлена</div>';
                $contactData = getContact($id); // Обновляем данные после успешного сохранения
            } else {
                $html .= '<div class="message error">Ошибка при обновлении записи</div>';
            }
        } else {
            $html .= '<div class="message error">' . implode('<br>', $errors) . '</div>';
            $contactData = $_POST; // Используем введенные данные при ошибке валидации
        }
    }

    // Форма редактирования
    $html .= '<form method="POST" action="index.php?action=edit&id=' . $id . '" class="edit-form">
        <div class="form-group">
            <label>Фамилия:</label>
            <input type="text" name="surname" value="' . htmlspecialchars($contactData['surname']) . '" required>
        </div>
        <div class="form-group">
            <label>Имя:</label>
            <input type="text" name="name" value="' . htmlspecialchars($contactData['name']) . '" required>
        </div>
        <div class="form-group">
            <label>Отчество:</label>
            <input type="text" name="patronymic" value="' . htmlspecialchars($contactData['patronymic']) . '">
        </div>
        <div class="form-group">
            <label>Пол:</label>
            <select name="gender" required>
                <option value="male"' . ($contactData['gender'] === 'male' ? ' selected' : '') . '>Мужской</option>
                <option value="female"' . ($contactData['gender'] === 'female' ? ' selected' : '') . '>Женский</option>
            </select>
        </div>
        <div class="form-group">
            <label>Дата рождения:</label>
            <input type="date" name="birthdate" value="' . htmlspecialchars($contactData['birthdate']) . '" required>
        </div>
        <div class="form-group">
            <label>Телефон:</label>
            <input type="tel" name="phone" value="' . htmlspecialchars($contactData['phone']) . '" required>
        </div>
        <div class="form-group">
            <label>Адрес:</label>
            <textarea name="address">' . htmlspecialchars($contactData['address']) . '</textarea>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="' . htmlspecialchars($contactData['email']) . '">
        </div>
        <div class="form-group">
            <label>Комментарий:</label>
            <textarea name="comment">' . htmlspecialchars($contactData['comment']) . '</textarea>
        </div>
        <div class="form-group">
            <input type="submit" value="Сохранить" class="btn btn-primary">
            <a href="index.php?action=view" class="btn btn-secondary">Отмена</a>
        </div>
    </form>';

    $html .= '</div>';
    return $html;
}

function updateContact($id)
{
    global $pdo;

    try {
        // Проверяем существование контакта
        $exists = $pdo->prepare("SELECT 1 FROM contacts WHERE id = ?");
        $exists->execute([$id]);
        if (!$exists->fetch()) {
            return false;
        }

        $stmt = $pdo->prepare("UPDATE contacts SET 
            surname = ?, 
            name = ?, 
            patronymic = ?, 
            gender = ?, 
            birthdate = ?, 
            phone = ?, 
            address = ?, 
            email = ?, 
            comment = ? 
            WHERE id = ?");
            
        return $stmt->execute([
            $_POST['surname'],
            $_POST['name'],
            $_POST['patronymic'],
            $_POST['gender'],
            $_POST['birthdate'],
            $_POST['phone'],
            $_POST['address'],
            $_POST['email'],
            $_POST['comment'],
            $id
        ]);
    } catch (PDOException $e) {
        error_log("Error updating contact: " . $e->getMessage());
        return false;
    }
}
?>