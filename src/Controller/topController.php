<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Ranking;

class topController extends Controller
{
    /**
    *   @Route("/top", name="app_top");
    */
    public function top()
    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Ranking r
            ORDER BY r.votes DESC'
        );

        return $this->render('top.html.twig', array('rankings' => $query->execute()));
    }

}
?>
