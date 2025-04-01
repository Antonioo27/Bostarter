<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\LogModel;

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
        $project = new Project();
        $rows = $project->getProjects(); // Recupera i dati dal Model

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




    public function infoCreator()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $this->view('infoCreatori'); // Mostra la home solo se l'utente è loggato
    }
}
