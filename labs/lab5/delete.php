<!-- модуль для удаления записи из базы данных. -->
<?php
require_once __DIR__ . '/db.php';//connect

function deleteList()
{
  global $pdo;

  $html = '<div style="max-width: 600px; margin: 0 auto;">';

  // Обрабатываю удаление, если указан ID
  if (isset($_GET['id'])) {
    $result = deleteContact($_GET['id']);
    if ($result) {
      $html .= '<p style="color: green;">Запись удалена</p>';
    } else {
      $html .= '<p style="color: red;">Ошибка: запись не удалена</p>';
    }
  }

    // Получаем все контакты
  $contacts = $pdo->query("SELECT id, surname, name FROM contacts ORDER BY surname, name")->fetchAll(PDO::FETCH_ASSOC);
//contacts - [];
  if (empty($contacts)) {//[]
    $html .= '<p>Нет записей для удаления</p>';
  } else {//[1,2,3]true
    $html .= '<ul>';
    foreach ($contacts as $contact) {
      $html .= '<li><a href="index.php?action=delete&id=' . $contact['id'] . '">' .
        htmlspecialchars($contact['surname'] . ' ' . $contact['name']) . '</a></li>';
    }
    $html .= '</ul>';
  }

  $html .= '</div>';
  return $html;
}

function deleteContact($id)
{
  global $pdo;

  try {
    return  $pdo->prepare("DELETE FROM contacts WHERE id = ?")->execute([$id]);
  } catch (PDOException $e) {
    return false;
  }
}
?>