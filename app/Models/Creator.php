<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Creator extends Model
{
    public function register($email)
    {
        try {

            $stmt = $this->pdo->prepare("CALL inserisciCreatore(:email)");

            $stmt->bindParam(':email', $email);

            $result = $stmt->execute();
            echo "Query eseguita!<br>"; // 🔹 TEST

            return $result;
        } catch (\PDOException $e) {
            die("Errore nella registrazione: " . $e->getMessage());
        }
    }
}
