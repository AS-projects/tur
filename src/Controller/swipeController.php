<?php
// src/Controller/LuckyController.php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Ranking;

class swipeController extends Controller
{

    /**
    *   @Route("/swipe/{rankingToDisplay}", name="app_swipe_display_card", requirements={"page"="\d+"})
    */

    public function displayRankingCard($rankingToDisplay)
    {
        $repository = $this->getDoctrine()->getRepository(Ranking::class);
        $ranking = $repository->find($rankingToDisplay);
        if ($ranking) //if it exists (temporary)
            return $this->render('swipe/swipe.html.twig', array('ranking' => $ranking));
        else
            return $this->render('swipe/noRankingToDisplay.html.twig');
    }

    /**
    *   @Route("/swipe", name="app_swipe_set");
    */
    public function setSwipe()
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();

        $sql = 'SELECT id FROM ranking WHERE id = (SELECT MIN(id) FROM ranking)';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        // returns an array of arrays (i.e. a raw data set)

        $fetched = $stmt->fetchAll();

        if (empty($fetched)) return $this->render('swipe/noRankingToDisplay.html.twig');
        return $this->displayRankingCard($fetched[0]["id"]);
    }

    /**
    *   @Route("/swipe/next/{currentRanking}", name="app_swipe_next");
    */

    public function nextRankingCard($currentRanking)
    {
        $conn = $this->getDoctrine()->getEntityManager()->getConnection();
        $sql = 'SELECT id FROM ranking WHERE id > :ranking ORDER BY id LIMIT 1';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['ranking' => $currentRanking]);
        // returns an array of arrays (i.e. a raw data set)

        $next = $stmt->fetch()["id"];

        if ($next)
        {
            return $this->displayRankingCard($next);
        }
        else {
            return $this->render('swipe/noRankingToDisplay.html.twig');
        }
    }

}
?>
