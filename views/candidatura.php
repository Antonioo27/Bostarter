<?php require 'partials/head.php';
?>

<body>

    <main>
        <nav class="navbar navbar-expand-lg bg-white px-4">
                <div class="container-fluid">
                    <!-- Logo -->
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img src="../public/image/image.png" alt="Logo" style="height: 40px;">
                    </a>

                    <!-- Toggle Button per dispositivi mobili -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Navbar Links -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>home">Home</a></li>
                            <li class="nav-item active"><a class="nav-link text-dark" href="<?= URL_ROOT ?>">Candidatura</a></li>
                            <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>skill">Skill</a></li>

                        </ul>


                        <!-- Pulsanti Login e Sign-up -->
                        <a href="#" class="btn btn-outline-success">Per i creatori</a>
                        <a href="<?= URL_ROOT ?>logout" class="btn btn-outline-secondary ms-3">Logout</a>
                    </div>
                </div>
        </nav>
        <div class="container">
            <div class="row">
            <!-- Ciclo foreach per array associativo (Chiave: nomeProgetto => Valore: lista dei nomi dei profili richiesti) -->
            <?php foreach ($profili as $nomeProgetto => $listaProfili): ?>
                <div class="col-12 mb-5">
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