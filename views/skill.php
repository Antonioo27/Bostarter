<?php require 'partials/head.php'; ?>

<body>
    <?php require 'partials/navbar.php'; ?>


    <div class="container mt-4">
        <h2 class="fs-5 fw-semibold text-primary">Le tue Skill</h2>

        <div class="table-responsive col-md-6 col-lg-5 mx-auto ms-0">
            <table class="table table-striped table-hover shadow-sm rounded">
                <thead class="table-primary">
                    <tr>
                        <th>Nome Competenza</th>
                        <th>Livello</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($skill)): ?>
                        <?php foreach ($skill as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['NomeCompetenza']) ?></td>
                                <td>
                                    <span class="badge bg-success fs-6">
                                        <?= htmlspecialchars($s['Livello']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">Nessuna competenza aggiunta.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mt-4">
        <h2 class="fs-5 fw-semibold text-primary">Aggiungi una Skill</h2>

        <form action="<?= URL_ROOT ?>skill/add" method="POST" class="col-md-6 col-lg-5 mx-auto ms-0">
            <div class="mb-3">
                <label for="nome_competenza" class="form-label">Competenza</label>
                <select class="form-control" id="nome_competenza" name="nome_competenza" required>
                    <option value="" disabled selected>Seleziona una competenza</option>
                    <?php foreach ($competenze as $competenza): ?>
                        <option value="<?= htmlspecialchars($competenza['Nome']) ?>">
                            <?= htmlspecialchars($competenza['Nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="livello" class="form-label">Livello</label>
                <select class="form-control" id="livello" name="livello" required>
                    <option value="" disabled selected>Seleziona il livello</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Aggiungi Skill</button>
        </form>
    </div>




</body>

</html>