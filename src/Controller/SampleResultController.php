<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SampleResultController extends AbstractController
{
    public function result(): Response
    {
        $api = new Api($this->getDoctrine());
        $request = Request::createFromGlobals();

        $specieId = (int) $request->get('specie_id');
        $populationId = (int) $request->get('population_id');
        $colonyId = (int) $request->get('colony_id');
        $familyId = (int) $request->get('family_id');
        $itemId = (int) $request->get('item_id');

        $t =$api->getMelogramsByHierarchy($itemId, $familyId, $colonyId
            , $populationId, $specieId)->getAsArray();
        return $this->render('sample_result.html.twig', $t);
    }

}