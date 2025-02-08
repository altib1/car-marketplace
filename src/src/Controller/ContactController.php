<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        Request $request, 
        \Symfony\Component\Mailer\MailerInterface $mailer,
        TranslatorInterface $translator
    ): Response {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        $session = $request->getSession();
        $lastSubmission = $session->get('last_contact_submission', 0);
        $currentTime = time();

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifier le délai seulement lors de la soumission
            if ($currentTime - $lastSubmission < 300) {
                $this->addFlash('error', 'contact.error.rate_limit');
                return $this->render('contact/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }

            try {
                $contactFormData = $form->getData();

                $email = (new Email())
                    ->from('noreply@autosmart.com') // Utilisez une adresse par défaut
                    ->replyTo($contactFormData['email'])
                    ->to('marketplacecar2@gmail.com')
                    ->subject($translator->trans('contact.email.subject'))
                    ->text($this->renderView('emails/contact.html.twig', [
                        'name' => strip_tags($contactFormData['name']),
                        'email' => strip_tags($contactFormData['email']),
                        'subject' => strip_tags($contactFormData['subject']),
                        'message' => strip_tags($contactFormData['message'])
                    ]));

                $mailer->send($email);
                
                $session->set('last_contact_submission', $currentTime);
                $this->addFlash('success', 'contact.success');

                return $this->redirectToRoute('app_contact');
            } catch (\Exception $e) {
                $this->addFlash('error', 'contact.error.send_failed');
            }
        }

        // Rendu normal du formulaire
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}