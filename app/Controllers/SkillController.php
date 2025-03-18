<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Skill;

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

    public function addSkill($email, $nomeCompetenza, $livello)
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $email = $_SESSION['user']['email'];
        $skill = new Skill();
        $result = $skill->addSkill($email, $nomeCompetenza, $livello);

        if ($result) {
            header("Location: " . URL_ROOT . "skill");
            exit();
        } else {
            die("Errore durante l'aggiunta della skill");
        }
    }
}
