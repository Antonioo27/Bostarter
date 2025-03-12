<?php
require_once 'partials/head.php';


// Connessione al database
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bostarter", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query per ottenere tutte le competenze
    $stmt = $pdo->query("SELECT * FROM COMPETENZA");
    $competenze = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Errore nel caricamento delle competenze: " . $e->getMessage());
}
?>

<body class="bg-dark text-light">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-dark bg-secondary px-3">
        <span class="navbar-brand mb-0 h1">Pannello Admin - Competenze</span>
        <a href="/logout" class="btn btn-danger">Logout</a>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <!-- Sezione Form -->
            <div class="col-md-4">
                <div class="card bg-secondary text-light p-3 shadow">
                    <h5 class="card-title text-center">Aggiungi Competenza</h5>
                    <form action="/admin/aggiungi_competenza" method="POST">
                        <div class="mb-3">
                            <label for="competenza" class="form-label">Nome Competenza</label>
                            <input type="text" id="competenza" name="competenza" class="form-control bg-dark text-light" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">Aggiungi</button>
                    </form>
                </div>
            </div>

            <!-- Sezione Tabella -->
            <div class="col-md-8">
                <div class="card bg-secondary text-light p-3 shadow">
                    <h5 class="card-title text-center">Lista Competenze</h5>
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($competenze as $competenza): ?>
                                <tr>
                                    <td><?= htmlspecialchars($competenza['Nome']) ?></td>
                                    <td>
                                        <form action="/admin/dashboard" method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="competenza" value="<?= $competenza['Nome'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($competenze)): ?>
                                <tr>
                                    <td colspan="3" class="text-center">Nessuna competenza trovata.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>