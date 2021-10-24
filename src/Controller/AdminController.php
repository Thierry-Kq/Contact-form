<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactMessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/administration/messages", name="message_list")
     */
    public function displayMessage(
        Request $request,
        ContactMessageRepository $repository
    ): Response
    {
        // todo : deny acces if not admin
        $messages = $repository->findGroupedByEmail();

        return $this->render('admin/messages_list.html.twig', [
            'messages' => $messages
        ]);
    }

   /**
     * @Route("/administration/message/{id}/toggle", name="message_toggle")
     */
    public function toggleTaskAction(
        ContactMessageRepository $repository,
        EntityManagerInterface $entityManager,
        int $id
    ): Response
    {
        $contactMessage = $repository->findOneBy(['id' => $id]);

        $contactMessage->toggle(!$contactMessage->getIsDone());
        $entityManager->flush();

        return $this->redirectToRoute('message_detail', [
            'slug' => $contactMessage->getSlug()
        ]);
    }

     /**
     * @Route("/administration/message/{slug}", name="message_detail")
     */
    public function messageDetail(
        ContactMessageRepository $repository,
        string $slug
    ): Response
    {
        $messages = $repository->findBy(['slug' => $slug], ['createdAt' => 'DESC']);

        return $this->render('admin/messages_detail.html.twig', [
            'messages' => $messages
        ]); 
    }
}
