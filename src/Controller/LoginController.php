<?php

namespace App\Controller;

use App\Model\LoginManager;

class LoginController extends AbstractController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $infos = array_map('trim', $_POST);
            $infos = array_map('htmlentities', $infos);
            $infos = array_map('stripslashes', $infos);
            $login = new LoginManager();
            if ((($login->checkUser($infos)) == true) && ($login->checkPass($infos)) == true) {
                echo "okay" ;
            } else {
                echo "not ok";
            }
        }
        return $this->twig->render('Login/login.html.twig');
    }
}
