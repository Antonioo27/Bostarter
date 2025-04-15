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
                                <input type="text" name="skills[]" class="form-control" placeholder="Es. PHP" required>
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
        document.getElementById('add-skill-btn').addEventListener('click', function () {
            const container = document.getElementById('skill-container');
            const row = document.createElement('div');
            row.className = 'row mb-2';

            const skillCol = document.createElement('div');
            skillCol.className = 'col-md-6';
            const skillInput = document.createElement('input');
            skillInput.type = 'text';
            skillInput.name = 'skills[]';
            skillInput.className = 'form-control';
            skillInput.placeholder = 'Es. JavaScript';
            skillInput.required = true;

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

            skillCol.appendChild(skillInput);
            levelCol.appendChild(levelSelect);
            row.appendChild(skillCol);
            row.appendChild(levelCol);
            container.appendChild(row);
        });
    </script>

    <?php require 'partials/footer.php'; ?>
</body>

</html>
