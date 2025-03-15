<?php require 'partials/head.php';
?>


<body>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm" style="height: 15vh;">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center me-3">
                <img src="../public/image/image.png" alt="" style="width:50%; height: 55%;">
            </a>
            <div class="d-flex flex-grow-1 mx-3 position-relative">
                <input class="form-control ps-5" type="search" placeholder="Cerca un progetto..." aria-label="Search">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="left: 15px; top: 30%; color: gray;"></i>
            </div>
            <a href="#" class="btn btn-outline-success">Per i creatori</a>
            <a href="<?= URL_ROOT ?>logout" class="btn btn-outline-secondary ms-3">Logout</a>
        </div>
    </nav>

    <!-- Main -->
    <div class="container mt-4">
        <div class="mb-4">
            <h2>Inserisci un nuovo progetto</h2>
            <form action="<?= URL_ROOT ?>aggiungi_progetto" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome del progetto</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label>
                    <textarea class="form-control" id="descrizione" name="descrizione" rows="3" maxlength="280" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="data_limite" class="form-label">Data di scadenza</label>
                    <input type="date" class="form-control" id="data_limite" name="data_limite" required>
                </div>
                <div class="mb-3">
                    <label for="budget" class="form-label">Budget</label>
                    <input type="number" class="form-control" id="budget" name="budget" required>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto del progetto</label>
                    <div id="additional-photos">
                        <input type="file" class="form-control" id="foto" name="foto[]" required>
                        <button type="button" class="btn btn-secondary" id="add-photo-btn">+</button>
                    </div>
                </div>
                <script>
                    document.getElementById('add-photo-btn').addEventListener('click', function() {
                        var additionalPhotosDiv = document.getElementById('additional-photos');
                        var newInput = document.createElement('input');
                        newInput.type = 'file';
                        newInput.name = 'foto[]';
                        newInput.className = 'form-control mt-2';
                        additionalPhotosDiv.appendChild(newInput);
                    });
                </script>
                <button type="submit" class="btn btn-primary">Inserisci progetto</button>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php foreach ($progetti as $progetto):
                $oggi = date('Y-m-d');
            ?>
                <div class="col-md-4 mb-4">
                    <div class="project-card">
                        <div id="carousel-<?= htmlspecialchars($progetto['Nome']) ?>" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($progetto['Foto_Progetto'] as $index => $foto): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="<?= $foto ?>" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <a class="carousel-control-prev" href="#carousel-<?= htmlspecialchars($progetto['Nome']) ?>" role="button" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-<?= htmlspecialchars($progetto['Nome']) ?>" role="button" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>

                        <!-- Info progetto -->
                        <div class="project-info">
                            <h5><a href="#"><?= htmlspecialchars($progetto['Nome']) ?></a></h5>

                            <?php
                            $data_limite = new DateTime($progetto['Data_Limite']);
                            $oggi_date = new DateTime(date('Y-m-d'));
                            $giorni_mancanti = $oggi_date->diff($data_limite)->format('%a');

                            $totale_finanziamenti = $progetto['Totale_Finanziamenti'] ?? 0;
                            $budget = $progetto['Budget'];
                            $percentuale_finanziata = ($budget > 0) ? min(100, ($totale_finanziamenti / $budget) * 100) : 0;
                            ?>

                            <!-- Giorni rimanenti + Percentuale finanziata -->
                            <div class="project-status">
                                <span class="remaining-days">
                                    <i class="fa-solid fa-clock"></i> <?= $giorni_mancanti ?> giorni rimanenti --
                                </span>
                                <span class="funding-percentage">
                                    <i class="fa-solid fa-chart-line"></i> <?= round($percentuale_finanziata, 2) ?>% finanziato
                                </span>
                            </div>

                            <!-- Email del creatore -->
                            <div class="creator-info">
                                <i class="fa-solid fa-user"></i> <strong>Creato da:</strong>
                                <a href="mailto:<?= htmlspecialchars($progetto['Email_Creatore']) ?>">
                                    <?= htmlspecialchars($progetto['Email_Creatore']) ?>
                                </a>
                            </div>

                            <!-- Contenuto che appare solo al passaggio del mouse -->
                            <div class="project-hover-content">
                                <p class="text-muted"><?= htmlspecialchars($progetto['Descrizione']) ?></p>
                                <div class="progress-container">
                                    <span><?= htmlspecialchars($totale_finanziamenti) ?>€ raccolti</span>
                                    <span><?= htmlspecialchars($budget) ?>€ obiettivo</span>
                                </div>
                                <div class="progress" style="margin-bottom: 15px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: <?= $percentuale_finanziata ?>%;"
                                        aria-valuenow="<?= $totale_finanziamenti ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="<?= $budget ?>"></div>
                                </div>
                                <a href="" class="btn btn-success w-100">Finanzia</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</body>