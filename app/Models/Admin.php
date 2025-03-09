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
                return $admin; // Login riuscito, restituisce i dati dell'amministratore
            }
            return false; // Credenziali errate
        } catch (\PDOException $e) {
            die("Errore durante il login: " . $e->getMessage());
        }
    }
}
