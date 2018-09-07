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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\Controller\FOSRestController;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Doctrine\ODM\MongoDB\DocumentManager;

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
            5 //limit per page
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
    public function edit($slug,Request $request)
    {
        
        $user = new User();
        $db = $this->get('doctrine_mongodb')->getManager();
        $repository = $db->getRepository(User::class);
        $userDetail = $repository->find(['id' => $slug]);
        //print_r($userDetail);
        //exit;
        $form = $this->createForm(UserForm::class, $userDetail);
        $form->handleRequest($request);
        if ($form->isSubmitted()) { 

            $db->flush();
            return $this->redirectToRoute('list');
        }
        return $this->render('user/new.html.twig', array(
            'form' => $form->createView(),
        )); 
       
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