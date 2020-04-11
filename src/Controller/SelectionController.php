<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SelectionController extends AbstractController
{
    public function selection(): Response
    {
        return $this->render('selection.html.twig');
    }

    public function selections(): Response
    {
        return $this->render("selections_view.html.twig");
    }
}