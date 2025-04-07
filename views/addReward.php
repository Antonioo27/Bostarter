<?php require 'partials/head.php'; ?>

<body>
    <?php require 'partials/navbar.php'; ?>

    <div class="container mt-5">
        <h2>Aggiungi una Reward</h2>
        <?php if (isset($error) && !empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="<?= URL_ROOT ?>insertReward" method="POST" enctype="multipart/form-data">
            <!-- Campo per la descrizione della reward -->
            <div class="mb-3">
                <label for="descrizione" class="form-label">Descrizione</label>
                <input type="text" class="form-control" id="descrizione" name="descrizione" placeholder="Inserisci una descrizione" required>
            </div>

            <!-- Campo per il caricamento della foto -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
            </div>

            <!-- Campo per selezionare il progetto associato -->
            <div class="mb-3">
                <label for="nome_progetto" class="form-label">Progetto associato</label>
                <select class="form-select" id="nome_progetto" name="nome_progetto" required>
                    <option value="" disabled selected>-- Seleziona il progetto --</option>
                    <?php if (isset($progetti) && !empty($progetti)): ?>
                        <?php foreach ($progetti as $progetto): ?>
                            <option value="<?= htmlspecialchars($progetto['Nome']) ?>">
                                <?= htmlspecialchars($progetto['Nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="">Nessun progetto disponibile</option>
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Aggiungi Reward</button>
        </form>
    </div>

    <?php require 'partials/footer.php'; ?>
</body>

</html>