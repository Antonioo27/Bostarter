<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Project extends Model
{

    public function getProject($nome)
    {
        try {

            $stmt = $this->pdo->prepare("CALL visualizzaProgetto(:nome)");
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (\PDOException $e) {
            die("Errore durante il recupero del progetto: " . $e->getMessage());
        }
    }

    public function getProjects()
    {
        try {

            $stmt = $this->pdo->prepare("CALL visualizzaProgettiConFoto()");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero dei progetti: " . $e->getMessage());
        }
    }


    public function addNewProject($nome, $descrizione, $email, $data_limite, $budget)
    {
        try {
            $data_inserimento = date("Y-m-d");
            $stato = 'Aperto';

            $stmt = $this->pdo->prepare("CALL Creatore_Inserimento_Progetto(:nome, :descrizione, :data_inserimento, :data_limite, :budget, :stato ,:email)");
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descrizione', $descrizione);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':data_limite', $data_limite);
            $stmt->bindParam(':data_inserimento', $data_inserimento);
            $stmt->bindParam(':stato', $stato);
            $stmt->bindParam(':budget', $budget);
            $stmt->execute();

            return true; // Progetto aggiunto con successo

        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta del progetto: " . $e->getMessage());
        }
    }

    public function addNewFotoProject($foto, $nome)
    {
        try {

            $stmt = $this->pdo->prepare("CALL Creatore_Inserimento_FotoProgetto(:nome, :foto)");
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta della foto: " . $e->getMessage());
        }
    }

    public function getProjectComments($nome)
    {
        try {

            $stmt = $this->pdo->prepare("CALL visualizzaCommentiProgetto(:nome)");
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero dei commenti: " . $e->getMessage());
        }
    }

    public function addProjectComment($nome, $email, $testo)
    {
        try {

            $stmt = $this->pdo->prepare("CALL inserisciCommentoProgetto(:email, :nome, :testo, :data)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':testo', $testo);
            $stmt->bindParam(':data', date("Y-m-d"));
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta del commento: " . $e->getMessage());
        }
    }

    // public function financeProject($nome, $email, $importo)
    // {
    //     try {

    //         $stmt = $this->pdo->prepare("CALL finanziaProgetto(:email, :nome, :importo, :data, :reward)");
    //         $stmt->bindParam(':email', $email);
    //         $stmt->bindParam(':nome', $nome);
    //         $stmt->bindParam(':importo', $importo);
    //         $stmt->bindParam(':data', date("Y-m-d"));
    //         $stmt->bindParam(':reward', $reward);
    //         $stmt->execute();

    //         return true;
    //     } catch (\PDOException $e) {
    //         die("Errore durante il finanziamento del progetto: " . $e->getMessage());
    //     }
    // }
}
