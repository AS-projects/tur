<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Category;
use App\Entity\Ranking;

class categoriesController extends Controller
{
    /**
    *   @Route("/categories/all", name="app_categories_all");
    */
    public function displayAllCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findAll();
        return $this->render('categories.html.twig', array('categories' => $categories));
    }

    /**
    *   @Route("/categories/SFW", name="app_categories_SFW");
    */
    public function displaySFWCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findBy(['isNSFW' => False]);
        return $this->render('categories.html.twig', array('categories' => $categories));
    }

    /**
    *   @Route("/categories/NSFW", name="app_categories_NSFW");
    */
    public function displayNSFWCategories()
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $categories = $repository->findBy(['isNSFW' => True]);
        return $this->render('categories.html.twig', array('categories' => $categories));
    }

    /**
    *   @Route("/category/{categoryToDisplay}", name="app_category_display", requirements={"categoryToDisplay"="\d+"});
    */
    public function displayRankingsInCategory($categoryToDisplay)
    {
        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->findOneBy(['id' => $categoryToDisplay]);
        return $this->render('category/category.html.twig', array('category' => $category));
    }
}
?>
