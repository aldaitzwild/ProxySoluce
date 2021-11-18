<?php

namespace App\Controller;

use App\Model\CategoryManager;
use App\Model\LoginManager;
use Exception;

class LoginController extends AbstractController
{
    public function login(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userInformations = array_map('trim', $_POST);
            $userPassword = $userInformations['pass'];
            $loginManager = new LoginManager();
            try {
                $informationsDB = $loginManager->checkInformations($userInformations);
                if (
                    isset($informationsDB['pass']) &&
                    (password_verify($userPassword, $informationsDB['pass'])) == true
                ) {
                    $_SESSION['userLogged'] = $informationsDB;
                    header('Location: /');
                    return null;
                }
                throw new Exception("Les informations sont incorrectes");
            } catch (\Exception $e) {
                $errors = $e->getMessage();
                return $this->twig->render('Login/login.html.twig', ['errors' => $errors]);
            }
        }
        return $this->twig->render('Login/login.html.twig');
    }
}
