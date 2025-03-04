<?php

namespace models;

use database\dbconnector;
use DateTime;
use engine\model;

class utenteCreatore extends utente
{

    static function CreatoreInserimentoProgetto(string $nomeProgetto, string $descrizioneProgetto, datetime $dataInizio, datetime $dataFine, float $budget, string $statoProgetto ,string $ematl)
    {
        $query = "CALL Creatore_Inserimento_Progetto('$nomeProgetto', '$descrizioneProgetto', '$dataInizio', '$dataFine', '$budget', '$statoProgetto', '$ematl')"; 
        return dbconnector::getDbConnector()->query($query);   
    }

    static function CreatoreInserimentoReward(int $codiceReward, string $descrizioneReward, longblob $fotoReward, string $nomeProgetto)
    {
        $query = "CALL Creatore_Inserimento_Reward('$codiceReward', '$descrizioneReward', '$fotoReward', '$nomeProgetto')"; 
        return dbconnector::getDbConnector()->query($query);   
    }

    static function CreatoreInserimentoRisposta(int $idCommento, string $testoRisposta, string $ematl)
    {
        $query = "CALL Creatore_Inserimento_Risposta('$idCommento', '$testoRisposta', '$ematl')"; 
        return dbconnector::getDbConnector()->query($query);   
    }

    static function CreatoreInserimentoProfilo(string $nomeProgetto, string $nomeProfilo){
        $query = "CALL Creatore_Inserimento_Profilo('$nomeProgetto', '$nomeProfilo')"; 
        return dbconnector::getDbConnector()->query($query);   
    }

    static function CreatoreAccettazioneCandidatura(string $email, string $nomeProfilo){
        $query = "CALL Creatore_Accettazione_Candidatura('$email', '$nomeProfilo')"; 
        return dbconnector::getDbConnector()->query($query)->fetch_array();   
    }
}