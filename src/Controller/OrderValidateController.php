<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    /**
     * OrderValidateController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index($stripeSessionId): Response
    {
        $order= $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('home');
        }

        //Modification du status isPaid
        if(!$order->getIsPaid()){
            $order->setIsPaid(1);
        }

        return $this->render('order_validate/index.html.twig',[
            'order'=>$order,
        ]);
    }
}