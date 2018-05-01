<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Ranking;
use App\Entity\Element;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ElementController extends Controller
{
    public function index()
    {
        return $this->render('element/index.html.twig', [
            'controller_name' => 'ElementController',
        ]);
    }

    /**
     * @Route("/element/add", name="addElement")
     */
    public function addElement(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $element = new Element();

        $form = $this->createFormBuilder($element)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('image', FileType::class, array('label' => 'Image'))
            ->add('ranking', EntityType::class, array('class' => Ranking::class, 'choice_label' => 'name'))
            ->add('save', SubmitType::class, array('label' => 'Create Element'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $form["image"]->getData();

            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // moves the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('elementImage_directory'),
                $fileName
            );

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents

            $ranking = $form->getData();
            $ranking->setVotes(0);
            $ranking->setImage($fileName);
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

            return new Response('Saved new element with id '.$element->getId());
        }

        return $this->render('element/addElement.html.twig', array(
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
