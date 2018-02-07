<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class categoriesController extends Controller
{
    /**
    *   @Route("/categories", name="app_categories");
    */
    public function displayCategories()
    {
        $defaultRanking = 12;
        return $this->render('categories.html.twig', array('number' => $defaultRanking));
    }

}
?>
