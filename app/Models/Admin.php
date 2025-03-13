<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Admin extends Model
{
    private $email;
    private $codiceSicurezza;
    private $password;

    public function authenticate($email, $codiceSicurezza, $password)
    {
        try {
            $stmt = $this->pdo->prepare("CALL autenticazioneAmministratore(:email, :codiceSicurezza)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':codiceSicurezza', $codiceSicurezza, PDO::PARAM_INT);
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['Password'])) {
                return $admin; // Login riuscito, restituisce i dati dell'utente
            }

            return false; // Credenziali errate
        } catch (\PDOException $e) {
            die("Errore durante il login: " . $e->getMessage());
        }
    }

    public function addCompetence($competenceName, $adminEmail)
    {
        try {
            $stmt = $this->pdo->prepare("CALL inserisciCompetenza(:nomeCompetenza, :emailAdmin)");
            $stmt->bindParam(':nomeCompetenza', $competenceName);
            $stmt->bindParam(':emailAdmin', $adminEmail);
            $stmt->execute();

            return true; // Competenza aggiunta con successo
        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta della competenza: " . $e->getMessage() . " Email Admin: " . $adminEmail);
        }
    }

    public function removeCompetence($competenceName, $adminEmail)
    {
        try {
            $stmt = $this->pdo->prepare("CALL rimuoviCompetenza(:nomeCompetenza, :emailAdmin)");
            $stmt->bindParam(':nomeCompetenza', $competenceName);
            $stmt->bindParam(':emailAdmin', $adminEmail);
            $stmt->execute();

            return true; // Competenza rimossa con successo
        } catch (\PDOException $e) {
            die("Errore durante la rimozione della competenza: " . $e->getMessage() . " Email Admin: " . $adminEmail);
        }
    }

    public function getCompetences()
    {
        try {
            $stmt = $this->pdo->prepare("CALL visualizzaCompetenze()");
            $stmt->execute();

            $competences = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $competences;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle competenze: " . $e->getMessage());
        }
    }
}
