<?php

namespace engine;

abstract class controller
{
    function redirect(String $controller, string $parameters = null)
    {
        if ($parameters == null) {
            header('Location: ' . "index.php?path=" . $controller, true);
            exit();
        } else {
            header('Location: ' . "index.php?path=" . $controller . "&" . $parameters, true);
            exit();
        }
    }
    public function __construct() {}

    function main(bool $checkUserIsLogged = true)
    {
        //check if the user is logged
        if ($checkUserIsLogged && !$this->userIslogged()) $this->redirect("login");
        //run methods on REQUEST_METHOD value
        if ($_SERVER["REQUEST_METHOD"] == "GET") $this->doGet();
        elseif ($_SERVER["REQUEST_METHOD"] == "POST") $this->doPost();
    }
    abstract public function doGet();
    public function doPost()
    {
        $this->doGet();
    }
    function printView(String $view, array $data = null)
    {
        if (is_file(VIEW_FOLDER . $view . ".php")) {
            if (isset($data)) $viewData = $data;
            include VIEW_FOLDER . $view . ".php";
        }
    }
    function userIslogged(): bool
    {
        if (isset($_SESSION["logged"]) && $_SESSION["logged"]) {
            return true;
        }
        return false;
    }
}
