<?php

namespace main\Models\Articles;

use main\Controllers\Interfaces;
use PDO;
use PDOException;

class Article extends Interfaces
{
    public function addArticle(string $title, string $content)
    {
        try {
            if (empty($title) || empty($content)) {
                error_log('Пожалуйста, заполните все поля');
                return false;
            }

            if ($this->SQL_REQUEST['addArticle']->execute([$title, $content]))
                return 'статья создана';

        } catch (PDOException $e) {
            error_log("Ошибка при создании статьи: " . $e->getMessage());
            return false;
        }
    }

    public function removeArticle(int $id)
    {
        try {
            if (empty($id)) {
                error_log('ID статьи не выбран');
                return false;
            }

            if ($this->SQL_REQUEST['removeArticle']->execute([$id]))
                return 'Статья успешно удалена!';

        } catch (PDOException $e) {
            error_log('Ошибка при удалении статьи: ' . $e->getMessage());
            return false;
        }
    }

    public function getArticleAll(): array|bool
    {
        try {
            $this->SQL_REQUEST['getArticleAll']->execute();//сначала отправим в базу
            return $this->SQL_REQUEST['getArticleAll']->fetchAll(PDO::FETCH_ASSOC);//после уже получаем содержание дабы избежать ошибок несуществующего метода
        } catch (PDOException $e) {
            error_log('Ошибка при получении статей: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllArticleById(int $user_id): array|bool
    {
        try {
            $this->SQL_REQUEST['getAllArticleById']->execute([$user_id]);
            return $this->SQL_REQUEST['getAllArticleById']->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Ошибка при получении статей по ID пользователя: ' . $e->getMessage());
            return false;
        }
    }

    // public function getListMyArticle(int $user_id): array|bool
    // {
    //     try {
    //         $this->SQL_REQUEST['getListMyArticle']->execute([$user_id]);
    //         return $this->SQL_REQUEST['getListMyArticle']->fetchAll(PDO::FETCH_ASSOC);
    //     } catch (PDOException $e) {
    //         error_log('Ошибка при получении статей пользователя: ' . $e->getMessage());
    //         return false;
    //     }
    // }

    public function onUpdateArticle(string $title, string $description, int $id): bool
    {
        try {
            return $this->SQL_REQUEST['onUpdateArticle']->execute([$title, $description, $id]);
        } catch (PDOException $e) {
            error_log('Ошибка при обновлении статьи: ' . $e->getMessage());
            return false;
        }
    }

    public function getArticleById(int $id): array|bool
    {
        try {
            $this->SQL_REQUEST['getArticleById']->execute([$id]);
            return $this->SQL_REQUEST['getArticleById']->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Ошибка при получении статьи: ' . $e->getMessage());
            return false;
        }
    }
}