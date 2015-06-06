<?php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\DemoBundle\Entity\User;
use Acme\DemoBundle\Form\UserType;
use Symfony\Component\HttpFoubdation\Response;

class LoginController extends Controller
{
	public function indexAction()
	{
		$user = new user();
		$form = $this->createForm(new UserType(), $user);

		$request = $this->get('request');
		$form->handleRequest($request);
		
		if($request->getMethod() == 'POST')
		{
			if($form->isValid())
			{
				return new Response('you are logged in successfully!');
			}
			
		   return $this->render('AcmeDemoBundle:Login:index.html.twig',array('form'=>$form->createView())); 

		}


		return $this->render('AcmeDemoBundle:Login:index.html.twig',array('form'=>$form->createView())); 
	}
}
