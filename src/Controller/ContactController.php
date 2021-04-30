<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            // Ici nous enverrons le mail
            $message = (new \Swift_Message('Nouveau contact'))

                // On attribue l'expéditeur
                ->setFrom($contact['from'])

                // On attribue le destinataire
                ->setTo('contact@adresse.fr')

                // On crée le message avec la vue Twig
                ->setBody(
                    $this->renderView(
                        'emails/contact.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;

            // On envoi le message
            $mailer->send($message);

            $this->addFlash('message', 'Votre message a été envoyé.'); // Un message flash de renvoi
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/index.html.twig', [
            'contact_form' =>$form->createView()
        ]);
    }
}
