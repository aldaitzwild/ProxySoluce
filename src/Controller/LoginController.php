<?php

namespace App\Controller;

use App\Model\LoginManager;
use Exception;

class LoginController extends AbstractController
{
    public function login(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userInformations = array_map('trim', $_POST);

            $userPassword = $userInformations['pass'];

            $loginManager = new LoginManager();

            try {
                $informationsDB = $loginManager->checkInformations($userInformations);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            if (isset($informationsDB)) {
                if ((password_verify($userPassword, $informationsDB['pass'])) == true) {
                    $_SESSION['userLogged'] = $informationsDB['user'];
                }
            }

            var_dump($_SESSION['userLogged']);
            /* return $this->twig->render('Login/login.html.twig', ['userInformations' => $userInformations]); */
        }
        return $this->twig->render('Login/login.html.twig');
    }
}

// Le problème est le suivant :
// J'arrive a vérifier le nom d'utilisateur
// Mais
// je n'arrive pas a vérifier le pass entre la DB et le POST
// Le hash ce fait bien dans la base de donnée
// je ne récupère pas le hash
// NOOOOOOON
// La solution n'est plus très loin.
// J'ai pas regarder sans le hashage.
// Problème ligne 20.
