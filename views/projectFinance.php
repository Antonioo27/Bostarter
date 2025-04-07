<?php require 'partials/head.php'; ?>

<body>
    <?php require 'partials/navbar.php'; ?>

    <div class="container mt-5">
        <?php if (isset($progetto) && !empty($progetto)): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h2 class="card-title"><?= htmlspecialchars($progetto['Nome']) ?></h2>
                    <p class="card-text"><?= nl2br(htmlspecialchars($progetto['Descrizione'])) ?></p>
                    <p><strong>Budget:</strong> <?= htmlspecialchars($progetto['Budget']) ?> €</p>
                </div>
            </div>

            <div class="row">
                <!-- Sezione Form di finanziamento -->
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h3 class="mb-3">Finanzia questo progetto</h3>
                            <form action="<?= URL_ROOT ?>project/finance/pay" method="POST">
                                <!-- Passiamo il nome del progetto -->
                                <input type="hidden" name="nome_progetto" value="<?= htmlspecialchars($progetto['Nome']) ?>">
                                <!-- Campo nascosto per memorizzare l'id della reward selezionata -->
                                <input type="hidden" id="reward" name="reward" required>

                                <div class="mb-3">
                                    <label for="importo" class="form-label">Importo da finanziare (€):</label>
                                    <input type="number" class="form-control" id="importo" name="importo" min="1" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Scegli una reward:</label>
                                    <div id="reward-container" style="overflow-x: auto; white-space: nowrap; padding-bottom: 1rem;">
                                        <?php if (isset($rewards) && !empty($rewards)): ?>
                                            <?php foreach ($rewards as $reward): ?>
                                                <div class="reward-item d-inline-block border p-2 m-2"
                                                    style="cursor: pointer; width: 180px;"
                                                    data-reward-id="<?= htmlspecialchars($reward['codice']) ?>">
                                                    <?php if (!empty($reward['Foto'])): ?>
                                                        <img src="data:image/jpeg;base64,<?= base64_encode($reward['foto']) ?>"
                                                            alt="Reward Image"
                                                            style="max-height: 100px; display: block; margin: 0 auto;">
                                                    <?php endif; ?>
                                                    <h5 class="mt-2 text-center" style="font-size: 1rem;">
                                                        <?= htmlspecialchars($reward['descrizione']) ?>
                                                    </h5>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <div class="reward-item">Nessuna reward disponibile</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-lg w-100">Procedi al pagamento</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sezione Informazioni sulle Reward (opzionale, per visualizzazione dettagliata) -->
                <div class="col-md-6">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h3 class="mb-3">Reward disponibili</h3>
                            <?php if (isset($rewards) && !empty($rewards)): ?>
                                <div class="d-flex flex-wrap">
                                    <?php foreach ($rewards as $reward): ?>
                                        <div class="m-2 p-2 border" style="width: 180px;">
                                            <?php if (!empty($reward['foto'])): ?>
                                                <img src="data:image/jpeg;base64,<?= base64_encode($reward['foto']) ?>"
                                                    alt="Reward Image"
                                                    style="max-height: 100px; display: block; margin: 0 auto;">
                                            <?php endif; ?>
                                            <h5 class="mt-2 text-center" style="font-size: 1rem;">
                                                <?= htmlspecialchars($reward['descrizione']) ?>
                                            </h5>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">Nessuna reward disponibile per questo progetto.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <p class="text-muted">Progetto non trovato.</p>
        <?php endif; ?>
    </div>

    <?php require 'partials/footer.php'; ?>

    <script>
        // Gestione della selezione della reward
        document.querySelectorAll('#reward-container .reward-item').forEach(function(item) {
            item.addEventListener('click', function() {
                // Rimuovi l'evidenziazione da tutte le reward
                document.querySelectorAll('#reward-container .reward-item').forEach(function(el) {
                    el.classList.remove('border-primary');
                });
                // Evidenzia la reward selezionata
                this.classList.add('border-primary');
                // Imposta il valore nel campo nascosto
                document.getElementById('reward').value = this.getAttribute('data-reward-id');
            });
        });
    </script>
</body>

</html>