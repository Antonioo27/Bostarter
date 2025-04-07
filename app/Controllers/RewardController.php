<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;


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

        $project = new Project();
        $projectsCreator = $project->getCreatorProjects($_SESSION['user']['email']);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $descrizione = $_POST['descrizione'];
            $nome_progetto = $_POST['nome_progetto'];
            $foto = file_get_contents($_FILES['foto']['tmp_name']);


            $result = $project->addReward($descrizione, $nome_progetto, $foto);

            $this->view('addReward', ['progetto' => $projectsCreator]);
        } else {
            // Mostra il form per aggiungere una nuova reward
            $this->view('addReward', ['progetti' => $projectsCreator]);
        }
    }
}
