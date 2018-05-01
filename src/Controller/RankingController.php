<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ranking;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RankingController extends Controller
{
    /**
     * @Route("/ranking", name="ranking")
     */
    public function index()
    {
        return $this->render('ranking/index.html.twig', [
            'controller_name' => 'RankingController',
        ]);
    }


    /**
    *   @Route("ranking/{currentRanking}", name="app_swipe_display_ranking", requirements={"currentRanking"="\d+"});
    */

    public function displayRanking($currentRanking)
    {
        $repository = $this->getDoctrine()->getRepository(Ranking::class);
        $ranking = $repository->find($currentRanking);
        return $this->render('ranking/display.html.twig', array('ranking' => $ranking));
    }

    /**
     * @Route("/ranking/add", name="addRanking")
     */
    public function addRanking(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $ranking = new Ranking();

        $form = $this->createFormBuilder($ranking)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class, array('required' => False))
            ->add('category', EntityType::class, array('class' => Category::class, 'choice_label' => 'title'))
            ->add('image', FileType::class, array('label' => 'Image', 'required' => False))
            ->add('save', SubmitType::class, array('label' => 'Create Ranking'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form["image"]->getData();

            $file = $form["image"]->getData();

            if ($file == NULL)
            {
                $ranking = $form->getData();
                $ranking->setImage(NULL);
            }
            else
            {
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                // moves the file to the directory where brochures are stored
                $file->move(
                    $this->getParameter('rankingImage_directory'),
                    $fileName
                );

                // updates the 'brochure' property to store the PDF file name
                // instead of its contents

                $ranking = $form->getData();
                $ranking->setImage($fileName);
            }
            $ranking->setVotes(0);
            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            $entityManager = $this->getDoctrine()->getManager();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($ranking);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return new Response('Saved new product with id '.$ranking->getId());
        }

        return $this->render('ranking/addRanking.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    /**
    * @return string
    */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}
