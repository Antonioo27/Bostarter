<?php require 'partials/head.php';
?>

<body>
    <?php require 'partials/navbar.php'; ?>

    <main style="min-height: 100vh;">

        <div class="container m-4">
            <div class="mb-4">
                <h2>Inserisci un nuovo progetto</h2>
                <form action="<?= URL_ROOT ?>aggiungi_progetto" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome del progetto</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="descrizione" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="descrizione" name="descrizione" rows="3" maxlength="500" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="data_limite" class="form-label">Data di scadenza</label>
                        <input type="date" class="form-control" id="data_limite" name="data_limite" required>
                    </div>
                    <div class="mb-3">
                        <label for="budget" class="form-label">Budget</label>
                        <input type="number" class="form-control" id="budget" name="budget" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipo_progetto" class="form-label">Tipo di progetto</label>
                        <select class="form-select" id="tipo_progetto" name="tipo_progetto" required>
                            <option value="" selected disabled>Seleziona tipo</option>
                            <option value="Hardware">Hardware</option>
                            <option value="Software">Software</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="componenti-wrapper">
                        <label for="componenti" class="form-label">Componenti necessari</label>
                        <div id="componenti-container">
                            <input type="text" class="form-control mb-2" name="componenti[]" placeholder="Componente 1">
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" id="add-componente-btn">+</button>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto del progetto</label>
                        <div id="additional-photos">
                            <input type="file" class="form-control" id="foto" name="foto[]" required>
                            <button type="button" class="btn btn-secondary" id="add-photo-btn">+</button>
                        </div>
                    </div>
                    <script>
                        document.getElementById('add-photo-btn').addEventListener('click', function() {
                            var additionalPhotosDiv = document.getElementById('additional-photos');
                            var newInput = document.createElement('input');
                            newInput.type = 'file';
                            newInput.name = 'foto[]';
                            newInput.className = 'form-control mt-2';
                            additionalPhotosDiv.appendChild(newInput);
                        });
                    </script>
                    <script>
                        // Mostra/nasconde i componenti se tipo = Hardware
                        document.getElementById('tipo_progetto').addEventListener('change', function () {
                            const componentiWrapper = document.getElementById('componenti-wrapper');
                            if (this.value === 'Hardware') {
                                componentiWrapper.classList.remove('d-none');
                            } else {
                                componentiWrapper.classList.add('d-none');
                            }
                        });

                        // Aggiunta di nuovi campi componente
                        document.getElementById('add-componente-btn').addEventListener('click', function () {
                            const container = document.getElementById('componenti-container');
                            const input = document.createElement('input');
                            input.type = 'text';
                            input.className = 'form-control mb-2';
                            input.name = 'componenti[]';
                            input.placeholder = 'Altro componente';
                            container.appendChild(input);
                        });
                    </script>
                    <button type="submit" class="btn btn-primary">Inserisci progetto</button>
                </form>
            </div>
        </div>
    </main>
    <?php require 'partials/footer.php'; ?>
</body>

</html>