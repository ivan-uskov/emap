<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

class MelogramController extends AbstractController
{
    public function page(): Response
    {
        $api = new Api($this->getDoctrine());

        return $this->render('melogram.html.twig', ['hierarchy' => $api->getHierarchyVariantsList()->asAssoc()]);
    }

    public function ajax(): Response
    {
        $request = Request::createFromGlobals();
        if ($request->getMethod() !== Request::METHOD_POST)
        {
            return new Response("Not Found",404);
        }

        $melogramName = (string) $request->query->get('melogram_name');

        $api = new Api($this->getDoctrine());

        return $this->render('melogram.html.twig', ['hierarchy' => $api->getHierarchyVariantsList()->asAssoc()]);
    }
}