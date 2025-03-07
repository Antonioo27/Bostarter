<?php

namespace App\Core;

abstract class Controller
{
    protected function view($view, $data = [])
    {
        extract($data); // Estrai dati come variabili
        require_once APP_ROOT . "/views/$view.php";
    }

    protected function redirect($route)
    {
        header("Location: " . URL_ROOT . $route);
        exit;
    }
}
