<?php require 'partials/head.php'; ?>

<body class="bg-dark text-light">
    <div class="containers d-flex justify-content-center align-items-center min-vh-100">

        <div class="card shadow-lg p-4 rounded-3 border-0 bg-secondary" style="width: 100%; max-width: 450px;">
            <h2 class="text-center text-light mb-4">Admin Login</h2>

            <form action="<?= URL_ROOT ?>admin" method="POST">
                <div class="row g-3">
                    <div class="col-lg-12">
                        <label for="email" class="form-label text-light">Email</label>
                        <input type="email" id="email" class="form-control bg-dark text-light border-0" name="email" required>
                    </div>
                    <div class="col-lg-12">
                        <label for="password" class="form-label text-light">Password</label>
                        <input type="password" id="password" class="form-control bg-dark text-light border-0" name="password" required>
                    </div>
                    <div class="col-lg-12">
                        <label for="codiceSicurezza" class="form-label text-light">Codice di Sicurezza</label>
                        <input type="number" id="codiceSicurezza" class="form-control bg-dark text-light border-0" name="codiceSicurezza" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg w-100 rounded-3 mt-3">Accedi</button>
                </div>
            </form>

            <p class="mt-3 text-center text-light">
                Torna alla <a href="<?= URL_ROOT ?>" class="text-warning">Home</a>
            </p>
        </div>
    </div>
</body>

</html>