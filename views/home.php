<?php require 'partials/head.php'; ?>

<body>
    <main>
        <?php require 'partials/navbar.php'; ?>

        <div class="container mt-5">
            <!-- Barra di ricerca: cerca per creatore e ordina -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <input type="text" id="searchCreator" class="form-control me-2" placeholder="Cerca per creatore">
                        <button class="btn btn-primary" id="resetFilters">Reset</button>
                    </div>
                </div>
            </div>


            <!-- Lista dei progetti -->
            <div class="row">
                <?php foreach ($progetti as $progetto):
                    $oggi = date('Y-m-d');
                ?>
                    <div class="col-md-4 mb-4 mt-5"
                        data-creator="<?= htmlspecialchars($progetto['Email_Creatore']) ?>"
                        data-financed="<?= $progetto['Totale_Finanziamenti'] ?>"
                        data-budget="<?= $progetto['Budget'] ?>"
                        data-date="<?= htmlspecialchars($progetto['Data_Limite']) ?>">
                        <div class="project-card">
                            <?php
                            // Genera un ID univoco per il carosello del progetto
                            $carouselId = 'carousel-' . md5($progetto['Nome']);
                            ?>
                            <div id="<?= $carouselId ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($progetto['Foto_Progetto'] as $index => $fotoBase64): ?>
                                        <?php $imageId = $carouselId . '-img-' . $index; ?>
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
                                <h5 class="mt-2"><?= htmlspecialchars($progetto['Nome']) ?></h5>
                                <?php
                                $data_limite = new DateTime($progetto['Data_Limite']);
                                $oggi_date = new DateTime(date('Y-m-d'));
                                $giorni_mancanti = $oggi_date->diff($data_limite)->format('%a');
                                $percentuale_finanziata = ($progetto['Budget'] > 0) ? min(100, ($progetto['Totale_Finanziamenti']) / $progetto['Budget'] * 100) : 0;
                                ?>
                                <div class="project-status">
                                    <span class="remaining-days">
                                        <i class="fa-solid fa-clock"></i> <?= $giorni_mancanti ?> giorni rimanenti --
                                    </span>
                                    <span class="funding-percentage">
                                        <i class="fa-solid fa-chart-line"></i> <?= round($percentuale_finanziata, 2) ?>% finanziato
                                    </span>
                                </div>
                                <div class="creator-info">
                                    <i class="fa-solid fa-user"></i> <strong>Creato da:</strong>
                                    <a href="mailto:<?= htmlspecialchars($progetto['Email_Creatore']) ?>">
                                        <?= htmlspecialchars($progetto['Email_Creatore']) ?>
                                    </a>
                                </div>
                                <div class="project-hover-content">
                                    <p class="text-muted"><?= htmlspecialchars(substr($progetto['Descrizione'], 0, 280)) ?><?= strlen($progetto['Descrizione']) > 280 ? '...' : '' ?></p>
                                    <div class="progress-container">
                                        <span><?= htmlspecialchars($progetto['Totale_Finanziamenti']) ?>€ raccolti</span>
                                        <span><?= htmlspecialchars($progetto['Budget']) ?>€ obiettivo</span>
                                    </div>
                                    <div class="progress" style="margin-bottom: 15px;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: <?= $percentuale_finanziata ?>%;"
                                            aria-valuenow="<?= htmlspecialchars($progetto['Totale_Finanziamenti']) ?>"
                                            aria-valuemin="0"
                                            aria-valuemax="<?= htmlspecialchars($progetto['Budget']) ?>"></div>
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
    <?php require 'partials/footer.php'; ?>

</body>
<script src="../public/script/orderProjectHome.js"></script>


</html>