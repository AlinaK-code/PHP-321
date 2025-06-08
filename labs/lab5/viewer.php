<!-- модуль для вывода содержимого базы данных в браузер; -->
<?php
require_once __DIR__ . '/db.php';

function getContactsTable($sort = 'date')
{
    global $pdo;

    // порядок сортировки
    $sortColumns = [
        'date' => 'created_at',
        'surname' => 'surname',
        'birthdate' => 'birthdate'
    ];

    $sortColumn = $sortColumns[$sort] ?? 'created_at';

    // Получаем контакты для текущей страницы
    $contacts = $pdo->query("SELECT * FROM contacts ORDER BY $sortColumn LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);

    if ($contacts > 5) {
        $form = '<form action="index.php?action=view" method="post"> 
<button type="submit" name="more">Показать еще →</button>
    </form>';
    } else {
        $form = '';
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['more'])){
        $form = '<form action="index.php?action=view" method="post"> 
<button type="submit" name="back">← Назад</button>
    </form>';
        $contacts = $pdo->query("SELECT * FROM contacts ORDER BY $sortColumn LIMIT 5, 10")->fetchAll(PDO::FETCH_ASSOC);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['back'])){
        $form = '<form action="index.php?action=view" method="post"> 
<button type="submit" name="add">Показать еще →</button>
    </form>';
        $contacts = $pdo->query("SELECT * FROM contacts ORDER BY $sortColumn LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    }

    $html = '<table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-bottom: 20px;">';
    $html .= '<tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th><th>Дата рождения</th><th>Телефон</th><th>Адрес</th><th>Email</th><th>Комментарий</th></tr>';

    foreach ($contacts as $contact) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($contact['surname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['patronymic']) . '</td>';
        $html .= '<td>' . ($contact['gender'] === 'male' ? 'Мужской' : 'Женский') . '</td>';
        $html .= '<td>' . $contact['birthdate'] . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['address']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($contact['comment']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>'. $form;

    return $html;
}
?>