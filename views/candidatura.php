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
                <?php foreach ($profili as $profilo): 
                ?>
                    <div class="col-md-6 mb-4">
                        <div class="border p-3 rounded shadow-sm bg-light">
                            <div class="mb-3">
                                <label class="form-label">Nome del profilo richiesto</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($profilo['Nome']) ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nome del progetto</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($profilo['Nome_Progetto']) ?>" readonly>
                            </div>
                            <div class="mb-3 text-end">
                                <form action="candidati.php" method="POST">
                                    <button type="submit" class="btn btn-primary">Candidati</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    
</body>
</html>