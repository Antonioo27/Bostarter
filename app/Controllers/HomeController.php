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
        $progetti = $user->getProjects();
    
        // Itera su tutti i progetti e converte l'immagine in Base64
        foreach ($progetti as &$progetto) {
            if (!empty($progetto['Codice_Foto'])) {
                $progetto['Codice_Foto'] = "data:image/jpeg;base64," . base64_encode($progetto['Codice_Foto']);
            } else {
                // Immagine di default se il progetto non ha foto
                $progetto['Codice_Foto'] = "public/image/placeholder.png";
            }
        }
    
        return $progetti;
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
            $email = $_POST['email'];
            $data_limite = $_POST['data_limite'];
            $budget = $_POST['budget'];
        
            // Verifica se è stato caricato un file
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
                // Ottieni informazioni sul file
                $fileTmpName = $_FILES['foto']['tmp_name'];
        
                // Legge i dati dell'immagine come binario
                $fileData = file_get_contents($fileTmpName);
        


                $User = new User();
                $result = $User->addNewProject($nome, $descrizione, $email, $data_limite, $budget, $fileData);
                if ($result) {
                    header("Location: " . URL_ROOT);
                    exit();
                }
                } else {
                echo "Errore: nessun file caricato.";
            }
        }
    }


}
