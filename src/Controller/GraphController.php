<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GraphController extends AbstractController
{
    public function graph(): Response
    {
        $api = new Api($this->getDoctrine());
        return $this->render('graph.html.twig', ['noteList' => json_encode($api->getNoteList())]);
    }
}