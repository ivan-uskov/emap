<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SampleController extends AbstractController
{
    public function sample(): Response
    {
        $api = new Api($this->getDoctrine());
        return $this->render('sample.html.twig', $api->getMelogramsList()->getAsArray());
    }
}