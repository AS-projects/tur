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
        if (isset($_POST["searchQuery"]))
        {
            $searchQuery = $_POST["searchQuery"];
        }
        else
        {
            $searchQuery = 12;
        }
        return $this->redirectToRoute('app_displaySearch', array('searchQuery'=>$searchQuery));
    }

    /**
    *   @Route("/search/{searchQuery}", name="app_displaySearch");
    */
    public function displaySearch($searchQuery)
    {
        return $this->render('search.html.twig', array('searchQuery' => $searchQuery));
    }

}
?>
