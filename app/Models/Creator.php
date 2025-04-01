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

    public function getCreator($email)
    {
        try {
            $stmt = $this->pdo->prepare("CALL Verifica_Ruolo_Utente(:email, @isCreator)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // 2. Legge il valore OUT
            $select = $this->pdo->query("SELECT @isCreator");
            $result = $select->fetchColumn();

            return $result == 1;
        } catch (\PDOException $e) {
            die("Errore durante il recupero del creatore: " . $e->getMessage());
        }
    }
}
