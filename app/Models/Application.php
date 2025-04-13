<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Application extends Model
{
    public function getApplications($email)
    {
        try {
            $stmt = $this->pdo->prepare("CALL ottieniCandidature(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle candidature: " . $e->getMessage());
        }
    }
    
    public function acceptApplication($email, $nomeProfilo, $nomeProgetto)
    {
        try {
            $stmt = $this->pdo->prepare("CALL accettaCandidatura(:email, :nomeProfilo, :nomeProgetto)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nomeProfilo', $nomeProfilo);
            $stmt->bindParam(':nomeProgetto', $nomeProgetto);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Errore durante l'accettazione della candidatura: " . $e->getMessage());
        }
    }

    public function rejectApplication($email, $nomeProfilo, $nomeProgetto)
    {
        try {
            $stmt = $this->pdo->prepare("CALL rifiutaCandidatura(:email, :nomeProfilo, :nomeProgetto)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nomeProfilo', $nomeProfilo);
            $stmt->bindParam(':nomeProgetto', $nomeProgetto);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Errore durante il rifiuto della candidatura: " . $e->getMessage());
        }
    }
    
}
