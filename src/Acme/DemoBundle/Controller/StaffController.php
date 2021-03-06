<?php

namespace Acme\DemoBundle\Controller;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;

use Acme\DemoBundle\Entity\Staff;
use Acme\DemoBundle\Entity\Staffphone;
use Acme\DemoBundle\Entity\Job;
use Acme\DemoBundle\Form\StaffType;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Acme\DemoBundle\Form\ContactType;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StaffController extends Controller
{

#list 

    /**
     * @Route("/", name="_demo")
     * @Template()
     */
    public function indexAction()
    {
	$staff = $this->getDoctrine()
            ->getRepository('AcmeDemoBundle:Staff')
            ->findAll();
      if (!$staff) {
        throw $this->createNotFoundException('No teachers found');
      }
    
      $build['staff'] = $staff;
      return $this->render('AcmeDemoBundle:Staff:staff_show_all.html.twig', $build);
    }

/////////////////////////////////////////////////////////////CRUD Operations of Teacher////////////////////////////////////////////

#add
	public function addAction()
		{
		
			$staff = new staff();
			$form = $this->createForm(new StaffType(), $staff);
			$job = new Job();
			$phone = new staffphone();
			
		
		        $validator = $this->get('validator');
                        $errors = $validator->validate($staff);

			$request = $this->get('request');
			$form->handleRequest($request);

        		

			if($request->getMethod() == 'POST')
			{

				if($form->isValid())
				{
					//$name=$form->get('fullname')->getData();
				      
		       //to save the data of teacher in database
			        	$em = $this->getDoctrine()->getManager();
					
					$phone->setUser($staff);
					$phone->setPhone($form->get('phone')->getData());
					$em->persist($phone);
					//var_dump($form->get('job')->getData());

					$staff->setJob($form->get('job')->getData());
					$em->persist($phone);
					$em->persist($staff);
        				$em->flush();


                                  
                                        return new Response('تم حفظ بيانات العضو بنجاح');
				      	
				}
			
			   return $this->render('AcmeDemoBundle:Staff:add.html.twig',array('form'=>$form->createView())); 

			}

			   return $this->render('AcmeDemoBundle:Staff:add.html.twig',array('form'=>$form->createView())); 

		}

#show	
       public function showAction($id) {
	      $staff = $this->getDoctrine()
		            ->getRepository('AcmeDemoBundle:Staff')
		            ->find($id);
	      if (!$staff) {
		throw $this->createNotFoundException('No teachers found by id ' . $id);
	      }


	    
	      $build['staff_item'] = $staff;
 	      $teacher=new staff();
	      $build['phones']=$teacher->getPhones();
	       
	      return $this->render('AcmeDemoBundle:Staff:staff_show.html.twig', $build);
	    }

#edit
	public function editAction($id, Request $request) {
	    $em = $this->getDoctrine()->getManager();
	    $staff = $em->getRepository('AcmeDemoBundle:Staff')->find($id);
	    $phone = $em->getRepository('AcmeDemoBundle:Staffphone')->find($id);	    
	    $job = $em->getRepository('AcmeDemoBundle:Job')->find($id);	    
		$validator = $this->get('validator');
		$errors = $validator->validate($staff);  
 
         
	    if (!$staff) {
	      throw $this->createNotFoundException(
		      'No teachers found for id ' . $id
	      );
	    }
	    
	    $form = $this->createFormBuilder($staff)
		->add('code', 'text')
		->add('fullname', 'text')
                ->add('job')
		->add('graduate', 'text')
		->add('dateofgraduate', 'date', array(
                 'years' => range(date('Y') -60, date('Y')+3),
                     ))
		->add('birthday', 'date', array(
                 'years' => range(date('Y') -60, date('Y')+3),
                     ))
		->add('appointmentdate', 'date', array(
                 'years' => range(date('Y') -60, date('Y')+3),
                     ))
		->add('dateofanotherstudy', 'date', array(
                 'years' => range(date('Y') -60, date('Y')+3),
                     ))
		->add('joindate', 'date', array(
                 'years' => range(date('Y') -60, date('Y')+3),
                     ))
		->add('degree', 'text')
		->add('dateofgetdegree', 'date', array(
                 'years' => range(date('Y') -60, date('Y')+3),
                     ))
		->add('nationalid', 'text')
		->add('address', 'text')
		->add('anotherstudy', 'text')
		->add('phone', 'text',array('mapped'=>false))
		->add('image','file', array(
                'data_class' => null, 'required' => false
            ))
		->add('submit','submit')
		->getForm();

	    $form->handleRequest($request);

		if($form->isValid())
				{
				$em->persist($staff);
				$phone->setUser($staff);
				$phone->setPhone($form->get('phone')->getData());
				$em->persist($phone);
				$staff->setJob($job);
				$staff->setJob($form->get('job')->getData());
				$em->persist($staff);
				$em->flush();

                          
                                $staff = $this->getDoctrine()
					    ->getRepository('AcmeDemoBundle:Staff')
					    ->findAll();
				      if (!$staff) {
					throw $this->createNotFoundException('No teachers found');
				      }
			      $build['staff'] = $staff;
			      return $this->render('AcmeDemoBundle:Staff:staff_show_all.html.twig', $build);
				      	
				}
	    $teacher = $em->getRepository('AcmeDemoBundle:Staff')->find($id);

	    $build['form'] = $form->createView();
	    $build['phones']=$teacher->getPhones();
	    return $this->render('AcmeDemoBundle:Staff:news_add.html.twig', $build);
	 }
		 
#delete
		 
		 public function deleteAction($id, Request $request) {

		    $em = $this->getDoctrine()->getManager();
		    $staff = $em->getRepository('AcmeDemoBundle:Staff')->find($id);
		    if (!$staff) {
		      throw $this->createNotFoundException(
			      'No news found for id ' . $id
		      );
		    }

		      $em->remove($staff);
		      $em->flush();
		      return new Response('News deleted successfully');

		    
		    $build['form'] = $form->createView();
		    return $this->render('AcmeDemoBundle:Staff:news_add.html.twig', $build);
		}

	}
