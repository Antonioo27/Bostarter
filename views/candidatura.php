<?php require 'partials/head.php';
?>

<body>

    <main>
        <?php require 'partials/navbar.php'; ?>

        <div class="container">
            <div class="row">
                <!-- Ciclo foreach per array associativo (Chiave: nomeProgetto => Valore: lista dei nomi dei profili richiesti) -->
                <?php foreach ($profili as $nomeProgetto => $listaProfili): ?>
                    <div class="col-12 my-4">
                        <div class="border rounded shadow-sm p-4 bg-white">
                            <h4 class="mb-3"><?= htmlspecialchars($nomeProgetto) ?></h4>
                            <a href="<?= URL_ROOT ?>project?nome=<?= urlencode($profilo['Nome_Progetto']) ?>" class="btn btn-primary mb-4">Dettagli Progetto</a>
                            <!-- Ciclo foreach per ogni profilo di un progetto -->
                            <?php foreach ($listaProfili as $profilo): ?>
                                <div class="border p-3 rounded shadow-sm bg-light mb-3">
                                    <div class="mb-2">
                                        <label class="form-label">Nome del profilo richiesto</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($profilo['Nome']) ?>" readonly>
                                    </div>
                                    <div class="text-end">
                                        <form action="candidati.php" method="POST" class="d-inline">
                                            <button type="submit" class="btn btn-primary">Candidati</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

</body>

</html>