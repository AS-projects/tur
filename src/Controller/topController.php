<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class topController extends Controller
{
    /**
    *   @Route("/top", name="app_top");
    */
    public function search()
    {
        $defaultRanking = 12;
        return $this->render('top.html.twig', array('number' => $defaultRanking));
    }

}
?>
