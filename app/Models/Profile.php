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

            return true; 

        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta del profilo: " . $e->getMessage());
        }
    }

    public function addProfile($nomeProfilo, $nomeProgetto, $competenze)
    {
        try {

            // Prima inserisci il profilo richiesto
            $stmt = $this->pdo->prepare("CALL aggiungiProfiloRichiesto(:nomeProfilo, :nomeProgetto)");
            $stmt->bindParam(':nomeProfilo', $nomeProfilo);
            $stmt->bindParam(':nomeProgetto', $nomeProgetto);
            $stmt->execute();

            // Poi inserisci le skill richieste per quel profilo
            foreach ($competenze as $comp) {
                $stmtSkill = $this->pdo->prepare("
                    INSERT INTO SKILL_RICHIESTE (Nome_Profilo, Nome_Progetto, Nome_Competenza, Livello)
                    VALUES (:nomeProfilo, :nomeProgetto, :nomeCompetenza, :livello)
                ");
                $stmtSkill->bindParam(':nomeProfilo', $nomeProfilo);
                $stmtSkill->bindParam(':nomeProgetto', $nomeProgetto);
                $stmtSkill->bindParam(':nomeCompetenza', $comp['nome']);
                $stmtSkill->bindParam(':livello', $comp['livello']);
                $stmtSkill->execute();
            }

            return true;

        } catch (\PDOException $e) {
            die("Errore durante l'inserimento del profilo richiesto: " . $e->getMessage());
        }
    }



}