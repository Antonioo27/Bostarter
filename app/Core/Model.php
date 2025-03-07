<?php

namespace App\Core;

use PDO;
use PDOException;

abstract class Model
{
    protected $pdo;

    public function __construct()
    {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false // 🔹 Evita problemi con le stored procedures
            ]);
        } catch (PDOException $e) {
            die("Errore di connessione: " . $e->getMessage());
        }
    }
}
