<?php

namespace TodoListBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class TodoListController extends Controller
{
   
   	/**
     * @Route("/", name="homepage")
     */
	 public function indexAction()
     {
		 //redirection list tasklist, faire routing todolist_taskslist_list
         return $this->redirect($this->generateUrl("app.todolist_showtasklist"));
     }
   
	
	
}
