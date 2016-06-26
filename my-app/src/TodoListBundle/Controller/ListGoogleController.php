<?php

namespace TodoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use TodoListBundle\Entity\MainList;
use TodoListBundle\Form\MainListType;

class ListGoogleController extends Controller
{
    public function listAction()
    {
        $client = $this->get('app_google.main_list_client');
        $lists = $client->getAll();

        return $this->render('TodoListBundle:Google:list.html.twig', array('lists' => $lists));
    }

    public function listIdAction($id, Request $request)
    {
        $client = $this->get('app_google.main_list_client');
        $list = $client->get($id);
        if ($list == null) {
            throw new NotFoundHttpException();
        }

        if ($request->getMethod() == 'POST') {
            if ($request->request->get('done') && $request->request->get('id')) {
                foreach ($list->getItemlists() as $value) {
                    if ($value->getId() == $request->request->get('id')) {
                        $value->inverseDone();
                        $itemclient = $this->get('app_google.item_list_client');
                        $itemclient->update($id, $value);
                        break;
                    }
                }
            }
        }

        return $this->render('TodoListBundle:Google:listid.html.twig', array('list' => $list));
    }

    public function listAddAction(Request $request)
    {
        $mainlist = new MainList();
        $form = $this->get('form.factory')->create(MainListType::class, $mainlist);

        if ($form->handleRequest($request)->isValid()) {
            $client = $this->get('app_google.main_list_client');
            $mainlist = $client->insert($mainlist);

            return $this->redirect($this->generateUrl('app.list_google_list_id', array('id' => $mainlist->getId())));
        }

        return $this->render('TodoListBundle:Google:listadd.html.twig', array('form' => $form->createView()));
    }

    public function listEditAction($id, Request $request)
    {
        $client = $this->get('app_google.main_list_client');

        $mainlist = $client->get($id);
        if ($mainlist == null) {
            throw new NotFoundHttpException();
        }
        $form = $this->get('form.factory')->create(MainListType::class, $mainlist);
        if ($form->handleRequest($request)->isValid()) {
            $mainlist = $client->update($mainlist);

            return $this->redirect($this->generateUrl('app.list_google_list_id', array('id' => $mainlist->getId())));
        }

        return $this->render('TodoListBundle:Google:listedit.html.twig', array('form' => $form->createView()));
    }

    public function listRemoveAction($id)
    {
        $client = $this->get('app_google.main_list_client');

        $mainlist = $client->get($id);
        if ($mainlist == null) {
            throw new NotFoundHttpException();
        }

        $client->delete($id);

        return $this->redirect($this->generateUrl('app.list_google_list'));
    }
}
