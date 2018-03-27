<?php

namespace Edogawa\App\Controllers;

use Edogawa\Core\Controllers\EdogawaController;

/**
 * Class Erreur
 * @package Edogawa\App\Controllers
 */
class Erreur extends EdogawaController
{
    /**
     * Affiche la page d'erreur correspondant au code 404
     */
    public function Erreur404()
    {
        return $this->render('Errors/404');
    }
}
