<?php

namespace App\Controller;

use App\Classes\Mailjet;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user= new User();
        $form= $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user= $form->getData();
            $search_email= $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());
            if(!$search_email){
                $password= $userPasswordEncoder->encodePassword($user,$user->getPassword());
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $email= new Mailjet();
                $content="Bienvenue ".$user->getFirstname()."<br> Vous êtes bien inscrit chez nous ............... ";
                $email->send($user->getEmail(),$user->getFirstname(), 'Bienvenue sur La Française Écolo-mode',$content);

                $this->addFlash('success','Bienvenue parmi nous');
                return $this->redirectToRoute('home');
            }else{
                $this->addFlash('danger',"Cet utilisateur existe déjà!");
            }

        }
        return $this->render('register/index.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
