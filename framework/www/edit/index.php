<?php
$title = 'Edit Article';

use main\Models\Articles\Article;
use main\Controllers\Interfaces;

// Get article ID from URL path
$article_id = isset($_GET['route']) ? (int) explode('/', $_GET['route'])[1] : 0;

// Get article data
$article = (new Article())->getArticleById($article_id);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = $_POST['name'];
	$content = $_POST['content'];
	(new Article())->onUpdateArticle($name, $content, $article_id);
	header('Location: /');
	exit;
}

// If article not found, redirect to home
if (!$article) {
	header('Location: /');
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo htmlspecialchars($article['title']); ?>	- Edit - Kamatali</title>
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Bootstrap Icons -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="/../../www/assets/css/style.css">
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
							<h2 class="card-title h4 mb-0">Edit Article</h2>
							<a href="/articles/<?php echo $article_id; ?>" class="btn btn-outline-secondary btn-sm">
								<i class="bi bi-arrow-left me-2"></i>Back to Article
							</a>
						</div>
						<form class="article-form" action="/edit/<?php echo $article_id; ?>" method="POST">
							<div class="mb-4">
								<label for="article-name" class="form-label">Article Title</label>
								<input type="text" class="form-control" id="article-name" name="name" required
									value="<?php echo htmlspecialchars($article['title']); ?>"
									placeholder="Enter article title">
							</div>
							<div class="mb-4">
								<label for="article-description" class="form-label">Content</label>
								<textarea class="form-control" id="article-description" name="content" required
									placeholder="Write your article content"
									rows="6"><?php echo htmlspecialchars($article['content']); ?></textarea>
							</div>
							<div class="d-flex gap-2">
								<button type="submit" class="btn btn-primary">
									<i class="bi bi-save me-2"></i>Save Changes
								</button>
								<a href="/articles/<?php echo $article_id; ?>" class="btn btn-outline-secondary">
									<i class="bi bi-x-circle me-2"></i>Cancel
								</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

</html>