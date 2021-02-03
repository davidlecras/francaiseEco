<?php

namespace App\Controller;

use App\Classes\Mailjet;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request): Response
    {
        $form= $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //On récupère les informations du formulaire
            $email_form=$form->get('email')->getData();
            $name=$form->get('firstname')->getData()." ".$form->get('lastname')->getData();
            $objet=$form->get('obj')->getData();
            $content=$form->get('content')->getData();

            //Transmission du message
            $email= new Mailjet();

            // À la Française Écolo-mode:
            $subject= 'Un nouveau message de contact depuis la Française écolo: '.$objet;
            $content_for_admin= 'Message de: '.$name."</br>";
            $content_for_admin .= "E-mail:".$email_form."</br>";
            $content_for_admin .="Objet: ".$objet."</br>";
            $content_for_admin .= "Message: ".$content;
            $email->send('davidlecras@hotmail.com','Administrateur',$subject, $content_for_admin);

            // À l'utilisateur:
            $content_for_user= "Merci d'avoir contacté La Française Écolo-mode.</br></br>";
            $content_for_user .= "Votre Message: ".$content."</br></br>";
            $content_for_user .="Nous vous répondrons au plus vite.</br>";
            $email->send($email_form,$name,'Votre message à La Française Écolo-mode',$content_for_user);

            // redirection:

            $this->addFlash('info','Votre message a bien été envoyé, nous vous répondrons au plus vite');
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
