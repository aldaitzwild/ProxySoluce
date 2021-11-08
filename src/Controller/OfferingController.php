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

        $categories = $categoryManager->selectAll();

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $offering = array_map('trim', $_POST);
            $offering = array_map('stripslashes', $offering);

            if (empty($_POST['description'])) {
                $errors['description'] = "Veuillez remplir la partie description";
            }

            if (empty($_POST['title'])) {
                $errors['title'] = "Veuillez remplir la partie titre";
            }

            if (empty($_POST['city'])) {
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

    /**
     * List items
     */
    public function search(): string
    {
        $offeringManager = new OfferingManager();
        $categoryManager = new CategoryManager();

        $categories = $categoryManager->selectAll();

        $params = ['categories' => $categories];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $data = array_map('trim', $_POST);

            if (!isset($_POST['category'])) {
                $errors[] = "Choisissez une catégorie";
            }
            if (!isset($_POST['city']) || strlen(trim($_POST['city'])) === 0) {
                $errors[] = "Précisez la ville";
            }

            if (count($errors) === 0) {
                $offersByCategory = $offeringManager->selectByCategory($data);

                $params['offers'] = $offersByCategory;
            } else {
                $params['errors'] = $errors;
            }
        }
        return $this->twig->render('Offering/search.html.twig', $params);
    }
}
