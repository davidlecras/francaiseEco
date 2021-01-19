<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderFailedController extends AbstractController
{
    private $entityManager;

    /**
     * OrderFailedController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="order_failed")
     */
    public function index($stripeSessionId): Response
    {
        $order= $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        //envoie d'email pour dire paiement refusé!

        return $this->render('order_failed/index.html.twig',[
            'order'=>$order
        ]);
    }
}
