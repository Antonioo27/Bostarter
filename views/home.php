<?php require 'partials/head.php'; 
?>


<body>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center me-3" href="#">
                <img src="../public/image/image.png" alt="" style="width:50%; height: 55%;">
            </a>
            <div class="d-flex flex-grow-1 mx-3 position-relative">
                <input class="form-control ps-5" type="search" placeholder="Cerca un progetto..." aria-label="Search">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="left: 15px; top: 30%; color: gray;"></i>
            </div>
            <a href="#" class="btn btn-outline-success">Per i creatori</a>
            <a href="<?= URL_ROOT ?>logout" class="btn btn-outline-secondary ms-3">Logout</a>
        </div>
    </nav>

    <!-- Main -->
    <div class="container mt-4">
        <div class="mb-4">
            <h2>Inserisci un nuovo progetto</h2>
            <form action="<?= URL_ROOT ?>aggiungi_progetto" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome del progetto</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
                <div class="mb-3">
                    <label for="descrizione" class="form-label">Descrizione</label>
                    <textarea class="form-control" id="descrizione" name="descrizione" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email del creatore</label>
                    <input type="email" class="form-control" id="email" name="email" required>
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
                <button type="submit" class="btn btn-primary">Inserisci progetto</button>
            </form>
        </div>
        <div class="row">
        <!-- <pre><?php print_r($progetti); ?></pre> -->

        <?php foreach ($progetti as $progetto): ?>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div id="carousel-<?= htmlspecialchars($progetto['Nome']) ?>" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($progetto['Foto_Progetto'] as $index => $foto): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="<?= $foto ?>" class="d-block w-100" style="height: 200px; object-fit: cover;">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carousel-<?= htmlspecialchars($progetto['Nome']) ?>" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-<?= htmlspecialchars($progetto['Nome']) ?>" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </a>
                </div>

                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($progetto['Nome']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($progetto['Descrizione']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($progetto['Email_Creatore']) ?></p>
                    <p><strong>Scadenza:</strong> <?= htmlspecialchars($progetto['Data_Limite']) ?></p>
                    <p><strong>Budget raggiunto:</strong> <?= htmlspecialchars($progetto['Totale_Finanziamenti'] ?? 0) ?></p>
                    <a href="finanzia.php" class="btn btn-primary">Finanzia</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        </div>
    </div>


</body>