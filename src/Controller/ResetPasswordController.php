<?php

namespace App\Controller;

use App\Classes\Mailjet;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * ResetPasswordController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/mot-de-passe-oublie", name="reset_password")
     */
    public function index(Request $request): Response
    {
        // Redirection si l'utilisateur est connecté:
        if($this->getUser()){
            $this->redirectToRoute('account');
        }

        if($request->get('email')){
            $user=$this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if(!$user){
                $this->addFlash('warning', "L'utilisateur n'est pas reconnu");
            }
            if($user){
                //Enregistrer en BD:
                $reset_password= new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new \DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                // Envoie d'un email avec le lien de MAJ du MDP:
                $email= new Mailjet();
                $user_complete_name= $user->getFirstName()." ".$user->getLastname();
                $url= $this->generateUrl('update_forgotten_password',[
                    'token'=> $reset_password->getToken(),
                ]);
                $content= "Bonjour ".$user_complete_name.",</br> Vous avez demander ";
                $content .= "Vous avez récemment demandé de réinitialiser le mot de passe de votre compte <strong>La française écolo-mode</strong>.";
                $content .= "</br></br> Cliquez sur ce lien pour <a href=".$url.">mettre à jour votre mot de passe</a>.";
                $email->send(
                    $user->getEmail(),
                    $user_complete_name,
                    'Mot de passe oublié',
                    $content);
                $this->addFlash('info',
                    'Un email vient de vous être envoyé pour réinitialiser votre mot de passe');
            }

        }

        return $this->render('reset_password/index.html.twig');
    }

    /**
     * @Route("/modifier-mon-mot-de-passe/{token}", name="update_forgotten_password")
     */
    public function update($token, Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $reset_password= $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        if(!$reset_password){
            $this->addFlash('danger', "Oups! Il semble qu'il y ait un problème!");
            return $this->redirectToRoute('reset_password');
        }
        $akhshav= new \DateTime();
        $date_valid=$reset_password->getCreatedAt()->modify('+3 hour');

        if($date_valid<$akhshav){
            $this->addFlash('danger','Le délai de modification du mot de passe a expiré');
            return $this->redirectToRoute('reset_password');
            }

        // Afficher le formulaire de modification du mdp:
        $form= $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){

            //Récupérer le nouveau mdp et le user:
            $updtd_password= $form->get('new_password')->getData();
            $user= $reset_password->getUser();

            //encoder le mdp:
            $password= $encoder->encodePassword($user,$updtd_password);

            // MAJ en BDD:
            $user->setPassword($password);
            $this->entityManager->flush();

            //Fin:
            $this->addFlash('success', 'Votre mot de passe est bien réinitialisé');
            return $this->redirectToRoute('app_login');

        }

        return $this->render('reset_password/update.html.twig',[
            'form'=>$form->createView(),
        ]);

    }
}
