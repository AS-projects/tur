<?php
// src/Controller/indexController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class indexController extends Controller
{
    /**
    *   @Route("/", name="index");
    */
    public function index()
    {
        return $this->render('index.html.twig');
    }
}
?>
