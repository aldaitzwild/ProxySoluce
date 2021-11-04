<?php

namespace App\Controller;

use App\Model\OfferingManager;
use App\Model\CategoryManager;

class OfferingController extends AbstractController
{
    public function add(): string
    {
        $offeringManager = new OfferingManager();
        $categoryManager = new CategoryManager();

        $categories = $categoryManager->getAllCategories();
        $params = ['categories' => $categories];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $errors = [];

            $data = array_map('trim', $_POST);

            if (!isset($_POST['category'])) {
                $errors[] = "Choisissez une catégorie";
            }
            if (!isset($_POST['city']) || strlen(trim($_POST['city'])) === 0) {
                $errors[] = "Précisez la ville";
            }else {
                $params['errors'] = $errors;

            } 
            

            $offering=$data;
            $offeringManager = new OfferingManager();
            $offeringManager->insert($offering);

        
        }
            return $this->twig->render('offering/add.html.twig', $params);
    }
}    

        



/*
            // clean $_POST data
            $offering = array_map('trim', $_POST);
            
            // TODO validations (length, format...)
            $offering = array_map('htmlentities', $offering);
            $offering = array_map('stripslashes', $offering);
            
            
            

            // if validation is ok, insert and redirection
            $offeringManager = new OfferingManager();
            $offeringManager->insert($offering);

            header('Location:/offering/add');
        }

        return $this->twig->render('offering/add.html.twig');
    }*/
