<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Skill;
use App\Models\LogModel;

class SkillController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }
        $competenze = $this->getCompetenze();
        $skill = $this->getSkills($_SESSION['user']['email']);
        $this->view('skill', ['competenze' => $competenze, 'skill' => $skill]); // Mostra la home solo se l'utente è loggato
    }

    public function getCompetenze()
    {
        $skill = new Skill();
        $rows = $skill->getCompetences(); // Recupera i dati dal Model

        $competenze = [];

        foreach ($rows as $row) {
            $competenze[] = [
                'Nome' => $row['Nome'],
            ];
        }

        return array_values($competenze);
    }



    public function getSkills($email)
    {
        $skill = new Skill();
        $rows = $skill->getSkills($email); // Recupera i dati dal Model

        $skills = []; // Array vuoto

        foreach ($rows as $row) {
            $skills[] = [
                'NomeCompetenza' => $row['Nome_Competenza'],
                'Livello' => $row['Livello'],
            ];
        }

        return $skills; // Restituisce tutte le competenze

    }

    public function addSkill()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nomeCompetenza = $_POST['nome_competenza'] ?? '';
            $livello        = $_POST['livello']        ?? '';
            $email          = $_SESSION['user']['email'];
            
            if (empty($nomeCompetenza) || empty($livello)) {
                $_SESSION['skillError'] = 'Devi selezionare competenza e livello.';
                header("Location: " . URL_ROOT . "skill");
                exit();
            }
            
            $log = new LogModel();
            $skill = new Skill();
            $esito = $skill->addSkill($email, $nomeCompetenza, $livello);

            if ($esito === 1) {
                $log->saveLog("SKILL", "SUCCESSO: Skill inserita correttamente", [
                    'skill' => $skill,
                    'email' => $_SESSION['user']['email']
                ]);
                $_SESSION['skillSuccess'] = 'Skill aggiunta con successo!';
            } elseif ($esito === -1) {
                $log->saveLog("SKILL", "ERRORE: Skill già presente", [
                    'email' => $_SESSION['user']['email']
                ]);
                $_SESSION['skillError'] = 'Questa skill è già presente nel tuo curriculum.';
            } else {
                $log->saveLog("SKILL", "ERRORE: Skill non inserita", [
                    'email' => $_SESSION['user']['email']
                ]);
                $_SESSION['skillError'] = 'Errore imprevisto durante l’inserimento.';
            }

            header("Location: " . URL_ROOT . "skill");
            exit();
        }
    }

}
