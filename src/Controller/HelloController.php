<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{

    /**
     * @Route("/hello") name="Hello"
     */
    public function hello(): Response{
        return new Response("Hello World !");
    }

    /**
     * @Route("/hello/{name}") name="Hello_Name"
     */
    public function helloName($name): Response{
        return new Response("Hello ".$name);
    }
}

?>