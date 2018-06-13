<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Ranking;
use App\Entity\Category;
use App\Entity\Comment;

class adminController extends Controller
{
    /**
    *   @Route("/admin", name="app_admin");
    */
    public function admin()
    {
        $entityManager = $this->getDoctrine()->getEntityManager();

        $queryC = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Category c'
        );

        $queryE = $entityManager->createQuery(
            'SELECT e
            FROM App\Entity\Element e'
        );

        $queryR = $entityManager->createQuery(
            'SELECT r
            FROM App\Entity\Ranking r'
        );

        $queryCo = $entityManager->createQuery(
            'SELECT c
            FROM App\Entity\Comment c'
        );

        return $this->render('admin/index.html.twig', array('rankings' => $queryR->execute(), 'elements' => $queryE->execute(), 'categories' => $queryC->execute(), 'comments' => $queryCo->execute()));
    }

}
?>
