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
            $selected = [];
            foreach ($_POST['skill'] as $skill) {
                $selected[$skill] = $skills[$skill];
                unset($skills[$skill]);
            }

            return $this->twig->render('DragnDrop/index.html.twig', ['skills' => $skills, 'selected' => $selected]);
        }

        return $this->twig->render('DragnDrop/index.html.twig', ['skills' => $skills]);
    }
}
