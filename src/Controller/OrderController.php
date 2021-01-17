<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\OrderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    /**
     * OrderController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/commande", name="order")
     */
    public function index(Cart $cart): Response
    {
        //On vérifie que User a bien une adresse, si no address, on redirige vers la page address_add:
        if(!$this->getUser()->getAddresses()->getValues()){
            return $this->redirectToRoute('account_address_add');
        }

        $form=$this->createForm(OrderType::class, null, [
            'user'=>$this->getUser(),
        ]);

        return $this->render('order/index.html.twig',[
            'form'=>$form->createView(),
            'cart'=>$cart->getFull(),
        ]);
    }

    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Cart $cart, Request $request): Response
    {
        $form=$this->createForm(OrderType::class, null, [
            'user'=>$this->getUser(),
        ]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $date= new \DateTime();
            $carriers= $form->get('carriers')->getData();
            $address=$form->get('addresses')->getData();
            $country = Countries::getName($address->getCountry());


            //Creation du string pour setDelivery:
            $address_full= $address->getFirstname()." ".$address->getLastname();
            $address_full .= '</br>'.$address->getPhone();
            if($address->getCompagny()){
                $address_full .= '</br>'.$address->getCompagny();
            }
            $address_full .= '</br>'.$address->getAddress();
            $address_full .= '</br>'.$address->getPostCode()." ".$address->getCity();
            $address_full .= '</br>'.$country;

            // On enregistre la commande: Order
            $order= new Order();
            $ref= $date->format('dmY').'-'.uniqid();
            $order->setReference($ref);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($address_full);
            $order->setIsPaid(0);
            $this->entityManager->persist($order);

            //On enregistre les produits: OrderDetails
            foreach ($cart->getFull() as $item){
                $order_detail=new OrderDetails();
                $order_detail->setMyOrder($order);
                $order_detail->setProduct($item['product']->getName());
                $order_detail->setQuantity($item['quantity']);
                $order_detail->setPrice($item['product']->getPrix());
                $order_detail->setTotal($item['product']->getPrix()*$item['quantity']);
                $this->entityManager->persist($order_detail);
            }


            $this->entityManager->flush();

            return $this->render('order/add.html.twig',[
                'cart'=>$cart->getFull(),
                'carrier'=>$carriers,
                'address'=>$address_full,
                'reference'=>$order->getReference()
            ]);
        }
        return $this->redirectToRoute('cart');
    }
}
