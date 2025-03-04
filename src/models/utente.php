<?php

namespace models;

require_once __DIR__ . "/../engine/model.php"; // Percorso corretto se "utente.php" è in "models/"

use database\dbconnector;
use DateTime;
use engine\model;

class utente extends model
{
    static function inserisciUtente(string $mail, string $password, string $nome, string $cognome, int $annoNascita, string $luogoNascita, string $nickname)
    {
        $query = "CALL inserisciUtente('$mail', '$password', $annoNascita, '$cognome', '$nome', '$luogoNascita', '$nickname')";
        return dbconnector::getDbConnector()->query($query);
    }

    static function autenticaUtente(string $email)
    {
        $db = dbconnector::getDbConnector();

        // Prepara la chiamata alla stored procedure
        $stmt = $db->prepare("CALL autenticaUtente(?)");

        if (!$stmt) {
            die("Errore nella preparazione della query: " . $db->error);
        }

        // Associa il parametro alla stored procedure
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Ottieni il risultato
        $result = $stmt->get_result();

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['Password'] ?? null; // Restituisce la password hashata se esiste
        } else {
            return null; // Nessun risultato trovato
        }

        // Chiude lo statement
        $stmt->close();
    }


    static function inserisciSkillCurriculum(string $mail, string $nomeCompetenza, string $livello)
    {
        $query = "CALL inserisciSkillCurriculum('$mail', '$nomeCompetenza', '$livello')";
        return dbconnector::getDbConnector()->query($query);
    }

    static function visualizzaProgetti(string $email)
    {
        $query = "CALL visualizzaProgetti('$email')";
        $result = dbconnector::getDbConnector()->query($query);
        return dbconnector::getDbConnector()->query($query)->fetch_array();
    }

    static function finanziaProgetto(string $email, string $nomeProgetto, float $importo, DateTime $dataFinanziamento, int $codiceReward)
    {
        $query = "CALL finanziaProgetto('$email', $nomeProgetto, $importo, $dataFinanziamento, $codiceReward)";
        return dbconnector::getDbConnector()->query($query);
    }

    static function inserisciCommentoProgetto(string $email, string $nomeProgetto, string $commento, Datetime $data)
    {
        $query = "CALL inserisciCommentoProgetto('$email', '$nomeProgetto', '$commento', '$data')";
        return dbconnector::getDbConnector()->query($query);
    }

    static function assegnaReward(string $email, string $nomeProgetto, int $codiceReward)
    {
        $query = "CALL assegnaReward('$email', '$nomeProgetto', $codiceReward)";
        return dbconnector::getDbConnector()->query($query);
    }

    static function inserisciCandidatura(string $email, string $nomeProgetto)
    {
        $query = "CALL inserisciCandidatura('$email', '$nomeProgetto')";
        return dbconnector::getDbConnector()->query($query);
    }
}
