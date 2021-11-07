<?php

namespace App\Controller;

class DragnDropController extends AbstractController
{
    public function index()
    {
        $skills = [
            'jardinage' => 'Jardinage',
            'maconnerie' => 'Maçonnerie',
            'mecanique' => 'Mécanique',
            'menuiserie' => 'Menuiserie',
            'montage-meuble' => 'Montage de meuble',
            'plomberie' => 'Plomberie',
            'electricite' => 'Electricité',
            'carrelage' => 'Carrelage',
            'carrosserie' => 'Carrosserie',
            'electronique' => 'Electronique',
            'informatique' => 'Informatique',
            'menage' => 'Ménage',
            'repassage' => 'Repassage'
        ];


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
