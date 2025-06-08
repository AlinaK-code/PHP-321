<!-- формирующий меню и регламентирующий его работу модуль -->
<?php
function getMenu($activeAction = 'view')
{
 $menuItems = [
  'view' => 'Просмотр',
  'add' => 'Добавление записи',
  'edit' => 'Редактирование записи',
  'delete' => 'Удаление записи'
 ];

 $html = '<div style="margin-bottom: 20px;">';

 // Основные пункты меню
 foreach ($menuItems as $action => $title) {
  $url = ($action === $activeAction) ? ' style="color: red;"' : ' style="color: blue;"';
  $html .= '<a href="index.php?action=' . $action . '"' . $url . '>' . $title . '</a> ';
 }

 // Подменю для действия просмотра
 if ($activeAction === 'view') {
  $sortOptions = [
   'date' => 'По дате добавления',
   'surname' => 'По фамилии',
   'birthdate' => 'По дате рождения'
  ];

  $activeSort = isset($_GET['sort']) ? $_GET['sort'] : 'date';

  $html .= '<br><small>';
  foreach ($sortOptions as $sort => $title) {
   $activeClass = ($sort === $activeSort) ? ' style="color: red;"' : ' style="color: blue;"';
   $html .= '<a href="index.php?action=view&sort=' . $sort . '"' . $activeClass . '>' . $title . '</a> ';
  }
  $html .= '</small>';
 }

 $html .= '</div>';
 return $html;
}
?>