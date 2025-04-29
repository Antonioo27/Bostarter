<?php

namespace App\Models;

use App\Core\Model;

class Statistic extends Model
{
    public function getTopCreators()
    {
        try {
            $stmt = $this->pdo->query("SELECT Nickname FROM ClassificaUtentiCreatori");
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\PDOException $e) {
            die("Errore nel recupero dei creatori: " . $e->getMessage());
        }
    }

    public function getTopProjects()
    {
        try {
            $stmt = $this->pdo->query("SELECT Nome FROM ProgettiViciniCompletamento");
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\PDOException $e) {
            die("Errore nel recupero dei progetti: " . $e->getMessage());
        }
    }

    public function getTopFunders()
    {
        try {
            $stmt = $this->pdo->query("SELECT Nickname FROM ClassificaUtentiFinanziatori");
            return $stmt->fetchAll(\PDO::FETCH_COLUMN);
        } catch (\PDOException $e) {
            die("Errore nel recupero dei finanziatori: " . $e->getMessage());
        }
    }
}

