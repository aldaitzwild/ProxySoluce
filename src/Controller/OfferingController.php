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

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $category = null;
            $city = null;

            if (!isset($_POST['category'])) {
                $errors[] = "Choisissez une catégorie";
            } else {
                $category = $_POST['category'];
            }
            if (!isset($_POST['city']) || strlen(trim($_POST['city'])) === 0) {
                $errors[] = "Précisez la ville";
            } else {
                $city = $_POST['city'];
            }

            if (count($errors) === 0) {
                $offersByCategory = $offeringManager->selectByCategory($category, $city);

                return $this->twig->render(
                    'Offering/search.html.twig',
                    [
                        'categories' => $categories,
                        'offers' => $offersByCategory
                    ]
                );
            } else {
                return $this->twig->render(
                    'Offering/search.html.twig',
                    [
                        'categories' => $categories,
                        'errors' => $errors
                    ]
                );
            }
        } else {
            return $this->twig->render(
                'Offering/search.html.twig',
                [
                    'categories' => $categories,
                ]
            );
        }
    }
}
