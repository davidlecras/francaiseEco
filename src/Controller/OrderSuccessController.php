<?php

namespace App\Controller;

use App\Classes\Cart;
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
        }

        return $this->render('order_success/index.html.twig',[
            'order'=>$order,
        ]);
    }
}
