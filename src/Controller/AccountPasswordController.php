<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * AccountPasswordController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/mon-compte/modification-mot-de-passe", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user=$this->getUser();
        $form= $this->createForm(ChangePasswordType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $old_password= $form->get('old_password')->getData();
            if($userPasswordEncoder->isPasswordValid($user,$old_password)){
                $new_password= $form->get('new_password')->getData();
                $password= $userPasswordEncoder->encodePassword($user,$new_password);
                $user->setPassword($password);
                $this->entityManager->flush($user);
                $this->addFlash('success',"Votre mot de passe a bien été modifié");
                return $this->redirectToRoute('account');
            }else{
                $this->addFlash("danger","Votre mot de passe actuel n'est pas valide");
            }
        }
        return $this->render('account/password.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
