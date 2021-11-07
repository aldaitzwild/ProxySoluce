<?php

namespace App\Controller;

use App\Model\OfferingManager;
use App\Model\CategoryManager;

class OfferingController extends AbstractController
{
    public function add(): string
    {   $errors = [];

        $offeringManager = new OfferingManager();
        $categoryManager = new CategoryManager();

        $categories = $categoryManager->selectAll();
       
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {   $offering = array_map('trim', $_POST);
            $offering = array_map('htmlentities', $offering);
            $offering = array_map('stripslashes', $offering);
            
            if (empty($_POST['description'])){
                $errors['description'] = "Veuillez remplir la partie description";
            }

            if (empty($_POST['title'])){
                $errors['title'] = "Veuillez remplir la partie titre";
            }

            if (empty($_POST['city'])){
                $errors['city'] = "Veuillez remplir la partie ville";
            }

            if (!empty($errors)) {
                return $this->twig->render('offering/add.html.twig', [
                    'errors' => $errors,
                    'categories' => $categories
                ]);
            }
           
            $offeringManager->insert($offering);
        }
         
        return $this->twig->render('offering/add.html.twig', ['categories' => $categories]);
    }
}    

        




