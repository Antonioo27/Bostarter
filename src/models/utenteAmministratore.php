<?php

namespace models;

use database\dbconnector;
use DateTime;
use engine\model;

class utenteAmministratore extends utente
{

    static function inserisciCompetenza(string $competenza, string $email)
    {
        $query = "CALL inserisciCompetenza('$competenza', '$email')"; 
        return dbconnector::getDbConnector()->query($query);   
    }

    static function autenticazioneAmministratore(string $email, int $codiceSicurezza, )
    {
        $query = "CALL autenticazioneAmministratore('$email', '$codiceSicurezza')"; 
        return dbconnector::getDbConnector()->query($query);   
    }
}