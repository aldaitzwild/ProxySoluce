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
                return $this->twig->render('Offering/add.html.twig', [
                    'errors' => $errors,
                    'categories' => $categories
                ]);
            }

            $offeringManager->insert($offering);
        }

        return $this->twig->render('Offering/add.html.twig', ['categories' => $categories]);
    }

    /**
     * List items
     */
    public function search(): string
    {
        $offeringManager = new OfferingManager();
        $categoryManager = new CategoryManager();

        $categories = $categoryManager->selectAll('name');

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
                if (count($offersByCategory) === 0) {
                    $params['empty'] = 'No offers available for this request.';
                }
                $params['offers'] = $offersByCategory;
            } else {
                $params['errors'] = $errors;
            }
        }
        return $this->twig->render('Offering/search.html.twig', $params);
    }

    /* Display offer */

    public function show(int $id, int $userid): string
    {
        $params = [];
        $offeringManager = new OfferingManager();
        $offer = $offeringManager->selectOfferById($id);
        $skills = $offeringManager->selectSkillsByUserId($userid);
        $params['offer'] = $offer;
        $params['skills'] = $skills;



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = array_map('trim', $_POST);
            $visitorEmail = $data['email'];
            $visitorMessage = $data['message'];
            $offerTitle = $data['title'];

            $errors = [];

            if (!filter_var($visitorEmail, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format d'email invalide, veuillez corriger le champ 'email'.";
            }

            if (empty($visitorMessage)) {
                $errors[] = "Message vide, veuillez compléter le champ 'message'.";
            }

            if (count($errors) > 0) {
                $params['errors'] = $errors;
            } else {
                $recipient = $offer['mail'];
                $subject = "Demande de contact pour votre annonce: $offerTitle";
                $subjectSender = "Demande de contact pour votre annonce: $offerTitle";

                $message = $data['message'];
                $messageSender = "Voici une copie de votre message \n" . $message;

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <enquiry@example.com>' . "\r\n";

                mail($recipient, $subject, $message, $headers);
                mail($visitorEmail, $subjectSender, $messageSender, $headers);

                $params['success'] = 'Message envoyé, Merci.';
            }
        }

        return $this->twig->render('Offering/show.html.twig', $params);
    }
}
