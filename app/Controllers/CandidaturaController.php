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

        $email = $_SESSION['user']['email'];

        $profili = $this->getProfiles($email);
        $this->view('candidatura', ['profili' => $profili]); 
    }

    public function getProfiles($email)
    {
        $profile = new Profile();
        $rows = $profile->getProfiles($email); // Tutti i profili
        
        $grouped_profile = [];
    
        // Raggruppa i profili per nome del progetto
        foreach ($rows as $row) {
            $nomeProgetto = $row['Nome_ProgettoSoftware'];
            $grouped_profile[$nomeProgetto][] = $row;
        }
    
        return $grouped_profile;
    }

    public function addApplication()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nomeProgetto = $_POST['nomeProgetto'];
            $nomeProfilo  = $_POST['nomeProfilo'];
            $email        = $_SESSION['user']['email'];

            $log = new LogModel();
            $profile = new Profile();
            $esito   = $profile->addApplication($email, $nomeProfilo, $nomeProgetto);

            if ($esito === 1) {
                $log->saveLog("CANDIDATURA", "Candidatura inviata con successo", [
                    'email' => $email,
                    'nome_profilo' => $nomeProfilo,
                    'nome_progetto' => $nomeProgetto,
                ]);
                $_SESSION['successCandidatura'] = 'Candidatura inviata correttamente';
            } else {
                $log->saveLog("CANDIDATURA", "Errore nell'invio della candidatura");
                $_SESSION['errorCandidatura'] = 'Candidatura non valida: non possiedi tutte le skill richieste';
            }

            header('Location: ' . URL_ROOT . 'candidatura');
            exit();
        }
    }

}