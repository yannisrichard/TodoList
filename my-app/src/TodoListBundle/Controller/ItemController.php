<?php

namespace TodoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TodoListBundle\Entity\ItemList;
use TodoListBundle\Form\ItemListType;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;


class ItemController extends Controller
{
    public function itemIdAction($id, $idItem, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $itemRepo = $this->getDoctrine()->getRepository('TodoListBundle:ItemList');
        $em = $this->getDoctrine()->getManager();

        $item = $itemRepo->findOneById($idItem);
        if($item == null || ($item->getMainlist()->getId() != $id)) {
            throw new NotFoundHttpException();
        }

        if($request->getMethod() == 'POST'){
           if($request->request->get('done')) {
               $item->inverseDone();
               $em->flush();
           }
        }

        return $this->render('TodoListBundle:Local:itemid.html.twig', array('item' => $item));
    }

    public function itemAddAction($id, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $listRepo = $this->getDoctrine()->getRepository('TodoListBundle:MainList');

        $list = $listRepo->findOneById($id);
        if(!$list) {
            throw new NotFoundHttpException();
        }

        $item = new ItemList();
        $form = $this->get('form.factory')->create(ItemListType::class, $item);

        if ($form->handleRequest($request)->isValid()) {
            $item->setMainlist($list);
            $em->persist($item);
            $em->flush();
            return $this->redirect($this->generateUrl('app.item_item_id', array('id' => $id, 'idItem' => $item->getId())));
        }

        return $this->render('TodoListBundle:Local:itemadd.html.twig', array('form' => $form->createView()));
    }

    public function itemEditAction($id, $idItem, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $itemRepo = $this->getDoctrine()->getRepository('TodoListBundle:ItemList');

        $item = $itemRepo->findOneById($idItem);
        if($item == null || ($item->getMainlist()->getId() != $id)) {
            throw new NotFoundHttpException();
        }

        $form = $this->get('form.factory')->create(ItemListType::class, $item);
        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $em->flush();
            return $this->redirect($this->generateUrl('app.item_item_id', array('id' => $id, 'idItem' => $item->getId())));
        }


        return $this->render('TodoListBundle:Local:itemedit.html.twig', array('form' => $form->createView()));
    }

    public function itemRemoveAction($id,$idItem) {
        $em = $this->getDoctrine()->getManager();
        $itemRepo = $this->getDoctrine()->getRepository('TodoListBundle:ItemList');
        $item = $itemRepo->findOneById($idItem);

        if($item == null || ($item->getMainlist()->getId() != $id)) {
            throw new NotFoundHttpException();
        }

        $em->remove($item);
        $em->flush();
        return $this->redirect($this->generateUrl('app.list_list_id', array('id' => $id)));
    }

}
