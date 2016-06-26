<?php

namespace TodoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use TodoListBundle\Entity\ItemList;
use TodoListBundle\Form\ItemListType;

class ItemGoogleController extends Controller
{
    public function itemIdAction($id, $idItem, Request $request)
    {
        $client = $this->get('app_google.item_list_client');

        $item = $client->get($id, $idItem);
        if ($item == null || ($item->getMainlist()->getId() != $id)) {
            throw new NotFoundHttpException();
        }

        if ($request->getMethod() == 'POST') {
            if ($request->request->get('done')) {
                $item->inverseDone();
                $item = $client->update($id, $item);
            }
        }

        return $this->render('TodoListBundle:Google:itemid.html.twig', array('item' => $item));
    }

    public function itemAddAction($id, Request $request)
    {
        $client = $this->get('app_google.main_list_client');

        $list = $client->get($id);
        if (!$list) {
            throw new NotFoundHttpException();
        }

        $item = new ItemList();
        $form = $this->get('form.factory')->create(ItemListType::class, $item);

        if ($form->handleRequest($request)->isValid()) {
            $item->setMainlist($list);
            $client = $this->get('app_google.item_list_client');
            $item = $client->insert($id, $item);

            return $this->redirect($this->generateUrl('app.item_google_item_id', array('id' => $id, 'idItem' => $item->getId())));
        }

        return $this->render('TodoListBundle:Google:itemadd.html.twig', array('form' => $form->createView()));
    }

    public function itemEditAction($id, $idItem, Request $request)
    {
        $client = $this->get('app_google.item_list_client');

        $item = $client->get($id, $idItem);
        if ($item == null || ($item->getMainlist()->getId() != $id)) {
            throw new NotFoundHttpException();
        }

        $form = $this->get('form.factory')->create(ItemListType::class, $item);
        if ($form->handleRequest($request)->isValid()) {
            $item = $client->update($id, $item);

            return $this->redirect($this->generateUrl('app.item_google_item_id', array('id' => $id, 'idItem' => $item->getId())));
        }

        return $this->render('TodoListBundle:Google:itemedit.html.twig', array('form' => $form->createView()));
    }

    public function itemRemoveAction($id, $idItem)
    {
        $client = $this->get('app_google.item_list_client');

        $item = $client->get($id, $idItem);
        if ($item == null || ($item->getMainlist()->getId() != $id)) {
            throw new NotFoundHttpException();
        }

        $client->delete($id, $idItem);

        return $this->redirect($this->generateUrl('app.list_google_list_id', array('id' => $id)));
    }
}
