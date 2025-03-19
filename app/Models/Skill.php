<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Skill extends Model
{
    public function getSkills($email)
    {
        try {

            $stmt = $this->pdo->prepare("CALL ottieniSkillUtente(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle skill di un utente: " . $e->getMessage());
        }
    }

    public function getCompetences()
    {
        try {

            $stmt = $this->pdo->prepare("CALL ottieniCompetenze()");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle skill di un utente: " . $e->getMessage());
        }
    }

    public function addSkill($email, $nomeCompetenza, $livello)
    {
        try {
            $stmt = $this->pdo->prepare("CALL inserisciSkillCurriculum(:email, :nomeCompetenza, :livello)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nomeCompetenza', $nomeCompetenza);
            $stmt->bindParam(':livello', $livello);
            $stmt->execute();

            return true; // Progetto aggiunto con successo

        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta della skill: " . $e->getMessage());
        }
    }
}
