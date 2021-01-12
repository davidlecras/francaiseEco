<?php
namespace App\Classes;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager,SessionInterface $session)
    {
        $this->entityManager= $entityManager;
        $this->session = $session;
    }

    public function getFull(){
        $cartComplete=[];
        if($this->get()){
            foreach ($this->get() as $id=>$quantity){
                $product=$this->entityManager->getRepository(Product::class)->findOneById($id);

                //Securité pour éviter de pouvoir ajouter un produit inexistant
                if(!$product){
                    return $this->deleteOneItem($id);
                    continue;
                }

                $cartComplete[]=[
                    'product'=>$product,
                    'quantity'=>$quantity
                ];
            }
        }
        return $cartComplete;
    }

    public function add($id){
        $cart=$this->session->get('cart', []);

        if(!empty($cart[$id])){
            $cart[$id]++;
        }else{
            $cart[$id]=1;
        }
        $this->session->set('cart',$cart);

    }

    public function reduce($id){
        $cart=$this->session->get('cart', []);

        if($cart[$id]>1){
            $cart[$id]--;
        }else{
            $this->deleteOneItem($id);
        }
       return $this->session->set('cart',$cart);

    }

    public function deleteOneItem($id){
        $cart=$this->session->get('cart', []);
        unset($cart[$id]);
        return $this->session->set('cart',$cart);
    }

    public function get(){
        return $this->session->get('cart');
    }

    public function remove(){
        return $this->session->remove('cart');
    }
}