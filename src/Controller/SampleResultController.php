<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class SampleResultController extends AbstractController
{
    public function result(): Response
    {
        $api = new Api($this->getDoctrine());
        return $this->render('sample_result.html.twig', $api->getMelogramsList()->getAsArray());
    }

}