<?php

namespace Main\Controllers;

use main\Config\Database;

class Interfaces
{

	public static $db;//connection
	public $SQL_REQUEST = [];//array
	public static $table_articles = 'articles';
	public static $table_comments = 'comments';
	public static $table_users = 'users';
	public function __construct()
	{
		self::$db = Database::getConnection();
		$this->SET_SQL_REQUEST();
		self::onTableAuth(self::$table_articles);//вызываем функцию проверки таблицы (до занесения данных)
		self::onTableAuth(self::$table_comments);
		self::onTableAuth(self::$table_users);
	}

	////ORM

	public static function onTableAuth(string $name)//автопроверка существования таблиц и колонок
	{
		try {
			switch (strtolower($name)) {
				case 'articles':
				case 'article':
					if (!self::onTableExists(self::$table_articles)) {//false - (не зарегестрирована таблица)
						$sql = "CREATE TABLE IF NOT EXISTS `" . self::$table_articles . "` (
    `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `author` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
						return self::$db->exec($sql);//execute - exec (отправка без параметров напрямую в базу)
					}
					break;
				case 'comments':
					if (!self::onTableExists(self::$table_comments)) {
						$sql = "CREATE TABLE IF NOT EXISTS `" . self::$table_comments . "` (
    `id` int NOT NULL AUTO_INCREMENT,
    `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
    `article_id` int NOT NULL,
    `author` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`article_id`) REFERENCES " . self::$table_articles . "(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
						return self::$db->exec($sql);
					}
					break;

			}//switch

		} catch (\PDOException $e) {
			die("Ошибка PDO при проверке/создании таблицы '$name': " . $e->getMessage());//die - отправка сообщения (echo аналог)
		}
	}

	public static function onTableExists(string $tableName)
	{
		try {
			return self::$db->query("SHOW TABLES LIKE '$tableName'")->rowCount() > 0;//true существует or false несуществует
		} catch (\PDOException $e) {
			error_log("Ошибка при проверке существования таблицы '$tableName': " . $e->getMessage());
			return false;
		}
	}

	public static function onColumnExists(string $columnName, string $tableName)//проверка на существование колонки в таблице
	{
		try {
			$stmt = self::$db->query("SHOW COLUMNS FROM " . $tableName . " LIKE '$columnName'");

			if ($stmt->rowCount() === 0) {
				$sql = "ALTER TABLE " . $tableName . " ADD COLUMN `$columnName` VARCHAR(255)";
				self::$db->exec($sql);
				error_log("Создание новой колонки '$columnName' в таблице '$tableName'");
			}

			return true;
		} catch (\PDOException $e) {
			error_log("Ошибка при проверке/создании колонки '$columnName' в таблице '$tableName': " . $e->getMessage());
			return false;
		}
	}

	public function SET_SQL_REQUEST()
	{
		if (empty($this->SQL_REQUEST)) {
			$this->SQL_REQUEST = [
				//тут везде реализована защита от sql инъекций через подготовленные запросы (PDO), далее при вызове метода $stmt->execute([$content, $article_id]) 
				//PDO автоматически 1) проверяет типы данных и 2) экранирует спец символы 3) Защищает от SQL инъекций
				'addComments' => self::$db->prepare("INSERT INTO " . self::$table_comments . " (content, article_id, author) VALUES (?, ?, 'Alina Kamatali')"),
				'removeComments' => self::$db->prepare("DELETE FROM " . self::$table_comments . " WHERE id = ?"),
				'getCommentsAll' => self::$db->prepare("SELECT * FROM " . self::$table_comments . " WHERE article_id = ? ORDER BY created_at DESC"),

				'addArticle' => self::$db->prepare("INSERT INTO " . self::$table_articles . " (title, content, author) VALUES (?, ?,'@belgoamericangirl')"),
				'removeArticle' => self::$db->prepare("DELETE FROM " . self::$table_articles . " WHERE id = ?"),
				'getArticleAll' => self::$db->prepare("SELECT * FROM " . self::$table_articles),
				'getAllArticleById' => self::$db->prepare("SELECT * FROM " . self::$table_articles . " WHERE id = ?"),
				'getArticleById' => self::$db->prepare("SELECT * FROM " . self::$table_articles . " WHERE id = ? LIMIT 1"),
				'onUpdateArticle' => self::$db->prepare("UPDATE " . self::$table_articles . " SET title = ?, content = ?, created_at = NOW() WHERE id = ?"),
			];
		}
		return $this->SQL_REQUEST;
	}

	public function redirect($url)
	{
		if (!headers_sent()) {//если отправка еще не была
			header("Location: $url", true, 200);
			exit;
		} else {//в случаи переброса повторно принудительно через JS редиректним пользователя
			echo "<script>window.location.href='$url';</script>";
			echo "<noscript><meta http-equiv='refresh' content='0;url=$url'></noscript>";
			exit;
		}
	}
}