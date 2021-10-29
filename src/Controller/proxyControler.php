<?php

namespace App\Controller;

use App\Model\personManager;

class ItemController extends AbstractController
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // clean $_POST data
        $item = array_map('trim', $_POST);

        // TODO validations (length, format...)

        // if validation is ok, insert and redirection
        $personManager = new personManager();
        $id = $personManager->insert($person);
        header('Location:/person');
    }

    return $this->twig->render('person/add.html.twig');
}

}