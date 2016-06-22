<?php

namespace TodoListBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use \DateTime;

use TodoListBundle\Entity\TaskList;
use TodoListBundle\Entity\Task;
use TodoListBundle\Form\TaskListType;
use TodoListBundle\Form\TaskType;




class TaskListController extends Controller
{
   
   	/**
     * @Route("/", name="homepage")
     */
	 public function indexAction()
     {
         return $this->redirect($this->generateUrl("app.todolist_showtasklist"));
     }
   
	/**
     * @Route("/tasklist/createTastTest", name="taskTest")
     */	
	public function createTaskTestAction()
	{
		$tasklist = new TaskList();
		$tasklist->setName('Liste Defaut');
		
		$task = new Task();
		$task->setName('Task1');
		$task->setStatut('Terminé');
		//$tasklist->getId() est null donc 1 pour tester
		$task->setTaskListID(1);

		$em = $this->getDoctrine()->getManager();

		//Dit à doctrine que tu veux save l'objet 
		$em->persist($tasklist);
		$em->persist($task);
		//execute requête
		$em->flush();

		return new Response('Saved new task and tasklist');
	}
	
	/**
     * @Route("/tasklist/show/{idList}", name="idList")
     */	
	public function showTasksAction($idList, Request $request)
	{
		$taskList = $this->getDoctrine()->getRepository('TodoListBundle:TaskList')->find($idList);
		$repository = $this->getDoctrine()->getRepository('TodoListBundle:Task');
        $tasks = $repository->findByTaskListID($idList);

		$task = new Task();
		$task->setTaskListID($idList);
		$form = $this->get('form.factory')->create(TaskType::class, $task);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($task);
			$em->flush();

			$request->getSession()->getFlashBag()->add('notice', 'Task saved.');
			
			return $this->redirect($this->generateUrl('app.todolist_showtasks', array('idList' => $idList)));
		}

		// ... do something, like pass the $task object into a template		
        //return $this->render('TodoListBundle:Task:index.html.twig', array('tasks' => $tasks, 'idList' => $idList));
		return $this->render('Tasklist/showTasks.html.twig', array('tasks' => $tasks, 'taskList' => $taskList, 'form' => $form->createView(), ));

	}
	
		
	/**
     * @Route("/tasklist")
     */	
	public function showTaskListAction()
	{
		$repository = $this->getDoctrine()->getRepository('TodoListBundle:TaskList');
        $tasklists = $repository->findAll();


		if (!$tasklists) {
			throw $this->createNotFoundException(
				'No tasklist found.'
			);
		}

		return $this->render('Tasklist/index.html.twig', array('tasklists' => $tasklists));
	}
	
	/**
     * @Route("tasklist/new")
     */	
	public function addTaskListAction(Request $request)  
	{ 
		$taskList = new TaskList();
		
		$form = $this->get('form.factory')->create(TaskListType::class, $taskList);

		if ($form->handleRequest($request)->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($taskList);
			
			$em->flush();
			$request->getSession()->getFlashBag()->add('notice', 'TaskList saved.');

			return $this->redirect($this->generateUrl('app.todolist_showtasklist'));
		}

		return $this->render('Tasklist/addTaskList.html.twig', array('form' => $form->createView(),   ));
	
	} 
	
	/**
     * @Route("tasklist/delete/{idList}", name="idList")
     */	
	public function deleteTaskListAction($idList) 
	{
		$em = $this->getDoctrine()->getManager();
		$TaskList = $em->getRepository('TodoListBundle:TaskList')->find($idList);
		$em->remove($TaskList);
		$em->flush();
		return $this->redirect($this->generateUrl('app.todolist_showtasklist'));
	}
	
	/**
     * @Route("tasklist/update/{idList}", name="idList")
     */	
	public function updateTaskListAction($idList, Request $request)
	{			
		$em = $this->getDoctrine()->getManager();
		$taskList = $em->getRepository('TodoListBundle:TaskList')->find($idList);

		if (!$taskList) {
			throw $this->createNotFoundException(
				'No product found for id '.$idList
			);
		}
		
		$form = $this->get('form.factory')->create(TaskListType::class, $taskList);

		if ($form->handleRequest($request)->isValid()) {
 			$data = $form->getData();
			$taskList->setName($data->getName());
			$em->flush();

			return $this->redirect($this->generateUrl("app.todolist_showtasklist"));
		}

		return $this->render('Tasklist/updateTaskList.html.twig', array('form' => $form->createView(),   ));

			
	} 

	
}
