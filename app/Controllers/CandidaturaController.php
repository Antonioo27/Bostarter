<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\LogModel;
use App\Models\Project;

class CandidaturaController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }
        $profili = $this->getProfiles();
        $this->view('candidatura', ['profili' => $profili]); 
    }

    public function getProfiles()
    {
        $profile = new Profile();
        $rows = $profile->getProfiles(); // Recupera i dati dal Model

        $profili = [];

        foreach ($rows as $row) {
            $nomeProgetto = $row['Nome_Progetto'];

            // Se il progetto non è già stato aggiunto, lo inizializziamo
            if (!isset($profili[$nomeProgetto])) {
                $profili[$nomeProgetto] = [
                    'Nome_Progetto' => $row['Nome_Progetto'],
                    'Nome' => $row['Nome'],
                ];
            }
        }

        return array_values($profili);
    }
}