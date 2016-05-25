<?php

namespace TodoListBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


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
     * @Route("/taskTest", name="taskTest")
     */	
	public function createTaskTestAction()
	{
		$tasklist = new TaskList();
		$tasklist->setName('Liste Defaut');
		$tasklist->setLimitData(new \DateTime())->format('Y-m-d H:i:s'));	
		
		$task = new Task();
		$task->setName('Task1');
		$task->setStatut('Terminé');
		$task->setTaskListID(tasklist->getId());

		$em = $this->getDoctrine()->getManager();

		// tells Doctrine you want to (eventually) save the task (no queries yet)
		$em->persist($tasklist);
		$em->persist($task);

		// actually executes the queries (i.e. the INSERT query)
		$em->flush();

		return new Response('Saved new task and tasklist');
	}
	
	/**
     * @Route("/tasks/{taskid}", name="taskid")
     */	
	public function showTasksAction($idList)
	{
		//$tasks = $this->getDoctrine()->getRepository('TodoListBundle:Task')->find($idList);
		$repository = $this->getDoctrine()->getRepository('ToDoListBundle:Task');
        $tasks = $repository->findByTaskslist($idList);

		if (!$tasks) {
			throw $this->createNotFoundException(
				'No tasks found for list '.$taskId
			);
		}

		// ... do something, like pass the $task object into a template		
        return $this->render('TodoListBundle:Task:index.html.twig', array('tasks' => $tasks, 'idList' => $idList));
		
	}
	
}
