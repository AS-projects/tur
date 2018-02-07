<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class swipeController extends Controller
{

    /**
    *   @Route("/swipe/{rankingToDisplay}", name="app_swipe_display_card", requirements={"page"="\d+"})
    */

    public function displayRankingCard($rankingToDisplay)
    {
        //DB stuff to do here
        if ($rankingToDisplay != 0) //if it exists (temporary)
            return $this->render('swipe/swipe.html.twig', array('number' => $rankingToDisplay));
        else
            return $this->render('swipe/noRankingToDisplay.html.twig');
    }

    /**
    *   @Route("/swipe", name="app_swipe_set");
    */
    public function setSwipe()
    {
        //get the defaultRanking (DB stuff)
        $defaultRanking = 12;
        return $this->displayRankingCard($defaultRanking);
    }

    /**
    *   @Route("/swipe/next/{currentRanking}", name="app_swipe_next");
    */

    public function nextRankingCard($currentRanking)
    {
        return $this->redirectToRoute('app_swipe_display_card', array('rankingToDisplay'=>$currentRanking+1));
    }

    /**
    *   @Route("/swipe/display/{currentRanking}", name="app_swipe_display_ranking");
    */

    public function displayRanking($currentRanking)
    {
        //shit ton of DB stuff to do here
        return $this->render('swipe/display.html.twig', array('number' => $currentRanking));
    }

}
?>
