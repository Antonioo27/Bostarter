<?php require 'partials/head.php'; ?>

<body>
    <header class="container-fluid d-flex justify-content-center align-items-center w-100" style="height: 8vh; background-color: white;">
        <img src="../public/image/image.png" alt="" style="width: 10%; height: 65%;">
    </header>

    <div class="container d-flex justify-content-center align-items-center min-vh-100" ;>
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 500px;">
            <h2 class="text-center mb-4">Registrazione</h2>
            <form action="<?= URL_ROOT ?>register" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" id="nome" class="form-control" name="nome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cognome" class="form-label">Cognome</label>
                        <input type="text" id="cognome" class="form-control" name="cognome" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                    </div>
                    <div class="col-md-6">
                        <label for="annoNascita" class="form-label">Anno di nascita</label>
                        <input type="number" id="annoNascita" class="form-control" name="annoNascita" required>
                    </div>
                    <div class="col-md-6">
                        <label for="luogoNascita" class="form-label">Luogo di Nascita</label>
                        <input type="text" id="luogoNascita" class="form-control" name="luogoNascita" required>
                    </div>
                    <div class="col-12">
                        <label for="nickname" class="form-label">Nickname</label>
                        <input type="text" id="nickname" class="form-control" name="nickname" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-lg w-100 mt-3">Registrati</button>
            </form>
            <p class="mt-3 text-center">
                Hai già un account? <a href="<?= URL_ROOT ?>login">Accedi</a>
            </p>
        </div>
    </div>
</body>

</html>