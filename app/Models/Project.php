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

    public function getCreatorProjects($email)
    {
        try {

            $stmt = $this->pdo->prepare("CALL visualizzaProgettiCreatore(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero dei progetti: " . $e->getMessage());
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

    public function addProjectComment($nome_progetto, $email, $testo)
    {
        try {

            $stmt = $this->pdo->prepare("CALL inserisciCommentoProgetto(:email, :nome, :testo, :data)");
            $data = date("Y-m-d");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nome', $nome_progetto);
            $stmt->bindParam(':testo', $testo);
            $stmt->bindParam(':data', $data);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta del commento: " . $e->getMessage());
        }
    }

    public function addFinancing($email, $nome, $importo, $data, $idReward)
    {
        try {

            $stmt = $this->pdo->prepare("CALL finanziaProgetto(:email, :nome, :importo, :data, :idReward)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':importo', $importo);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':idReward', $idReward);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Errore durante il finanziamento del progetto: " . $e->getMessage());
        }
    }

    public function getRewardsProject($nome_progetto)
    {
        try {

            $stmt = $this->pdo->prepare("CALL visualizzaRewardsProgetto(:nome_progetto)");
            $stmt->bindParam(':nome_progetto', $nome_progetto);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle ricompense: " . $e->getMessage());
        }
    }

    public function addReward($descrizione, $nome_progetto, $foto)
    {
        try {

            $stmt = $this->pdo->prepare("CALL Creatore_Inserimento_Reward(:descrizione, :foto, :nome_progetto)");
            $stmt->bindParam(':descrizione', $descrizione);
            $stmt->bindParam(':nome_progetto', $nome_progetto);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta della ricompensa: " . $e->getMessage());
        }
    }

    public function getReply($nome_progetto)
    {
        try {
            $stmt = $this->pdo->prepare("CALL visualizzaRisposteProgetto(:nome_progetto)");
            $stmt->bindParam(':nome_progetto', $nome_progetto);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle risposte: " . $e->getMessage());
        }
    }

    public function addReplyComment($commentID, $email, $reply_text)
    {
        try {
            $stmt = $this->pdo->prepare("CALL Creatore_Inserimento_Risposta(:commentID, :reply_text, :email)");
            $stmt->bindParam(':commentID', $commentID);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':reply_text', $reply_text);
            $stmt->execute();

            return true;
        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta della risposta: " . $e->getMessage());
        }
    }
}
