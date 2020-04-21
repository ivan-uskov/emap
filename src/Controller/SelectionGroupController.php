<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
use App\Module\Emap\Api\ApiInterface;
use App\View\SelectionGroupView;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SelectionGroupController extends AbstractController
{
    public function add(): Response
    {
        return $this->render('selection_group.html.twig');
    }

    public function preview(): Response
    {
        $selectionIds = array_unique(Request::createFromGlobals()->get('select'));
        sort($selectionIds);

        $selections = array_filter(array_map(fn($id) => $this->api()->getSelection((int) $id), $selectionIds));

        if (empty($selections))
        {
            return $this->redirectToRoute('add_selection_group');
        }

        return $this->render('selection_group_result.html.twig', (new SelectionGroupView($selections))->asArray());
    }

    public function addAjax(): Response
    {
        return $this->withApiAndRequest(function (ApiInterface $api, Request $request) {
            $api->addSelectionGroup(json_decode($request->get('items'), true, 512, JSON_THROW_ON_ERROR));
            return $this->redirectToRoute('selection_groups_list');
        });
    }

    public function list(): Response
    {
        return $this->render('selection_group_list.html.twig', ['items' => $this->api()->getSelectionGroups()->asArray()]);
    }

    public function remove(int $id): Response
    {
        $this->api()->removeSelectionGroup($id);
        return $this->redirectToRoute('selection_groups_list');
    }

    public function view(int $id): Response
    {

    }

    private function withApiAndRequest(callable $fn): Response
    {
        try
        {
            $request = Request::createFromGlobals();
            return $fn($this->api(), $request);
        }
        catch (\Exception $exception)
        {
            return new Response('Bad Request: ' . get_class($exception) . ' ' . $exception->getMessage(), 400);
        }
    }

    private function api(): ApiInterface
    {
        return new Api($this->getDoctrine());
    }
}