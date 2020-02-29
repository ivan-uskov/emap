<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function home(): Response
    {
        $api = new Api($this->getDoctrine());
        return $this->render('home.html.twig', $api->getMelogramsList()->getAsArray());
    }
}