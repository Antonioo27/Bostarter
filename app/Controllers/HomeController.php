<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }
        $progetti = $this->getProgetti();
        $this->view('home', ['progetti' => $progetti]); // Mostra la home solo se l'utente è loggato
    }

    public function getProgetti()
    {
        $user = new User();
        $rows = $user->getProjects(); // Recupera i dati dal Model

        $progetti = [];

        foreach ($rows as $row) {
            $nomeProgetto = $row['Nome'];

            // Se il progetto non è già stato aggiunto, lo inizializziamo
            if (!isset($progetti[$nomeProgetto])) {
                $progetti[$nomeProgetto] = [
                    'Nome' => $row['Nome'],
                    'Descrizione' => $row['Descrizione'],
                    'Email_Creatore' => $row['Email_Creatore'],
                    'Data_Limite' => $row['Data_Limite'],
                    'Budget' => $row['Budget'],
                    'Totale_Finanziamenti' => $row['Totale_Finanziamenti'] ?? 0,
                    'Foto_Progetto' => []
                ];
            }

            if (!empty($row['Codice_Foto'])) {
                $progetti[$nomeProgetto]['Foto_Progetto'][] = "data:image/jpeg;base64," . base64_encode($row['Codice_Foto']);
            }
        }

        return array_values($progetti);
    }



    public function aggiungiProgetto()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Recupera i dati dal form
            $nome = $_POST['nome'];
            $descrizione = $_POST['descrizione'];
            $email = $_SESSION['user']['email'];
            $data_limite = $_POST['data_limite'];
            $budget = $_POST['budget'];

            $fotoArray = [];

            if (!empty($_FILES['foto']['name'][0])) {
                foreach ($_FILES['foto']['tmp_name'] as $tmpName) {
                    if ($tmpName) {
                        $fotoArray[] = file_get_contents($tmpName);
                    }
                }
            }

            $user = new User();
            $result = $user->addNewProject($nome, $descrizione, $email, $data_limite, $budget);

            if ($result) {
                foreach ($fotoArray as $foto) {
                    $user->addNewFotoProject($foto, $nome);
                }
                header("Location: " . URL_ROOT);
                exit();
            } else {
                echo "Errore durante l'inserimento del progetto.";
            }
        }
    }
}
