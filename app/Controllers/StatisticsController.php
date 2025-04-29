<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Models\Statistic;

class StatisticsController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $statModel = new Statistic();

        $topCreators = $statModel->getTopCreators();
        $topProjects = $statModel->getTopProjects();
        $topFunders  = $statModel->getTopFunders();

        // Passa i dati alla view
        $this->view('stats', [
            'topCreatori' => $topCreators,
            'topProgetti' => $topProjects,
            'topFinanziatori' => $topFunders
        ]);
    }
}

