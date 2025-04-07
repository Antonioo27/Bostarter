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
                <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>candidatura">Candidatura</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>skill">Skill</a></li>
                <?php if (!empty($_SESSION['user']['is_creator'])): ?>
                    <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>createProject">Crea Progetto</a></li>
                    <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>insertReward">Inserisci Reward</a></li>
                <?php endif; ?>
            </ul>

            <!-- Icona utente con nickname -->
            <?php if (!empty($_SESSION['user'])): ?>
                <span class="navbar-text me-3">
                    <!-- Utilizzo di un'icona Bootstrap (assicurati di aver caricato i Bootstrap Icons) -->
                    <i class="bi bi-person-circle"></i> <b><?= htmlspecialchars($_SESSION['user']['nickname']) ?></b>
                </span>
            <?php endif; ?>

            <!-- Pulsanti Login e Sign-up -->
            <?php if (empty($_SESSION['user']['is_creator'])): ?>
                <a href="<?= URL_ROOT ?>infoCreatori" class="btn btn-outline-success">Per i creatori</a>
            <?php endif; ?>
            <a href="<?= URL_ROOT ?>logout" class="btn btn-outline-secondary ms-3">Logout</a>
        </div>
    </div>
</nav>