<?php

namespace App\Controller;

use App\Model\LoginManager;
use Exception;

class LoginController extends AbstractController
{
    // public function login(): string
    // {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $userInformations = array_map('trim', $_POST);
    //         $userPassword = $userInformations['pass'];
    //         $loginManager = new LoginManager();
    //         try {
    //             $informationsDB = $loginManager->checkInformations($userInformations);
    //         } catch (\Exception $e) {
    //             echo $e->getMessage();
    //         }
    //         if ((password_verify($userPassword, $informationsDB['pass'])) == true) {
    //             $_SESSION = $informationsDB;
    //             return $this->twig->render('Login/welcome.html.twig', ['session' => $_SESSION]);
    //         }
    //         if (isset($informationsDB)) {
    //             return $this->twig->render('Login/login.html.twig', ['userInformations' => $userInformations]);
    //         }
    //     }
    //     return $this->twig->render('Login/login.html.twig');
    // }
}
