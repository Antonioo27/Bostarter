<?php require 'partials/head.php'; ?>

<body>
    <main>
        <nav class="navbar navbar-expand-lg bg-white px-4">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="../public/image/image.png" alt="Logo" style="height: 40px;">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="#">Candidatura</a></li>
                        <li class="nav-item"><a class="nav-link text-dark" href="<?= URL_ROOT ?>skill">Skill</a></li>
                    </ul>

                    <a href="<?= URL_ROOT ?>logout" class="btn btn-outline-secondary ms-3">Logout</a>
                </div>
            </div>
        </nav>

        <section class="container mt-5">
            <div class="row align-items-center">
                <!-- Testo -->
                <div class="col-md-6 mb-4">
                    <h1 class="fw-bold" style="font-size: 3rem;">Sfrutta il<br><span class="text-success">potenziale del<br>finanziamento</span></h1>
                    <p class="mt-4 fs-5">
                        Qualunque sia il tuo sogno, qui puoi trovare le risorse per realizzarlo.
                        Entra a far parte della più vasta community di sostenitori per trasformare le tue idee in realtà.
                    </p>
                    <a href="<?= URL_ROOT ?>registerCreator" class="btn btn-dark btn-lg mt-3">Inizia</a>
                </div>

                <!-- Immagini -->
                <div class="col-md-6 text-center">
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <img src="../public/image/gruppo-di-confrontare-le-idee-multietnico-dei-progettisti-giovani-progettisti-che-lavorano-insieme-sul-progetto-creativo-78363972.webp" alt="Creatore 1" class="img-fluid rounded shadow" style="width: 45%;">
                        <img src="../public/image/camera-scala-con-architetti-due-che-insieme-costruiscono-un-modello-architettonico-ufficio-forma-scalare-case-su-tavolo-270830599.webp" alt="Creatore 2" class="img-fluid rounded shadow" style="width: 45%;">
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>

</html>