<?php
// src/Controller/UserController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
	
	/**
    * @Route("/user/")
    */
    public function list()
    {
        
		$url = "http://localhost:3000/users/";
		$contents = file_get_contents($url);
		$clima=json_decode($contents);
		// return $clima;
      /* return new Response(
            '<html><body>Lucky number: '.$clima->result[0]['firstName'].'</body></html>'
        ); */
		return $this->render('user/index.html.twig', [
            'data'=> $clima->result
        ]);
    }
	/**
    * @Route("/user/show/{userid}",requirements={"userId"="\d+"})
    */
	
    public function show()
    {
        $url = "http://localhost:3000/users/1";
		$contents = file_get_contents($url);
		$clima=json_decode($contents);
		// return $clima;
      /* return new Response(
            '<html><body>Lucky number: '.$clima->result[0]['firstName'].'</body></html>'
        ); */
		return $this->render('user/show.html.twig', [
            'data'=> $clima->result
        ]);
    }
	
	
	
	/**
    * @Route("/user/new")
    */
    public function new()
    {
        $number = random_int(0, 100);

       /* return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        ); */
		return $this->render('user/new.html.twig', [
            'number' => $number,
        ]);
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