<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use App\Module\Emap\Api\Input\AddMelogramInput;
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

        $melogramName = (string) $request->get('melogram_name');
        $familyId = (int) $request->get('family_id');

        $file = $request->files->get('melogram_file');
        $filePath = $file ? $file->getRealPath() : '';
        $fileContent = $filePath && file_exists($filePath) ? file_get_contents($filePath) : '';

        try
        {
            $api = new Api($this->getDoctrine());
            $api->addMelogram(new AddMelogramInput($melogramName, $familyId, $fileContent));
        }
        catch (\Exception $exception)
        {
            return new Response("Bad Request: " . get_class($exception), 400);
        }

        return $this->redirectToRoute('homepage');
    }

    public function remove(int $id): Response
    {
        if ($id > 0)
        {
            $api = new Api($this->getDoctrine());
            $api->removeMelogram($id);
        }

        return $this->redirectToRoute('homepage');
    }

    public function edit(int $id): Response
    {
        return $this->redirectToRoute('homepage');
    }
}