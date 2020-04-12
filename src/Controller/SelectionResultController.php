<?php

namespace App\Controller;

use App\Module\Emap\Api\Api;
use App\Module\Emap\Api\ApiInterface;
use App\Module\MusicXML\Api\Api as MusicXMLApi;
use App\View\CommonView;
use App\View\MelogramView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SelectionResultController extends AbstractController
{
    public function view(int $id): Response
    {
        $selection = $this->api()->getSelection($id);
        if ($selection === null)
        {
            return new Response('Not Found', 404);
        }

        $result = [];
        foreach ($selection->getUidsWithFiles() as $uid => $file)
        {
            $result[$uid] = $this->buildElement($uid, $file);
        }

        return $this->render('selection_result.html.twig', $this->buildTemplateParams($result, true));
    }

    public function result(): Response
    {
        $result = [];
        $selections = Request::createFromGlobals()->get('select');
        foreach ($selections as $select)
        {
            $specieId = (int) $select['specie_id'];
            $populationId = (int) $select['population_id'];
            $colonyId = (int) $select['colony_id'];
            $familyId = (int) $select['family_id'];
            $itemId = (int) $select['item_id'];

            foreach ($this->api()->getMelogramsByHierarchy($itemId, $familyId, $colonyId, $populationId, $specieId)->getAsArray() as $m)
            {
                $result[$m['uid']] = $this->buildElement($m['uid'], $m['file']);
            }
        }
        if (empty($result))
        {
            return $this->redirectToRoute('selection');
        }

        return $this->render('selection_result.html.twig', $this->buildTemplateParams($result));
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

    private function api(): ApiInterface
    {
        return new Api($this->getDoctrine());
    }
}