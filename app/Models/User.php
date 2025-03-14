<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    private $email;
    private $nome;
    private $cognome;
    private $password;
    private $nickname;
    private $annoNascita;
    private $luogoNascita;

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

    public function getProjects()
    {
        try {
            $stmt = $this->pdo->prepare("CALL visualizzaProgetti()");
            $stmt->execute();

            $progetti = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $progetti;
        } catch (\PDOException $e) {
            die("Errore durante il recupero dei progetti: " . $e->getMessage());
        }
    }

    public function addNewProject($nome, $descrizione, $email, $data_limite, $budget, $fileData)
    {
        try {

            $data_inserimento = date("Y-m-d");
            $stato = 'Aperto';

            $stmt = $this->pdo->prepare("CALL Creatore_Inserimento_Progetto(:nome, :descrizione, :data_inserimento, :data_limite, :budget, :stato ,:email, :foto)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descrizione', $descrizione);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':data_limite', $data_limite);
            $stmt->bindParam(':data_inserimento', $data_inserimento);
            $stmt->bindParam(':stato', $stato);
            $stmt->bindParam(':budget', $budget);
            $stmt->bindParam(':foto', $fileData, PDO::PARAM_LOB);
            $stmt->execute();

            return true; // Progetto aggiunto con successo

        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta del progetto: " . $e->getMessage());
        }
    }
}
