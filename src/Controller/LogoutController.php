<?php

namespace App\Controller;

class LogoutController extends AbstractController
{
    public function logout()
    {
        if (isset($_SESSION['userLogged'])) { // Si connecté on déconnecte et on te redirige vers une page.
            session_destroy();
        }
        header("Location: /");
    }
}
