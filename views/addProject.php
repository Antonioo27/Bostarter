<?php require 'partials/head.php';
?>

<body>
    <?php require 'partials/navbar.php'; ?>

    <main style="min-height: 100vh;">

        <div class="container mt-5">
            
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
                            <option value="1">Hardware</option>
                            <option value="2">Software</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="componenti-wrapper">
                        <label class="form-label">Componenti necessari</label>
                        <div id="componenti-container">
                            <div class="componente mb-3 border p-3 rounded">
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <input type="text" class="form-control" name="componenti[nome][]" placeholder="Nome" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <input type="text" class="form-control" name="componenti[descrizione][]" placeholder="Descrizione" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <input type="number" step="0.01" class="form-control" name="componenti[prezzo][]" placeholder="Prezzo" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <input type="number" class="form-control" name="componenti[quantita][]" placeholder="Quantità" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm" id="add-componente-btn">+ Aggiungi Componente</button>
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
                        document.getElementById('tipo_progetto').addEventListener('change', function () {
                            const wrapper = document.getElementById('componenti-wrapper');
                            if (this.value === '1') { // Hardware
                                wrapper.classList.remove('d-none');
                            } else {
                                wrapper.classList.add('d-none');
                            }
                        });

                        document.getElementById('add-componente-btn').addEventListener('click', function () {
                            const container = document.getElementById('componenti-container');

                            const wrapper = document.createElement('div');
                            wrapper.className = 'componente mb-3 border p-3 rounded';

                            wrapper.innerHTML = `
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <input type="text" class="form-control" name="componenti[nome][]" placeholder="Nome" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <input type="text" class="form-control" name="componenti[descrizione][]" placeholder="Descrizione" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <input type="number" step="0.01" class="form-control" name="componenti[prezzo][]" placeholder="Prezzo" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <input type="number" class="form-control" name="componenti[quantita][]" placeholder="Quantità" required>
                                    </div>
                                </div>
                            `;

                            container.appendChild(wrapper);
                        });
                    </script>

                    <button type="submit" class="btn btn-primary">Inserisci progetto</button>
                </form>
        </div>
    </main>
    <?php require 'partials/footer.php'; ?>
</body>

</html>