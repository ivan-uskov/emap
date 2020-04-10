<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SelectionResultController extends AbstractController
{
    private function isDuplicate($item, $itemsArray): bool
    {
        foreach ($itemsArray as $currentItem)
        {
            if($item == $currentItem)
            {
                return true;
            }
        }
        return false;
    }

    private function createNewArrayWithoutDuplicates($array)
    {
        $result = array();
        foreach ($array as $item)
        {
            if(!$this->isDuplicate($item, $result)) {
                array_push($result, $item);
            }
        }
        return $result;
    }

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
            $selectResult = $api->getMelogramsByHierarchy($itemId, $familyId, $colonyId
                , $populationId, $specieId)->getAsArray();
            $items = $selectResult["items"];
            $result = array_merge($result, $items);
        }

        $result = $this->createNewArrayWithoutDuplicates($result);

        return $this->render('selection_result.html.twig', array("selection_result" => $result));
    }

}