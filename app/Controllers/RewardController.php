<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\LogModel;


class RewardController extends Controller
{

    public function addReward()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $log = new LogModel();
        $project = new Project();
        $projectsCreator = $project->getCreatorProjects($_SESSION['user']['email']);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $descrizione = $_POST['descrizione'];
            $nome_progetto = $_POST['nome_progetto'];
            $foto = file_get_contents($_FILES['foto']['tmp_name']);


            $result = $project->addReward($descrizione, $nome_progetto, $foto);

            if ($result) {
                $log->saveLog("REWARD", "reward aggiunta correttamente", [
                    'descrizione' => $descrizione,
                    'nome_progetto' => $nome_progetto,
                ]);
            } else {
                $log->saveLog("REWARD", "errore nell'aggiunta della reward");
            }

            $this->view('addReward', ['progetto' => $projectsCreator]);
        } else {
            // Mostra il form per aggiungere una nuova reward
            $this->view('addReward', ['progetti' => $projectsCreator]);
        }
    }
}
