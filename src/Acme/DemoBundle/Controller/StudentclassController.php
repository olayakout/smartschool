<?php

namespace Acme\DemoBundle\Controller;

use Acme\DemoBundle\Entity\Studentclass;
use Acme\DemoBundle\Form\StudentclassType;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StudentclassController extends Controller
{

#list 

    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
	$classes = $this->getDoctrine()
	              ->getRepository('AcmeDemoBundle:Studentclass')
	              ->findAll();

      if (!$classes) {
        throw $this->createNotFoundException('No classes found');
      }
    
      $build['classes'] = $classes;
      return $this->render('AcmeDemoBundle:Studentclass:class_show_all.html.twig', $build);
    }

/////////////////////////////////////////////////////////////CRUD Operations of Book////////////////////////////////////////////

#add
	public function addAction()
		{
			$studentclass = new Studentclass();
			$form = $this->createForm(new StudentclassType(), $studentclass);
                        
                        $validator = $this->get('validator');
                        $errors = $validator->validate($studentclass);
		
			$request = $this->get('request');
			$form->handleRequest($request);
		
			if($request->getMethod() == 'POST')
			{

				if($form->isValid())
				{
					$em = $this->getDoctrine()->getManager();
					$em->persist($studentclass);
					$em->flush();
                                        
                $classes = $this->getDoctrine()
			      ->getRepository('AcmeDemoBundle:Studentclass')
			      ->findAll();
					      if (!$classes) {
						throw $this->createNotFoundException('No classes found');
					      }
				      $build['classes'] = $classes;
				      return $this->render('AcmeDemoBundle:Studentclass:class_show_all.html.twig', $build);
					
				}
			
			   return $this->render('AcmeDemoBundle:Studentclass:add.html.twig',array('form'=>$form->createView())); 

			}

			   return $this->render('AcmeDemoBundle:Studentclass:add.html.twig',array('form'=>$form->createView())); 

		}
#show	
       public function showAction($id) {
	      $class = $this->getDoctrine()
			   ->getRepository('AcmeDemoBundle:Studentclass')
			   ->find($id);
	      if (!$class) {
		      throw $this->createNotFoundException('No class found by id ' . $id);
	      }
	      $build['class_item'] = $class;
	      return $this->render('AcmeDemoBundle:Studentclass:class_show.html.twig', $build);
	    }

#edit
	public function editAction($id, Request $request) {
	    $em = $this->getDoctrine()->getManager();
	    $class = $em->getRepository('AcmeDemoBundle:Studentclass')->find($id);

		$validator = $this->get('validator');
		$errors = $validator->validate($class );   
         
	    if (!$class ) {
	      throw $this->createNotFoundException(
		      'No class  found for id ' . $id
	      );
	    }
	    
	    $form = $this->createFormBuilder($class )
			 ->add('name', 'text')
			 ->add('submit','submit')
			 ->getForm();

	    $form->handleRequest($request);

	    if ($form->isValid()) {
					$em->flush();
					$classes = $this->getDoctrine()
						      ->getRepository('AcmeDemoBundle:Studentclass')
						      ->findAll();
					      if (!$classes) {
						throw $this->createNotFoundException('No classes found');
					      }
				      $build['classes'] = $classes;
			              return $this->render('AcmeDemoBundle:Studentclass:class_show_all.html.twig', $build);

		// return new Response('News updated successfully');
	    }
	    
	    $build['form'] = $form->createView();

	    return $this->render('AcmeDemoBundle:Studentclass:news_add.html.twig', $build);
	 }
		 
#delete
		 
		 public function deleteAction($id, Request $request) {

		    $em = $this->getDoctrine()->getManager();
		    $class = $em->getRepository('AcmeDemoBundle:Studentclass')->find($id);
		    if (!$class) {
		      throw $this->createNotFoundException(
			      'No class found for id ' . $id
		      );
		    }

		      $em->remove($class);
		      $em->flush();
		      return new Response('تم المسح  بنجاح');

		    
		    $build['form'] = $form->createView();
		    return $this->render('AcmeDemoBundle:Studentclass:news_add.html.twig', $build);
		}

	}
