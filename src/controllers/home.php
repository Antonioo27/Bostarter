<?php
require_once __DIR__ . '/../database/dbconnector.php';
require_once __DIR__ . '/../models/utente.php'; // Importa la classe utente    

include 'header.php';

?>

<body>
    <nav class="navbar navbar-light bg-white shadow-sm">
        <div class="container d-flex align-items-center">
            <a class="navbar-brand d-flex align-items-center me-3" href="#">
                <!-- <img src="logo.png" alt="Logo Bostarter" style="width: 120px;"> -->
                <h2 class="mb-0 ms-2" style="color: rgb(1, 191, 1); font-family: 'Lucida Sans', Geneva, sans-serif;">
                    BOSTARTER
                </h2>
            </a>
            <div class="d-flex flex-grow-1 mx-3 position-relative">
                <input class="form-control ps-5" type="search" placeholder="Cerca un progetto..." aria-label="Search">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="left: 15px; top: 30%; color: gray;"></i>
            </div>            
            <a href="#" class="btn btn-outline-success">Per i creatori</a>
            <a href="#" class="btn btn-outline-secondary ms-3">Logout</a>
        </div>
    </nav>    
</body>