<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\LogModel;


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
        $log = new LogModel();
        $project = new Project();

        if ($project) {
            $log->saveLog("FINANZIAMENTO", "Finanziamento aggiunto con successo", [
                'email' => $_SESSION['user']['email']
            ]);        
        } else {
            $log->saveLog("FINANZIAMENTO", "Errore nell'aggiunta del finanziamento", [
                'email' => $_SESSION['user']['email']
            ]);
        }
        $project->addFinancing($email, $nome_progetto, $importo, $data, $codiceReward);
        header("Location: " . URL_ROOT . "project?nome=" . urlencode($nome_progetto));
        exit();
    }
}
