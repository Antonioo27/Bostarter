<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Profile;
use App\Models\LogModel;
use App\Models\Project;
use App\Models\Application; 


class CandidatureRicevuteController extends Controller
{
    public function index()
    {
        session_start();

        if (!isset($_SESSION['user'])) {
            // Se l'utente non è loggato, reindirizzalo alla pagina di login
            header("Location: " . URL_ROOT . "login");
            exit();
        }

        $email = $_SESSION['user']['email'];

        $listaCandidature = $this->getApplications($email);
        $this->view('candidatureRicevute', ['candidatureRicevute' => $listaCandidature]); 
    }

    public function getApplications($email)
    {
        $application = new Application();
        $rows = $application->getApplications($email); 
        
        $grouped_candidature = [];

        // Raggruppa le candidature per nome del progetto
        foreach ($rows as $row) {
            $nomeProgetto = $row['Nome_Progetto'];
            $grouped_candidature[$nomeProgetto][] = $row;
        }

        return $grouped_candidature;
    }

    public function acceptApplication()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomeProgetto = $_POST['nomeProgetto'];
            $emailUtente = $_POST['email'];
            $nomeProfilo = $_POST['nomeProfilo'];
            
            $application = new Application();
            $application->acceptApplication($email, $nomeProfilo, $nomeProgetto);
            
            // Reindirizza alla pagina di candidatura
            header("Location: " . URL_ROOT . "candidatura");
            exit();
        }
    }

    public function rejectApplication()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nomeProgetto = $_POST['nomeProgetto'];
            $emailUtente = $_POST['email'];
            $nomeProfilo = $_POST['nomeProfilo'];
            
            $application = new application();
            $application->rejectApplication($email, $nomeProfilo, $nomeProgetto);
            
            // Reindirizza alla pagina di candidatura
            header("Location: " . URL_ROOT . "candidatura");
            exit();
        }
    }
    

}


<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Application extends Model
{
    public function getApplications($email)
    {
        try {
            $stmt = $this->pdo->prepare("CALL ottieniCandidature(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle candidature: " . $e->getMessage());
        }
    }
    
    public function acceptApplication($email, $nomeProfilo, $nomeProgetto)
    {
        try {
            $stmt = $this->pdo->prepare("CALL accettaCandidatura(:email, :nomeProfilo, :nomeProgetto)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nomeProfilo', $nomeProfilo);
            $stmt->bindParam(':nomeProgetto', $nomeProgetto);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Errore durante l'accettazione della candidatura: " . $e->getMessage());
        }
    }

    public function rejectApplication($email, $nomeProfilo, $nomeProgetto)
    {
        try {
            $stmt = $this->pdo->prepare("CALL rifiutaCandidatura(:email, :nomeProfilo, :nomeProgetto)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nomeProfilo', $nomeProfilo);
            $stmt->bindParam(':nomeProgetto', $nomeProgetto);
            $stmt->execute();
        } catch (\PDOException $e) {
            die("Errore durante il rifiuto della candidatura: " . $e->getMessage());
        }
    }
    
}



<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Profile extends Model
{
    public function getProfiles($email)
    {
        try {
            $stmt = $this->pdo->prepare("CALL ottieniProfili(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero dei profili di un utente: " . $e->getMessage());
        }
    }
    // {
    //     try {
    //         $stmt = $this->pdo->prepare("CALL ottieniProfili()");
    //         $stmt->execute();
    //         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //         return $rows;
    //     } catch (\PDOException $e) {
    //         die("Errore durante il recupero dei profili di un utente: " . $e->getMessage());
    //     }
    // }

    public function getApplications($email)
    {
        try {
            $stmt = $this->pdo->prepare("CALL ottieniCandidature(:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $rows;
        } catch (\PDOException $e) {
            die("Errore durante il recupero delle candidature: " . $e->getMessage());
        }
    }

    public function addApplication($email, $nomeProfilo, $nomeProgetto)
    {
        try {
            $stmt = $this->pdo->prepare("CALL inserisciCandidatura(:email, :nomeProgetto, :nomeProfilo)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nomeProfilo', $nomeProfilo);
            $stmt->bindParam(':nomeProgetto', $nomeProgetto);
            $stmt->execute();

            return true; // Profilo aggiunto con successo

        } catch (\PDOException $e) {
            die("Errore durante l'aggiunta del profilo: " . $e->getMessage());
        }
    }

}


