<?php


namespace App\Controller;

use App\Module\Emap\Api\Api;
use App\Module\Emap\Api\ApiInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SelectionController extends AbstractController
{
    public function selection(): Response
    {
        return $this->render('selection.html.twig');
    }

    public function selections(): Response
    {
        return $this->render('selections_view.html.twig', ['items' => $this->api()->getSelections()->asArray()]);
    }

    public function remove(int $id): Response
    {
        $this->api()->removeSelection($id);
        return $this->redirectToRoute('selections_list');
    }

    public function add(): Response
    {
        return $this->withApiAndRequest(function (ApiInterface $api, Request $request) {
            $api->addSelection(json_decode($request->get('items'), true, 512, JSON_THROW_ON_ERROR));
            return $this->redirectToRoute('selections_list');
        });
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