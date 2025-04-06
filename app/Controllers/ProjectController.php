<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;


class ProjectController extends Controller
{

    public function index()
    {
        $nome_progetto = isset($_GET['nome']) ? $_GET['nome'] : null;

        if ($nome_progetto) {
            $progetto = $this->getProject($nome_progetto);
            $comments = $this->getComments($nome_progetto);

            $this->view('project', ['progetto' => $progetto, 'comments' => $comments]);
        } else {
            $this->view('/');
        }
    }


    public function getProject($nome_progetto)
    {
        $project = new Project();
        $rows = $project->getProject($nome_progetto);

        $progetto = [];

        foreach ($rows as $row) {
            $progetto = [
                'Nome' => $row['Nome'],
                'Descrizione' => $row['Descrizione'],
                'Email_Creatore' => $row['Email_Creatore'],
                'Data_Limite' => $row['Data_Limite'],
                'Budget' => $row['Budget'],
                'Totale_Finanziamenti' => $row['Totale_Finanziamenti'] ?? 0,
                'Foto_Progetto' => []
            ];

            if (!empty($row['Codice_Foto'])) {
                $progetto['Foto_Progetto'][] = "data:image/jpeg;base64," . base64_encode($row['Codice_Foto']);
            }
        }

        return $progetto;
    }


    public function getComments($nome)
    {
        $project = new Project();

        $rows = $project->getProjectComments($nome);
        $comments = [];
        foreach ($rows as $row) {
            $comments[] = [
                'Email' => $row['Email_Utente'],
                'Testo' => $row['Testo'],
                'Data' => $row['Data']
            ];
        }
        return $comments;
    }

    public function addComment($nome)
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $testo = $_POST['testo'];
            $email = $_SESSION['user']['email'];

            if (empty($testo)) {
                $this->view('project', ['error' => 'Il campo testo è obbligatorio']);
                exit();
            }

            $project = new Project();
            $project->addProjectComment($nome, $email, $testo);
        }
    }
}
