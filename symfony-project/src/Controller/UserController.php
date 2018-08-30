<?php
// src/Controller/UserController.php
namespace App\Controller;

use App\Document\User; 
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
use Doctrine\ORM\Mapping as ORM;

class UserController extends Controller
{
	
	/**
    * @Route("/user/")
    */
    public function list()
    {
        $db = $this->get('doctrine_mongodb')->getManager();
        $repository = $db->getRepository(User::class);
        $users = $repository->findAll();        
        $db->flush();
        return $this->render('user/index.html.twig', [
            'data'=> $users
        ]); 

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
        //echo "<pre>";print_R($users);  
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
        $form = $this->createFormBuilder($user)
        ->setAction('new')
        ->setMethod('GET')
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('email', TextType::class)
        ->add('mobile', TextType::class)
        ->add('dateofBirth', TextType::class)
        ->add('education', TextareaType::class)
        ->add('bloodGroup', TextType::class)
        ->add('gender', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Add User'))
        ->getForm();
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
    public function edit($slug,Request $request)
    {
        $number = random_int(0, 100);
        $user = new User();
        $db = $this->get('doctrine_mongodb')->getManager();
        $repository = $db->getRepository(User::class);
        $user = $repository->find(['id' => $slug]);        
        $db->flush(); 
    
       $form = $this->createFormBuilder($user)
        ->setAction('edit')
        ->setMethod('GET')
        ->add('id', HiddenType::class, array(
            'data' => $slug,
        ))
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('email', TextType::class)
        ->add('mobile', TextType::class)
        ->add('dateofBirth', TextType::class)
        ->add('education', TextareaType::class)
        ->add('bloodGroup', TextType::class)
        ->add('gender', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Update User'))
        ->getForm();
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $data = $form->getData();
            $db = $this->get('doctrine_mongodb')->getManager();
            $repository = $db->getRepository(User::class);
            $user = $repository->find(['id' => $data['id']]); 
            $user->setFirstName($data['firstName']);
            $user->setLastName($data['lastName']);
            $user->setEmail($data['email']);
            $user->setMobile($data['mobile']);
            $user->setDateofBirth($data['dateofBirth']);
            $user->setEducation($data['education']);
            $user->setBloodGroup($data['bloodGroup']);
            $user->setGender($data['gender']);
           
            // $dm->flush();
           // $db->persist($user);
            $db->flush();
            return $this->redirectToRoute('list');
         }

        return $this->render('user/edit.html.twig', array(
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