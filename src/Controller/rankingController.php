<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class rankingController extends Controller
{
    /**
    *   @Route("/ranking", name="app_ranking");
    */
    public function search()
    {
        $defaultRanking = 12;
        return $this->render('ranking.html.twig', array('number' => $defaultRanking));
    }

}
?>
