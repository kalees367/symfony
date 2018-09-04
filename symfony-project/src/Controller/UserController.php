<?php
// src/Controller/UserController.php
namespace App\Controller;

use App\Document\User; 
use App\Form\UserForm; 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\Mapping as ORM;

class UserController extends Controller
{
	
	/**
    * @Route("/user/")
    */
    public function list(Request $request)
    {
        $db = $this->get('doctrine_mongodb')->getManager();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $db->getRepository(User::class)->findAll(), //query
            $request->query->getInt('page', 1), //page
            3 //limit per page
        );
        return $this->render('user/index.html.twig', array(
            "data" => $pagination
        ));

    }
	/**
    * @Route("/user/show/{slug}")
    */
	
    public function show($slug)
    {
        $db = $this->get('doctrine_mongodb')->getManager();
        $repository = $db->getRepository(User::class);
        $users = $repository->find(['id' => $slug]);        
        $db->flush(); 
       // print_R($users);  
        return $this->render('user/show.html.twig', [
            'user'=> $users
        ]); 
        
    }
	/**
    * @Route("/user/new")
    */
    public function new(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { 
            $user = $form->getData();
            $db = $this->get('doctrine_mongodb')->getManager();
            $db->persist($user);
            $db->flush();
            return $this->redirectToRoute('list');
         }

        return $this->render('user/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
    * @Route("/user/edit/{slug}")
    */
    public function edit($slug=NULL,Request $request)
    {
      
        $user = new User();
        $db = $this->get('doctrine_mongodb')->getManager();
        $repository = $db->getRepository(User::class);
            $user = $repository->find(['id' => $slug]);        
            if($slug!=NULL){
                $user_emails = implode(",",$user->getEmail());
                $user_mobiles = implode(",",$user->getMobile());
                $user_educations = implode(",",$user->getEducation());
                $form = $this->createFormBuilder($user)
                //->setAction('/user/update')
                ->setMethod('POST')
                ->add('id', HiddenType::class, array(
                    'data' => $slug,
                ))
                ->add('firstName', TextType::class)
                ->add('lastName', TextType::class)
                ->add('email', TextType::class, array( 'data' => $user_emails))
                ->add('mobile', TextType::class, array( 'data' => $user_mobiles))
                ->add('dateofBirth', DateType::class, array(
                    'widget' => 'single_text',
                    // this is actually the default format for single_text
                    'format' => 'yyyy-MM-dd','data'=> new \DateTime($user->getDateofBirthObject()->format('Y-m-d H:i:s')),
                ))
                ->add('education', TextareaType::class, array( 'data' => $user_educations))
                ->add('bloodGroup', TextType::class)
                ->add('gender', TextType::class)
                ->add('save', SubmitType::class, array('label' => 'Update User'))
                ->getForm();
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) { 
                    $data = $form->getData();
                    $db = $this->get('doctrine_mongodb')->getManager();
                    $repository = $db->getRepository(User::class)->find($data->getId());
                    $db->flush();
                    return $this->redirectToRoute('list');
                }
                return $this->render('user/edit.html.twig', array(
                    'form' => $form->createView(),
                ));
               
            }
    }

    /**
    * @Route("/user/delete/{slug}")
    */
    public function delete($slug)
    {
        $db = $this->get('doctrine_mongodb')->getManager();
        $repository = $db->getRepository(User::class);
        $users = $repository->find(['id' => $slug]); 
        $db->remove($users);
        $db->flush();
        return $this->redirectToRoute('list');
    }
	
}