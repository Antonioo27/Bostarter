<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Admin extends Model
{
    private $email;
    private $codiceSicurezza;

    public function authenticate($email, $codiceSicurezza)
    {
        try {
            $stmt = $this->pdo->prepare("CALL autenticazioneAmministratore(:email, :codiceSicurezza)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':codiceSicurezza', $codiceSicurezza, PDO::PARAM_INT);
            $stmt->execute();

            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin) {
                return $admin['Email_Amministratore']; // Assicurati che il campo restituito sia corretto
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
}
