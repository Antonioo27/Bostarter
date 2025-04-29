<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Project;
use App\Models\LogModel;

class HomeCreatorController extends Controller
{

    public function viewFormNewProject()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $this->view('addProject'); // Mostra il form per aggiungere un nuovo progetto
    }


    public function addNewProject()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $log = new LogModel();

            // Dati progetto
            $nome = $_POST['nome'];
            $descrizione = $_POST['descrizione'];
            $email = $_SESSION['user']['email'];
            $data_limite = $_POST['data_limite'];
            $budget = $_POST['budget'];
            $tipo_progetto = (int)$_POST['tipo_progetto'];

            // Componenti (array multidimensionale)
            $componenti = isset($_POST['componenti']) ? $_POST['componenti'] : [];

            // Foto
            $fotoArray = [];
            if (!empty($_FILES['foto']['name'][0])) {
                foreach ($_FILES['foto']['tmp_name'] as $tmpName) {
                    if ($tmpName) {
                        $fotoArray[] = file_get_contents($tmpName);
                    }
                }
            }

            $project = new Project();
            $result = $project->addNewProject($nome, $descrizione, $email, $data_limite, $budget, $tipo_progetto);

            if ($result) {
                // Se tipo = 1 (Hardware) e sono stati inviati componenti
                if ($tipo_progetto === 1 && !empty($componenti)) {
                    $nomi = $componenti['nome'] ?? [];
                    $descrizioni = $componenti['descrizione'] ?? [];
                    $prezzi = $componenti['prezzo'] ?? [];
                    $quantita = $componenti['quantita'] ?? [];

                    for ($i = 0; $i < count($nomi); $i++) {
                        if (
                            !empty($nomi[$i]) &&
                            isset($descrizioni[$i], $prezzi[$i], $quantita[$i]) &&
                            is_numeric($prezzi[$i]) &&
                            is_numeric($quantita[$i])
                        ) {
                            $project->addComponentToProject(
                                trim($nomi[$i]),
                                trim($descrizioni[$i]),
                                (float)$prezzi[$i],
                                (int)$quantita[$i],
                                $nome
                            );
                        }
                    }
                }

                // Foto
                foreach ($fotoArray as $foto) {
                    $project->addNewFotoProject($foto, $nome);
                }

                // Log e redirect
                $log->saveLog("PROGETTO", "Progetto aggiunto con successo", [
                    "email_utente" => $email,
                    "nome_progetto" => $nome
                ]);

                header("Location: " . URL_ROOT);
                exit();
            } else {
                $log->saveLog("PROGETTO", "ERRORE : Progetto non inserito", [
                    "email_utente" => $email,
                    "nome_progetto" => $nome
                ]);
                echo "Errore durante l'inserimento del progetto.";
            }
        }
    }

}
