<?php

namespace App\Core;


use PDO;
use PDOException;
use MongoDB\Client;

abstract class Model
{
    protected $pdo;
    protected $mongo;
    protected $useMongoDB = false;

    public function __construct($useMongoDB = false)
    {
        $this->useMongoDB = $useMongoDB;
        if ($this->useMongoDB) {
            $this->connectMongoDB();
        } else {
            $this->connectMySQL();
        }
    }

    private function connectMySQL()
    {
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            die("Errore di connessione MySQL: " . $e->getMessage());
        }
    }

    private function connectMongoDB()
    {
        try {
            $host = "localhost"; // Cambia se necessario
            $port = "27017";
            $databaseName = "Bostarter"; // Sostituiscilo con il nome del tuo database

            $this->mongo = new Client("mongodb://$host:$port");
            $this->mongo = $this->mongo->$databaseName;
        } catch (\Exception $e) {
            die("Errore di connessione MongoDB: " . $e->getMessage());
        }
    }

    public function getMongoCollection($collectionName)
    {
        if (!$this->useMongoDB) {
            throw new \Exception("MongoDB non è abilitato per questo modello.");
        }
        return $this->mongo->$collectionName;
    }
}
