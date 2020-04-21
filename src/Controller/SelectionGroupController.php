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

    public function list(): Response
    {
        return $this->render('selection_group_list.html.twig', ['items' => []]);
    }

    public function remove(int $id): Response
    {

    }

    public function view(int $id): Response
    {

    }

    private function api(): ApiInterface
    {
        return new Api($this->getDoctrine());
    }
}