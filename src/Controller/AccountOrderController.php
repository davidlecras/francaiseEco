<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{
    private $entityManager;

    /**
     * AccountOrderController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/mon-compte/mes-commandes", name="account_order")
     */
    public function index(): Response
    {
        $user=$this->getUser();
        $orders= $this->entityManager->getRepository(Order::class)->finOrdersSuccessfullyPaidByDesc($user);
        return $this->render('account/order.html.twig',[
            'orders'=>$orders
        ]);
    }

    /**
     * @Route("/mon-compte/mes-commandes/{reference}", name="account_show_my_order")
     */
    public function showMyOrder($reference): Response
    {
        $order= $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if(!$order || $order->getUser() != $this->getUser()){
            return $this->redirectToRoute('account_order');
        }
        return $this->render('account/show_my_order.html.twig',[
            'order'=>$order
        ]);
    }
}
