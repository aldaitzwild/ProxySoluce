<?php

namespace App\Controller;

use App\Model\SkillManager;

class DragnDropController extends AbstractController
{
    public function index()
    {
        $skillManager = new SkillManager();
        $skills = $skillManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['skill'])) {
            $skillManager->assignSkill($_POST['userId'], $_POST['skill']);
            header('Location:/welcome');
        }
        return $this->twig->render('DragnDrop/index.html.twig', ['skills' => $skills]);
    }

    public function updateSkills()
    {
        $skillManager = new SkillManager();
        $skills = $skillManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['skill']) && isset($_POST['update'])) {
            $skillManager->updateSkills($_POST['userId'], $_POST['skill']);
            header('Location:/profile');
        }
        return $this->twig->render('DragnDrop/index.html.twig', ['skills' => $skills]);
    }
}
