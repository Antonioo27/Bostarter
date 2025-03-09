<?php require 'partials/head.php'; ?>

<body>
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
</body>