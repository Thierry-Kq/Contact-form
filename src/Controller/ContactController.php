<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\FileSaveService;
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
        SluggerInterface $slugger,
        FileSaveService $fileSaveService
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

            $this->addFlash('success', 'Votre message à bien été envoyé');

            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
