<?php

namespace TodoListBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use TodoListBundle\Entity\Task;
use TodoListBundle\Form\TaskType;


class TaskController extends Controller
{
	/**
     * @Route("/task/{idTask}", name="idTask")
     */	
	public function getTaskAction($idTask, Request $request)
	{
		$em = $this->getDoctrine()->getManager();
		$task = $em->getRepository('TodoListBundle:Task')->find($idTask);

		return $this->render('Task/getTask.html.twig', array('task' => $task, ));

	}
	
	/**
     * @Route("task/delete/{idTask}", name="idTask")
     */	
	public function deleteTaskAction($idTask) 
	{
		$em = $this->getDoctrine()->getManager();
		$task = $em->getRepository('TodoListBundle:Task')->find($idTask);
		$em->remove($task);
		$em->flush();
		return $this->redirect($this->generateUrl('app.todolist_showtasks', array('idList' => $task->getTaskListID())));
	}
	
	/**
     * @Route("task/update/{idTask}", name="idTask")
     */	
	public function updateTaskAction($idTask, Request $request)
	{			
		$em = $this->getDoctrine()->getManager();
		$task = $em->getRepository('TodoListBundle:Task')->find($idTask);

		if (!$task) {
			throw $this->createNotFoundException(
				'No product found for id '.$idTask
			);
		}
		
		$form = $this->get('form.factory')->create(TaskType::class, $task);

		if ($form->handleRequest($request)->isValid()) {
 			$data = $form->getData();
			$task->setName($data->getName());
			$task->setStatut($data->getStatut());
			$task->setTaskListID($data->getTaskListID());

			$em->flush();

		return $this->redirect($this->generateUrl('app.todolist_getTask', array('idTask' => $idTask)));
		}

		return $this->render('Task/updateTask.html.twig', array('form' => $form->createView(),   ));
			
	} 
	

}
