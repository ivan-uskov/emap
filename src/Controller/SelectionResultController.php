<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use App\Module\MusicXML\Api\Api as MusicXMLApi;
use App\View\MelogramView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SelectionResultController extends AbstractController
{
    public function result(): Response
    {
        $api = new Api($this->getDoctrine());
        $request = Request::createFromGlobals();

        $selections = $request->get('select');
        $result = [];
        foreach ($selections as $select)
        {
            $specieId = (int) $select['specie_id'];
            $populationId = (int) $select['population_id'];
            $colonyId = (int) $select['colony_id'];
            $familyId = (int) $select['family_id'];
            $itemId = (int) $select['item_id'];

            foreach ($api->getMelogramsByHierarchy($itemId, $familyId, $colonyId, $populationId, $specieId)->getAsArray() as $m)
            {
                $res = (new MusicXMLApi())->parse($m['file']);
                $view = new MelogramView($res);

                $result[$m['uid']] = [
                    'uid' => $m['uid'],
                    'file' => $m['file'],
                    'melogram' => json_encode($view->getData(), JSON_THROW_ON_ERROR, 512),
                ];
            }
        }

        return $this->render('selection_result.html.twig', ['selection_result' => $result]);
    }
}