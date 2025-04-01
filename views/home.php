<?php require 'partials/head.php';
?>

<body>


    <main>
        <?php require 'partials/navbar.php'; ?>

        <!-- Main -->

        <div class="container">
            <div class="row">
                <?php foreach ($progetti as $progetto):
                    $oggi = date('Y-m-d');
                ?>
                    <div class="col-md-4 mb-4 mt-5">
                        <div class="project-card">
                            <?php
                            // Genera un ID univoco per il carosello del progetto
                            $carouselId = 'carousel-' . md5($progetto['Nome']);
                            ?>
                            <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($progetto['Foto_Progetto'] as $index => $fotoBase64): ?>
                                        <?php $imageId = $carouselId . '-img-' . $index; ?> <!-- ID univoco per ogni immagine -->
                                        <div id="<?= $imageId ?>" class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="<?= htmlspecialchars($fotoBase64) ?>" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Pulsanti di navigazione -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#<?= $carouselId ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
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
                                    <p class="text-muted"><?= htmlspecialchars(substr($progetto['Descrizione'], 0, 280)) ?><?= strlen($progetto['Descrizione']) > 280 ? '...' : '' ?></p>
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
                                    <a href="<?= URL_ROOT ?>project?nome=<?= urlencode($progetto['Nome']) ?>" class="btn btn-success w-100">Dettagli</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </main>
</body>

</html>