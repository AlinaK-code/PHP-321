<?php
$title = 'Article View';

use main\Models\Articles\Article;
use main\Controllers\Interfaces;
use main\Models\Comments\Comments;

// получаем id статьи из URL
$article_id = isset($_GET['route']) ? (int) explode('/', $_GET['route'])[1] : 0;//id post

// получаем данные статьи
$article = (new Article())->getArticleById($article_id);

// Если не нашел коментарий, то перенаправь на главную
if (!$article) {
	(new Interfaces())->redirect('/');
	exit;
}

$comments = (new Comments())->getCommentsAll($article_id);

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['content'])) {
	$content = trim($_POST['content']);
	if (!empty($content)) {
		if ((new Comments())->addComments($content, $article_id)) {
			// Обновляем страницу чтобы показать новый комментарий
			header("Location: /articles/" . $article_id);
			exit;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo htmlspecialchars($article['title']); ?> - Kamatali</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link href="/../../www/assets/css/style.css" rel="stylesheet">
</head>

<body>
	<!-- Navigation -->
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
						<a class="nav-link" href="/">
							<i class="bi bi-house-door me-1"></i>Home
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" href="/articles">
							<i class="bi bi-newspaper me-1"></i>Articles
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/about">
							<i class="bi bi-info-circle me-1"></i>About
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/contact">
							<i class="bi bi-envelope me-1"></i>Contact
						</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Main Content -->
	<div class="container py-5 mt-5">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="card shadow-sm page-transition">
					<div class="card-body p-4">
						<div class="d-flex justify-content-between align-items-center mb-4">
							<h1 class="card-title h3 mb-0"><?php echo htmlspecialchars($article['title']); ?></h1>
							<div class="dropdown">
								<button class="btn btn-outline-secondary btn-sm" type="button"
									data-bs-toggle="dropdown">
									<i class="bi bi-three-dots-vertical"></i>
								</button>
								<ul class="dropdown-menu dropdown-menu-end">
									<li>
										<a class="dropdown-item" href="/edit/<?php echo $article_id; ?>">
											<i class="bi bi-pencil me-2"></i>Edit
										</a>
									</li>
									<li>
										<a class="dropdown-item text-danger" href="/delete/<?php echo $article_id; ?>"
											onclick="return confirm('Are you sure you want to delete this article?')">
											<i class="bi bi-trash me-2"></i>Delete
										</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="article-meta text-muted mb-4">

							<p class="author"><?php echo htmlspecialchars($article['author']); ?></p>
							<small>
								<i class="bi bi-clock me-1"></i>Published on
								<?php echo date('F j, Y', strtotime($article['created_at'])); ?>
							</small>
						</div>
						<div class="article-content">
							<?php echo nl2br(htmlspecialchars($article['content'])); ?>
						</div>
						<div class="mt-4">
							<a href="/" class="btn btn-outline-secondary">
								<i class="bi bi-arrow-left me-2"></i>На главную
							</a>
						</div>



						<!-- Comments Section -->
						<div class="mt-5">
							<h3 class="h4 mb-4">Комментарии</h3>
							
							<!-- Comment Form -->
							<div class="card mb-4">
								<div class="card-body">
									<form method="post" class="mb-0">
										<div class="mb-3">
											<textarea class="form-control" name="content" rows="3" placeholder="Место для вашего комментария..." required></textarea>
										</div>
										<button type="submit" class="btn btn-primary">
											<i class="bi bi-chat-dots me-2"></i>Добавить комментарий
										</button>
									</form>
								</div>
							</div>

							<!-- Comments List -->
							<?php if ($comments && count($comments) > 0): ?>
								<?php foreach ($comments as $comment): ?>
									<div class="card mb-3">
										<div class="card-body">
											<div class="d-flex justify-content-between align-items-start">
												<div>
													<h6 class="mb-1"><?php echo htmlspecialchars($comment['author']); ?></h6>
													<small class="text-muted">
														<i class="bi bi-clock me-1"></i>
														<?php echo date('F j, Y g:i A', strtotime($comment['created_at'])); ?>
													</small>
												</div>
												<a href="/deleteComment/<?php echo $comment['id']; ?>?article_id=<?php echo $article_id; ?>" 
												   class="btn btn-sm btn-outline-danger" 
												   onclick="return confirm('Вы уверены, что хотите удалить этот комментарий?')">
													<i class="bi bi-trash"></i>
												</a>
											</div>
											<p class="mt-3 mb-0"><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
										</div>
									</div>
								<?php endforeach; ?>
							<?php else: ?>
								<div class="text-center text-muted">
									<i class="bi bi-chat-dots display-4"></i>
									<p class="mt-2">Комментариев пока нет. Будьте первым!</p>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>