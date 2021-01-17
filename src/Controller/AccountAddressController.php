<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAddressController extends AbstractController
{
    private $entityManager;

    /**
     * AccountAddressController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/mon-compte/mes-adresses", name="account_address")
     */
    public function index(): Response
    {
        $addresses= $this->entityManager->getRepository(Address::class)->findAll();
        return $this->render('account/address.html.twig',[
            'addresses'=>$addresses
        ]);
    }

    /**
     * @Route("/mon-compte/ajouter-une-adresses", name="account_address_add")
     */
    public function addAddress(Cart $cart, Request $request): Response
    {
        $address= new Address();
        $form= $this->createForm(AddressType::class,$address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            $this->addFlash('success', "Votre adresse a bien été rajoutée!");
            if($cart->get()){
                return $this->redirectToRoute('order');
            }else{
                return $this->redirectToRoute('account_address');
            }
        }

        return $this->render('account/address_form.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/mon-compte/modifier-une-adresses/{id}", name="account_address_edit")
     */
    public function editAddress(Request $request, $id): Response
    {
        $address= $this->entityManager->getRepository(Address::class)->findOneById($id);

        // Sécurité:
        if(!$address || $address->getUser() != $this->getUser() ){
            return $this->redirectToRoute('account_address');
        }

        $form= $this->createForm(AddressType::class,$address);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->flush($address);
            $this->addFlash('success', "Votre adresse a bien été modifiée!");
            return $this->redirectToRoute('account_address');
        }

        return $this->render('account/address_form.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route("/mon-compte/supprimer-une-adresses/{id}", name="account_address_remove")
     */
    public function removeAddress( $id): Response
    {
        $address= $this->entityManager->getRepository(Address::class)->findOneById($id);

        // Sécurité pour supprimer (ajout d'un csrf-token plus tard):
        if($address && $address->getUser() == $this->getUser() ){
            $this->entityManager->remove($address);
            $this->entityManager->flush();
        }
        $this->addFlash('danger', "Votre adresse a bien été supprimée!");
        return $this->redirectToRoute('account_address');
    }
}
