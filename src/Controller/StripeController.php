<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/commande/create-session/{reference}", name="stripe")
     */
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference): Response
    {
        $order= $entityManager->getRepository(Order::class)->findOneByReference($reference);
        if(!$order){
            new JsonResponse(['error'=>'order']);
        }
        $products_for_stripe=[];
        $YOUR_DOMAIN = 'http://localhost:8000';

        foreach ($order->getOrderDetails()->getValues() as $item){
            $product= $entityManager->getRepository(Product::class)->findOneByName($item->getProduct());
            $products_for_stripe[]=[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $item->getPrice(),
                    'product_data' => [
                        'name' => $item->getProduct(),
                        'images' => [$YOUR_DOMAIN."/uploads/".$product->getImage()],
                    ],
                ],
                'quantity' => $item->getQuantity(),
            ];
        }

        $products_for_stripe[]=[
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice()*100,
                'product_data' => [
                    'name' => $order->getCarrierName(),
                    'images' => [$YOUR_DOMAIN],
                ],
            ],
            'quantity' => 1,
        ];

        Stripe::setApiKey('sk_test_51I3jbWGY1J9ax6qN08eImKmSwBPWTMy03dmLFQAOaMUvmhFWfAVFxSJu9hngf6iF11V7trVk5bdR41EnnSgscJfG001UiBdn5d');
        $checkout_session = \Stripe\Checkout\Session::create([
            'customer_email'=>$this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [$products_for_stripe],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);

        $reponse= new JsonResponse(['id'=>$checkout_session->id]);
        return $reponse;
    }
}
