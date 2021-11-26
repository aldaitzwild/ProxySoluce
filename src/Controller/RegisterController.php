<?php

namespace App\Controller;

use App\Model\OfferingManager;
use App\Model\RegisterManager;
use App\Model\SkillManager;

class RegisterController extends AbstractController
{
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $register = array_map('trim', $_POST);
            $register = array_map('stripslashes', $register);
            $errors = $this->checkInformations($_POST);
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

    private function checkInformations(array $info)
    {
        $errors = array();
        if (!filter_var($info['mail'], FILTER_VALIDATE_EMAIL)) {
            $errors['mail'] = "Ceci n'est pas un email";
        }
        if ($this->regexUser($info['user'])) {
            $errors['username'] = "Dois faire minimum 5 caractères.";
        }
        if ($info['pass'] != $info['confirm'] || $this->regexPass($info['pass'])) {
            $errors['pass'] = "Dois contenir au moins 8 caractères, 1 minuscule, 1 majuscule et 1 chiffre.";
        }
        foreach ($info as $index => $value) {
            $errors = $this->processingErrors($index, $value, $errors);
        }
        return $errors;
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
                $file = $uniqueName . "." . $extension;
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


    public function show(): ?string
    {
        if (!isset($_SESSION['userLogged'])) {
            header('Location: /login');
            return null;
        } else {
            return $this->twig->render('Login/show.html.twig');
        }
    }

    public function edit(): ?string
    {
        if (!isset($_SESSION['userLogged'])) {
            header('Location: /login');
            return null;
        } else {
            $userId = $_SESSION['userLogged']['id'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $register = array_map('trim', $_POST);
                $register = array_map('stripslashes', $register);
                $errors = $this->checkInformations($_POST);
                if ($_FILES['picture']['name'] != '') {
                    $register['picture'] = $this->addImage($_FILES);
                }

                // AFFICHER ERREUR ET ARRETER SUITE DU SCRIPT
                if (!empty($errors)) {
                    return $this->twig->render('Login/inscription.html.twig', [
                        'errors' => $errors,
                        'edit' => true,
                        'register' => $register,
                    ]);
                }

                $registerManager = new RegisterManager();
                $updateState = $registerManager->update($register, $userId);

                if ($updateState) {
                    foreach ($register as $key => $item) {
                        $_SESSION['userLogged'][$key] = $item;
                    }
                }
                header('Location: /profile');
                return null;
            } else {
                $register = $_SESSION['userLogged'];
                return $this->twig->render('Login/inscription.html.twig', [
                    'edit' => true,
                    'register' => $register,
                ]);
            }
        }
    }

    public function editSkills(): ?string
    {
        if (!isset($_SESSION['userLogged'])) {
            header('Location: /login');
            return null;
        } else {
            $userId = $_SESSION['userLogged']['id'];

            $skillManager = new SkillManager();
            $skills = $skillManager->selectAll();

            $selected = $skillManager->selectSkillsByUserId($userId);

            foreach ($selected as $item) {
                $skills = $this->cleanArray($skills, $item['id']);
            }

            $params = ['skills' => $skills, 'selected' => $selected, 'userId' => $userId, 'update' => true];

            return $this->twig->render('DragnDrop/index.html.twig', $params);
        }
    }

    private function cleanArray($array, $term)
    {
        $matches = array();
        foreach ($array as $a) {
            if ($a['id'] != $term) {
                $matches[] = $a;
            }
        }
        return $matches;
    }

    public function delete(): ?string
    {
        if (!isset($_SESSION['userLogged'])) {
            header('Location: /login');
            return null;
        } else {
            $userId = $_SESSION['userLogged']['id'];

            $offeringManager = new OfferingManager();
            $offeringManager->deleteOffersByUserId($userId);

            $skillManager = new SkillManager();
            $skillManager->deleteSkillsByUserId($userId);

            $registerManager = new RegisterManager();
            $registerManager->deleteUserById($userId);

            session_destroy();

            header('Location: /');
            return null;
        }
    }
}
