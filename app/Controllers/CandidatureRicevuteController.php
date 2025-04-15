<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\LogModel;
use App\Models\Project;
use App\Models\Application; 


class CandidatureRicevuteController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $email = $_SESSION['user']['email'];

        $listaCandidature = $this->getApplications($email);
        $this->view('candidatureRicevute', ['candidatureRicevute' => $listaCandidature]); 
    }

    public function getApplications($email)
    {
        $application = new Application();
        $rows = $application->getApplications($email); 
        
        $grouped_candidature = [];

        // Raggruppa le candidature per nome del progetto
        foreach ($rows as $row) {
            $nomeProgetto = $row['Nome_Progetto'];
            $grouped_candidature[$nomeProgetto][] = $row;
        }

        return $grouped_candidature;
    }

    public function acceptApplication()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomeProgetto = $_POST['nomeProgetto'];
            $emailUtente = $_POST['email'];
            $nomeProfilo = $_POST['nomeProfilo'];
            
            $application = new Application();
            $application->acceptApplication($emailUtente, $nomeProfilo, $nomeProgetto);
            
            // Reindirizza alla pagina di home
            header("Location: " . URL_ROOT . "home");
            exit();
        }
    }

    public function rejectApplication()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomeProgetto = $_POST['nomeProgetto'];
            $emailUtente = $_POST['email'];
            $nomeProfilo = $_POST['nomeProfilo'];
            
            $application = new application();
            $application->rejectApplication($emailUtente, $nomeProfilo, $nomeProgetto);
            
            // Reindirizza alla pagina di candidatura
            header("Location: " . URL_ROOT . "home");
            exit();
        }
    }
    

}

