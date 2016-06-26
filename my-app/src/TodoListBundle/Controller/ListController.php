<?php

namespace TodoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use TodoListBundle\Entity\MainList;
use TodoListBundle\Form\MainListType;

class ListController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listRepo = $em->getRepository('TodoListBundle:MainList');

        $lists = $listRepo->findAll();

        return $this->render('TodoListBundle:Local:list.html.twig', array('lists' => $lists));
    }

    public function listIdAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listRepo = $this->getDoctrine()->getRepository('TodoListBundle:MainList');

        $list = $listRepo->findOneById($id);
        if ($list == null) {
            throw new NotFoundHttpException();
        }

        if ($request->getMethod() == 'POST') {
            if ($request->request->get('done') && $request->request->get('id')) {
                foreach ($list->getItemlists() as $value) {
                    if ($value->getId() == $request->request->get('id')) {
                        $value->inverseDone();
                        break;
                    }
                }
                $em->flush();
            }
        }

        return $this->render('TodoListBundle:Local:listid.html.twig', array('list' => $list));
    }

    public function listAddAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $mainlist = new MainList();
        $form = $this->get('form.factory')->create(MainListType::class, $mainlist);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mainlist);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Task saved.');

            return $this->redirect($this->generateUrl('app.list_list_id', array('id' => $mainlist->getId())));
        }

        return $this->render('TodoListBundle:Local:listadd.html.twig', array('form' => $form->createView()));
    }

    public function listEditAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listrepo = $em->getRepository('TodoListBundle:MainList');

        $mainlist = $listrepo->findOneById($id);
        if ($mainlist == null) {
            throw new NotFoundHttpException();
        }
        $form = $this->get('form.factory')->create(MainListType::class, $mainlist);

        if ($form->handleRequest($request)->isValid()) {
            $data = $form->getData();
            $em->flush();

            return $this->redirect($this->generateUrl('app.list_list_id', array('id' => $mainlist->getId())));
        }

        return $this->render('TodoListBundle:Local:listedit.html.twig', array('form' => $form->createView()));
    }

    public function listRemoveAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mainlist = $em->getRepository('TodoListBundle:MainList')->findOneById($id);

        if ($mainlist == null) {
            throw new NotFoundHttpException();
        }

        $em->remove($mainlist);
        $em->flush();

        return $this->redirect($this->generateUrl('app.list_list'));
    }
}
