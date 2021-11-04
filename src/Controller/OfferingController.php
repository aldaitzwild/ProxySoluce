<?php

namespace App\Controller;

use App\Model\OfferingManager;

class OfferingController extends AbstractController
{
    /**
     * List items
     */
    public function search(): string
    {
        $offeringManager = new OfferingManager();

        $categories = $offeringManager->getAllCategories();
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
