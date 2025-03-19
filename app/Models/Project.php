<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Project extends Model
{
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
}
