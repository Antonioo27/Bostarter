<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Profile extends Model
{
    public function getProfiles($email)
    {
        try {
            $stmt = $this->pdo->prepare("CALL ottieniProfili(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero dei profili di un utente: " . $e->getMessage());
        }
    }
    // {
    //     try {
    //         $stmt = $this->pdo->prepare("CALL ottieniProfili()");
    //         $stmt->execute();
    //         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         return $rows;
    //     } catch (\PDOException $e) {
    //         die("Errore durante il recupero dei profili di un utente: " . $e->getMessage());
    //     }
    // }

    public function addApplication($email, $nomeProfilo, $nomeProgetto)
    {
        try {
            $stmt = $this->pdo->prepare("CALL inserisciCandidatura(:email, :nomeProgetto, :nomeProfilo)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nomeProfilo', $nomeProfilo);
            $stmt->bindParam(':nomeProgetto', $nomeProgetto);
            $stmt->execute();

            return true; // Profilo aggiunto con successo

        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta del profilo: " . $e->getMessage());
        }
    }

}