<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;


class FinanceController extends Controller
{

    public function addFinancing()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_SESSION['user']['email'];
            $nome_progetto = $_POST['nome_progetto'] ?? null;
            $importo = $_POST['importo'] ?? null;
            $data = date('Y-m-d');
            $codiceReward = $_POST['reward'] ?? null;
        }

        $project = new Project();
        $project->addFinancing($email, $nome_progetto, $importo, $data, $codiceReward);
        header("Location: " . URL_ROOT . "project?nome=" . urlencode($nome_progetto));
        exit();
    }
}
