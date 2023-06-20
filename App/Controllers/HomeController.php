<?php

namespace App\Controllers;

class HomeController
{
    public function home()
    {
        redirectIfNotLogged();

        $error = isset($_GET['error']) ? $_GET['error'] : '';
        $message = isset($_GET['message']) ? $_GET['message'] : '';

        include 'views/home.html.php';
    }

    public function notFound()
    {
        include 'views/not-found.html.php';
    }
}
