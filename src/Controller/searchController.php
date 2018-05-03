<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Category;
use App\Entity\Ranking;
use App\Entity\Element;

class searchController extends Controller
{
    /**
    *   @Route("/search", name="app_search");
    */
    public function search()
    {
        if ($_POST["searchQuery"]!= NULL)
        {
            $searchQuery = $_POST["searchQuery"];

            $repository = $this->getDoctrine()->getRepository(Ranking::class);

            $rankings = $repository->findBy(
                ['name' => $_POST["searchQuery"]],
                ['votes' => 'DESC']);

            $repository = $this->getDoctrine()->getRepository(Element::class);

            $elements = $repository->findBy(
                ['name' => $_POST["searchQuery"]],
                ['votes' => 'DESC']);

            $repository = $this->getDoctrine()->getRepository(Category::class);

            $categories = $repository->findBy(
                ['title' => $_POST["searchQuery"]]);

            return $this->render('search.html.twig', array('searchQuery' => $_POST["searchQuery"], 'rankings' => $rankings, 'elements' => $elements, 'categories' => $categories));
        }
        else
        {
            return $this->redirectToRoute('index');
        }
    }
}
?>
