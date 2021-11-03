<?php

namespace App\Controller;

use App\Model\OfferingManager;

class OfferingController extends AbstractController
{
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $offering = $category = array_map('trim', $_POST);
            
            // TODO validations (length, format...)

            // if validation is ok, insert and redirection

            $offeringManager = new OfferingManager();
            $id = $offeringManager->insert($offering);

            header('Location:/offering/add');
        }

        return $this->twig->render('offering/add.html.twig');
    }

}