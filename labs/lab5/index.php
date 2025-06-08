<!-- единственный загружаемый в браузер документ, осуществляющий всю работу сайта; -->
<?php
require_once __DIR__ . '/menu.php';
require_once __DIR__ . '/viewer.php';
require_once __DIR__ . '/add.php';
require_once __DIR__ . '/edit.php';
require_once __DIR__ . '/delete.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab-5</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="container">
    <?php
    // Получаем текущую страницу и действие из параметров URL
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $action = isset($_GET['action']) ? $_GET['action'] : 'view';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'date';
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null;

    // Отображаем меню
    echo getMenu($action);

    // Отображаем содержимое в зависимости от действия
    switch ($action) {
      case 'view':
        echo getContactsTable( $sort);
        break;
      case 'add':
        echo addForm();
        break;
      case 'edit':
        echo getEditForm($id);
        break;
      case 'delete':
        echo deleteList();
        break;
    }
    ?>
  </div>
</body>

</html>