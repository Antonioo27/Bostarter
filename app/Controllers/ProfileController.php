<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\Profile;
use App\Models\LogModel;
use App\Models\Skill;


class ProfileController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        // Carica i progetti del creatore loggato per il form
        $competenze = $this->getCompetenze();
        $progetti = $this->getCreatorProjectsSW();

        $this->view('addProfile', ['progetti' => $progetti, 'competenze' => $competenze]);
    }

    public function addProfile()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_profilo = $_POST['nome_profilo'] ?? null;
            $progetto = $_POST['progetto'] ?? null;
            $skills = $_POST['skills'] ?? [];
            $livelli = $_POST['livelli'] ?? [];

            if (empty($nome_profilo) || empty($progetto) || empty($skills) || empty($livelli)) {
                die("Tutti i campi sono obbligatori.");
            }

            $competenze = [];
            for ($i = 0; $i < count($skills); $i++) {
                $competenze[] = [
                    'nome' => $skills[$i],
                    'livello' => $livelli[$i],
                ];
            }

            $profile = new Profile();
            $log = new LogModel();

            $result = $profile->addProfile($nome_profilo, $progetto, $competenze);

            if ($result) {
                $log->saveLog("PROFILO", "Profilo inserito con successo", [
                    'nome_profilo' => $nome_profilo,
                    'progetto' => $progetto,
                    'email' => $_SESSION['user']['email']
                ]);
                header("Location: " . URL_ROOT);
                exit();
            } else {
                $log->saveLog("PROFILO", "ERRORE: Inserimento fallito", [
                ]);
                die("Errore durante l'inserimento del profilo.");
            }
        } else {
            header("Location: " . URL_ROOT . "insertProfile");
        }
    }

    public function getCompetenze()
    {
        $skill = new Skill();
        $rows = $skill->getCompetences(); // Recupera i dati dal Model

        $competenze = [];

        foreach ($rows as $row) {
            $competenze[] = [
                'Nome' => $row['Nome'],
            ];
        }

        return array_values($competenze);
    }

    public function getCreatorProjectsSW() 
    {

        $project = new Project();
        $rows = $project->getCreatorProjectsSW($_SESSION['user']['email']); // Recupera i dati dal Model

        $progetti = [];

        foreach ($rows as $row) {
            $progetti[] = [
                'Nome' => $row['Nome']
            ];
        }

        return array_values($progetti);
    }

    
}
