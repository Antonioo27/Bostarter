<?php

namespace models;

require_once __DIR__ . "/../engine/model.php"; // Percorso corretto se "utente.php" è in "models/"

use database\dbconnector;
use DateTime;
use engine\model;

class utente extends model
{
    static function inserisciUtente(string $luogoNascita, string $mail, string $password, int $annoNascita, string $cognome, string $nome, string $nickname)
    {
        $query = "CALL inserisciUtente('$mail', '$password', $annoNascita, '$cognome', '$nome', '$luogoNascita', '$nickname')";
        return dbconnector::getDbConnector()->query($query);
    }


    static function autenticaUtente(string $email)
    {
        $db = dbconnector::getDbConnector();

        // Esegui la stored procedure direttamente
        $result = $db->query("CALL autenticaUtente('$email')");

        // Se c'è un risultato, restituisce la password, altrimenti null
        return ($result && $row = $result->fetch_assoc()) ? $row['Password'] : null;
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
