<?php

namespace Acme\DemoBundle\Controller;

use Acme\DemoBundle\Entity\Student;
use Acme\DemoBundle\Entity\Studentphone;
use Acme\DemoBundle\Form\StudentType;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StudentController extends Controller
{

#list 

    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
	$students = $this->getDoctrine()
            ->getRepository('AcmeDemoBundle:Student')
            ->findAll();
      if (!$students) {
        throw $this->createNotFoundException('No students found');
      }
              $student=new student();
	      $build['phones']=$student->getPhones();
      $build['students'] = $students;
      return $this->render('AcmeDemoBundle:Student:student_show_all.html.twig', $build);
    }

/////////////////////////////////////////////////////////////CRUD Operations of Teacher////////////////////////////////////////////

#add
	public function addAction()
		{
			$phone = new studentphone();
			$student = new student();
			$form = $this->createForm(new StudentType(), $student);
			
		        $validator = $this->get('validator');
                        $errors = $validator->validate($student);

			$request = $this->get('request');
			$form->handleRequest($request);

			if($request->getMethod() == 'POST')
			{

				if($form->isValid())
				{
					//$name=$form->get('fullname')->getData();
				
		       //to save the data of teacher in database
			        	$em = $this->getDoctrine()->getManager();
					$phone->setUser($student);
					$phone->setPhone($form->get('phone')->getData());
					$em->persist($phone);
        				$em->persist($student);
					$em->flush();

                                  
                               return new Response('تم حفظ بيانات الطالب بنجاح');
				      	
				}
			
			   return $this->render('AcmeDemoBundle:Student:add.html.twig',array('form'=>$form->createView())); 

			}

			   return $this->render('AcmeDemoBundle:Student:add.html.twig',array('form'=>$form->createView())); 

		}

#show	
       public function showAction($id) {
	      $student = $this->getDoctrine()
		            ->getRepository('AcmeDemoBundle:Student')
		            ->find($id);
	      if (!$student) {
		throw $this->createNotFoundException('No students found by id ' . $id);
	      }


	    
	      $build['student_item'] = $student;
 	      $user=new student();
	      $build['phones']=$user->getPhones();
	       
	      return $this->render('AcmeDemoBundle:Student:student_show.html.twig', $build);
	    }


#edit
	public function editAction($id, Request $request) {
	    $em = $this->getDoctrine()->getManager();
	    $student = $em->getRepository('AcmeDemoBundle:Student')->find($id);
	    $phone = $em->getRepository('AcmeDemoBundle:Studentphone')->find($id);	
    
		$validator = $this->get('validator');
		$errors = $validator->validate($student);   
         
	    if (!$student) {
	      throw $this->createNotFoundException(
		      'No students found for id ' . $id
	      );
	    }
	    
	    $form = $this->createFormBuilder($student)
		->add('fullname', 'text')
		->add('fatherjob', 'text')
		->add('birthday', 'date', array(
                 'years' => range(date('Y') -8, date('Y')+3),
                     ))
		->add('nationalid', 'text')
		->add('address', 'text')
		->add('phone', 'text',array('mapped'=>false))
		->add('image','file', array(
                'data_class' => null, 'required' => false
            ))
		->add('submit','submit')
		->getForm();

	    $form->handleRequest($request);

	    if ($form->isValid()) {
				$em->persist($student);
                                $phone->setUser($student);
				$phone->setPhone($form->get('phone')->getData());
				$em->persist($phone);
		                $em->flush();
		$students = $this->getDoctrine()
			    ->getRepository('AcmeDemoBundle:Student')
			    ->findAll();
		      if (!$students) {
			throw $this->createNotFoundException('No students found');
		      }


	      $build['students'] = $students;
              return $this->render('AcmeDemoBundle:Student:student_show_all.html.twig', $build);

		// return new Response('News updated successfully');
	    }

	   $student = $em->getRepository('AcmeDemoBundle:Student')->find($id);


	    $build['phones']=$student->getPhones();
	    $build['form'] = $form->createView();

	    return $this->render('AcmeDemoBundle:Student:news_add.html.twig', $build);
	 }
		 
#delete
		 
		 public function deleteAction($id, Request $request) {

		    $em = $this->getDoctrine()->getManager();
		    $student = $em->getRepository('AcmeDemoBundle:Student')->find($id);
		    if (!$student) {
		      throw $this->createNotFoundException(
			      'No news found for id ' . $id
		      );
		    }

		      $em->remove($student);
		      $em->flush();
		      return new Response('News deleted successfully');

		    
		    $build['form'] = $form->createView();
		    return $this->render('AcmeDemoBundle:Student:news_add.html.twig', $build);
		}

	}
