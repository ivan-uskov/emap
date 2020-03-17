<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Input\UpdateMelogramInput;
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

    public function addAjax(): Response
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

    public function editAjax(int $id): Response
    {
        $request = Request::createFromGlobals();
        if ($request->getMethod() !== Request::METHOD_POST)
        {
            return new Response("Not Found",404);
        }

        $melogramName = (string) $request->get('melogram_name');
        $familyId = (int) $request->get('family_id');

        $file = $request->files->get('melogram_file');
        $filePath = $file ? $file->getRealPath() : null;
        $fileContent = $filePath && file_exists($filePath) ? (string) file_get_contents($filePath) : null;

        try
        {
            $api = new Api($this->getDoctrine());
            $api->updateMelogram(new UpdateMelogramInput($id, $melogramName, $familyId, $fileContent));
        }
        catch (\Exception $exception)
        {
            return new Response("Bad Request: " . get_class($exception), 400);
        }

        return $this->redirectToRoute('edit_melogram', ['id' => $id]);
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
        $api = new Api($this->getDoctrine());
        $melogram = $api->getMelogram($id);

        return $this->render('melogram.html.twig', ['hierarchy' => $api->getHierarchyVariantsList()->asAssoc(), 'melogram' => $melogram->asArray()]);
    }
}