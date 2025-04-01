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

        $profili = $rows;

        return array_values($profili);
    }
}