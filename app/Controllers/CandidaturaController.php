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
        $rows = $profile->getProfiles(); // Tutti i profili
        
        $grouped_profile = [];
    
        // Raggruppa i profili per nome del progetto
        foreach ($rows as $row) {
            $nomeProgetto = $row['Nome_Progetto'];
            $grouped_profile[$nomeProgetto][] = $row;
        }
    
        return $grouped_profile;
    }
}