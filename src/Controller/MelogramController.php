<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MelogramController extends AbstractController
{
    public function page(): Response
    {
        return $this->render('melogram.html.twig');
    }
}