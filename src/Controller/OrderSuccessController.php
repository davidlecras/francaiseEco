<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\Mailjet;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    /**
     * OrderSuccessController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_success")
     */
    public function index($stripeSessionId, Cart $cart): Response
    {
        $order= $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        //Vérification de sécurité
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        // Actions après la validation du paiement:
        if(!$order->getIsPaid()){

            //Vider le panier
            $cart->remove();

            //Modifier le status isPaid:
            $order->setIsPaid(1);
            $this->entityManager->flush();

            // Envoi d'un email pour la confirmation d'achat:
            $user=$order->getUser();
            $email= new Mailjet();
            $content="Merci ".$user->getFirstname().
                "<br> Nous vous remercion pour votre commande n° ".$order->getReference().
                "<br> Elle est maintenant validée. Nous allons la traiter le plus rapidement.<br> Vous recevrez un e-mail une fois celle-ci expédiée.";
            $email->send($user->getEmail(),$user->getFirstname(), 'Commande n° '.$order->getReference(),$content);

        }

        return $this->render('order_success/index.html.twig',[
            'order'=>$order,
        ]);
    }
}
