<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /** fonction de contact d'un utilisateur à l'admin (MailTrap)
     * @param MailerInterface $mailer
     * @param Request $request
     * @return Response
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    #[Route('contact', name : 'app_contact')]
    public function contact(MailerInterface $mailer, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $email = (new TemplatedEmail())
                -> from($contact->getEmail())
                -> to('galeries_maudoux@gmail.com')
                -> subject($contact->getSubject())
                -> htmlTemplate('contact/email-css.html.twig')
                -> context([
                    'firstName' => $contact->getFirstName(),
                    'lastName' => $contact->getLastName(),
                    'message' => $contact->getContent(),
                    'title' => $contact->getSubject(),
                ]);
            $mailer->send($email);

            $this->addFlash(
                'success',
                'Votre mail a bien été envoyé'
            );
            return $this->redirectToRoute('app_home');
        }
        return $this->renderForm('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
