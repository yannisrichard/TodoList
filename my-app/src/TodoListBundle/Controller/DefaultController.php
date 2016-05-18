<?php

namespace TodoListBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        //return new Response(sprintf('Home, Sweet Home %s!', $name));
		//return new Response('Hello, ' . $name, 200));
		
		//Redirecting
		//$this->redirect($this->generateUrl('homepage'));
			
		//Rendering Templates note : hello.html.twig existe pas
		//return $this->render ('hello/hello.html.twig', array('name' => $name));
			
		//Json response
		$Response = new Response(json_encode(array('name' => $name)));
		$response->headers->set('Content-Type', 'application/json');
		//$response = new JsonResponse(array('name => $name));
		
		return $response;
	}
	
}
