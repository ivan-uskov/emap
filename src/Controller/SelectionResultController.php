<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
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
        $result = array();
        foreach ($selections as $select)
        {
            $specieId = (int) $select['specie_id'];
            $populationId = (int) $select['population_id'];
            $colonyId = (int) $select['colony_id'];
            $familyId = (int) $select['family_id'];
            $itemId = (int) $select['item_id'];
            $t = $api->getMelogramsByHierarchy($itemId, $familyId, $colonyId
                , $populationId, $specieId)->getAsArray();
            $items = $t["items"];
            $result = array_merge($result, $items);
        }
        return $this->render('selection_result.html.twig', array("selection_result" => $result));
    }

}