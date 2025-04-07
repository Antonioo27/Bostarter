<?php require 'partials/head.php'; ?>

<body>
    <main>
        <?php require 'partials/navbar.php'; ?>
        <div class="container mt-5">
            <?php if (isset($progetto) && !empty($progetto)): ?>
                <!-- Header con carosello e overlay -->
                <div class="project-header">
                    <?php if (!empty($progetto['Foto_Progetto'])): ?>
                        <div id="projectCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($progetto['Foto_Progetto'] as $index => $foto): ?>
                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                        <img src="<?= $foto ?>" class="d-block w-100 project-header-img">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#projectCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#projectCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    <?php endif; ?>
                    <div class="project-overlay">
                        <h1><?= htmlspecialchars($progetto['Nome']) ?></h1>
                        <p>Creato da: <a href="mailto:<?= htmlspecialchars($progetto['Email_Creatore']) ?>"><?= htmlspecialchars($progetto['Email_Creatore']) ?></a></p>
                    </div>
                </div>

                <!-- Dettagli del progetto -->
                <div class="project-details card p-4 mt-4">
                    <p><?= nl2br(htmlspecialchars($progetto['Descrizione'])) ?></p>


                    <div class="card project-finance-card p-4 my-4">
                        <!-- Totale raccolto + obiettivo -->
                        <h2 class="mb-3">
                            <?= htmlspecialchars($progetto['Totale_Finanziamenti']) ?>€
                            <small class="d-block text-muted">raccolti su un obiettivo di <?= htmlspecialchars($progetto['Budget']) ?> €</small>
                        </h2>
                        <?php
                        $data_limite = new DateTime($progetto['Data_Limite']);
                        $oggi_date = new DateTime(date('Y-m-d'));
                        $giorni_mancanti = $oggi_date->diff($data_limite)->format('%a');
                        ?>
                        <!-- Giorni rimanenti -->
                        <p class="mb-3 fs-5"><strong><?= $giorni_mancanti ?></strong> giorni alla fine</p>

                        <!-- Pulsante di finanziamento -->
                        <a href="<?= URL_ROOT ?>project/finance?nome=<?= urlencode($progetto['Nome']) ?>" class="btn btn-success w-100 p-2 m-2">Finanzia questo progetto</a>

                        <!-- Testo descrittivo -->
                        <p class="text-muted small mb-0">
                            Tutto o niente. Questo progetto sarà finanziato solo se raggiungerà
                            il suo obiettivo entro il ven 18 aprile 2025 17:00 CEST.
                        </p>
                    </div>


                    <!-- Sezione Commenti -->
                    <div class="comments-section mt-5">
                        <h3>Commenti</h3>
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment card p-3 mb-3">
                                    <div class="comment-header d-flex justify-content-between">
                                        <span class="comment-author"><?= htmlspecialchars($comment['Email']) ?></span>
                                        <span class="comment-date text-muted"><?= htmlspecialchars($comment['Data']) ?></span>
                                    </div>
                                    <p class="comment-text"><?= nl2br(htmlspecialchars($comment['Testo'])) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted">Nessun commento ancora.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Aggiungi Commento -->
                    <div class="add-comment-section mt-5">
                        <h4>Aggiungi un commento</h4>
                        <form action="<?= URL_ROOT ?>add_comment?nome=<?= urlencode($progetto['Nome']) ?>" method="POST">
                            <div class="mb-3">
                                <label for="testo" class="form-label">Commento</label>
                                <textarea class="form-control" id="testo" name="testo" rows="4" required></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg">Invia</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <p class="text-muted">Progetto non trovato.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php require 'partials/footer.php'; ?>

</body>

</html>