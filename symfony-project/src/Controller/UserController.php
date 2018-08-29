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
       /* $url = "http://localhost:3000/users/1";
		$contents = file_get_contents($url);
		$clima=json_decode($contents);
		return $this->render('user/show.html.twig', [
            'data'=> $clima->result
        ]); */
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
        ->add('firstName', TextType::class)
        ->add('lastName', TextType::class)
        ->add('email', TextType::class)
        ->add('mobile', TextType::class)
        ->add('dateofBirth', TextType::class)
        ->add('education', TextType::class)
        ->add('bloodGroup', TextType::class)
        ->add('gender', TextType::class)
        ->add('save', SubmitType::class, array('label' => 'Add User'))
        ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
            $number = random_int(0, 100);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
             $entityManager = $this->getDoctrine()->getManager();
             $entityManager->persist($user);
             $entityManager->flush();
             return $this->render('user/edit.html.twig', [
                'number' => $number,
            ]);
           // return $this->redirectToRoute('task_success');
        }



        return $this->render('user/new.html.twig', array(
            'form' => $form->createView(),
        ));
        /*
        $Email = ["kalees@gmail.com","eswar@gmail.com"];
        $Mobile = ["9943012345","9894125636"];
        $EduDetails = ["UG"=>"B.Tech","PG"=>"M.tech"];
        $user->setFirstName("kalees");
        $user->setLastName("waran");
        $user->setEmail($Email);
        $user->setMobile($Mobile);
        $user->setDateofBirth("05/05/1988");
        $user->setEducation($EduDetails);
        $user->setBloodGroup("B+ve");
        $user->setGender("Male");
        $db = $this->get('doctrine_mongodb')->getManager();

        $db->persist($user);
        $db->flush();
        return new Response( 'ok' ); */
    }
	/**
    * @Route("/user/edit")
    */
    public function edit()
    {
        $number = random_int(0, 100);

       /* return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        ); */
		return $this->render('user/edit.html.twig', [
            'number' => $number,
        ]);
    }
	
}