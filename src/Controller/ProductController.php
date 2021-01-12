<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    /**
     * ProductController constructor.
     * @param $entityManager
     */
    public function __construct( EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/la-boutique", name="product")
     */
    public function index(Request $request): Response
    {
        //Barre de recherche et filtres
        $search= new Search();
        $form= $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $products= $this->entityManager->getRepository(Product::class)->findWithSearch($search);
        }else{
            //Affichage de tous les produits:
            $products= $this->entityManager->getRepository(Product::class)->findAll();
        }

        return $this->render('product/index.html.twig',[
            'products'=>$products,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/produit/{slug}", name="product_show")
     */
    public function show($slug): Response
    {
        $product= $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        if(!$product){
            return $this->redirectToRoute('product');
        }
        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
