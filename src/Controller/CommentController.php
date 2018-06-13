<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index()
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    public function addComment(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $comment = new Comment();

        $form = $this->createFormBuilder($comment)
            ->add('content', TextareaType::class, array('required' => True))
            ->add('save', SubmitType::class, array('label' => 'Comment'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $comment = $form->getData();
            $comment->setTimestamp(time());

            $entityManager = $this->getDoctrine()->getManager();

            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($comment);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }
        return $this->render('ranking/addRanking.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
    *   @Route("comment/delete/{commentToDelete}", name="app_delete_comment");
    */
    public function deleteComment($commentToDelete)
    {
        $repository = $this->getDoctrine()->getRepository(Comment::class);
        $entityManager = $this->getDoctrine()->getManager();
        $comment = $repository->findOneBy(array("id" => $commentToDelete));
        $entityManager->remove($comment);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }
}
