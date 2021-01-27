<?php

namespace App\Controller;

use App\Classes\Mailjet;
use App\Entity\CarouselHeader;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    /**
     * HomeController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $products_is_best= $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $carousel= $this->entityManager->getRepository(CarouselHeader::class)->findAll();
        return $this->render('home/index.html.twig',[
            'products'=>$products_is_best,
            'carousel_images'=>$carousel
        ]);
    }
}
