<?php require 'partials/head.php'; ?>


<body>
    <header class="container-fluid d-flex justify-content-center align-items-center w-100" style="height: 8vh; background-color: white;">
        <img src="../public/image/image.png" alt="" style="width: 10%; height: 65%;">
    </header>
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 position-relative">
        <div class="position-absolute top-0 end-0 m-3">
            <a href="<?= URL_ROOT ?>admin" class="btn btn-light">Admin</a>
        </div>
        <div class="card shadow-lg p-4 rounded-3" style="width: 100%; max-width: 400px;">
            <h2 class="text-center mb-4">Accedi</h2>
            <form action="<?= URL_ROOT ?>login" method="POST">
                <div class="row g-3">
                    <div class="col-lg-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-lg-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg w-100 rounded-3">Accedi</button>
                </div>
            </form>
            <p class="mt-3 text-center">
                Sei nuovo su Bostarter? <a href="<?= URL_ROOT ?>register">Registrati</a>
            </p>
        </div>
    </div>
</body>

</html>