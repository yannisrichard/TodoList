<?php

namespace TodoListBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }   
    
	/**
     * @Route("/hello/{name}", name="hello")
     */
    public function helloAction($name)
    {
		return new Response('Hello, ' . $name, 200);
        //return new Response(sprintf('Home, Sweet Home %s!', $name));
		
		//Redirecting
		//return $this->redirect($this->generateUrl('homepage'));
			
		//Rendering Templates note : hello.html.twig existe pas
		//return $this->render ('hello/hello.html.twig', array('name' => $name));
			
		//Json response
		//$Response = new Response(json_encode(array('name' => $name)));
		//$Response->headers->set('Content-Type', 'application/json');
		//$Response = new JsonResponse(array('name' => $name));
		//return $Response;
	}
	
}
