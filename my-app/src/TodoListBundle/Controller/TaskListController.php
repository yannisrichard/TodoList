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

class TaskListController extends Controller
{
   
   	/**
     * @Route("/", name="homepage")
     */
	 public function indexAction()
     {
		 //redirection list tasklist, faire routing todolist_taskslist_list
         //return $this->redirect($this->generateUrl("todolist_taskslist_list"));
     }
   
	/**
     * @Route("/tasklist/createTastTest", name="taskTest")
     */	
	public function createTaskTestAction()
	{
		$tasklist = new TaskList();
		$tasklist->setName('Liste Defaut');
		$tasklist->setLimitData(new DateTime('2016-05-25'));
		
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
     * @Route("/tasklist/{idList}", name="idList")
     */	
	public function showTasksAction($idList)
	{
		//$tasks = $this->getDoctrine()->getRepository('TodoListBundle:Task')->find($idList);
		$repository = $this->getDoctrine()->getRepository('TodoListBundle:Task');
        $tasks = $repository->findByTaskListID($idList);

		if (!$tasks) {
			throw $this->createNotFoundException(
				'No tasks found for list '.$taskId
			);
		}

		// ... do something, like pass the $task object into a template		
        //return $this->render('TodoListBundle:Task:index.html.twig', array('tasks' => $tasks, 'idList' => $idList));
		return $this->render('Tasklist/index.html.twig', array('taskslist' => $tasks));

	}
	
}
