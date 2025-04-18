<?php require 'partials/head.php'; ?>

<body>
    <?php require 'partials/navbar.php'; ?>

    <main style="min-height: 100vh;">
        <div class="container mt-5">
            <h2>Inserisci un nuovo profilo</h2>

            <form action="<?= URL_ROOT ?>aggiungi_profilo" method="POST">
                <!-- Seleziona progetto -->
                <div class="mb-3">
                    <label for="progetto" class="form-label">Progetto</label>
                    <select class="form-select" id="progetto" name="progetto" required>
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

                <!-- Campo per il nome del profilo -->
                <div class="mb-3">
                    <label for="nome_profilo" class="form-label">Nome del profilo</label>
                    <input type="text" class="form-control" id="nome_profilo" name="nome_profilo" placeholder="Es. Sviluppatore Backend" required>
                </div>

                <!-- Skill richieste -->
                <div class="mb-3">
                    <label class="form-label">Skill richieste</label>
                    <div id="skill-container">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <select class="form-control" id="nome_competenza" name="skills[]" required>
                                    <option value="" disabled selected>Seleziona una competenza</option>
                                    <?php foreach ($competenze as $competenza): ?>
                                        <option value="<?= htmlspecialchars($competenza['Nome']) ?>">
                                            <?= htmlspecialchars($competenza['Nome']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>                            
                            </div>
                            <div class="col-md-4">
                                <select name="livelli[]" class="form-select" required>
                                    <option value="" disabled selected>Livello</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" id="add-skill-btn">+ Aggiungi Skill</button>
                </div>

                <button type="submit" class="btn btn-primary">Inserisci Profilo</button>
            </form>
        </div>
    </main>

    <script>
    const competenze = <?= json_encode($competenze) ?>;

    document.getElementById('add-skill-btn').addEventListener('click', function () {
        const container = document.getElementById('skill-container');
        const row = document.createElement('div');
        row.className = 'row mb-2';

        // Colonna skill (select)
        const skillCol = document.createElement('div');
        skillCol.className = 'col-md-6';
        const skillSelect = document.createElement('select');
        skillSelect.name = 'skills[]';
        skillSelect.className = 'form-control';
        skillSelect.required = true;

        // Opzioni competenze
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.disabled = true;
        defaultOption.selected = true;
        defaultOption.textContent = 'Seleziona una competenza';
        skillSelect.appendChild(defaultOption);

        competenze.forEach(comp => {
            const opt = document.createElement('option');
            opt.value = comp.Nome;
            opt.textContent = comp.Nome;
            skillSelect.appendChild(opt);
        });

        skillCol.appendChild(skillSelect);

        // Colonna livello
        const levelCol = document.createElement('div');
        levelCol.className = 'col-md-4';
        const levelSelect = document.createElement('select');
        levelSelect.name = 'livelli[]';
        levelSelect.className = 'form-select';
        levelSelect.required = true;
        levelSelect.innerHTML = `
            <option value="" disabled selected>Livello</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        `;

        levelCol.appendChild(levelSelect);
        row.appendChild(skillCol);
        row.appendChild(levelCol);
        container.appendChild(row);
    });
    </script>


    <?php require 'partials/footer.php'; ?>
</body>

</html>
