<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {

        $allProduits = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'produits' => $allProduits,
        ]);

    }

    #[Route('/product/{slug}', name: 'product')]

    public function show($slug): Response
    {

        $produit = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);

        if (!$produit){
           return $this->redirectToRoute('app_product');
        }
        return $this->render('product/show.html.twig', [
            'produit' => $produit
        ]);

    }
}
