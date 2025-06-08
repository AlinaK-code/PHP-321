<?php

namespace main\Config;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
   // Параметры подключения к базе данных
   private const DB_HOST = 'database';
   private const DB_PORT = '3306';
   private const DB_USERNAME = 'docker';
   private const DB_PASSWORD = 'docker';
   private const DB_NAME = 'docker';
   private static $instance = [];

   public static function getConnection()
   {
      if (empty(self::$instance)) {
         try {
            $dsn = "mysql:host=" . self::DB_HOST .
               ";port=" . self::DB_PORT .
               ";dbname=" . self::DB_NAME .
               ";charset=utf8mb4";

            self::$instance = new PDO($dsn, self::DB_USERNAME, self::DB_PASSWORD, [
                  // Включает режим исключений для обработки ошибок PDO
               PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                  // Устанавливает режим выборки данных по умолчанию - ассоциативный массив
               PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
               PDO::ATTR_EMULATE_PREPARES => false
            ]);

            return self::$instance;
         } catch (PDOException $e) {
            throw new RuntimeException('Database connection error: ' . $e->getMessage());
         }
      }
      return self::$instance;
   }

   public static function closeConnection()
   {
      self::$instance = [];
   }

   // public static function query($sql, $params = [])
   // {
   //    try {
   //       $stmt = self::getConnection()->prepare($sql);

   //       if (stripos($sql, 'INSERT INTO') !== false || stripos($sql, 'UPDATE') !== false || stripos($sql, 'DELETE FROM') !== false) {
   //          $tableName = self::extractTableName($sql);
   //          if ($tableName) {
   //             $checkTable = self::getConnection()->query("SHOW TABLES LIKE '$tableName'");
   //             if ($checkTable->rowCount() === 0) {
   //                throw new PDOException("Table '$tableName' does not exist");
   //             }
   //          }
   //       }

   //       $result = $stmt->execute($params);
   //       return $stmt;
   //    } catch (PDOException $e) {
   //       throw new RuntimeException('Query execution error: ' . $e->getMessage());
   //    }
   // }

   private static function extractTableName($sql)
   {
      if (preg_match('/(?:FROM|INTO|UPDATE)\s+`?(\w+)`?/i', $sql, $matches)) {
         return $matches[1];
      }
      return null;
   }
}