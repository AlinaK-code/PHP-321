<?php

namespace main\Models\Comments;

use main\Controllers\Interfaces;
use PDO;
use PDOException;

class Comments extends Interfaces
{

    function __construct()
    {
        parent::__construct();
        self::onTableAuth(self::$table_comments);
    }   

    public function addComments(string $content, int $article_id)
    {
        try {
            if (empty($content) || empty($article_id)) {
                error_log('Пожалуйста, заполните все поля');
                return false;
            }

            if ($this->SQL_REQUEST['addComments']->execute([$content, $article_id]))
                return true;
        } catch (PDOException $e) {
            error_log("Ошибка при добавлении комментария: " . $e->getMessage());
            return false;
        }
    }

    public function removeComments(int $id)
    {
        try {
            if (empty($id)) {
                error_log('ID комментария не выбран');
                return false;
            }

            if ($this->SQL_REQUEST['removeComments']->execute([$id]))
                return 'Комментарий успешно удален!';

        } catch (PDOException $e) {
            error_log('Ошибка при удалении комментария: ' . $e->getMessage());
            return false;
        }
    }

    public function getCommentsAll(int $article_id): array|bool
    {
        try {
            if (empty($article_id)) {
                error_log('ID статьи не указан');
                return false;
            }
            
            $this->SQL_REQUEST['getCommentsAll']->execute([$article_id]);
            return $this->SQL_REQUEST['getCommentsAll']->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Ошибка при получении комментариев: ' . $e->getMessage());
            return false;
        }
    }

}