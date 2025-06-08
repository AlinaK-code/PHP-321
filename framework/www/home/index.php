<?php
$title = 'Главная';

use main\Models\Articles\Article;
use main\Controllers\Interfaces;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 $name = $_POST['name'];
 $content = $_POST['content'];
 (new Article())->addArticle($name, $content);
 header('Location: /');
}

$all_artical = (new Article())->getArticleAll();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title><?php echo $title; ?></title>
 <!-- Bootstrap CSS -->
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 <!-- Bootstrap Icons -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
 <!-- Google Fonts -->
 <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

 <style>
p:is(.author) {
	font-size: 0.8rem;
	color: #666;
}

p:is(.author):before {
	content: "Автор: ";
	color: #f33d95;
}
</style>
</head>

<body class="bg-light">
 <!-- Навигация -->
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
   <a class="navbar-brand fw-bold" href="/">
    <i class="bi bi-grid-3x3-gap-fill me-2"></i>Kamatali
   </a>
   <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
   </button>
   <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ms-auto">
     <li class="nav-item">
      <a class="nav-link active" href="/">
       <i class="bi bi-house-door me-1"></i>Главная
      </a>
     </li>
     <li class="nav-item">
      <a class="nav-link" href="/">
       <i class="bi bi-newspaper me-1"></i>Статьи
      </a>
     </li>
     <li class="nav-item">
      <a class="nav-link" href="/">
       <i class="bi bi-info-circle me-1"></i>О нас
      </a>
     </li>
     <li class="nav-item">
      <a class="nav-link" href="/contacts">
       <i class="bi bi-envelope me-1"></i>Контакты
      </a>
     </li>
    </ul>
   </div>
  </div>
 </nav>

 <!-- Hero секция -->
 <div class="hero bg-dark text-white py-5 mt-5">
  <div class="container py-5">
   <div class="row align-items-center">
    <div class="col-lg-8">
     <h1 class="display-4 fw-bold mb-3">Мой первый фреймворк :)</h1>
     <p class="lead mb-4"></p>
     <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#newPostModal">
      <i class="bi bi-plus-circle me-2"></i>Создать пост
     </button>
    </div>
    <div class="col-lg-6">
     <div class="position-relative">
      <div class="shape shape-1 position-absolute"></div>
      <div class="shape shape-2 position-absolute"></div>
      <div class="shape shape-3 position-absolute"></div>
     </div>
    </div>
   </div>
  </div>
 </div>

 <!-- Основной контент -->
 <div class="container py-5">
  <!-- Список статей -->
  <div class="row g-4">
   <?php
   $articles = (new Article())->getArticleAll();
   if ($articles) {
    foreach ($articles as $article) {
     echo '<div class="col-md-6 col-lg-4">
                        <article class="card h-100 border-0 shadow-sm hover-shadow">
                            <div class="position-relative">
                                <img src="https://masterpiecer-images.s3.yandex.net/a94346d36fdd11eeb8ce963c1ee369ba:upscaled" class="card-img-top" alt="Article image"
                                    style="height: 200px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="/edit/' . $article['id'] . '">
                                                <i class="bi bi-pencil me-2"></i>Редактировать
                                            </a></li>
                                            <li><a class="dropdown-item text-danger" href="/delete/' . $article['id'] . '" 
                                                onclick="return confirm(\'Вы уверены, что хотите удалить эту статью?\')">
                                                <i class="bi bi-trash me-2"></i>Удалить
                                            </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title h5 mb-3">' . htmlspecialchars($article['title']) . ' <p class="author">'.htmlspecialchars($article['author']).'</p></h3>
                                <p class="card-text text-muted">' . htmlspecialchars($article['content']) . '</p>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-heart me-2 text-danger"></i>
                                        <i class="bi bi-chat me-2 text-primary"></i>
                                        <i class="bi bi-share me-2 text-success"></i>
                                    </div>
                                    <a href="/articles/' . $article['id'] . '" class="btn btn-link text-primary p-0">
                                        Читать далее
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>';
    }
   } else {
    echo '<div class="col-12"><p class="text-muted">Статьи не найдены</p></div>';
   }
   ?>
  </div>
 </div>

 <!-- Модальное окно для создания поста -->
 <div class="modal fade" id="newPostModal" tabindex="-1">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <h5 class="modal-title">Создать новый пост</h5>
     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
     <form class="article-form" method="POST">
      <div class="mb-3">
       <label for="article-name" class="form-label">Заголовок</label>
       <input type="text" class="form-control" id="article-name" name="name" required
        placeholder="Введите заголовок поста">
      </div>
      <div class="mb-3">
       <label for="article-content" class="form-label">Содержание</label>
       <textarea class="form-control" id="article-content" name="content" required
        placeholder="Что у вас нового?" rows="4"></textarea>
      </div>
      <div class="d-flex justify-content-end gap-2">
       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
       <button type="submit" class="btn btn-primary">
        <i class="bi bi-send me-2"></i>Опубликовать
       </button>
      </div>
     </form>
    </div>
   </div>
  </div>
 </div>

 <!-- Bootstrap JS -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <style>
  body {
   font-family: 'Inter', sans-serif;
  }

  .hero {
   background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
   position: relative;
   overflow: hidden;
  }

  .shape {
   width: 300px;
   height: 300px;
   border-radius: 50%;
   opacity: 0.1;
   background: white;
  }

  .shape-1 {
   top: -100px;
   right: -50px;
  }

  .shape-2 {
   bottom: -150px;
   right: 100px;
   width: 200px;
   height: 200px;
  }

  .shape-3 {
   top: 50%;
   right: 50%;
   width: 150px;
   height: 150px;
  }

  .card {
   transition: all 0.3s ease;
   border-radius: 15px;
   overflow: hidden;
  }

  .hover-shadow:hover {
   transform: translateY(-5px);
   box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
  }

  .navbar {
   padding: 1rem 0;
   background: linear-gradient(to right, #1a1a1a, #2d2d2d) !important;
  }

  .navbar-brand {
   font-size: 1.5rem;
   color: #fff !important;
  }

  .nav-link {
   font-weight: 500;
   padding: 0.5rem 1rem !important;
   color: rgba(255, 255, 255, 0.8) !important;
  }

  .nav-link:hover,
  .nav-link.active {
   color: #fff !important;
  }

  .btn-primary {
   background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);
   border: none;
   padding: 0.75rem 1.5rem;
  }

  .btn-primary:hover {
   background: linear-gradient(45deg, #FD1D1D, #E1306C, #C13584, #833AB4, #5851DB, #405DE6);
  }

  .modal-content {
   border-radius: 15px;
   border: none;
  }

  .modal-header {
   border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  }

  .form-control:focus {
   border-color: #405DE6;
   box-shadow: 0 0 0 0.25rem rgba(64, 93, 230, 0.25);
  }

  .dropdown-menu {
   border-radius: 10px;
   box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
   border: none;
  }

  .dropdown-item {
   padding: 0.5rem 1rem;
  }

  .dropdown-item:hover {
   background-color: #f8f9fa;
  }

  .dropdown-item.text-danger:hover {
   background-color: #dc3545;
   color: white !important;
  }
 </style>
</body>

</html>