<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use App\Module\Emap\Api\ApiInterface;
use App\Module\Emap\Api\Input\AddMelogramInput;
use App\Module\Emap\Api\Input\UpdateMelogramInput;
use App\Module\MusicXML\Api\Api as MusicXMLApi;
use App\View\CommonView;
use App\View\MelogramView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\Request;

class MelogramController extends AbstractController
{
    public function page(): Response
    {
        return $this->render('melogram.html.twig');
    }

    private function buildTemplateParams(array $result, bool $alreadySaved = false): array
    {
        $common = (new CommonView($result))->getData();

        return [
            'selection_result' => $result,
            'items' => json_encode(array_keys($result), JSON_THROW_ON_ERROR, 512),
            'common_result' => json_encode($common, JSON_THROW_ON_ERROR, 512),
            'already_saved' => $alreadySaved,
        ];
    }

    public function addAjax(): Response
    {
        return $this->withApiAndRequest(function (ApiInterface $api, Request $request) {
            if ($request->getMethod() !== Request::METHOD_POST)
            {
                return new Response('Not Found', 404);
            }

            $specieId = (int)$request->get('specie_id');
            $populationId = (int)$request->get('population_id');
            $colonyId = (int)$request->get('colony_id');
            $familyId = (int)$request->get('family_id');
            $itemId = (int)$request->get('item_id');

            $file = $request->files->get('melody_file');
            $filePath = $file ? $file->getRealPath() : '';
            $fileContent = $filePath && file_exists($filePath) ? file_get_contents($filePath) : '';

            $api->addMelogram(new AddMelogramInput(
                $itemId,
                $familyId,
                $colonyId,
                $populationId,
                $specieId,
                $fileContent
            ));

            return $this->redirectToRoute('homepage');
        });
    }

    public function export(int $id): Response
    {
        $api = new Api($this->getDoctrine());
        $melogram = $api->getMelogram($id);
        if ($melogram === null)
        {
            return new Response('Not Found',404);
        }

        return new Response($melogram->getFile(),200, [
            'Content-Type' => 'text/xml',
            'Cache-Control' => 'public',
            'Content-Length' => strlen($melogram->getFile()),
            'Content-Disposition' => 'attachment; filename=' . $melogram->getUid() . '.musicxml',
        ]);
    }

    public function editAjax(int $id): Response
    {
        return $this->withApiAndRequest(function (ApiInterface $api, Request $request) use ($id) {
            if ($request->getMethod() !== Request::METHOD_POST)
            {
                return new Response('Not Found',404);
            }

            $specieId = (int) $request->get('specie_id');
            $populationId = (int) $request->get('population_id');
            $colonyId = (int) $request->get('colony_id');
            $familyId = (int) $request->get('family_id');
            $itemId = (int) $request->get('item_id');

            $file = $request->files->get('melogram_file');
            $filePath = $file ? $file->getRealPath() : null;
            $fileContent = $filePath && file_exists($filePath) ? (string) file_get_contents($filePath) : null;

            $api->updateMelogram(new UpdateMelogramInput(
                $id,
                $itemId,
                $familyId,
                $colonyId,
                $populationId,
                $specieId,
                $fileContent
            ));

            return $this->redirectToRoute('edit_melogram', ['id' => $id]);
        });
    }

    public function remove(int $id): Response
    {
        if ($id > 0)
        {
            $api = new Api($this->getDoctrine());
            $api->removeMelogram($id);
        }

        return $this->redirectToRoute('selections_list');
    }

    private function buildElement(string $uid, string $file): array
    {
        $view = new MelogramView((new MusicXMLApi())->parse($file));
        return [
            'view' => $view,
            'uid' => $uid,
            'file' => $file,
            'melogram' => json_encode($view->getData(), JSON_THROW_ON_ERROR, 512),
        ];
    }

    public function edit(int $id): Response
    {
        $api = new Api($this->getDoctrine());
        $melogram = $api->getMelogram($id);

        if ($melogram === null)
        {
            return new Response('Not Found',404);
        }
        $hierarchy = $api->getMelogramHierarchyData($id)->asArray();
        $result = [];
        foreach ($api->getMelogramsByHierarchy($hierarchy["item"]
            , $hierarchy["family"], $hierarchy["colony"], $hierarchy["population"]
            , $hierarchy["specie"])->getAsArray() as $m)
        {
            $result[$m['uid']] = $this->buildElement($m['uid'], $m['file']);
        }

        return $this->render('melogram.html.twig', ['melogram' => $melogram->asArray()
            , 'common_result' => $this->buildTemplateParams($result)["common_result"]]);
    }

    private function withApiAndRequest(callable $fn): Response
    {
        try
        {
            $request = Request::createFromGlobals();
            $api = new Api($this->getDoctrine());
            return $fn($api, $request);
        }
        catch (\Exception $exception)
        {
            return new Response('Bad Request: ' . get_class($exception) . ' ' . $exception->getMessage(), 400);
        }
    }
}