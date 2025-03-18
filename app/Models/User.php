<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    public function register($nome, $cognome, $email, $password, $annoNascita, $luogoNascita, $nickname)
    {
        try {

            $stmt = $this->pdo->prepare("CALL inserisciUtente(:email, :password, :annoNascita, :cognome, :nome, :luogoNascita, :nickname)");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':annoNascita', $annoNascita, PDO::PARAM_INT);
            $stmt->bindParam(':cognome', $cognome);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':luogoNascita', $luogoNascita);
            $stmt->bindParam(':nickname', $nickname);

            $result = $stmt->execute();
            echo "Query eseguita!<br>"; // 🔹 TEST

            return $result;
        } catch (\PDOException $e) {
            die("Errore nella registrazione: " . $e->getMessage());
        }
    }


    public function login($email, $password)
    {
        try {
            $stmt = $this->pdo->prepare("CALL autenticaUtente(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['Password'])) {
                return $user; // Login riuscito, restituisce i dati dell'utente
            }
            return false; // Credenziali errate
        } catch (\PDOException $e) {
            die("Errore durante il login: " . $e->getMessage());
        }
    }
}
