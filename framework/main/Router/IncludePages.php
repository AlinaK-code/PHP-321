<?php

namespace main\Router;

use main\Controllers\Interfaces;
use main\Models\Articles\Article;
use main\Models\Comments\Comments;

class IncludePages extends Interfaces
{
    public function main()
    {
        include dirname(__DIR__, 2) . '/www/home/index.php';
    }

    public function edit()
    {
        include dirname(__DIR__, 2) . '/www/edit/index.php';
    }

    public function delete()//мы сразу обрабатываю удаление и вернем пользователя на главную
    {
        $article_id = isset($_GET['route']) ? (int) explode('/', $_GET['route'])[1] : 0;
        if ($article_id > 0) {
            (new Article())->removeArticle($article_id);
            header('Location: /');
        }
        exit;
    }

    public function deleteComment()
    {
        $comment_id = isset($_GET['route']) ? (int) explode('/', $_GET['route'])[1] : 0;
        $article_id = isset($_GET['article_id']) ? (int) $_GET['article_id'] : 0;
        
        if ($comment_id > 0) {
            (new Comments())->removeComments($comment_id);
            // Redirect back to the article page
            if ($article_id > 0) {
                header('Location: /articles/' . $article_id);
            } else {
                header('Location: /');
            }
            exit;
        }
        header('Location: /');
        exit;
    }
    public function viewArticle()
    {
        include dirname(__DIR__, 2) . '/www/articles/index.php';
    }
    public function viewComments()
    {
        include dirname(__DIR__, 2) . '/www/comments/index.php';
    }

    public function error404()
    {
        include dirname(__DIR__, 1) . '/router/View/error/404.php';
    }
}