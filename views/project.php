<?php require 'partials/head.php'; ?>

<body>
    <main>
        <div class="container mt-5">
            <?php if (isset($progetto) && !empty($progetto)): ?>
                <div class="row">
                    <div class="col-md-8">
                        <h2><?= htmlspecialchars($progetto['Nome']) ?></h2>
                        <p class="text-muted">Creato da: <a href="mailto:<?= htmlspecialchars($progetto['Email_Creatore']) ?>"><?= htmlspecialchars($progetto['Email_Creatore']) ?></a></p>
                        <p><?= nl2br(htmlspecialchars($progetto['Descrizione'])) ?></p>
                        <p><strong>Budget:</strong> <?= htmlspecialchars($progetto['Budget']) ?>€</p>
                        <p><strong>Scadenza:</strong> <?= htmlspecialchars($progetto['Data_Limite']) ?></p>
                        <p><strong>Totale Finanziamenti:</strong> <?= htmlspecialchars($progetto['Totale_Finanziamenti']) ?>€</p>
                        <button class="btn btn-success">Finanzia il progetto</button>
                    </div>
                    <div class="col-md-4">
                        <?php if (!empty($progetto['Foto_Progetto'])): ?>
                            <div id="projectCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php foreach ($progetto['Foto_Progetto'] as $index => $foto): ?>
                                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                            <img src="<?= $foto ?>" class="d-block w-100" style="height: 200px; object-fit: cover;">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <a class="carousel-control-prev" href="#projectCarousel" role="button" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </a>
                                <a class="carousel-control-next" href="#projectCarousel" role="button" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>
                <h3>Commenti</h3>
                <div class="comments">
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="comment mb-3">
                                <strong><?= htmlspecialchars($comment['Email']) ?></strong> <span class="text-muted">(<?= htmlspecialchars($comment['Data']) ?>)</span>
                                <p><?= nl2br(htmlspecialchars($comment['Testo'])) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nessun commento ancora.</p>
                    <?php endif; ?>
                </div>
                
                <hr>
                <h4>Aggiungi un commento</h4>
                <form action="<?= URL_ROOT ?>add_comment?nome=<?= urlencode($progetto['Nome']) ?>" method="POST">
                    <div class="mb-3">
                        <label for="testo" class="form-label">Commento</label>
                        <textarea class="form-control" id="testo" name="testo" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Invia</button>
                </form>
            <?php else: ?>
                <p>Progetto non trovato.</p>
            <?php endif; ?>
        </div>
    </main>

</body>