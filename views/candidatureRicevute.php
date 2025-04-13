
<?php require 'partials/head.php';
?>

<body>
    
    <?php require 'partials/navbar.php';
    ?>
    <div class="container">
        <div class="row">
            <?php foreach ($candidatureRicevute as $nomeProgetto => $listaCandidature): ?>
                <div class="col-12 my-4">
                    <div class="border rounded shadow-sm p-4 bg-white">
                        <h4 class="mb-3"><?= htmlspecialchars($nomeProgetto) ?></h4>

                        <?php if (empty($listaCandidature)): ?>
                            <p class="text-muted">Nessuna candidatura ricevuta.</p>
                        <?php else: ?>
                            <?php foreach ($listaCandidature as $candidatura): ?>
                                <div class="border p-3 rounded shadow-sm bg-light mb-3">
                                    <div class="mb-2">
                                        <label class="form-label">Email candidato</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($candidatura['Email_Utente']) ?>" readonly>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Profilo per cui si è candidato</label>
                                        <input type="text" class="form-control" value="<?= htmlspecialchars($candidatura['Nome_Profilo']) ?>" readonly>
                                    </div>
                                    <div class="text-end">
                                        <form action="<?= URL_ROOT ?>gestioneCandidature/accetta_candidatura" method="POST" class="d-inline me-2">
                                            <input type="hidden" name="nomeProgetto" value="<?= htmlspecialchars($nomeProgetto) ?>">
                                            <input type="hidden" name="email" value="<?= htmlspecialchars($candidatura['Email_Utente']) ?>">
                                            <input type="hidden" name="nomeProfilo" value="<?= htmlspecialchars($candidatura['Nome_Profilo']) ?>">
                                            <input type="hidden" name="azione" value="accetta">
                                            <button type="submit" class="btn btn-success">Accetta</button>
                                        </form>
                                        <form action="<?= URL_ROOT ?>gestioneCandidature/rifiuta_candidatura" method="POST" class="d-inline">
                                            <input type="hidden" name="nomeProgetto" value="<?= htmlspecialchars($nomeProgetto) ?>">
                                            <input type="hidden" name="email" value="<?= htmlspecialchars($candidatura['Email_Utente']) ?>">
                                            <input type="hidden" name="nomeProfilo" value="<?= htmlspecialchars($candidatura['Nome_Profilo']) ?>">
                                            <input type="hidden" name="azione" value="rifiuta">
                                            <button type="submit" class="btn btn-danger">Rifiuta</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php require 'partials/footer.php'; ?>
</body>