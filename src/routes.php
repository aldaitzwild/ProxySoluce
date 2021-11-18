<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)

use App\Controller\HomeController;

return [
    '' => ['HomeController', 'home'],
    'login' => ['LoginController', 'login'],
    'inscription' => ['RegisterController', 'add'],
    'welcome' => ['RegisterController', 'welcome'],
    'profile' => ['RegisterController', 'show'],
    'profile/edit' => ['RegisterController', 'edit'],
    'profile/delete' => ['RegisterController', 'delete'],
    'profile/edit/skills' => ['RegisterController', 'editSkills'],
    'profile/edit/skill' => ['DragnDropController', 'updateSkills'],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'skill' => ['DragnDropController', 'index'],
    'offerings/add' => ['OfferingController', 'add'],
    'offerings/search' => ['OfferingController', 'search'],
    'offerings/list' => ['OfferingController', 'list', ['category']],
    'offerings/list/mine' => ['OfferingController', 'listOwnOffers'],
    'offerings/show' => ['OfferingController', 'show', ['id']],
    'offering/delete' => ['OfferingController', 'delete'],
    'offering/update' => ['OfferingController', 'edit', ['id']],
    'offering/showoffer' => ['OfferingController', 'showAll'],
    'logout' => ['LogoutController', 'logout',],
];
