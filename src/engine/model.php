<?php

namespace engine;

use database\dbconnector;

abstract class model
{
    protected static $db;

    public function __construct()
    {
        // Inizializza la connessione al database utilizzando dbconnector
        self::$db = dbconnector::getDbConnector();
    }
}
