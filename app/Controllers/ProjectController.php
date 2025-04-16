<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;


class ProjectController extends Controller
{

    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $nome_progetto = isset($_GET['nome']) ? $_GET['nome'] : null;

        if ($nome_progetto) {
            $progetto = $this->getProject($nome_progetto);
            $comments = $this->getComments($nome_progetto);
            $reply = $this->getReply($nome_progetto);

            $this->view('project', ['progetto' => $progetto, 'comments' => $comments, 'reply' => $reply]);
        } else {
            $this->view('/');
        }
    }

    public function getFinancePage()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $nome_progetto = isset($_GET['nome']) ? $_GET['nome'] : null;

        if ($nome_progetto) {
            $progetto = $this->getProject($nome_progetto);
            $rewardsProgetto = $this->getRewardsProject($nome_progetto);
            $this->view('projectFinance', ['progetto' => $progetto, 'rewards' => $rewardsProgetto]);
        } else {
            $this->view('/');
        }
    }

    public function getCreatorProjects()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $email = $_SESSION['user']['email'];
        $project = new Project();
        $rows = $project->getCreatorProjects($email);

        $progetti = [];

        foreach ($rows as $row) {
            $progetti[] = [
                'Nome' => $row['Nome'],
                'Descrizione' => $row['Descrizione'],
                'Email_Creatore' => $row['Email_Creatore'],
                'Data_Limite' => $row['Data_Limite'],
                'Budget' => $row['Budget'],
                'Totale_Finanziamenti' => $row['Totale_Finanziamenti'] ?? 0,
                'Foto_Progetto' => []
            ];

            if (!empty($row['Codice_Foto'])) {
                $progetti[count($progetti) - 1]['Foto_Progetto'][] = "data:image/jpeg;base64," . base64_encode($row['Codice_Foto']);
            }
        }

        return $progetti;
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

    public function getRewardsProject($nome_progetto)
    {
        $project = new Project();
        $rows = $project->getRewardsProject($nome_progetto);

        $rewards = [];

        foreach ($rows as $row) {
            $rewards[] = [
                'codice' => $row['Codice'],
                'descrizione' => $row['Descrizione'],
                'foto' => $row['Foto'],
                'nome_progetto' => $row['Nome_Progetto'],
            ];
        }

        return $rewards;
    }


    public function getComments($nome)
    {
        $project = new Project();

        $rows = $project->getProjectComments($nome);
        $comments = [];
        foreach ($rows as $row) {
            $comments[] = [
                'ID' => $row['ID'],
                'Email' => $row['Email_Utente'],
                'Testo' => $row['Testo'],
                'Reply' => $row['Reply'],
                'Data' => $row['Data']
            ];
        }
        return $comments;
    }

    public function addComment()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $nome_progetto = isset($_GET['nome']) ? $_GET['nome'] : null;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $testo = $_POST['testo'];
            $email = $_SESSION['user']['email'];

            if (empty($testo)) {
                $this->view('project', ['error' => 'Il campo testo è obbligatorio']);
                exit();
            }

            $project = new Project();
            $project->addProjectComment($nome_progetto, $email, $testo);
            header("Location: " . URL_ROOT . "project?nome=" . urlencode($nome_progetto));
            exit();
        }
    }

    public function getReply($nome_progetto)
    {
        $project = new Project();
        $rows = $project->getReply($nome_progetto);

        $reply = [];

        foreach ($rows as $row) {
            $reply[] = [
                'Email' => $row['Email_Creatore'],
                'Testo' => $row['Testo'],
                'Data' => $row['Data']
            ];
        }

        return $reply;
    }

    public function addReplyComment()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $commentID = isset($_GET['comment_id']) ? $_GET['comment_id'] : null;
        $nome_progetto = isset($_GET['nome']) ? $_GET['nome'] : null;


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $testo = $_POST['reply_text'];
            $email = $_SESSION['user']['email'];

            if (empty($testo)) {
                $this->view('project', ['error' => 'Il campo testo è obbligatorio']);
                exit();
            }

            $project = new Project();
            $project->addReplyComment($commentID, $email, $testo);
            header("Location: " . URL_ROOT . "project?nome=" . urlencode($nome_progetto));
            exit();
        }
    }
}
