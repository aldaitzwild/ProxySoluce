<?php

namespace App\Controller;

use App\Model\RegisterManager;
use App\Model\SkillManager;

class RegisterController extends AbstractController
{
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $register = array_map('trim', $_POST);
            $register = array_map('htmlentities', $register);
            $register = array_map('stripslashes', $register);
            $errors = array();
            if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                $errors['mail'] = "Ceci n'est pas un email";
            }
            if ($this->regexUser($_POST['user'])) {
                $errors['username'] = "Dois faire minimum 5 caractères.";
            }
            if ($_POST['pass'] != $_POST['confirm'] || $this->regexPass($_POST['pass'])) {
                $errors['pass'] = "Dois contenir au moins 8 caractères, 1 minuscule, 1 majuscule et 1 chiffre.";
            }
            foreach ($_POST as $index => $value) {
                $errors = $this->processingErrors($index, $value, $errors);
            }
            $register['picture'] = $this->addImage($_FILES);
            // AFFICHER ERREUR ET ARRETER SUITE DU SCRIPT
            if (!empty($errors)) {
                return $this->twig->render('Login/inscription.html.twig', [
                    'errors' => $errors,
                    'register' => $register,
                ]);
            }
            $registerManager = new RegisterManager();
            $userId = $registerManager->insert($register);
            $skillManager = new SkillManager();
            $skills = $skillManager->selectAll();
            return $this->twig->render('DragnDrop/index.html.twig', ['skills' => $skills, 'userId' => $userId]);
        }
        return $this->twig->render('Login/inscription.html.twig');
    }

    public function addImage(array $files): string
    {
        if (isset($files['picture'])) {
            $tmpName = $files['picture']['tmp_name'];
            $name = $files['picture']['name'];
            $size = $files['picture']['size'];
            $extensionsOk = ['jpg', 'png', 'jpeg'];
            $maxSize = 1000000;
            $errors = $files['picture']['error'];
            $tabExtension = explode('.', $name);
            $extension = strtolower(end($tabExtension));
            if (in_array($extension, $extensionsOk) && $size <= $maxSize && $errors == 0) {
                $uniqueName = uniqid('', true);
                $file = $uniqueName . " . " . $extension;
                move_uploaded_file($tmpName, '. /../../public/uploads/' . $file);
                return $file;
            }
        }
        return '';
    }

    public function processingErrors(string $index, $value, array $errors)
    {
        if (empty($value)) {
            $errors[$index] = $index . "Ne correspond pas aux champs indiqués";
        }
        return $errors;
    }

    public function welcome()
    {
        return $this->twig->render('Login/welcome.html.twig');
    }

    public function regexPass($pass): bool
    {
        return !filter_var($pass, FILTER_VALIDATE_REGEXP, array(
            "options" => array("regexp" => "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/")
        ));
    }

    public function regexUser($user): bool
    {
        return !filter_var($user, FILTER_VALIDATE_REGEXP, array(
            "options" => array("regexp" => "/^[A-Za-z][A-Za-z0-9]{4,31}$/")
        ));
    }
}
