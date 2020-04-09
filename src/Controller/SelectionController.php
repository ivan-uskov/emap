<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SelectionController extends AbstractController
{
    public function sample(): Response
    {
        return $this->render('selection.html.twig');
    }

    public function selections(): Response
    {
        return $this->render("selections_view.html.twig");
    }
}