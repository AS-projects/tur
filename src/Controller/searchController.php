<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class searchController extends Controller
{
    /**
    *   @Route("/search", name="app_search");
    */
    public function search()
    {
        $defaultRanking = 12;
        return $this->render('search.html.twig', array('number' => $defaultRanking));
    }

}
?>
