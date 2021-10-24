<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContactMessageRepository;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactMessage(
        Request $request,
        EntityManagerInterface $entityManager,
        SluggerInterface $slugger
    ): Response
    {
        $contactMessage = new ContactMessage();

        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contactMessage->setSlug($slugger->slug($contactMessage->getFromEmail()));
            $fileSaveService->saveAsJson($contactMessage);
            $entityManager->persist($contactMessage);
            $entityManager->flush();

            // todo : addflash 
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

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
