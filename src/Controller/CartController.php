<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $entityManager;

    /**
     * CartController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {

        return $this->render('cart/index.html.twig',[
            'cartComplete'=>$cart->getFull(),
        ]);
    }


    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function addToCart($id, Cart $cart): Response
    {
        $cart->add($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/reduce/{id}", name="reduce_to_cart")
     */
    public function reduceToCart($id, Cart $cart): Response
    {
        $cart->reduce($id);
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/delete/{id}", name="delete_one_item_from_cart")
     */
    public function delete($id, Cart $cart): Response
    {
        $cart->deleteOneItem($id);
        $this->addFlash('danger', "Article retiré de votre panier");
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function removeMyCart(Cart $cart): Response
    {
        $cart->remove();
        return $this->redirectToRoute('product');
    }
}
